<?php

namespace Application\Filter;

use Application\Options\MailInterface as Options;
use Zend\Filter\FilterInterface;
use Zend\Mail\Message;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;

class MailMessage implements FilterInterface
{
    /** @var PhpRenderer */
    private $renderer;

    /** @var Options */
    private $options;

    /**
     * @param PhpRenderer $renderer
     * @param Options     $options
     */
    public function __construct(PhpRenderer $renderer, Options $options)
    {
        $this->renderer = $renderer;
        $this->options = $options;
    }

    public function filter($value)
    {
        $model = new ViewModel(array('object' => $value));

        $model->setTemplate($this->options->getSubjectTemplate());
        $subject = $this->renderer->render($model);

        $model->setTemplate($this->options->getBodyTemplate());
        $body = $this->renderer->render($model);

        $message = new Message();
        $message->addTo($this->options->getTo())
            ->addFrom($this->options->getFrom())
            ->setSubject($subject)
            ->setBody($body);

        return $message;
    }
}
