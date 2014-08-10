<?php

namespace ApplicationTest\Listener;

use Application\Listener\Aggregate;
use Zend\Mvc\MvcEvent;

class AggregateTest extends \PHPUnit_Framework_TestCase
{
    /** @var Aggregate */
    protected $fixture;

    /** @var \Zend\ServiceManager\ServiceLocatorInterface|\Mockery\MockInterface */
    protected $serviceLocator;

    /** @var \Application\Service\Feature\OutputCacheInterface|\Mockery\MockInterface */
    protected $cacher;

    protected function setUp()
    {
        $this->cacher = \Mockery::mock('Application\Service\Feature\OutputCacheInterface');

        $this->serviceLocator = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator
            ->shouldReceive('get')
            ->with('Application\PluginManager')
            ->andReturn($this->serviceLocator);

        $this->serviceLocator
            ->shouldReceive('get')
            ->with('Application\Service\OutputCache')
            ->andReturn($this->cacher);

        $this->fixture = new Aggregate($this->serviceLocator);
    }

    public function testExtendingAbstractListenerAggregate()
    {
        $this->assertInstanceOf('Zend\EventManager\AbstractListenerAggregate', $this->fixture);
    }

    public function testAttaching()
    {
        $sem = \Mockery::mock('Zend\EventManager\SharedEventManagerInterface');
        $sem->shouldReceive('attach')->with(
            'MamuzContact\Service\Command',
            'persist.post',
            array($this->fixture, 'onPersistContact')
        );
        $em = \Mockery::mock('Zend\EventManager\EventManagerInterface');
        $em->shouldReceive('getSharedManager')->andReturn($sem);

        $em->shouldReceive('attach')->with(
            MvcEvent::EVENT_ROUTE,
            array($this->fixture, 'onMvcRoute'),
            -100
        );

        $em->shouldReceive('attach')->with(
            MvcEvent::EVENT_FINISH,
            array($this->fixture, 'onMvcFinish'),
            -100
        );

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

    public function testOnMvcRoute()
    {
        $expected = 'foo';
        $event = \Mockery::mock('Zend\Mvc\MvcEvent');
        $this->cacher->shouldReceive('bindMvcEvent')->with($event)->andReturn($this->cacher);
        $this->cacher->shouldReceive('read')->andReturn($expected);

        $this->assertSame($expected, $this->fixture->onMvcRoute($event));
    }

    public function testOnMvcFinish()
    {
        $event = \Mockery::mock('Zend\Mvc\MvcEvent');
        $this->cacher->shouldReceive('bindMvcEvent')->with($event)->andReturn($this->cacher);
        $this->cacher->shouldReceive('write');

        $this->fixture->onMvcFinish($event);
    }
}
