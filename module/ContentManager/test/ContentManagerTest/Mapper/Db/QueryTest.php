<?php

namespace ContentManagerTest\Mapper\Db;

use ContentManager\Mapper\Db\Query;

/** @group Mapper */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /** @var Query */
    protected $fixture;

    /** @var \Doctrine\ORM\EntityManager | \Mockery\MockInterface */
    protected $entityManager;

    /** @var \Doctrine\ORM\EntityRepository | \Mockery\MockInterface */
    protected $entityRepository;

    /** @var \ContentManager\Entity\Page | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('ContentManager\Entity\Page');
        $this->entityRepository = \Mockery::mock('Doctrine\ORM\EntityRepository');
        $this->entityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->entityManager
            ->shouldReceive('getRepository')
            ->with('ContentManager\Entity\Page')
            ->andReturn($this->entityRepository);

        $this->fixture = new Query($this->entityManager);
    }

    public function testImplementingQueryInterface()
    {
        $this->assertInstanceOf('ContentManager\Feature\QueryInterface', $this->fixture);
    }

    public function testFindPageByName()
    {
        $name = 'foo';
        $this->entityRepository->shouldReceive('findOneBy')->with(
            array(
                'active'     => true,
                'name'       => $name,
                'parentName' => null,
            )
        )->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPageByNode($name));
    }

    public function testFindPageByNameWithParent()
    {
        $name = 'foo';
        $parent = 'bar';
        $this->entityRepository->shouldReceive('findOneBy')->with(
            array(
                'active'     => true,
                'name'       => $parent,
                'parentName' => $name,
            )
        )->andReturn($this->entity);

        $this->assertSame($this->entity, $this->fixture->findPageByNode($name, $parent));
    }

    public function testFindNullPage()
    {
        $name = 'foo';
        $this->entityRepository->shouldReceive('findOneBy')->with(
            array(
                'active'     => true,
                'name'       => $name,
                'parentName' => null,
            )
        )->andReturn(null);

        $this->assertInstanceOf('ContentManager\Entity\NullPage', $this->fixture->findPageByNode($name));
    }
}
