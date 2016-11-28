<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    
    private $container;
    //.. $container declaration & setter
    public function setContainer(ContainerInterface $container = null) {
         $this->container = $container;
    }
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('toto');
        $user->setLastname('titi');
        $user->setEmail('toto@kikifsdfsdf.fr');
        
        $password = $this->container->get('security.password_encoder')
                ->encodePassword($user, '123');
        $user->setPassword($password);


        // On le persiste
        $manager->persist($user);

        // On déclenche l'enregistrement
        $manager->flush();
    }



}
