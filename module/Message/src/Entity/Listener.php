<?php

namespace Message\Entity;

use Zend\Filter\FilterInterface;
use Zend\Form\Annotation;

class Listener
{
    /**
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required()
     * @var string
     */
    private $id;

    /**
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Required()
     * @var string
     */
    private $event;

    /**
     * @Annotation\Validator({"name":"Callback", "options": {"callback":"isArray"}})
     * @Annotation\Required()
     * @var array
     */
    private $adapterOptions;

    /**
     * @var FilterInterface|null
     */
    private $filter;

    /**
     * @param array $adapterOptions
     * @return Listener
     */
    public function setAdapterOptions(array $adapterOptions)
    {
        $this->adapterOptions = $adapterOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getAdapterOptions()
    {
        return $this->adapterOptions;
    }

    /**
     * @param string $event
     * @return Listener
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param FilterInterface $filter
     * @return Listener
     */
    public function setFilter(FilterInterface $filter)
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return null|FilterInterface
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @return boolean
     */
    public function hasFilter()
    {
        return $this->filter instanceof FilterInterface;
    }

    /**
     * @param string $id
     * @return Listener
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
