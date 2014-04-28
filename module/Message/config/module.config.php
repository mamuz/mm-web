<?php

return array(
    'service_manager' => array(
        'invokables' => array(
            'Message\Listener\Aggregate' => 'Message\Listener\AggregateFactory',
        ),
        'factories'  => array(
            'Message\Service\Mail' => 'Message\Service\MailFactory',
        ),
    ),
    'form_elements'   => array(
        'factories' => array(
            'Message\Form\ListenerEntity' => 'Message\Form\ListenerEntity',
        ),
    ),
);
