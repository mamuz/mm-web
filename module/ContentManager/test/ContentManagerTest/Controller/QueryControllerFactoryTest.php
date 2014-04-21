<?php

namespace ContentManagerTest\Controller;

use ContentManager\Controller\QueryControllerFactory;

/** @group Controller */
class QueryControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var QueryControllerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new QueryControllerFactory;
    }

    public function testImplementingFactoyInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $queryInterface = \Mockery::mock('ContentManager\Feature\QueryInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('ContentManager\Service\Query')->andReturn($queryInterface);

        $controller = $this->fixture->createService($sm);

        $this->assertInstanceOf('ContentManager\Controller\QueryController', $controller);
        $this->assertSame($queryInterface, $controller->getQueryService());
    }
}
