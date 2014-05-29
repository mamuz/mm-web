<?php

namespace MamuzApplicationTest\View\Helper;

use MamuzApplication\View\Helper\AutoVersionFactory;

class AutoVersionFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var AutoVersionFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new AutoVersionFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array('mamuz-application' => array('document_root' => 'foo'));
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $service);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $config = array('mamuz-application' => array('document_root' => 'foo'));
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $service = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\View\Helper\HelperInterface', $service);
    }
}
