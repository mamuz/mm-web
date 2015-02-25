<?php

namespace Application\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;
use MamuzBlog\View\Helper\PermaLinkPost as MamuzBlogPermaLinkPost;

class PermaLinkPost extends MamuzBlogPermaLinkPost
{
    /**
     * @param PostEntity $entity
     * @return string
     */
    public function render(PostEntity $entity)
    {
        $url = $this->getRenderer()->url(
            'blogPublishedPost',
            array(
                'title' => $this->getRenderer()->slugify($entity->getTitle()),
                'id'    => $this->getRenderer()->hashId($entity->getId())
            )
        );

        return $url;
    }
}
