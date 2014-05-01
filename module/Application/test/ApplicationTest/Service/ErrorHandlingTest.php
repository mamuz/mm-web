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
        $exception = \Mockery::mock('Exception');
        $exception->shouldReceive('getFile')->andReturn('file');
        $exception->shouldReceive('getLine')->andReturn(12);
        $exception->shouldReceive('getMessage')->andReturn('message');
        $exception->shouldReceive('getPrevious')->andReturn(false);
        $exception->shouldReceive('getTraceAsString')->andReturn('trace');

        $this->logger->shouldReceive('err');

        $this->fixture->logException($exception);
    }
}
