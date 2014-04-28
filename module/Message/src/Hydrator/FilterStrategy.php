<?php

namespace Message\Hydrator;

use Zend\Filter\FilterInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class FilterStrategy implements StrategyInterface, ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @return ServiceLocatorInterface
     */
    private function getFilterManager()
    {
        return $this->serviceLocator->get('FilterManager');
    }

    /**
     * @param FilterInterface $value
     * @return string
     */
    public function extract($value)
    {
        return get_class($value);
    }

    /**
     * @param string $value
     * @return FilterInterface
     */
    public function hydrate($value)
    {
        return $this->getFilterManager()->get($value);
    }
}
