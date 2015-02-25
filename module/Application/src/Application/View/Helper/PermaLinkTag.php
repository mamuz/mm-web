<?php

namespace Application\View\Helper;

use MamuzBlog\View\Helper\PermaLinkTag as MamuzBlogPermaLinkTag;

class PermaLinkTag extends MamuzBlogPermaLinkTag
{
    /**
     * @param string|null $tagName
     * @return string
     */
    public function render($tagName = null)
    {
        $url = $this->getRenderer()->url(
            'blogPublishedPosts',
            array('tag' => $tagName)
        );

        return $url;
    }
}
