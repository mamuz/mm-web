<?php

namespace Application\View\Helper;

use MamuzBlog\Entity\Post as PostEntity;
use MamuzBlog\View\Helper\PostPanel as MamuzBlogPostPanel;

class PostPanel extends MamuzBlogPostPanel
{
    public function render(PostEntity $entity)
    {
        parent::render($entity);

        return $this->panel($this->header, $this->content, $this->footer);
    }

    /**
     * @param string $header
     * @param string $content
     * @param string $footer
     * @return string
     */
    public function panel($header, $content, $footer)
    {
        $html = '<article>' . PHP_EOL
            . '<header><h1>' . $header . '</h1></header>' . PHP_EOL
            . '<p> ' . PHP_EOL
            . $content . PHP_EOL
            . '</p>' . PHP_EOL
            . '<footer>' . PHP_EOL
            . $footer . PHP_EOL
            . '</footer>' . PHP_EOL
            . '</article>';

        return $html;
    }
}
