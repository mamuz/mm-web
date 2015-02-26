<?php

namespace Application\View\Helper;

use MamuzBlog\View\Helper\PostMeta as MamuzBlogPostMeta;

class PostMeta extends MamuzBlogPostMeta
{
    protected function createDate(\DateTime $dateTime)
    {
        $dateString = $dateTime->format('F j, Y');
        $title = $this->getRenderer()->translate('Created at ') . $dateString;

        $html = $this->getRenderer()->glyphicon('calendar', array('title' => $title))
            . '&nbsp;<time datetime="' . $dateTime->format('Y-m-d') . '">'
            . $dateString
            . '</time>';

        return $html;
    }
}
