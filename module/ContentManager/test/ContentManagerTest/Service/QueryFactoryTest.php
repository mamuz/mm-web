<?php

namespace ContentManagerTest\Service;

use ContentManager\Service\QueryFactory;

/** @group Service */
class QueryControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var QueryFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new QueryFactory;
    }

    public function testImplementingFactoyInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $entityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($entityManager);

        $controller = $this->fixture->createService($sm);

        $this->assertInstanceOf('ContentManager\Service\Query', $controller);
    }
}
