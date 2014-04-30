<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\Log\Logger;
use Zend\ModuleManager\Feature;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ResponseInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        /** @var ApplicationInterface $application */
        $application = $e->getTarget();

        /** @var MvcEvent $e */
        $this->registerErrorLoggerTo($application);
        $this->attachListenerTo($application);
        $this->addHeaderLinesTo($e->getResponse());
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
     * @param ApplicationInterface $application
     * @return void
     */
    private function registerErrorLoggerTo(ApplicationInterface $application)
    {
        $eventManager = $application->getEventManager();
        $serviceManager = $application->getServiceManager();

        /** @var \Zend\Log\LoggerInterface $logger */
        $logger = $serviceManager->get('Application\Service\Log');

        Logger::registerErrorHandler($logger);
        Logger::registerExceptionHandler($logger);
        Logger::registerFatalErrorShutdownFunction($logger);

        $eventManager->attach(
            array(MvcEvent::EVENT_DISPATCH_ERROR, MvcEvent::EVENT_RENDER_ERROR),
            function (MvcEvent $event) use ($serviceManager) {
                $exception = $event->getResult()->exception;
                if (!$exception) {
                    return;
                }
                /** @var \Application\Service\ErrorHandling $errorHandler */
                $errorHandler = $serviceManager->get('Application\Service\ErrorHandling');
                $errorHandler->logException($exception);
            }
        );
    }

    /**
     * @param ApplicationInterface $application
     * @return void
     */
    private function attachListenerTo(ApplicationInterface $application)
    {
        $sm = $application->getServiceManager();
        $em = $application->getEventManager();

        /* @var \Application\Listener\Aggregate $listenerAggregate */
        $listenerAggregate = $sm->get('Application\Listener\Aggregate');
        $em->attachAggregate($listenerAggregate);
    }

    /**
     * @param ResponseInterface $response
     * @return void
     */
    private function addHeaderLinesTo(ResponseInterface $response)
    {
        if ($response instanceof HttpResponse) {
            $headers = $this->getConfig()['application']['http']['headers'];
            foreach ($headers as $name => $value) {
                $response->getHeaders()->addHeaderLine($name, $value);
            }
        }
    }
}
