<?php

namespace ApplicationTest\Service;

use Application\Service\OutputCache;

class OutputCacheTest extends \PHPUnit_Framework_TestCase
{
    /** @var OutputCache */
    protected $fixture;

    /** @var \Zend\Cache\Storage\StorageInterface|\Mockery\MockInterface */
    protected $storage;

    /** @var \Zend\Mvc\MvcEvent|\Mockery\MockInterface */
    protected $mvcEvent;

    /** @var \Zend\Http\PhpEnvironment\Response|\Mockery\MockInterface */
    protected $response;

    /** @var \Zend\Http\PhpEnvironment\Request|\Mockery\MockInterface */
    protected $request;

    /** @var \Zend\Mvc\Router\RouteMatch|\Mockery\MockInterface */
    protected $routeMatch;

    /** @var array */
    protected $blacklist = array('foo');

    protected function setUp()
    {
        $this->routeMatch = \Mockery::mock('Zend\Mvc\Router\RouteMatch');
        $this->response = \Mockery::mock('Zend\Http\PhpEnvironment\Response');
        $this->request = \Mockery::mock('Zend\Http\PhpEnvironment\Request');
        $this->mvcEvent = \Mockery::mock('Zend\Mvc\MvcEvent');
        $this->storage = \Mockery::mock('Zend\Cache\Storage\StorageInterface');
        $this->fixture = new OutputCache($this->storage);
    }

    public function testImplementingOutputInterface()
    {
        $this->assertInstanceOf('Application\Service\Feature\OutputCacheInterface', $this->fixture);
    }

    public function testReadWithoutMvcEvent()
    {
        $this->assertNull($this->fixture->read());
    }

    public function testWriteWithoutMvcEvent()
    {
        $this->assertSame($this->fixture, $this->fixture->write());
    }

    public function testReadByMvcEventWithoutHttpRequest()
    {
        $this->mvcEvent->shouldReceive('getRequest')->andReturn(null);
        $this->assertNull($this->fixture->bindMvcEvent($this->mvcEvent)->read());
    }

    public function testReadByMvcEventRouteMatchIsBlacklisted()
    {
        $this->fixture->setBlacklistedRouteNames($this->blacklist);
        $this->routeMatch->shouldReceive('getMatchedRouteName')->andReturn($this->blacklist[0]);
        $this->mvcEvent->shouldReceive('getRequest')->andReturn($this->request);
        $this->mvcEvent->shouldReceive('getRouteMatch')->andReturn($this->routeMatch);
        $this->assertNull($this->fixture->bindMvcEvent($this->mvcEvent)->read());
    }

    public function testReadByMvcEventRouteMatchIsNotBlacklisted()
    {
        $this->fixture->setBlacklistedRouteNames($this->blacklist);
        $this->routeMatch->shouldReceive('getMatchedRouteName')->andReturn('bar');
        $this->request->shouldReceive('getRequestUri')->andReturn('baz');
        $this->mvcEvent->shouldReceive('getRequest')->andReturn($this->request);
        $this->mvcEvent->shouldReceive('getResponse')->andReturn($this->response);
        $this->mvcEvent->shouldReceive('getRouteMatch')->andReturn($this->routeMatch);
        $this->storage->shouldReceive('getItem')->with(md5('baz'))->andReturn(null);

        $this->assertNull($this->fixture->bindMvcEvent($this->mvcEvent)->read());
    }

    public function testReadNullByMvcEventAndWrite()
    {
        $content = 'content';
        $this->response->shouldReceive('getContent')->andReturn($content);
        $this->request->shouldReceive('getRequestUri')->andReturn('baz/');
        $this->mvcEvent->shouldReceive('getRequest')->andReturn($this->request);
        $this->mvcEvent->shouldReceive('getResponse')->andReturn($this->response);
        $this->mvcEvent->shouldReceive('getRouteMatch')->andReturn(false);
        $this->storage->shouldReceive('getItem')->with(md5('baz'))->andReturn(null);
        $this->storage->shouldReceive('setItem')->with(md5('baz'), $content);

        $this->assertNull($this->fixture->bindMvcEvent($this->mvcEvent)->read());
        $this->assertSame($this->fixture, $this->fixture->write());
    }

    public function testReadByMvcEventAndNotWritable()
    {
        $content = 'content';
        $headers = \Mockery::mock('Zend\Http\Headers');
        $headers->shouldReceive('addHeaderLine');
        $this->response->shouldReceive('setContent')->with($content);
        $this->response->shouldReceive('getHeaders')->andReturn($headers);
        $this->request->shouldReceive('getRequestUri')->andReturn('baz/');
        $this->mvcEvent->shouldReceive('getRequest')->andReturn($this->request);
        $this->mvcEvent->shouldReceive('getResponse')->andReturn($this->response);
        $this->mvcEvent->shouldReceive('getRouteMatch')->andReturn(false);
        $this->storage->shouldReceive('getItem')->with(md5('baz'))->andReturn($content);

        $this->assertSame($this->response, $this->fixture->bindMvcEvent($this->mvcEvent)->read());
        $this->assertSame($this->fixture, $this->fixture->write());
    }
}
