<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
/**
 * load init sql file: 
 *
 * @author lionel
 */
class SQLInitFixtures extends AbstractFixture implements OrderedFixtureInterface
{    
  


    public function load(ObjectManager $manager) {
      $filename = './app/Resources/tautof.sql';
      $sql = file_get_contents($filename);  // Read file contents
      $manager->getConnection()->exec($sql);  // Execute native SQLtestdb

      $manager->flush();
    }

    public function getOrder() {
      return 99;  // Order in which this fixture will be executed
    }
  
  
}
