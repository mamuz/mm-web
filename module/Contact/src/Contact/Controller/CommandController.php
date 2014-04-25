<?php

namespace Contact\Controller;

use Contact\Feature\CommandInterface;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class CommandController extends AbstractActionController
{
    /** @var CommandInterface */
    private $commandService;

    /** @var FormInterface */
    private $contactForm;

    /** @var ModelInterface */
    private $viewModel;

    /**
     * @param CommandInterface $commandService
     * @param FormInterface    $contactForm
     */
    public function __construct(
        CommandInterface $commandService,
        FormInterface $contactForm
    ) {
        $this->commandService = $commandService;
        $this->contactForm = $contactForm;
        $this->viewModel = new ViewModel(array('form' => $this->contactForm));
    }

    /**
     * Persist contact entity
     *
     * @return ModelInterface
     */
    public function createAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        if ($request->isPost()
            && $this->contactForm->setData($request->getPost())->isValid()
        ) {
            /** @var \Contact\Entity\Contact $contact */
            $contact = $this->contactForm->getData();
            $this->commandService->persist($contact);
            $this->viewModel->setVariable('contact', $contact);
        }

        return $this->viewModel;
    }
}
