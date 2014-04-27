<?php

namespace ContactTest\Entity;

use Contact\Entity\Contact;

/** @group Entity */
class ContactTest extends \PHPUnit_Framework_TestCase
{
    /** @var Contact */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Contact;
    }

    public function testClone()
    {
        $createdAt = new \DateTime;
        $this->fixture->setId(12);
        $this->fixture->setCreatedAt($createdAt);
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($createdAt, $clone->getCreatedAt());
        $this->assertEquals($createdAt, $clone->getCreatedAt());
    }

    public function testMutateAndAccessCreatedAt()
    {
        $this->assertInstanceOf('\DateTime', $this->fixture->getCreatedAt());
        $expected = new \DateTime;
        $this->fixture->setCreatedAt($expected);
        $this->assertSame($expected, $this->fixture->getCreatedAt());
    }

    public function testMutateAndAccessFromEmail()
    {
        $expected = 'foo';
        $this->fixture->setFromEmail($expected);
        $this->assertSame($expected, $this->fixture->getFromEmail());
    }

    public function testMutateAndAccessId()
    {
        $expected = 'foo';
        $this->fixture->setId($expected);
        $this->assertSame($expected, $this->fixture->getId());
    }

    public function testMutateAndAccessMessage()
    {
        $expected = 'foo';
        $this->fixture->setMessage($expected);
        $this->assertSame($expected, $this->fixture->getMessage());
    }

    public function testMutateAndAccessSubject()
    {
        $expected = 'foo';
        $this->fixture->setSubject($expected);
        $this->assertSame($expected, $this->fixture->getSubject());
    }

    public function testMutateAndAccessReplied()
    {
        $this->assertFalse($this->fixture->isReplied());
        $expected = true;
        $this->fixture->setReplied($expected);
        $this->assertTrue($this->fixture->isReplied());
    }

    public function testArrayRepresentation()
    {
        $this->fixture->setId(12);
        $this->fixture->setFromEmail('email');
        $this->fixture->setSubject('subject');

        $this->assertSame(
            array(
                'From'    => 'email',
                'Subject' => 'subject',
            ),
            $this->fixture->toArray()
        );
    }
}
