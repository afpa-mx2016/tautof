<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Repository;


class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    
    
    public function search($makeId, $modelId){
        
        
        $query = $this->createQueryBuilder('a');

        if (!empty($modelId)){
             $query
                ->innerJoin('a.model', 'm')
                ->where('m.id = :model_id')
                ->setParameter('model_id', $modelId);
        }else if (!empty($makeId)){
             $query
                ->innerJoin('a.model', 'm')
                ->innerJoin('m.make', 'ma')
                ->where('ma.id = :make_id')
                ->setParameter('make_id', $makeId);
        }
        
        
       
               // ->orderBy('m.name', 'ASC')

          
        return $query->getQuery()->getResult();
    }
    
    

}
