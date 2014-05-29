# MamuzApplication

## Configuration

In config file define logging and http header

```php
return array(
    'mamuz-application'        => array(
        'http' => array(
            'headers' => array(
                'Content-Type'     => 'text/html; charset=UTF-8',
                'Content-Language' => 'en',
            ),
        ),
        'log'  => array(
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
```

## Mail Listener

Listener for triggered events can be implemented in src/MamuzApplication/Listener/Aggregate.
For example you can sending mails for that by using Mail Service.
Those services can be configured by a factory, which reads options from module config.

```php
return array(
    'mamuz-application'        => array(
        'mail' => array(
            'contact' => array(
                'template_map' => array(
                    'contact/subject' => __DIR__ . '/../view/mail/contact/subject.phtml',
                    'contact/body'    => __DIR__ . '/../view/mail/contact/body.phtml',
                ),
                'options'      => array(
                    'to'              => 'muzzi_is@web.de',
                    'from'            => 'automail@marco-muths.de',
                    'subjectTemplate' => 'contact/subject',
                    'bodyTemplate'    => 'contact/body',
                ),
            ),
        ),
    ),
);
```
