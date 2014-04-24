<?php

namespace ContentManager\Form;

use ContentManager\Entity\Page;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Zend\Form\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PageFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return Form
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $entity = new Page;

        $builder = $serviceLocator->get('formannotationbuilder');
        var_dump(get_class($builder));
        exit;
        $builder = new AnnotationBuilder($entityManager);
        $form = $builder->createForm($entity);
        $form->setHydrator(new DoctrineHydrator($entityManager, 'ContentManager\Entity\Page'));
        $form->bind($entity);

        return $form;
    }
}
