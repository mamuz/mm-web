<?php

namespace Application\View\Helper;

use MamuzBlog\Entity\Post;
use Zend\View\Helper\AbstractHelper;

class KeywordsByPost extends AbstractHelper
{
    /**
     * @param  Post  $post
     * @param  array $keywords
     * @return string
     */
    public function __invoke(Post $post, array $keywords = array())
    {
        foreach ($post->getTags() as $tag) {
            $keywords[] = $tag->getName();
        }

        return implode(', ', $keywords);
    }
}
