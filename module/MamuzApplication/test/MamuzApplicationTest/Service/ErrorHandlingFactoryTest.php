<?php

namespace MamuzApplicationTest\Service;

use MamuzApplication\Service\ErrorHandlingFactory;

class ErrorHandlingFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ErrorHandlingFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new ErrorHandlingFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $logger = \Mockery::mock('Zend\Log\LoggerInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')
            ->with('MamuzApplication\PluginManager')
            ->andReturn($sm);
        $sm->shouldReceive('get')->with('MamuzApplication\Service\Log')->andReturn($logger);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('MamuzApplication\Service\Feature\ExceptionLoggerInterface', $service);
    }
}
