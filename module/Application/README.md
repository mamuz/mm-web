# Application

## Configuration

In ``./config/autoload/application.global.php`` you have to define

 - document root: used for asset versioning
 - http headers: used for sending response headers
 - log: used for error logger factory

### Example

```php
return array(
    'application' => array(
        'document_root' => $_SERVER['DOCUMENT_ROOT'],
        'http'          => array(
            'headers' => array(
                'Content-Type'     => 'text/html; charset=UTF-8',
                'Content-Language' => 'en',
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
                        'stream'    => './data/log/error/' . date('Y-m') . '.log',
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

### Mail Listener

Listener for triggered events can be implemented in src/Application/Listener/Aggregate.
For example you can sending mails for that by using Mail Service.
Those services can be configured by a factory, which reads options from module config.

```php
return array(
    'application'        => array(
        'mail' => array(
            'contact' => array(
                'template_map' => array(
                    'contact/subject' => __DIR__ . '/../view/mail/contact/subject.phtml',
                    'contact/body'    => __DIR__ . '/../view/mail/contact/body.phtml',
                ),
                'options'      => array(
                    'to'              => 'foo@bar.com',
                    'from'            => 'baz@bam.com',
                    'subjectTemplate' => 'contact/subject',
                    'bodyTemplate'    => 'contact/body',
                ),
            ),
        ),
    ),
);
```

## Output cache

To improve response performance an output cache exists, which can be configured
with factory options in ``./config/autoload/cache.global.php``. Each route which not
contains in ``blacklistedRouteNames`` array will be cached. Cached responses have an
additional header ``X-Application-Cache``.

### Example

```php
return array(
    'caches' => array(
        'outputCache' => array(
            'adapter'               => array(
                'name' => 'filesystem'
            ),
            'options'               => array(
                'cache_dir' => './data/cache/output',
            ),
            'blacklistedRouteNames' => array(
                'contact'
            ),
        ),
    ),
);
```

## Navigation

Navigation is build by view helper specialized for bootstrap and configured by
``./config/autoload/navigation.global.php`` which contains options for Zend\Navigation factory.
