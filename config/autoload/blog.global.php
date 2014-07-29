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
            'mamuz-blog/post-query/active-posts' => './module/Application/view/mamuz-blog/post-query/active-posts.phtml',
        )
    ),
);
