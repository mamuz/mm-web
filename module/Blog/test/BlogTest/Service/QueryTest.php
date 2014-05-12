<?php

namespace BlogTest\Service;

use Blog\Service\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Query */
    protected $fixture;

    /** @var \Zend\EventManager\EventManagerInterface | \Mockery\MockInterface */
    protected $eventManager;

    /** @var \Blog\Feature\QueryInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \Blog\Entity\Post | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('Blog\Entity\Post');
        $this->mapper = \Mockery::mock('Blog\Feature\QueryInterface');
        $this->eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface')->shouldIgnoreMissing();

        $this->fixture = new Query($this->mapper);
        $this->fixture->setEventManager($this->eventManager);
    }

    public function testImplementingQueryInterface()
    {
        $this->assertInstanceOf('Blog\Feature\QueryInterface', $this->fixture);
    }

    public function testImplementingEventManagerAwareInterface()
    {
        $this->assertInstanceOf('Zend\EventManager\EventManagerAwareInterface', $this->fixture);
    }

    public function testSetCurrentPage()
    {
        $currentPage = 3;
        $this->mapper->shouldReceive('setCurrentPage')->with($currentPage);

        $result = $this->fixture->setCurrentPage($currentPage);
        $this->assertSame($result, $this->fixture);
    }

    public function testfindActivePosts()
    {
        $this->mapper->shouldReceive('findActivePosts')->andReturn(array($this->entity));

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePosts.pre',
            $this->fixture,
            array()
        );

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePosts.post',
            $this->fixture,
            array(array($this->entity))
        );

        $this->assertSame(array($this->entity), $this->fixture->findActivePosts());
    }

    public function testfindActivePostsByTag()
    {
        $tag = 'foo';
        $this->mapper
            ->shouldReceive('findActivePostsByTag')
            ->with($tag)
            ->andReturn(array($this->entity));

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePostsByTag.pre',
            $this->fixture,
            array($tag)
        );

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePostsByTag.post',
            $this->fixture,
            array(array($this->entity))
        );

        $this->assertSame(array($this->entity), $this->fixture->findActivePostsByTag($tag));
    }

    public function testfindActivePostById()
    {
        $id = 'foo';
        $this->mapper
            ->shouldReceive('findActivePostById')
            ->with($id)
            ->andReturn($this->entity);

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePostsByTag.pre',
            $this->fixture,
            array($id)
        );

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePostById.post',
            $this->fixture,
            array($this->entity)
        );

        $this->assertSame($this->entity, $this->fixture->findActivePostById($id));
    }
}
