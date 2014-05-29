<?php

namespace MamuzApplicationTest\Service;

use MamuzApplication\Service\OutputCacheFactory;

class OutputCacheFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var OutputCacheFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new OutputCacheFactory;
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

        $this->assertInstanceOf('\MamuzApplication\Service\Feature\OutputCacheInterface', $service);
    }
}
