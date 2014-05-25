<?php

namespace Application\Navigation\Service;

use Zend\Navigation\Service\AbstractNavigationFactory;

class ProductOwnerNavigationFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'product-owner';
    }
}
