<?php

namespace Blog\Controller;

use Blog\Feature\QueryInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
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
     * Latest blog entries retrieval
     *
     * @return ModelInterface
     */
    public function listAction()
    {
        $collection = $this->queryService->findCollection($this->params()->fromRoute());
        return new ViewModel(array('collection' => $collection));
    }
}
