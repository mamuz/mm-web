<?php

namespace ContentManagerTest\Entity;

use ContentManager\Entity\Page;

/** @group Entity */
class PageTest extends \PHPUnit_Framework_TestCase
{
    /** @var Page */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Page;
    }

    public function testClone()
    {
        $this->fixture->setId(12);
        $this->fixture->setPath('foo');
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNull($clone->getPath());
    }

    public function testMutateAndAccessId()
    {
        $expected = 12;
        $this->assertNull($this->fixture->getId());
        $this->fixture->setId($expected);
        $this->assertSame($expected, $this->fixture->getId());
    }

    public function testMutateAndAccessPath()
    {
        $expected = 'foo';
        $this->assertNull($this->fixture->getPath());
        $this->fixture->setPath($expected);
        $this->assertSame($expected, $this->fixture->getPath());
    }

    public function testMutateAndAccessTitle()
    {
        $expected = 'foo';
        $this->assertSame('', $this->fixture->getTitle());
        $this->fixture->setTitle($expected);
        $this->assertSame($expected, $this->fixture->getTitle());
    }

    public function testMutateAndAccessContent()
    {
        $expected = 'foo';
        $this->assertSame('', $this->fixture->getContent());
        $this->fixture->setContent($expected);
        $this->assertSame($expected, $this->fixture->getContent());
    }

    public function testMutateAndAccessActive()
    {
        $this->assertFalse($this->fixture->isActive());
        $this->fixture->setActive(true);
        $this->assertTrue($this->fixture->isActive());
    }
}
