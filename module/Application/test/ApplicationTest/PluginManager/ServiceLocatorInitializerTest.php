<?php

namespace ApplicationTest\Service;

use Application\PluginManager\ServiceLocatorInitializer;

class ServiceLocatorInitializerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ServiceLocatorInitializer */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new ServiceLocatorInitializer;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\InitializerInterface', $this->fixture);
    }

    public function testInitialize()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $instance = \Mockery::mock('Zend\ServiceManager\ServiceLocatorAwareInterface');
        $instance->shouldReceive('setServiceLocator')->with($sm);

        $result = $this->fixture->initialize($instance, $sm);
        $this->assertSame($result, $instance);
    }

    public function testInitializeWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $instance = \Mockery::mock('Zend\ServiceManager\ServiceLocatorAwareInterface');
        $instance->shouldReceive('setServiceLocator')->with($sm);

        $result = $this->fixture->initialize($instance, $sl);
        $this->assertSame($result, $instance);
    }
}
