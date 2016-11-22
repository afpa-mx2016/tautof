<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Description of ModelFormTransformer
 *
 * @author lionel
 */
class ModelFormTransformer implements DataTransformerInterface {

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Transforms an object (model) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($model)
    {
        if (null === $model) {
            return '';
        }

        return $model->getName();
    }

    /**
     * Transforms a string (number) to an object (model).
     *
     * @param  string $modelId
     * @return Issue|null
     * @throws TransformationFailedException if object (model) is not found.
     */
    public function reverseTransform($modelId)
    {
        var_dump("kikouuuuuuuuuuuuu");
        // no issue number? It's optional, so that's ok
        if (!$modelId) {
            return;
        }

        $model = $this->manager
            ->getRepository('AppBundle:Model')
            // query for the issue with this id
            ->find($modelId)
        ;

        if (null === $model) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $modelId
            ));
        }

        return $model;
    }
}

