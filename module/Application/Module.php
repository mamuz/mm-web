<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
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
        $this->addHeaderLinesTo($e->getResponse());
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
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
