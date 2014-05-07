<?php

namespace BlogTest\Entity;

use Blog\Entity\Tag;

class TagTest extends \PHPUnit_Framework_TestCase
{
    /** @var Tag */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new Tag;
    }

    public function testClone()
    {
        $posts = $this->fixture->getPosts();
        $this->fixture->setId(12);
        $clone = clone $this->fixture;

        $this->assertNull($clone->getId());
        $this->assertNotSame($posts, $clone->getPosts());
        $this->assertEquals($posts, $clone->getPosts());
    }

    public function testMutateAndAccessId()
    {
        $expected = 'foo';
        $this->fixture->setId($expected);
        $this->assertSame($expected, $this->fixture->getId());
    }

    public function testMutateAndAccessName()
    {
        $expected = 'foo';
        $this->fixture->setName($expected);
        $this->assertSame($expected, $this->fixture->getName());
    }

    public function testMutateAndAccessPosts()
    {
        $expected = new \Doctrine\Common\Collections\ArrayCollection;
        $this->fixture->setPosts($expected);
        $this->assertSame($expected, $this->fixture->getPosts());
    }
}
