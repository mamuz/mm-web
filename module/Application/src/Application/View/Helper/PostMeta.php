<?php

namespace Application\View\Helper;

use MamuzBlog\View\Helper\PostMeta as MamuzBlogPostMeta;

class PostMeta extends MamuzBlogPostMeta
{
    protected function createDate(\DateTime $dateTime)
    {
        $html = $this->getRenderer()->glyphicon('calendar')
            . '<time datetime="' . $dateTime->format('Y-m-d') . '" pubdate="pubdate">'
            . $dateTime->format('F j, Y')
            . '</time>';

        return $html;
    }
}
