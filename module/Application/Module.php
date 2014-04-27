<?php

namespace Application;

use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Response as HttpResponse;
use Zend\ModuleManager\Feature;
use Zend\Mvc\ModuleRouteListener;
use Zend\Stdlib\ResponseInterface;

class Module implements
    Feature\AutoloaderProviderInterface,
    Feature\BootstrapListenerInterface,
    Feature\ConfigProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        /** @var \Zend\Mvc\MvcEvent $e */
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
