<?php

namespace ContactTest\Listener;

use Contact\Listener\Aggregate;

class AggregateTest extends \PHPUnit_Framework_TestCase
{
    /** @var Aggregate */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Aggregate;
    }

    public function testExtendingAbstractListenerAggregate()
    {
        $this->assertInstanceOf('Zend\EventManager\AbstractListenerAggregate', $this->fixture);
    }
}
