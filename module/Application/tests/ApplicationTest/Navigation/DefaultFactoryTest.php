<?php

namespace ApplicationTest\Navigation;

use Application\Navigation\DefaultFactory;

class DefaultFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var DefaultFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new DefaultFactory;
    }

    public function testExtendingDefaultNavigationFactory()
    {
        $this->assertInstanceOf('Zend\Navigation\Service\DefaultNavigationFactory', $this->fixture);
    }
}
