<?php

namespace Contact\Controller;

use Contact\Feature\CommandInterface;
use Zend\Form\FormInterface;
use Zend\Http\PhpEnvironment\Response;
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
        $prg = $this->prg('/contact', true);
        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return $this->viewModel;
        }

        if ($this->contactForm->setData($prg)->isValid()) {
            /** @var \Contact\Entity\Contact $contact */
            $contact = $this->contactForm->getData();
            $this->commandService->persist($contact);
            $this->viewModel->setVariable('contact', $contact);
        }

        return $this->viewModel;
    }
}
