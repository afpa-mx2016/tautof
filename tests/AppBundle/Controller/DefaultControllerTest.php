<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\init\InitFixtures as SQLfixtures;
use AppBundle\Entity\Advert;
use AppBundle\Entity\User;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DefaultControllerTest extends WebTestCase
{
    
    
    
    public function setUp(){
        $client = static::createClient();
        $container = $client->getContainer();

        $em = $container->get('doctrine')->getManager();
        
        //purge db
        $schemaTool = new SchemaTool($em);
        $metadata = $em->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);

        //init db sql
        $fixture = new SQLfixtures();
        $fixture->load($em);
        
        //add new user admin, 123
        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('toto');
        $user->setLastname('titi');
        $user->setEmail('toto@kikifsdfsdf.fr');
        $password = $container->get('security.password_encoder')
                ->encodePassword($user, '123');
        $user->setPassword($password);
        $em->persist($user);
        $em->flush();
        
        //need a new advert
        $user = $em->getRepository('AppBundle:User')->findOneBy(array('username'=> 'admin'));
        
        $color = $em->getRepository('AppBundle:Color')->findOneBy(array('name'=> 'Rouge'));
        $model = $em->getRepository('AppBundle:Model')->findOneBy(array('name'=> ' - 318i'));
        
        $advert = new Advert();
        $advert->setUser($user);
        $advert->setModel($model);
        $advert->setColor($color);
        $advert->setCost(1560);
        $advert->setDescr('super annonce');
        $advert->setKm(125000);
        $advert->setYear(2000);
        $advert->setTitle('Vends super titine');
        $em->persist($advert);
        $em->flush();
        
        
    }
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Tautof!', $crawler->filter('title')->text());
        // make list should be not empty
        $this->assertGreaterThan(1, $crawler->filter('#make-list option')->count());
        //model list should be empty ("1" because of bla test fake usernk selected option)
        $this->assertEquals(1, $crawler->filter('#model-list option')->count());
        
        
        $submitBtn = $crawler->selectButton('submit');
        $form = $submitBtn->form();
        
        $form['make']->select('8'); //BMW
        
        //$this->assertGreaterThan(1, $crawler->filter('#model-list option')->count());
        //submit
        $crawler = $client->submit($form);
        
        //should have a list of more than one adverts
        $this->assertGreaterThan(0, $crawler->filter('tbody tr')->count());
        
        //now simulate with no advert
        //
        $submitBtn = $crawler->selectButton('submit');
        $form = $submitBtn->form();
        $form['make']->select('1'); //acura
        $crawler = $client->submit($form);
        
         //should have a list of 0e adverts
        $this->assertEquals(0, $crawler->filter('tbody tr')->count());
        
        
        
    }
    
    public function testAddAdvert(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/advert/new');
        
        //should be redirected if not logged in
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        
        $loginPage = $client->followRedirect();
        //should have a message
        $this->assertEquals(1, $loginPage->filter('#alert-box')->count());
        
        
    }
    
    public function testLoginFailed(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $submitBtn = $crawler->selectButton('submit');
        $form = $submitBtn->form();
        
        $form['_username'] = 'zozo';
        $form['_password'] = 'booooo';
        
        $client->submit($form);
        
        //should be redirected if not logged in
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        
        $loginPage = $client->followRedirect();
        
        //should have a message
        $this->assertEquals(1, $loginPage->filter('#alert-box')->count());
            
    }
    public function testLoginSuccess(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $submitBtn = $crawler->selectButton('submit');
        $form = $submitBtn->form();
        
        $form['_username'] = 'admin';
        $form['_password'] = '123';
        
        $client->submit($form);
        
        //should be redirected if not logged in
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        
        $homePage = $client->followRedirect();
        
        //should be connected
        //var_dump($homePage->filter('nav div .navbar-right')->text());
        $this->assertContains('Hi! admin', $homePage->filter('nav div .navbar-right')->text());
            
    }
    
}
