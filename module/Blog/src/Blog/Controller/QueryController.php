<?php

namespace Blog\Controller;

use Blog\Feature\QueryInterface;
use Zend\Http\PhpEnvironment\Response;
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
     * Active post entries retrieval
     *
     * @return ModelInterface|null
     */
    public function activePostsAction()
    {
        $this->queryService->setCurrentPage($this->params()->fromRoute('page', 1));

        if ($tag = $this->params()->fromRoute('tag')) {
            $collection = $this->queryService->findActivePostsByTag($tag);
        } else {
            $collection = $this->queryService->findActivePosts();
        }

        if ($collection instanceof \Countable
            && count($collection) < 1
        ) {
            /** @var Response $response */
            $response = $this->getResponse();
            $response->setStatusCode(Response::STATUS_CODE_404);
            return null;
        }

        return new ViewModel(array('collection' => $collection));
    }
}
