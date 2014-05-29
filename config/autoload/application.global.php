<?php

return array(
    'mamuz-application' => array(
        'document_root' => $_SERVER['DOCUMENT_ROOT'],
        'http'          => array(
            'headers' => array(
                'Content-Type'     => 'text/html; charset=UTF-8',
                'Content-Language' => 'en',
            ),
        ),
        'mail'          => array(
            'contact' => array(
                'template_map' => array(
                    'contact/subject' => './module/MamuzApplication/view/mamuz-mail/contact/subject.phtml',
                    'contact/body'    => './module/MamuzApplication/view/mamuz-mail/contact/body.phtml',
                ),
                'options'      => array(
                    'to'              => 'muzzi_is@web.de',
                    'from'            => 'automail@marco-muths.de',
                    'subjectTemplate' => 'contact/subject',
                    'bodyTemplate'    => 'contact/body',
                ),
            ),
        ),
        'log'           => array(
            'exceptionhandler'             => true,
            'errorhandler'                 => true,
            'fatal_error_shutdownfunction' => true,
            'writers'                      => array(
                'error' => array(
                    'name'    => 'stream',
                    'options' => array(
                        'stream'    => './data/logs/error_' . date('Y-m') . '.log',
                        'formatter' => array(
                            'name'    => 'simple',
                            'options' => array(
                                'dateTimeFormat' => 'Y-m-d H:i:s'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
