<?php

namespace ContentManagerTest\Filter;

use ContentManager\Filter\PageCriteria;

/** @group Filter */
class PageCriteriaTest extends \PHPUnit_Framework_TestCase
{
    /** @var PageCriteria */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new PageCriteria;
    }

    public function testImplementingFilterInterface()
    {
        $this->assertInstanceOf('Zend\Filter\FilterInterface', $this->fixture);
    }

    // @todo test filtering
}
