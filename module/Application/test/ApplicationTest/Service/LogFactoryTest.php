<?php

namespace ApplicationTest\Service;

use Application\Service\LogFactory;

class LogFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LogFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new LogFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array('application' => array('log' => null));
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Log\LoggerInterface', $service);
    }
}
