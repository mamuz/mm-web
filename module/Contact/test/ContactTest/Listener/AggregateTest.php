<?php

namespace ContactTest\Listener;

use Contact\Listener\Aggregate;

class AggregateTest extends \PHPUnit_Framework_TestCase
{
    /** @var Aggregate */
    protected $fixture;

    /** @var \Zend\Mail\Transport\TransportInterface|\Mockery\MockInterface */
    protected $mailTransporter;

    protected function setUp()
    {
        $this->mailTransporter = \Mockery::mock('Zend\Mail\Transport\TransportInterface');
        $this->fixture = new Aggregate($this->mailTransporter);
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
        $contactId = 12;
        $contactData = array('foo' => 'bar', 2 => 'baz');
        $contact = \Mockery::mock('Contact\Entity\Contact');
        $contact->shouldReceive('getId')->andReturn($contactId);
        $contact->shouldReceive('toArray')->andReturn($contactData);
        $event = \Mockery::mock('Zend\EventManager\EventInterface');
        $event->shouldReceive('getParam')->with(0)->andReturn($contact);

        $this->mailTransporter->shouldReceive('send')->andReturnUsing(
            function ($message) use ($contactId, $contactData) {
                /** @var \Zend\Mail\Message $message */
                $this->assertInstanceOf('Zend\Mail\Message', $message);
                $this->assertNotEmpty($message->getTo());
                $this->assertNotEmpty($message->getFrom());
                $this->assertContains((string) $contactId, $message->getSubject());
                foreach ($contactData as $val) {
                    $this->assertContains($val, $message->getBody());
                }
            }
        );

        $this->fixture->onPersistContact($event);
    }
}
