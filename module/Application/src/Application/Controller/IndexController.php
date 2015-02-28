<?php

namespace Application\Controller;

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
        /** @var \Zend\ServiceManager\ServiceLocatorInterface $blogDomain */
        $blogDomain = $this->getServiceLocator()->get('MamuzBlog\DomainManager');
        /** @var \MamuzBlog\Feature\PostQueryInterface $queryService */
        $queryService = $blogDomain->get('MamuzBlog\Service\PostQuery');
        $collection = $queryService->findPublishedPosts()->getIterator();

        if (isset($collection[0])) {
            $post = $collection[0];
        } else {
            $post = null;
        }

        $viewModel = new ViewModel(array('post' => $post));
        $viewModel->setTemplate('mamuz-blog/post-query/published-post');

        return $viewModel;
    }
}
