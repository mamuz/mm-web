<?php

namespace ContentManager\Controller;

use ContentManager\Feature\QueryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class QueryController extends AbstractActionController
{
    /** @var QueryInterface */
    private $queryService;

    /**
     * @param QueryInterface $queryService
     */
    public function __construct(QueryInterface $queryService)
    {
        $this->queryService = $queryService;
    }

    /**
     * Page content retrieval by route parameters
     *
     * @return ViewModel
     */
    public function pageAction()
    {
        $parent = $this->params()->fromRoute('parent');
        $child = $this->params()->fromRoute('child');
        $page = $this->queryService->findPageByNode($parent, $child);
        return new ViewModel(array('content' => $page->getContent()));
    }
}
