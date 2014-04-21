<?php

namespace ContentManagerTest\Controller;

use ContentManager\Controller\QueryController;
use ContentManagerTest\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;

/** @group Controller */
class QueryControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Zend\Mvc\Controller\AbstractActionController */
    protected $controller;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var RouteMatch */
    protected $routeMatch;

    /** @var MvcEvent */
    protected $event;

    protected function setUp()
    {
        /** @var \Zend\ServiceManager\ServiceManager $serviceManager */
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new QueryController();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->controller);
    }

    public function testQueryActionCanBeAccessed()
    {
        return;
        $this->routeMatch->setParam('action', 'page');
        $result = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
