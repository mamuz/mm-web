<?php

namespace ContentManager\Filter;

use Zend\Filter\FilterInterface;

class PageCriteria implements FilterInterface
{
    /** @var array */
    private $criteria = array(
        'active'     => true,
        'name'       => null,
        'parentName' => null,
    );

    /**
     * @param array $criteria
     * @return PageCriteria
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;
        return $this;
    }

    /**
     * @return array
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    public function filter($value)
    {
        if (!is_array($value) && !$value instanceof \Traversable) {
            $value = (array)$value;
        }

        $criteria = $this->getCriteria();
        foreach ($criteria as $key => $val) {
            if (array_key_exists($key, $value)) {
                $criteria[$key] = $value[$key];
            }
        }

        if (null === $criteria['name']) {
            $criteria['name'] = $criteria['parentName'];
            $criteria['parentName'] = null;
        }

        return $criteria;
    }
}
