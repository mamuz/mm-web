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
        $criteria = $this->params()->fromRoute();
        $page = $this->queryService->findPageByCriteria($criteria);
        return new ViewModel(array('content' => $page->getContent()));
    }
}
