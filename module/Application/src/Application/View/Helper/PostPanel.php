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
        $isoDate = $this->entity->getModifiedAt()->format('c');

        $html = '<article itemscope itemtype="http://schema.org/BlogPosting">' . PHP_EOL
            . '<header><h1 itemprop="headline">' . $header . '</h1></header>' . PHP_EOL
            . '<footer>' . $footer . '</footer>' . PHP_EOL
            . '<div itemprop="articleBody">' . $content . '</div>' . PHP_EOL
            . '<div itemprop="description" class="hide">'
            . $this->getRenderer()->markdown($this->entity->getDescription())
            . '</div>' . PHP_EOL
            . '<meta itemprop="datePublished" content="' . $isoDate . '" />' . PHP_EOL
            . '</article>';

        return $html;
    }
}
