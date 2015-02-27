<?php

return array(
    'MamuzBlogFeed' => array(
        'default' => array(
            'autoHeadLink'  => true,
            'type' => 'rss',
            'maxResults'    => 100,
            'language'      => 'en',
            'dateCreated'   => new \DateTime('2015-02-26'),
            'lastBuildDate' => new \DateTime,
            'title'         => "mamuz' coding blog",
            'description'   => 'Practices, Principles and Patterns of Web-Development',
            'encoding'      => 'UTF-8',
            'copyright'     => date('Y') . ' by Marco Muths. All rights reserved.',
            'image'         => array(
                'uri'         => 'http://www.mamuz.de/img/logo.png',
                'title'       => "mamuz' coding blog",
                'link'        => 'http://www.mamuz.de',
                'description' => 'Practices, Principles and Patterns of Web-Development',
            ),
            'categories'    => array(
                array(
                    'term' => 'IT',
                ),
                array(
                    'term' => 'Web-Development',
                ),
                array(
                    'term' => 'Programming',
                ),
            ),
        ),
    ),
);
