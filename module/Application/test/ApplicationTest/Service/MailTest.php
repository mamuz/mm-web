<?php

namespace ApplicationTest\Service;

use Application\Service\Mail;

class MailTest extends \PHPUnit_Framework_TestCase
{
    /** @var Mail */
    protected $fixture;

    /** @var \Zend\Filter\FilterInterface|\Mockery\MockInterface */
    protected $builder;

    /** @var \Zend\Mail\Transport\TransportInterface|\Mockery\MockInterface */
    protected $transporter;

    protected function setUp()
    {
        $this->builder = \Mockery::mock('Zend\Filter\FilterInterface');
        $this->transporter = \Mockery::mock('Zend\Mail\Transport\TransportInterface');
        $this->fixture = new Mail($this->builder, $this->transporter);
    }

    public function testImplementingExceptionLoggerInterface()
    {
        $this->assertInstanceOf('Application\Service\Feature\MailObjectInterface', $this->fixture);
    }

    public function testSend()
    {
        $this->transporter->shouldReceive('send')->andReturnUsing(
            function ($object) {
                $this->assertInstanceOf('Zend\Mail\Message', $object);
            }
        );
        $this->fixture->send();
    }

    public function testSendBintObject()
    {
        $object = \Mockery::mock('Zend\Mail\Message');
        $this->builder->shouldReceive('filter')->with($object)->andReturn($object);
        $this->transporter->shouldReceive('send')->with($object);

        $this->fixture->bind($object)->send();
    }
}
