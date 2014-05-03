<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @Annotation\Name("blog")
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Annotation\Exclude()
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"Alnum", "options": {"allowWhiteSpace":"false"}})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"1", "max":"255"}})
     * @Annotation\Options({"label":"Title"})
     * @var string
     */
    private $title = '';

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Annotation\Attributes({"type":"text"})
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"3", "max":"65535"}})
     * @Annotation\Options({"label":"Content"})
     * @var string
     */
    private $content = '';

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @Annotation\Filter({"name":"Boolean"})
     * @Annotation\Options({"label":"Active"})
     * @var bool
     */
    private $active = false;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var \DateTime
     */
    private $modifiedAt;

    /**
     * init datetime objects
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * destroy identity and init datetime objects
     */
    public function __clone()
    {
        $this->id = null;
        $this->init();
    }

    /**
     * set createdAt and modifiedAt to now
     */
    private function init()
    {
        $this->createdAt = new \DateTime;
        $this->modifiedAt = new \DateTime;
    }

    /**
     * @param int $id
     * @return Blog
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $content
     * @return Blog
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param boolean $active
     * @return Blog
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }
}
