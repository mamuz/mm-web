<?php

namespace ApplicationTest\View\Helper;

use Application\View\Helper\AutoVersion;

class AutoVersionTest extends \PHPUnit_Framework_TestCase
{
    /** @var AutoVersion */
    protected $fixture;

    /** @var string */
    protected $docRoot = __DIR__;

    protected function setUp()
    {
        $this->fixture = new AutoVersion($this->docRoot);
    }

    public function testExtendingAbstractHelper()
    {
        $this->assertInstanceOf('Zend\View\Helper\AbstractHelper', $this->fixture);
    }

    public function testInvokable()
    {
        $file = basename(__FILE__);
        $invoke = $this->fixture;
        list($basename, $ext) = explode('.', $file);
        $this->assertRegExp(
            '%/' . $basename . '\.[0-9]{10}\.' . $ext . '%',
            $invoke('/' . $file)
        );
    }

    public function testInvokableWithoutTrailingSlash()
    {
        $file = basename(__FILE__);
        $invoke = $this->fixture;
        list($basename, $ext) = explode('.', $file);
        $this->assertSame(
            $file,
            $invoke($file)
        );
    }

    public function testInvokableFileNotExists()
    {
        $file = '/foo';
        $invoke = $this->fixture;
        $this->assertSame(
            $file,
            $invoke($file)
        );
    }
}
