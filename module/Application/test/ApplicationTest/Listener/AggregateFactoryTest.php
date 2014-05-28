<?php

namespace ApplicationTest\Service;

use Application\Listener\AggregateFactory;

class AggregateFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var AggregateFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new AggregateFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $cache = \Mockery::mock('Application\Service\Feature\OutputCacheInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')
            ->with('Application\PluginManager')
            ->andReturn($sm);
        $sm->shouldReceive('get')->with('Application\Service\OutputCache')->andReturn($cache);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\EventManager\ListenerAggregateInterface', $service);
    }
}
