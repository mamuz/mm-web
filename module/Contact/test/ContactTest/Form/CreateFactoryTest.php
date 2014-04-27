<?php

namespace ContactTest\Form;

use Contact\Form\CreateFactory;

/** @group Form */
class CreateFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var CreateFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new CreateFactory;
    }

    public function testImplementingFactoyInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $metadata = \Mockery::mock('Doctrine\Common\Persistence\Mapping\ClassMetadata')->shouldIgnoreMissing();
        $metadata->shouldReceive('getAssociationNames')->andReturn(array());
        $metadata->shouldReceive('getFieldNames')->andReturn(array());
        $objectManager = \Mockery::mock('Doctrine\Common\Persistence\ObjectManager');
        $objectManager->shouldReceive('getClassMetadata')->andReturn($metadata);

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Doctrine\ORM\EntityManager')->andReturn($objectManager);
        $sm->shouldReceive('get')->with('Config')->andReturn(array());

        $form = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Form\FormInterface', $form);
    }
}
