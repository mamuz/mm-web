<?php

namespace MamuzApplication\Navigation;

use Zend\Navigation\Service\AbstractNavigationFactory;

class ProductOwnerFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'product-owner';
    }
}
