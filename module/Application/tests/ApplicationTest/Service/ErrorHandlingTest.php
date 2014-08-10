<?php

namespace ApplicationTest\Service;

use Application\Service\ErrorHandling;

class ErrorHandlingTest extends \PHPUnit_Framework_TestCase
{
    /** @var ErrorHandling */
    protected $fixture;

    /** @var \Zend\Log\LoggerInterface|\Mockery\MockInterface */
    protected $logger;

    protected function setUp()
    {
        $this->logger = \Mockery::mock('Zend\Log\LoggerInterface');
        $this->fixture = new ErrorHandling($this->logger);
    }

    public function testImplementingExceptionLoggerInterface()
    {
        $this->assertInstanceOf('Application\Service\Feature\ExceptionLoggerInterface', $this->fixture);
    }

    public function testLogException()
    {
        $exception = new \Exception();
        $this->logger->shouldReceive('err');

        $result = $this->fixture->logException($exception);
        $this->assertSame($result, $this->fixture);
    }
}
