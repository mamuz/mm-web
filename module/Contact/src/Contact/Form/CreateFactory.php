<?php

namespace Contact\Form;

use Contact\Entity\Contact;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use Zend\Captcha;
use Zend\Form\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateFactory implements FactoryInterface
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

        /** @var \Doctrine\Common\Persistence\ObjectManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $entity = new Contact;

        $builder = new AnnotationBuilder($entityManager);
        $form = $builder->createForm($entity);
        $form->setHydrator(new DoctrineHydrator($entityManager, 'ContentManager\Entity\Page'));
        $form->bind($entity);

        $form->add(
            array(
                'type'    => 'Zend\Form\Element\Csrf',
                'name'    => 'csrf',
                'options' => array(
                    'csrf_options' => array(
                        'timeout' => 6000 // 10 minutes
                    )
                )
            )
        );

        $form->add(
            array(
                'type'       => 'Zend\Form\Element\Captcha',
                'name'       => 'captcha',
                'options'    => array(
                    'label'   => 'Please verify you are human',
                    'captcha' => new Captcha\Figlet,
                ),
                'attributes' => array(
                    'required' => 'required'
                ),
            )
        );

        $form->add(
            array(
                'type'       => 'Submit',
                'name'       => 'submit',
                'attributes' => array(
                    'value' => 'send',
                    'class' => 'btn btn-default',
                ),
            )
        );

        return $form;
    }
}
