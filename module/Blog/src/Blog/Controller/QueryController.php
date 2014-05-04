<?php

namespace Blog\Controller;

use Blog\Crypt\CryptInterface;
use Blog\Feature\QueryInterface;
use Zend\Http\PhpEnvironment\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class QueryController extends AbstractActionController
{
    /** @var QueryInterface */
    private $queryService;

    /** @var CryptInterface */
    private $cryptEngine;

    /**
     * @param QueryInterface $queryService
     * @param CryptInterface $cryptEngine
     */
    public function __construct(
        QueryInterface $queryService,
        CryptInterface $cryptEngine
    ) {
        $this->queryService = $queryService;
        $this->cryptEngine = $cryptEngine;
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
            return $this->nullResponse();
        }

        return new ViewModel(array('collection' => $collection));
    }

    /**
     * Active post entry retrieval
     *
     * @return ModelInterface|null
     */
    public function activePostAction()
    {
        $encryptedId = $this->params()->fromRoute('id');
        if ($decryptedId = $this->cryptEngine->decrypt($encryptedId)) {
            $post = $this->queryService->findActivePostById($decryptedId);
        }

        if (!isset($post)) {
            return $this->nullResponse();
        }

        return new ViewModel(array('post' => $post));
    }

    /**
     * Set 404 status code to response
     *
     * @return null
     */
    private function nullResponse()
    {
        /** @var Response $response */
        $response = $this->getResponse();
        $response->setStatusCode(Response::STATUS_CODE_404);
        return null;
    }
}
