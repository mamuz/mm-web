<?php

namespace Application\Options;

class Mail implements MailInterface
{
    /** @var string */
    private $to = '';

    /** @var string */
    private $from = '';

    /** @var string */
    private $subjectTemplate = '';

    /** @var string */
    private $bodyTemplate = '';

    /**
     * @param string[] $options
     */
    public function __construct(array $options)
    {
        foreach ($options as $property => $value) {
            $this->$property = (string) $value;
        }
    }

    public function getBodyTemplate()
    {
        return $this->bodyTemplate;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getSubjectTemplate()
    {
        return $this->subjectTemplate;
    }

    public function getTo()
    {
        return $this->to;
    }
}
