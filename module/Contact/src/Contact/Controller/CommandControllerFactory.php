<?php

namespace Contact\Controller;

use Contact\Controller\CommandController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandControllerFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return CommandController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }
        /** @var ServiceLocatorInterface $domainManager */
        $domainManager = $serviceLocator->get('Contact\DomainManager');

        /** @var \Contact\Feature\CommandInterface $commandService */
        $commandService = $domainManager->get('Contact\Service\Command');

        /** @var ServiceLocatorInterface $fem */
        $fem = $domainManager->get('FormElementManager');

        /** @var \Zend\Form\FormInterface $createForm */
        $createForm = $fem->get('Contact\Form\Create');

        return new CommandController($commandService, $createForm);
    }
}
