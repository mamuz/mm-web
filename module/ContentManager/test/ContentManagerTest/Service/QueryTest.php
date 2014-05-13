<?php

namespace ContentManagerTest\Service;

use ContentManager\Service\Query;

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

    public function testFindActivePageByPath()
    {
        $path = 'foo';
        $this->mapper
            ->shouldReceive('findActivePageByPath')
            ->with($path)
            ->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findActivePageByPath($path));
    }
}
