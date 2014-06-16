<?php

namespace Application\Service;

use Application\Filter\MailMessage as MessageBuilder;
use Application\Options\Mail as MailOptions;
use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactMailFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \Application\Service\Feature\MailObjectInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\View\HelperPluginManager $viewManager */
        $viewManager = $serviceLocator->get('ViewManager');
        $renderer = $viewManager->getRenderer();

        $config = $serviceLocator->get('Config')['application']['mail']['contact'];
        $mailOptions = new MailOptions($config['options']);

        $messageBuilder = new MessageBuilder($renderer, $mailOptions);
        $mailTransporter = new Sendmail;
        $mailer = new Mail($messageBuilder, $mailTransporter);

        return $mailer;
    }
}
