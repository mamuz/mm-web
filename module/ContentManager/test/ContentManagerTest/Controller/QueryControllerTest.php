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
    protected $fixture;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var RouteMatch */
    protected $routeMatch;

    /** @var MvcEvent */
    protected $event;

    /** @var \ContentManager\Feature\QueryInterface | \Mockery\MockInterface */
    protected $queryInterface;

    protected function setUp()
    {
        $this->queryInterface = \Mockery::mock('ContentManager\Feature\QueryInterface');

        /** @var \Zend\ServiceManager\ServiceManager $serviceManager */
        $serviceManager = Bootstrap::getServiceManager();
        $this->fixture = new QueryController();
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
        $this->fixture->setQueryService($this->queryInterface);
    }

    public function testExtendingZendActionController()
    {
        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractActionController', $this->fixture);
    }

    public function testQueryActionCanBeAccessed()
    {
        $parent = 'foo';
        $child = 'bar';
        $content = 'baz';

        $params = \Mockery::mock('Zend\Mvc\Controller\Plugin\Params');
        $params->shouldReceive('__invoke')->andReturn($params);
        $params->shouldReceive('fromRoute')->with('parent')->andReturn($parent);
        $params->shouldReceive('fromRoute')->with('child')->andReturn($child);
        $pluginManager = \Mockery::mock('Zend\Mvc\Controller\PluginManager')->shouldIgnoreMissing();
        $pluginManager->shouldReceive('get')->with('params', null)->andReturn($params);
        $this->fixture->setPluginManager($pluginManager);

        $page = \Mockery::mock('ContentManager\Entity\Page');
        $page->shouldReceive('getContent')->andReturn($content);

        $this->queryInterface
            ->shouldReceive('findPageByNode')
            ->with($parent, $child)
            ->andReturn($page);

        $this->routeMatch->setParam('action', 'page');
        $result = $this->fixture->dispatch($this->request);
        $response = $this->fixture->getResponse();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertSame($content, $result->getVariables()['content']);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
