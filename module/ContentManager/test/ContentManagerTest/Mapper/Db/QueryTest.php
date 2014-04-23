<?php

namespace ContentManagerTest\Mapper\Db;

use ContentManager\Mapper\Db\Query;

/** @group Mapper */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Query */
    protected $fixture;

    /** @var \Doctrine\Common\Persistence\ObjectRepository | \Mockery\MockInterface */
    protected $entityRepository;

    /** @var \ContentManager\Entity\Page | \Mockery\MockInterface */
    protected $entity;

    /** @var \Zend\Filter\FilterInterface | \Mockery\MockInterface */
    protected $filter;

    protected function setUp()
    {
        $this->filter = \Mockery::mock('Zend\Filter\FilterInterface');
        $this->entity = \Mockery::mock('ContentManager\Entity\Page');
        $this->entityRepository = \Mockery::mock('Doctrine\Common\Persistence\ObjectRepository');

        $this->fixture = new Query($this->entityRepository, $this->filter);
    }

    public function testImplementingQueryInterface()
    {
        $this->assertInstanceOf('ContentManager\Feature\QueryInterface', $this->fixture);
    }

    public function testFindPageByName()
    {
        $criteria = array('foo');
        $this->filter->shouldReceive('filter')->with($criteria)->andReturn($criteria);
        $this->entityRepository->shouldReceive('findOneBy')->with($criteria)->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPageByCriteria($criteria));
    }

    public function testFindNullPage()
    {
        $criteria = array('foo');
        $this->filter->shouldReceive('filter')->with($criteria)->andReturn($criteria);
        $this->entityRepository->shouldReceive('findOneBy')->with($criteria)->andReturn(null);

        $this->assertInstanceOf(
            'ContentManager\Entity\NullPage',
            $this->fixture->findPageByCriteria($criteria)
        );
    }
}
