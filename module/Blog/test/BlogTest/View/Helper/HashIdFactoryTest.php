<?php

namespace BlogTest\View\Helper;

use Blog\View\Helper\HashIdFactory;

class HashIdFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var HashIdFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new HashIdFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $adapter = \Mockery::mock('Blog\Crypt\AdapterInterface');
        $domainManager = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $domainManager->shouldReceive('get')->with('Blog\Crypt\HashIdAdapter')->andReturn($adapter);
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Blog\DomainManager')->andReturn($domainManager);

        $helper = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $adapter = \Mockery::mock('Blog\Crypt\AdapterInterface');
        $domainManager = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $domainManager->shouldReceive('get')->with('Blog\Crypt\HashIdAdapter')->andReturn($adapter);
        $sm->shouldReceive('get')->with('Blog\DomainManager')->andReturn($domainManager);

        $helper = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $helper);
    }
}
