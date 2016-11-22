<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array  $options)
            
    {

        $modelRepo = $options['em']->getRepository('AppBundle:Model');
        
        $formModifier = function (FormInterface $form, $make) use($modelRepo){
            
            if ($make===null){
                $models = array();
            }else{
                $models = $modelRepo->findBy(array( 'make' => $make));    
            }
            
            
            $form->add('model', EntityType::class, array(
                'class'       => 'AppBundle:Model',
                'placeholder' => '',
                'choices'     => $models
            ));
        };
        

        $builder->add('id', HiddenType::class)
                ->add('title')
                ->add('make', EntityType::class, array(
                    // query choices from this entity
                    'class' => 'AppBundle:Make',
                    'mapped' => false,
                    'choice_label' => 'name'

                ))
                ->add('color')
                ->add('cost')
                ->add('km')
                ->add('descr')
                ->add('year')
                ->add('submit', SubmitType::class);

        //called at init form build
        $builder->addEventListener(FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {

                $make = $event->getForm()->get('make')->getData();

                $formModifier($event->getForm(), $make);

            }
        );
        //
        $builder->get('make')->addEventListener( FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
            
                
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $make = $event->getForm()->getData();
                         
                    // since we've added the listener to the child, we'll have to pass on
                    // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $make);
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Advert',
            'em' => null
        ));
       // $resolver->setRequired(array('em'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_advert';
    }


}
