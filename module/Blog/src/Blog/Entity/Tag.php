<?php

namespace Blog\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

/**
 * @ORM\Entity
 * @Annotation\Name("tag")
 */
class Tag
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
     * @ORM\Column(type="string", nullable=false)
     * @Annotation\Filter({"name":"StripTags"})
     * @Annotation\Filter({"name":"StringTrim"})
     * @Annotation\Validator({"name":"Alnum", "options": {"allowWhiteSpace":"false"}})
     * @Annotation\Validator({"name":"StringLength", "options": {"min":"1", "max":"255"}})
     * @Annotation\Options({"label":"Name"})
     * @Annotation\Required()
     * @var string
     */
    private $name = '';

    /**
     * @ManyToMany(targetEntity="Blog", mappedBy="tags")
     * @var Collection
     */
    private $blogs;

    /**
     * init datetime objects
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * destroy identity
     */
    public function __clone()
    {
        $this->id = null;
    }

    /**
     * @param int $id
     * @return Tag
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
     * @param string $name
     * @return Blog
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Collection $blogs
     * @return Tag
     */
    public function setBlogs(Collection $blogs)
    {
        $this->blogs = $blogs;
        return $this;
    }

    /**
     * @return Collection|Blog[]
     */
    public function getBlogs()
    {
        return $this->blogs;
    }
}
