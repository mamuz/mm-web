<?php

namespace ContentManagerTest\Service;

use ContentManager\Service\Query;

/** @group Service */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Query */
    protected $fixture;

    /** @var \ContentManager\Feature\QueryInterface | \Mockery\MockInterface */
    protected $mapper;

    /** @var \ContentManager\Entity\Page | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('ContentManager\Entity\Page');
        $this->mapper = \Mockery::mock('ContentManager\Feature\QueryInterface');

        $this->fixture = new Query($this->mapper);
    }

    public function testImplementingQueryInterface()
    {
        $this->assertInstanceOf('ContentManager\Feature\QueryInterface', $this->fixture);
    }

    public function testFindPageByName()
    {
        $name = 'foo';
        $this->mapper
            ->shouldReceive('findPageByNode')
            ->with($name, null)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPageByNode($name));
    }

    public function testFindPageByNameWithParent()
    {
        $name = 'foo';
        $parent = 'bar';
        $this->mapper
            ->shouldReceive('findPageByNode')
            ->with($name, $parent)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPageByNode($name, $parent));
    }
}
