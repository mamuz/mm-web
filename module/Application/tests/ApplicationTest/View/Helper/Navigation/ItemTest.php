<?php

namespace ApplicationTest\View\Helper;

use Application\View\Helper\Navigation\Item;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    /** @var Item */
    protected $fixture;

    /** @var \Zend\Navigation\Page\AbstractPage|\Mockery\MockInterface */
    protected $page;

    /** @var string */
    protected $pageLabel = 'foo';

    /** @var string */
    protected $pageHref = 'bar';

    protected function setUp()
    {
        $this->page = \Mockery::mock('Zend\Navigation\Page\AbstractPage');
        $this->page->shouldReceive('getCustomProperties')->andReturn(array());
        $this->page->shouldReceive('getLabel')->andReturn($this->pageLabel);
        $this->page->shouldReceive('getHref')->andReturn($this->pageHref);
        $this->fixture = new Item;
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testRenderActivePageWithTarget()
    {
        $pageTarget = 'baz';
        $this->page->shouldReceive('hasPages')->andReturn(false);
        $this->page->shouldReceive('isActive')->with(false)->andReturn(true);
        $this->page->shouldReceive('getTarget')->andReturn($pageTarget);

        $expected = '<li class="active">'
            . '<a href="' . $this->pageHref . '" target="' . $pageTarget . '">'
            . $this->pageLabel
            . '</a></li>' . PHP_EOL;

        $this->assertSame($expected, $this->fixture->render($this->page));

        $invoke = $this->fixture;
        $this->assertSame($expected, $invoke($this->page));
    }

    public function testRenderInactivePageWithoutTarget()
    {
        $this->page->shouldReceive('getTarget')->andReturn('');
        $this->page->shouldReceive('hasPages')->andReturn(false);
        $this->page->shouldReceive('isActive')->with(false)->andReturn(false);

        $expected = '<li><a href="' . $this->pageHref . '">'
            . $this->pageLabel
            . '</a></li>' . PHP_EOL;

        $this->assertSame($expected, $this->fixture->render($this->page));

        $invoke = $this->fixture;
        $this->assertSame($expected, $invoke($this->page));
    }

    public function testRenderPageWithInactiveSubPage()
    {
        $subPage = clone $this->page;
        $subPage->shouldReceive('getTarget')->andReturn('');
        $subPage->shouldReceive('hasPages')->andReturn(false);
        $subPage->shouldReceive('isActive')->with(false)->andReturn(false);
        $this->page->shouldReceive('getTarget')->andReturn('');
        $this->page->shouldReceive('hasPages')->andReturn(true);
        $this->page->shouldReceive('isActive')->with(true)->andReturn(false);
        $this->page->shouldReceive('getPages')->andReturn(array($subPage));

        $subPages = '<ul class="dropdown-menu">' . PHP_EOL
            . '<li><a href="' . $this->pageHref . '">'
            . $this->pageLabel
            . '</a></li>' . PHP_EOL
            . '</ul>';

        $expected = '<li class="dropdown">'
            . '<a href="' . $this->pageHref . '" class="dropdown-toggle" data-toggle="dropdown">'
            . $this->pageLabel . '<b class="caret"></b></a>'
            . PHP_EOL . $subPages . PHP_EOL
            . '</li>' . PHP_EOL;

        $this->assertSame($expected, $this->fixture->render($this->page));

        $invoke = $this->fixture;
        $this->assertSame($expected, $invoke($this->page));
    }

    public function testRenderPageWithActiveSubPage()
    {
        $subPage = clone $this->page;
        $subPage->shouldReceive('getTarget')->andReturn('');
        $subPage->shouldReceive('hasPages')->andReturn(false);
        $subPage->shouldReceive('isActive')->with(false)->andReturn(true);
        $this->page->shouldReceive('getTarget')->andReturn('');
        $this->page->shouldReceive('hasPages')->andReturn(true);
        $this->page->shouldReceive('isActive')->with(true)->andReturn(true);
        $this->page->shouldReceive('getPages')->andReturn(array($subPage));

        $subPages = '<ul class="dropdown-menu">' . PHP_EOL
            . '<li class="active"><a href="' . $this->pageHref . '">'
            . $this->pageLabel
            . '</a></li>' . PHP_EOL
            . '</ul>';

        $expected = '<li class="active dropdown">'
            . '<a href="' . $this->pageHref . '" class="dropdown-toggle" data-toggle="dropdown">'
            . $this->pageLabel . '<b class="caret"></b></a>'
            . PHP_EOL . $subPages . PHP_EOL
            . '</li>' . PHP_EOL;

        $this->assertSame($expected, $this->fixture->render($this->page));

        $invoke = $this->fixture;
        $this->assertSame($expected, $invoke($this->page));
    }
}
