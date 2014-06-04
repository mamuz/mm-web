<?php

namespace ApplicationTest\Navigation;

use Application\Navigation\ProductOwnerFactory;

class ProductOwnerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ProductOwnerFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new ProductOwnerFactory;
    }

    public function testExtendingAbstractNavigationFactory()
    {
        $this->assertInstanceOf('Zend\Navigation\Service\AbstractNavigationFactory', $this->fixture);
    }

    public function testNameAccessByFailure()
    {
        $serviceLocator = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $serviceLocator->shouldReceive('get')->with('Config')->andReturn(array('navigation' => array()));
        try {
            $this->fixture->createService($serviceLocator);
        } catch (\Exception $e) {
            $this->assertContains('product-owner', $e->getMessage());
            return;
        }

        $this->fail('Expected exception not catched');
    }
}
