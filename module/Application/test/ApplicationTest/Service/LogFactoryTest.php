<?php

namespace ApplicationTest\Service;

use Application\Service\LogFactory;

class LogFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LogFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new LogFactory;
        $this->fixture->setWriter(
            \Mockery::mock('Zend\Log\Writer\WriterInterface')
        );
    }

    public function testImplementingFactoyInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('Zend\Log\LoggerInterface', $service);
    }
}
