<?php

namespace ApplicationTest\Options;

use Application\Options\Mail;

class MailTest extends \PHPUnit_Framework_TestCase
{
    /** @var Mail */
    protected $fixture;

    /** @var array */
    protected $options = array(
        'to'              => 'toFoo',
        'from'            => 'fromFoo',
        'subjectTemplate' => 'bar',
        'bodyTemplate'    => 'baz',
    );

    protected function setUp()
    {
        $this->fixture = new Mail($this->options);
    }

    public function testImplementingMailInterface()
    {
        $this->assertInstanceOf('Application\Options\MailInterface', $this->fixture);
    }

    public function testAccessTo()
    {
        $this->assertSame($this->options['to'], $this->fixture->getTo());
    }

    public function testAccessFrom()
    {
        $this->assertSame($this->options['from'], $this->fixture->getFrom());
    }

    public function testAccessSubjectTemplate()
    {
        $this->assertSame($this->options['subjectTemplate'], $this->fixture->getSubjectTemplate());
    }

    public function testAccessBodyTemplate()
    {
        $this->assertSame($this->options['bodyTemplate'], $this->fixture->getBodyTemplate());
    }
}
