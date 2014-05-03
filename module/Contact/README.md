# Captcha support

## Configuration

Create a new config file and place it to config/autoload. Insert an array with options
for the Zend Captcha form element factory. e.g:

```php
return array(
    'captcha' => array(
        'type'       => 'Zend\Form\Element\Captcha',
        'name'       => 'captcha',
        'options'    => array(
            'label'   => 'Please verify you are human',
            'captcha' => array(
                'class'   => 'recaptcha',
                'options' => array(
                    'pubkey'  => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                    'privkey' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
                ),
            ),
        ),
        'attributes' => array(
            'required' => 'required'
        ),
    ),
);
```

## Requirement for Google ReCaptcha WebService

Register your domain to [Google ReCaptcha WebService](http://recaptcha.net/) to
create a private key and a public key. Be sure that private key will not commit to VCS.
Usage of Recaptcha requires [ZendService_Recapcha](https://github.com/zendframework/ZendService_ReCaptcha).
Add this dependency to composer.json.
