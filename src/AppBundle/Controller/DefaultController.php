<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        $makes = $em->getRepository('AppBundle:Make')->findAll();
        
        
        $makeId = $request->get('make');
        $modelId = $request->get('model');
        
        $adverts = NULL;
        if (!empty($makeId) || !empty($modelId)){
            $adverts = $em->getRepository('AppBundle:Advert')->search($makeId, $modelId);
        }
        
        $models = NULL;
        if (!empty($makeId)){
            $models = $em->getRepository('AppBundle:Model')->findBy(array('make'=> $makeId));
        }
        
     
        return $this->render('default/home.html.twig', [
            'makes' => $makes,
            'models' => $models,
            'adverts' => $adverts,
            'selected_make_id' => $makeId,
            'selected_model_id' => $modelId
        ]);
    }
}
