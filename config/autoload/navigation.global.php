<?php

return array(
    'navigation' => array(
        'default' => array(
            'home'         => array(
                'label' => 'Home',
                'route' => 'home',
            ),
            'blog'         => array(
                'label' => 'Blog',
                'route' => 'blogActivePosts',
            ),
            'frontend'     => array(
                'label' => 'Frontend',
                'uri'   => '#',
                'pages' => array(
                    'introduction'      => array(
                        'label' => 'Introduction',
                        'uri'   => '/frontend/introduction',
                    ),
                    'html'              => array(
                        'label' => 'HTML',
                        'uri'   => '/frontend/html',
                    ),
                    'css'               => array(
                        'label' => 'CSS',
                        'uri'   => '/frontend/css',
                    ),
                    'javascript'        => array(
                        'label' => 'JavaScript',
                        'uri'   => '/frontend/javascript',
                    ),
                    'user-experience'   => array(
                        'label' => 'User Experience',
                        'uri'   => '/frontend/user-experience',
                    ),
                    'responisve-design' => array(
                        'label' => 'Responsive Design',
                        'uri'   => '/frontend/responsive+design',
                    ),
                    'frameworks'        => array(
                        'label' => 'Frameworks',
                        'uri'   => '/frontend/frameworks',
                    ),
                ),
            ),
            'oop'          => array(
                'label' => 'OOP',
                'uri'   => '#',
                'pages' => array(
                    'php'             => array(
                        'label' => 'PHP',
                        'uri'   => '/oop/php',
                    ),
                    'clean-code'      => array(
                        'label' => 'Clean Code',
                        'uri'   => '/oop/clean+code',
                    ),
                    'solid'           => array(
                        'label' => 'SOLID',
                        'uri'   => '/oop/solid',
                    ),
                    'principles'      => array(
                        'label' => 'Principles',
                        'uri'   => '/oop/principles',
                    ),
                    'design-patterns' => array(
                        'label' => 'Design Patterns',
                        'uri'   => '/oop/design+patterns',
                    ),
                    'aspect-oriented' => array(
                        'label' => 'Aspect-Oriented',
                        'uri'   => '/oop/aspect-oriented',
                    ),
                    'frameworks'      => array(
                        'label' => 'Frameworks',
                        'uri'   => '/oop/frameworks',
                    ),
                ),
            ),
            'architecture' => array(
                'label' => 'Architecture',
                'uri'   => '#',
                'pages' => array(
                    'planning'      => array(
                        'label' => 'Planning',
                        'uri'   => '/architecture/planning',
                    ),
                    'conventions'   => array(
                        'label' => 'Conventions',
                        'uri'   => '/architecture/conventions',
                    ),
                    'principles'    => array(
                        'label' => 'Principles',
                        'uri'   => '/architecture/principles',
                    ),
                    'documentation' => array(
                        'label' => 'Documentation',
                        'uri'   => '/architecture/documentation',
                    ),
                ),
            ),
            'agile'        => array(
                'label' => 'Agile',
                'uri'   => '#',
                'pages' => array(
                    'scrum'                 => array(
                        'label' => 'Scrum',
                        'uri'   => '/agile/scrum',
                    ),
                    'continous-integration' => array(
                        'label' => 'Continous Integration',
                        'uri'   => '/agile/continous+integration',
                    ),
                    'domain-driven'         => array(
                        'label' => 'Domain-Driven',
                        'uri'   => '/agile/domain-driven',
                    ),
                    'test-driven'           => array(
                        'label' => 'Test-Driven',
                        'uri'   => '/agile/test-driven',
                    ),
                    'behavior-driven'       => array(
                        'label' => 'Behavior-Driven',
                        'uri'   => '/agile/behavior-driven',
                    ),
                ),
            ),
        ),
    ),
);
