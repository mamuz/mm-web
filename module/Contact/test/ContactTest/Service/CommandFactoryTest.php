<?php

namespace ContactTest\Service;

use Contact\Service\CommandFactory;

class CommandFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var CommandFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new CommandFactory;
    }

    public function testImplementingFactoyInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $objectManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($objectManager);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Contact\Service\Command', $service);
    }
}
