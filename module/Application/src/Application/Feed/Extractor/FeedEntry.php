<?php

namespace Application\Feed\Extractor;

use MamuzBlog\Entity\Post;
use MamuzBlogFeed\Extractor\FeedEntry as MamuzBlogFeedEntry;

class FeedEntry extends MamuzBlogFeedEntry
{
    protected function getArrayCopyFrom(Post $object)
    {
        /** @var \MamuzBlog\View\Renderer\PhpRenderer $renderer */
        $renderer = $this->getRenderer();

        $permaLink = $renderer->permaLinkPost($object);

        $data = array(
            'id'           => $permaLink,
            'link'         => $permaLink,
            'commentLink'  => $permaLink . '#disqus_thread',
            'title'        => $object->getTitle(),
            'description'  => $renderer->markdown($object->getDescription()),
            'content'      => $renderer->markdown($object->getContent()),
            'dateModified' => $object->getModifiedAt(),
            'dateCreated'  => $object->getCreatedAt(),
        );

        return $data;
    }
}
