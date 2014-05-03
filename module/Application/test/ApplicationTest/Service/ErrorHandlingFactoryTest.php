<?php

namespace ApplicationTest\Service;

use Application\Service\ErrorHandlingFactory;

class ErrorHandlingFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ErrorHandlingFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new ErrorHandlingFactory;
    }

    public function testImplementingFactoyInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $logger = \Mockery::mock('Zend\Log\LoggerInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')
            ->with('Application\PluginManager')
            ->andReturn($sm);
        $sm->shouldReceive('get')->with('Application\Service\Log')->andReturn($logger);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Application\Service\Feature\ExceptionLoggerInterface', $service);
    }
}
