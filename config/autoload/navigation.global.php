<?php

return array(
    'navigation' => array(
        'default' => array(
            'home'     => array(
                'label' => 'Home',
                'route' => 'home',
                'options' => array('title' => 'Home of mamuz\' coding blog'),
            ),
            'blog'     => array(
                'label' => 'Archive',
                'uri'   => '/archive',
                'options' => array('title' => 'Blog Archive'),
            ),
            'about-me' => array(
                'label' => 'About',
                'uri'   => '/about',
                'options' => array('title' => 'About Me', 'rel' => 'author'),
            ),
            'contact'  => array(
                'label' => 'Contact',
                'route' => 'contact',
                'options' => array('title' => 'Contact Me'),
            ),
        ),
    ),
);
