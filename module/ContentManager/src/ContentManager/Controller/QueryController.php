<?php

namespace ContentManager\Controller;

use ContentManager\Entity\NullPage;
use ContentManager\Feature\QueryInterface;
use Zend\Http\Response;
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
     * @return ViewModel|null
     */
    public function pageAction()
    {
        $path = $this->params()->fromRoute('path');
        $page = $this->queryService->findActivePageByPath($path);

        if ($page instanceof NullPage) {
            /** @var Response $response */
            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_404);
            return null;
        }

        return new ViewModel(array('page' => $page));
    }
}
