<?php

namespace ApplicationTest\Service;

use Application\Service\ContactMailFactory;

class ContactMailFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var ContactMailFactory */
    protected $fixture;

    protected function setUp()
    {
        $this->fixture = new ContactMailFactory;
    }

    public function testImplementingFactoryInterface()
    {
        $this->assertInstanceOf('Zend\ServiceManager\FactoryInterface', $this->fixture);
    }

    public function testCreation()
    {
        $config = array(
            'application' => array(
                'mail' => array(
                    'contact' => array(
                        'options' => array(),
                    )
                )
            )
        );

        $renderer = \Mockery::mock('Zend\View\Renderer\RendererInterface');
        $viewManager = \Mockery::mock('Zend\View\HelperPluginManager');
        $viewManager->shouldReceive('getRenderer')->andReturn($renderer);

        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('ViewManager')->andReturn($viewManager);
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('\Application\Service\Feature\MailObjectInterface', $service);
    }
}
