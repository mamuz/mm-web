<?php

namespace BlogTest\Controller;

use Blog\Controller\QueryControllerFactory;

class QueryControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var QueryControllerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new QueryControllerFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $cryptEngine = \Mockery::mock('Blog\Crypt\AdapterInterface');
        $queryInterface = \Mockery::mock('Blog\Feature\QueryInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('Blog\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('Blog\Service\Query')->andReturn($queryInterface);
        $sm->shouldReceive('get')->with('Blog\Crypt\HashIdAdapter')->andReturn($cryptEngine);

        $controller = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }
}
