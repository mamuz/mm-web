<?php

return array(
    'mamuz-blog'   => array(
        'pagination' => array(
            'range' => array(
                'post' => 1,
                'tag'  => 10,
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'mamuz-blog/query/active-posts' => './module/Application/view/mamuz-blog/query/active-posts.phtml',
        )
    ),
);
