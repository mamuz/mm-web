<?php

namespace ContactTest\Mapper\Db;

use Contact\Mapper\Db\Command;

class CommandTest extends \PHPUnit_Framework_TestCase
{
    /** @var Command */
    protected $fixture;

    /** @var \Doctrine\Common\Persistence\ObjectManager | \Mockery\MockInterface */
    protected $entityManager;

    /** @var \Contact\Entity\Contact | \Mockery\MockInterface */
    protected $entity;

    protected function setUp()
    {
        $this->entity = \Mockery::mock('Contact\Entity\Contact');
        $this->entityManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');

        $this->fixture = new Command($this->entityManager);
    }

    public function testImplementingCommandInterface()
    {
        $this->assertInstanceOf('Contact\Feature\CommandInterface', $this->fixture);
    }

    public function testPersist()
    {
        $this->entityManager->shouldReceive('persist')->with($this->entity);
        $this->entityManager->shouldReceive('flush');

        $this->assertSame($this->entity, $this->fixture->persist($this->entity));
    }
}
