<?php

namespace ApplicationTest\View\Helper;

use Application\View\Helper\Navigation\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    /** @var Item */
    protected $fixture;

    /** @var \Zend\Navigation\Page\AbstractPage|\Mockery\MockInterface */
    protected $page = __DIR__;

    protected function setUp()
    {
        $this->page = \Mockery::mock('Zend\Navigation\Page\AbstractPage');
        $this->fixture = new Item();
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testInvokable()
    {
        $invoke = $this->fixture;
    }
}
