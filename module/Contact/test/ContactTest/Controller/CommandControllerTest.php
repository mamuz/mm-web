<?php

namespace ContactTest\Controller;

use Contact\Controller\CommandController;
use ContactTest\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Mvc\Router\RouteMatch;

/** @group Controller */
class QueryControllerTest extends \PHPUnit_Framework_TestCase
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

    /** @var \Contact\Feature\CommandInterface | \Mockery\MockInterface */
    protected $commandInterface;

    /** @var \Zend\Form\FormInterface | \Mockery\MockInterface */
    protected $formInterface;

    protected function setUp()
    {
        $this->commandInterface = \Mockery::mock('Contact\Feature\CommandInterface');
        $this->formInterface = \Mockery::mock('Zend\Form\FormInterface');

        /** @var \Zend\ServiceManager\ServiceManager $serviceManager */
        $serviceManager = Bootstrap::getServiceManager();
        $this->fixture = new CommandController($this->commandInterface, $this->formInterface);
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->fixture->setEvent($this->event);
        $this->fixture->setServiceLocator($serviceManager);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->fixture);
    }

    public function testCreateActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'create');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame($this->formInterface, $result->getVariables()['form']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateActionWithInvalidPost()
    {
        $postData = new \Zend\Stdlib\Parameters(array('foo', 'baz'));
        $this->routeMatch->setParam('action', 'create');
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setPost($postData);
        $this->formInterface->shouldReceive('setData')->with($postData)->andReturn($this->formInterface);
        $this->formInterface->shouldReceive('isValid')->andReturn(false);
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame($this->formInterface, $result->getVariables()['form']);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testCreateActionWithValidPost()
    {
        $contact = \Mockery::mock('Contact\Entity\Contact');
        $postData = new \Zend\Stdlib\Parameters(array('foo', 'baz'));
        $this->routeMatch->setParam('action', 'create');
        $this->request->setMethod(Request::METHOD_POST);
        $this->request->setPost($postData);
        $this->formInterface->shouldReceive('setData')->with($postData)->andReturn($this->formInterface);
        $this->formInterface->shouldReceive('isValid')->andReturn(true);
        $this->formInterface->shouldReceive('getData')->andReturn($contact);
        $this->commandInterface->shouldReceive('persist')->with($contact);
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame($this->formInterface, $result->getVariables()['form']);
        $this->assertSame($contact, $result->getVariables()['contact']);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
