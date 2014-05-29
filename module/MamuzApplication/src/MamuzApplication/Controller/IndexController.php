<?php

namespace MamuzApplication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    /**
     * Home
     *
     * @return ModelInterface
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}
