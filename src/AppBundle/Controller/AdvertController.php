<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Advert controller.
 *
 * @Route("advert")
 */
class AdvertController extends Controller
{

    
     /**
     * Lists all advert entities.
     *
     * @Route("/", name="advert_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adverts = $em->getRepository('AppBundle:Advert')->findAll();

        return $this->render('advert/index.html.twig', array(
            'adverts' => $adverts,
        ));
    }

    /**
     * Creates a new advert entity.
     *
     * @Route("/search", name="advert_search")
     * @Method({"GET"})
     */
    public function searchAction(Request $request)
    {
        $makeId = $request->get('make');
        $modelId = $request->get('model');
        
        //TODO validation
        
        $em = $this->getDoctrine()->getManager();

        $adverts = $em->getRepository('AppBundle:Advert')->search($makeId, $modelId);
        

        return $this->render('advert/index.html.twig', array(
            'adverts' => $adverts
          
        ));
    }
    
      /**
     * Creates a new advert entity.
     *
     * @Route("/new", name="advert_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        
       
        $advert = new Advert();
        $form = $this->createForm('AppBundle\Form\AdvertType', $advert,
                array('action' => $this->generateUrl('advert_new'),
                    'em' => $this->getDoctrine()->getManager()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //TODO FAKE USER!!!! //need to take it from session
            $user = $em->getRepository('AppBundle:User')->find(2);
            //var_dump($advert);
            $advert->setUser($user);
            $em->persist($advert);
            $em->flush($advert);

            return $this->redirectToRoute('advert_show', array('id' => $advert->getId()));
        }

        return $this->render('advert/new.html.twig', array(
            'advert' => $advert,
            'form' => $form->createView()
        ));
    }
    
     /**
     * Creates a new advert entity.
     *
     * @Route("/new2", name="advert_new2")
     * @Method({"GET", "POST"})
     */
    public function new2Action(Request $request)
    {
        
       
        $advert = new Advert();
        $form = $this->createForm('AppBundle\Form\AdvertFormType', $advert,
                array('action' => $this->generateUrl('advert_new2'),
                    'em' => $this->getDoctrine()->getManager()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //TODO FAKE USER!!!!
            $user = $em->getRepository('AppBundle:User')->find(2);
            //var_dump($advert);
            $advert->setUser($user);
            $em->persist($advert);
            $em->flush($advert);

            return $this->redirectToRoute('advert_show', array('id' => $advert->getId()));
        }

        return $this->render('advert/new2.html.twig', array(
            'advert' => $advert,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a advert entity.
     *
     * @Route("/{id}", name="advert_show")
     * @Method("GET")
     */
    public function showAction(Advert $advert)
    {
        $deleteForm = $this->createDeleteForm($advert);

        return $this->render('advert/show.html.twig', array(
            'advert' => $advert,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing advert entity.
     *
     * @Route("/{id}/edit", name="advert_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Advert $advert)
    {
        $deleteForm = $this->createDeleteForm($advert);
        $editForm = $this->createForm('AppBundle\Form\AdvertType', $advert);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('advert_edit', array('id' => $advert->getId()));
        }

        return $this->render('advert/edit.html.twig', array(
            'advert' => $advert,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a advert entity.
     *
     * @Route("/{id}", name="advert_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Advert $advert)
    {
        $form = $this->createDeleteForm($advert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($advert);
            $em->flush($advert);
        }

        return $this->redirectToRoute('advert_index');
    }

    /**
     * Creates a form to delete a advert entity.
     *
     * @param Advert $advert The advert entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Advert $advert)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('advert_delete', array('id' => $advert->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
