<?php

namespace ApplicationTest\Filter;

use Application\Filter\MailMessage;

class MailMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var MailMessage */
    protected $fixture;

    /** @var \Zend\View\Renderer\RendererInterface|\Mockery\MockInterface */
    protected $renderer;

    /** @var \Application\Options\MailInterface|\Mockery\MockInterface */
    protected $options;

    /** @var string */
    protected $value = 'foo';

    protected function setUp()
    {
        $this->renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $this->renderer->shouldReceive('setTemplate')->with('subjectTemplate');
        $this->renderer->shouldReceive('setTemplate')->with('bodyTemplate');
        $this->renderer->shouldReceive('render')->andReturnUsing(
            function ($model) {
                /** @var \Zend\View\Model\ModelInterface $model */
                $this->assertInstanceOf('Zend\View\Model\ModelInterface', $model);
                $this->assertSame($this->value, $model->getVariable('object'));
                return $model->getTemplate() . '_rendered';
            }
        );

        $this->options = \Mockery::mock('Application\Options\MailInterface');
        $this->options->shouldReceive('getTo')->andReturn('to@mail.com');
        $this->options->shouldReceive('getFrom')->andReturn('from@mail.com');
        $this->options->shouldReceive('getSubjectTemplate')->andReturn('subjectTemplate');
        $this->options->shouldReceive('getBodyTemplate')->andReturn('bodyTemplate');

        $this->fixture = new MailMessage($this->renderer, $this->options);
    }

    public function testImplementingFilterInterface()
    {
        $this->assertInstanceOf('Zend\Filter\FilterInterface', $this->fixture);
    }

    public function testFiltering()
    {
        $message = $this->fixture->filter($this->value);
        $to = $message->getTo()->current()->getEmail();
        $from = $message->getFrom()->current()->getEmail();

        $this->assertInstanceOf('Zend\Mail\Message', $message);
        $this->assertSame('to@mail.com', $to);
        $this->assertSame('from@mail.com', $from);
        $this->assertSame('subjectTemplate_rendered', $message->getSubject());
        $this->assertSame('bodyTemplate_rendered', $message->getBody());
    }
}
