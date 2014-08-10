<?php

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use ApplicationTest\Bootstrap;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;

class IndexControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Zend\Mvc\Controller\AbstractActionController */
    protected $fixture;

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
        $this->fixture = new IndexController();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $routerConfig = array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->fixture->setEvent($this->event);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->fixture);
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ModelInterface', $result);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
