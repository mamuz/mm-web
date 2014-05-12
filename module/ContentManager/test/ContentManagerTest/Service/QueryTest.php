<?php

namespace ContentManagerTest\Service;

use ContentManager\Service\Query;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Query */
    protected $fixture;

    /** @var \Zend\EventManager\EventManagerInterface | \Mockery\MockInterface */
    protected $eventManager;

    /** @var \ContentManager\Feature\QueryInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \ContentManager\Entity\Page | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('ContentManager\Entity\Page');
        $this->mapper = \Mockery::mock('ContentManager\Feature\QueryInterface');
        $this->eventManager = \Mockery::mock('Zend\EventManager\EventManagerInterface')->shouldIgnoreMissing();

        $this->fixture = new Query($this->mapper);
        $this->fixture->setEventManager($this->eventManager);
    }

    public function testImplementingQueryInterface()
    {
        $this->assertInstanceOf('ContentManager\Feature\QueryInterface', $this->fixture);
    }

    public function testImplementingEventManagerAwareInterface()
    {
        $this->assertInstanceOf('Zend\EventManager\EventManagerAwareInterface', $this->fixture);
    }

    public function testFindActivePageByPath()
    {
        $path = 'foo';
        $this->mapper
            ->shouldReceive('findActivePageByPath')
            ->with($path)
            ->andReturn($this->entity);

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePageByPath.pre',
            $this->fixture,
            array($path)
        );

        $this->eventManager->shouldReceive('trigger')->with(
            'findActivePageByPath.post',
            $this->fixture,
            array($this->entity)
        );

        $this->assertSame($this->entity, $this->fixture->findActivePageByPath($path));
    }
}
