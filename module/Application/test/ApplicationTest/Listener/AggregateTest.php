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
        $this->serviceLocator
            ->shouldReceive('get')
            ->with('Application\PluginManager')
            ->andReturn($this->serviceLocator);

        $this->fixture = new Aggregate;
        $this->fixture->setServiceLocator($this->serviceLocator);
    }

    public function testImplementingServiceLocatorAwareInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\ServiceLocatorAwareInterface', $this->fixture);
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
        $object = 'foo';
        $mailer = \Mockery::mock('\Application\Service\Feature\MailObjectInterface');
        $mailer->shouldReceive('bind')->with($object);
        $mailer->shouldReceive('send');
        $this->serviceLocator->shouldReceive('get')->with('Application\Service\ContactMail')->andReturn($mailer);

        $event = \Mockery::mock('Zend\EventManager\EventInterface');
        $event->shouldReceive('getParam')->with(0)->andReturn($object);

        $this->fixture->onPersistContact($event);
    }
}
