<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Model controller.
 *
 * @Route("model")
 */
class ModelController extends Controller
{
     /**
     * @Route("/form_list", name="model_form_list")
     */
    public function formListAction(Request $request)
    {
        
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Model');
        
        
        $makeId = $request->query->get('make_id');
        
        if ($makeId){

           // $make = $repo->find($makeId);
           //$models = $repo->findByMake($make);
            $models = $repo->findBy(array('make'=> $makeId));


        }else { //display all
             $models = $repo->findAll();
        }
        
      
        return $this->render('model/model_form_list.html.twig', array(
            'models' => $models,
        ));
            
    }
    
     /**
     * @Route("/json_list", name="model_json_list")
     */
    public function indexAction(Request $request)
    {
        
        $repo = $this->getDoctrine()->getManager()->getRepository('AppBundle:Model');
        
        
        $makeId = $request->query->get('make_id');
        
        if ($makeId){
            $models = $repo->findBy(array('make'=> $makeId));
        }else { //display all
             $models = $repo->findAll();
        }
        
        //TODO we could use 
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['make']);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);
        $json = $serializer->serialize(array('models'=> $models), 'json');
        
        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
        
        //return new JsonResponse(array('models'=> $models));

            
    }
}
