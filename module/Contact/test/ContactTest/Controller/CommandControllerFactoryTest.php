<?php

namespace ContactTest\Controller;

use Contact\Controller\CommandControllerFactory;

class CommandControllerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommandControllerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new CommandControllerFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $commandInterface = \Mockery::mock('Contact\Feature\CommandInterface');
        $formInterface = \Mockery::mock('Zend\Form\FormInterface');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $fem = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $fem->shouldReceive('get')->with('Contact\Form\Create')->andReturn($formInterface);
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('Contact\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('Contact\Service\Command')->andReturn($commandInterface);
        $sm->shouldReceive('get')->with('FormElementManager')->andReturn($fem);

        $controller = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }

    public function testCreationWithServiceLocatorAwareness()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $sl = \Mockery::mock('Zend\ServiceManager\AbstractPluginManager');
        $sl->shouldReceive('getServiceLocator')->andReturn($sm);

        $commandInterface = \Mockery::mock('Contact\Feature\CommandInterface');
        $formInterface = \Mockery::mock('Zend\Form\FormInterface');
        $fem = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $fem->shouldReceive('get')->with('Contact\Form\Create')->andReturn($formInterface);
        $sm->shouldReceive('getServiceLocator')->andReturn($sm);
        $sm->shouldReceive('get')->with('Contact\DomainManager')->andReturn($sm);
        $sm->shouldReceive('get')->with('Contact\Service\Command')->andReturn($commandInterface);
        $sm->shouldReceive('get')->with('FormElementManager')->andReturn($fem);

        $controller = $this->fixture->createService($sl);

        $this->assertInstanceOf('Zend\Mvc\Controller\AbstractController', $controller);
    }
}
