<?php

namespace Application\Filter;

use Application\Options\MailInterface as Options;
use Zend\Filter\FilterInterface;
use Zend\Mail\Message;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\RendererInterface;

class MailMessage implements FilterInterface
{
    /** @var RendererInterface */
    private $renderer;

    /** @var Options */
    private $options;

    /** @var ModelInterface */
    private $model;

    /**
     * @param RendererInterface $renderer
     * @param Options           $options
     */
    public function __construct(RendererInterface $renderer, Options $options)
    {
        $this->renderer = $renderer;
        $this->options = $options;
    }

    public function filter($value)
    {
        $this->model = new ViewModel(array('object' => $value));

        $message = new Message();
        $message->addTo($this->options->getTo())
            ->addFrom($this->options->getFrom())
            ->setSubject($this->renderSubject())
            ->setBody($this->renderBody());

        return $message;
    }

    /**
     * @return string
     */
    private function renderSubject()
    {
        return $this->renderModel($this->options->getSubjectTemplate());
    }

    /**
     * @return string
     */
    private function renderBody()
    {
        return $this->renderModel($this->options->getBodyTemplate());
    }

    /**
     * @param string $template
     * @return string
     */
    private function renderModel($template)
    {
        $this->model->setTemplate($template);
        return $this->renderer->render($this->model);
    }
}
