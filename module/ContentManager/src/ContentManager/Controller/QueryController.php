<?php

namespace ContentManager\Controller;

use ContentManager\Service\QueryAwareTrait;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class QueryController extends AbstractActionController
{
    use QueryAwareTrait;

    /**
     * Page content retrieval by name parameter
     *
     * @return ViewModel
     */
    public function pageAction()
    {
        $name = $this->params()->fromRoute('name');
        $page = $this->getQueryService()->findPageByName($name);
        return new ViewModel(array('content' => $page->getContent()));
    }
}
