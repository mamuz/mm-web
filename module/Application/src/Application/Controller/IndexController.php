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
        $collection = $queryService->findPublishedPosts();

        return new ViewModel(array('collection' => $collection));
    }
}
