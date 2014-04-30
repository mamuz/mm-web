<?php

namespace ApplicationTest\Listener;

use Application\Listener\Aggregate;

class AggregateTest extends \PHPUnit_Framework_TestCase
{
    /** @var Aggregate */
    protected $fixture;

    /** @var \Zend\ServiceManager\ServiceLocatorInterface|\Mockery\MockInterface */
    protected $serviceLocator;

    protected function setUp()
    {
        $this->serviceLocator = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');

        $this->fixture = new Aggregate;
        $this->fixture->setServiceLocator($this->serviceLocator);
    }

    public function testExtendingAbstractListenerAggregate()
    {
        $this->assertInstanceOf('Zend\EventManager\AbstractListenerAggregate', $this->fixture);
    }

    public function testAttaching()
    {
        $sem = \Mockery::mock('Zend\EventManager\SharedEventManagerInterface');
        $sem->shouldReceive('attach')->with(
            'Contact\Service\Command',
            'persist.post',
            array($this->fixture, 'onPersistContact')
        );
        $em = \Mockery::mock('Zend\EventManager\EventManagerInterface');
        $em->shouldReceive('getSharedManager')->andReturn($sem);

        $this->fixture->attach($em);
    }

    public function testOnPersistContact()
    {
    }
}
