<?php

namespace ApplicationTest\Service\Cache;

use Application\Service\Cache\OutputFactory;

class OutputFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var OutputFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new OutputFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array(
            'caches' => array(
                'outputCache' => array(
                    'blacklistedRouteNames' => array(),
                ),
            ),
        );
        $cacheStorage = \Mockery::mock('Zend\Cache\Storage\StorageInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);
        $sm->shouldReceive('get')->with('outputCache')->andReturn($cacheStorage);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('\Application\Service\Cache\OutputInterface', $service);
    }
}
