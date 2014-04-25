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
     * Page retrieval by route parameters
     *
     * @return ViewModel
     */
    public function pageAction()
    {
        $path = $this->params()->fromRoute('path');
        $page = $this->queryService->findActivePageByPath($path);
        return new ViewModel(array('page' => $page));
    }
}
