<?php

namespace MamuzApplication;

use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\ModuleManager\Feature;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\ApplicationInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface,
    Feature\InitProviderInterface
{
    /** @var ApplicationInterface */
    private $application;

    /** @var ServiceLocatorInterface */
    private $pluginManager;

    /** @var EventManagerInterface */
    private $eventManager;

    public function init(ModuleManagerInterface $modules)
    {
        if ($modules instanceof ModuleManager) {
            $this->addPluginManager($modules);
        }
    }

    public function onBootstrap(EventInterface $e)
    {
        /** @var MvcEvent $e */
        $this->application = $e->getApplication();
        $this->eventManager = $this->application->getEventManager();
        $this->pluginManager = $this->application->getServiceManager()->get(
            'MamuzApplication\PluginManager'
        );

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

    private function addPluginManager(ModuleManager $modules)
    {
        /** @var \Zend\ServiceManager\ServiceLocatorInterface $sm */
        $sm = $modules->getEvent()->getParam('ServiceManager');
        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');

        $serviceListener->addServiceManager(
            'MamuzApplication\PluginManager',
            'application_plugin',
            'MamuzApplication\PluginManager\ProviderInterface',
            'getApplicationPluginConfig'
        );
    }

    /**
     * @return void
     */
    private function attachErrorLogger()
    {
        $this->pluginManager->get('MamuzApplication\Service\Log');
        $this->eventManager->attach(
            array(MvcEvent::EVENT_DISPATCH_ERROR, MvcEvent::EVENT_RENDER_ERROR),
            function (MvcEvent $event) {
                if ($exception = $event->getResult()->exception) {
                    /** @var \MamuzApplication\Service\Feature\ExceptionLoggerInterface $errorHandler */
                    $errorHandler = $this->pluginManager->get('MamuzApplication\Service\ErrorHandling');
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
        $listenerAggregate = $this->pluginManager->get('MamuzApplication\Listener\Aggregate');
        $this->eventManager->attachAggregate($listenerAggregate);
    }

    /**
     * @param HttpResponse $response
     * @return void
     */
    private function addHeaderLinesToResponse(HttpResponse $response)
    {
        $headers = $this->getConfig()['mamuz-application']['http']['headers'];
        foreach ($headers as $name => $value) {
            $response->getHeaders()->addHeaderLine($name, $value);
        }
    }
}
