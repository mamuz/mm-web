<?php

namespace MamuzApplication\Service;

use MamuzApplication\Filter\MailMessage as MessageBuilder;
use MamuzApplication\Options\Mail as MailOptions;
use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver;

class ContactMailFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return \MamuzApplication\Service\Feature\MailObjectInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config')['mamuz-application']['mail']['contact'];

        $templateMap = new Resolver\TemplateMapResolver($config['template_map']);
        $resolver = new Resolver\AggregateResolver();
        $resolver->attach($templateMap);

        $renderer = new PhpRenderer();
        $renderer->setResolver($resolver);

        $mailOptions = new MailOptions($config['options']);

        $messageBuilder = new MessageBuilder($renderer, $mailOptions);
        $mailTransporter = new Sendmail;
        $mailer = new Mail($messageBuilder, $mailTransporter);

        return $mailer;
    }
}
