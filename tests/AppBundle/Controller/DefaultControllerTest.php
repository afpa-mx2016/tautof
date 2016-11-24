<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Tautof!', $crawler->filter('title')->text());
        // make list should be not empty
        $this->assertGreaterThan(1, $crawler->filter('#make-list option')->count());
        //model list should be empty ("1" because of blank selected option)
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
}
