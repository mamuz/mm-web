<?php

namespace MamuzApplicationTest\Service;

use MamuzApplication\Service\ContactMailFactory;

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
            'mamuz-application' => array(
                'mail' => array(
                    'contact' => array(
                        'template_map' => array(),
                        'options'      => array(),
                    )
                )
            )
        );
        $sm = \Mockery::mock('Zend\ServiceManager\ServiceLocatorInterface');
        $sm->shouldReceive('get')->with('Config')->andReturn($config);

        $service = $this->fixture->createService($sm);

        $this->assertInstanceOf('\MamuzApplication\Service\Feature\MailObjectInterface', $service);
    }
}
