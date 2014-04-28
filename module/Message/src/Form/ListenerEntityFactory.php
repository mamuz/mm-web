<?php

namespace Message\Form;

use Message\Entity\Listener;
use Message\Hydrator\FilterStrategy;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\FormInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class ListenerEntityFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return FormInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $entity = new Listener;

        $strategy = new FilterStrategy;
        $strategy->setServiceLocator($serviceLocator);
        $hydrator = new ClassMethods(false);
        $hydrator->addStrategy("filter", new FilterStrategy);

        $builder = new AnnotationBuilder();
        $form = $builder->createForm($entity);
        $form->setHydrator($hydrator);
        $form->bind($entity);

        return $form;
    }
}
