<?php

return array(
    'navigation' => array(
        'product-owner' => array(
            'check-out' => array(
                'label' => 'Check out',
                'uri'   => '#',
                'pages' => array(
                    'about-me' => array(
                        'label' => 'About Me',
                        'uri'   => '/about+me',
                    ),
                    'imprint'  => array(
                        'label' => 'Imprint',
                        'uri'   => '/imprint',
                    ),
                    'contact'  => array(
                        'label' => 'Contact',
                        'route' => 'contact',
                    ),
                ),
            ),
        ),
        'default'       => array(
            'home' => array(
                'label' => 'Home',
                'route' => 'home',
            ),
            'blog' => array(
                'label' => 'Blog',
                'uri'   => '/blog',
            ),
        ),
    ),
);
