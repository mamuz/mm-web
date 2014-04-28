<?php

namespace Message\Listener;

use Message\Entity;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AggregaterFactory implements FactoryInterface
{
    /** @var ServiceLocatorInterface */
    private $serviceLocator;

    /** @var Entity\Listener[] */
    private $listeners = array();

    /**
     * {@inheritdoc}
     * @return Aggregate
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->loadListener();

        $collection = Entity\ListenerCollection;
        $collection->attachAll($this->listeners);

        return new Aggregate($collection);
    }

    /**
     * @return void
     */
    private function loadListener()
    {
        /** @var ServiceLocatorInterface $fem */
        $fem = $this->serviceLocator->get('FormElementManager');
        /** @var \Zend\Form\FormInterface $form */
        $form = $fem->get('Message\Form\ListenerEntity');
        $config = $this->serviceLocator->get('Config');
        if (isset($config['message']['listeners'])) {
            foreach ($config['message']['listeners'] as $listenerOptions) {
                if ($form->setData($listenerOptions)->isValid()) {
                    $this->listeners[] = $form->getData();
                }
            }
        }
    }
}
