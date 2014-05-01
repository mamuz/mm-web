<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Log\Logger;
use Zend\ModuleManager\Feature;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface
{
    /** @var ApplicationInterface */
    private $application;

    /** @var ServiceLocatorInterface */
    private $serviceLocator;

    /** @var EventManagerInterface */
    private $eventManager;

    public function onBootstrap(EventInterface $e)
    {
        /** @var MvcEvent $e */
        $this->application = $e->getApplication();
        $this->eventManager = $this->application->getEventManager();
        $this->serviceLocator = $this->application->getServiceManager();

        $this->attachErrorLogger();
        $this->attachListenerAggregate();

        $response = $e->getResponse();
        if ($response instanceof HttpResponse) {
            $this->addHeaderLinesToResponse($response);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return void
     */
    private function attachErrorLogger()
    {
        /** @var \Zend\Log\Logger $logger */
        $logger = $this->serviceLocator->get('Application\Service\Log');

        Logger::registerErrorHandler($logger);
        Logger::registerExceptionHandler($logger);
        Logger::registerFatalErrorShutdownFunction($logger);

        $this->eventManager->attach(
            array(MvcEvent::EVENT_DISPATCH_ERROR, MvcEvent::EVENT_RENDER_ERROR),
            function (MvcEvent $event) {
                if ($exception = $event->getResult()->exception) {
                    /** @var \Application\Service\Feature\ExceptionLoggerInterface $errorHandler */
                    $errorHandler = $this->serviceLocator->get('Application\Service\ErrorHandling');
                    $errorHandler->logException($exception);
                }
            }
        );
    }

    /**
     * @return void
     */
    private function attachListenerAggregate()
    {
        /* @var \Zend\EventManager\ListenerAggregateInterface $listenerAggregate */
        $listenerAggregate = $this->serviceLocator->get('Application\Listener\Aggregate');
        $this->eventManager->attachAggregate($listenerAggregate);
    }

    /**
     * @param HttpResponse $response
     * @return void
     */
    private function addHeaderLinesToResponse(HttpResponse $response)
    {
        $headers = $this->getConfig()['application']['http']['headers'];
        foreach ($headers as $name => $value) {
            $response->getHeaders()->addHeaderLine($name, $value);
        }
    }
}
