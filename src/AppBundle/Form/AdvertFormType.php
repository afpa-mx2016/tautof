<?php

namespace AppBundle\Form;

use AppBundle\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AdvertFormType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array  $options)
            
    {

        $em =$options['em'];

        $builder->add('id', HiddenType::class)
                ->add('title')
                ->add('make', EntityType::class, array(
                    // query choices from this entity
                    'class' => 'AppBundle:Make',
                    'mapped' => false,
                    'choice_label' => 'name'
                ))
                ->add('model', EntityType::class, array(
                    'class'       => 'AppBundle:Model',
                    'placeholder' => '',
                    //'required' => false, //this is a workaround to avoid validation on this property
                    'choices'     => array()
                ))
                ->add('color')
                ->add('cost')
                ->add('km')
                ->add('descr')
                ->add('year')
                ->add('submit', SubmitType::class);
       
        /*
         *  HACKING!
         * "model" come from a populated list by ajax, so model is not reconized as an entity by symfony
         *  we need to force just before form submit validation phase so that model is recognized as part of valid choices...
         */
        $builder->addEventListener( FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($em) {

            
                $modelRepo = $em->getRepository('AppBundle:Model');
            
                $data = $event->getData();
                $form = $event->getForm();
                
                $model = $modelRepo->find($data['model']);
                
                $form->add('model', EntityType::class, array(
                    'class'       => 'AppBundle:Model',
                    'placeholder' => '',
                    'choices'     => array($model)
                ));

                         
            }
        );
                    
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Advert'
            
        ));
        $resolver->setRequired(array('em'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_advert';
    }


}
