<?php

return array(
    'mamuz-blog'   => array(
        'pagination'     => array(
            'range' => array(
                'post' => 1,
                'tag'  => 10,
            ),
        ),
        'display-disqus' => true,
    ),
    'view_manager' => array(
        'template_map' => array(
            // @codingStandardsIgnoreStart
            'mamuz-blog/post-query/published-post'  => './module/Application/view/mamuz-blog/post-query/published-post.phtml',
            'mamuz-blog/post-query/published-posts' => './module/Application/view/mamuz-blog/post-query/published-posts.phtml',
            'mamuz-blog/tag-query/items'            => './module/Application/view/mamuz-blog/tag-query/items.phtml',
            // @codingStandardsIgnoreEnd
        )
    ),
    'blog_domain' => array(
        'factories' => array(
            'MamuzBlogFeed\Feed\Writer\Factory' => 'Application\Feed\WriterFactory',
        ),
    ),
);
