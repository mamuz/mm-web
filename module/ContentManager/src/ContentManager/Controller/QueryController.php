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
        $parent = $this->params()->fromRoute('parent');
        $child = $this->params()->fromRoute('child');
        $page = $this->getQueryService()->findPageByNode($parent, $child);
        return new ViewModel(array('content' => $page->getContent()));
    }
}
