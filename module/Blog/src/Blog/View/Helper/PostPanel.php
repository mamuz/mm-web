<?php

namespace Blog\View\Helper;

use Blog\Entity\Post as PostEntity;
use Zend\View\Helper\AbstractHelper;

class PostPanel extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke(PostEntity $entity, $headerLink = true)
    {
        return $this->render($entity, $headerLink);
    }

    /**
     * @param PostEntity $entity
     * @param bool       $headerLink
     * @return string
     */
    public function render(PostEntity $entity, $headerLink = true)
    {
        $header = $entity->getTitle();

        if ($headerLink) {
            $url = $this->getView()->url(
                'blogActivePost',
                array(
                    'title' => $entity->getTitle(),
                    'id'    => $this->getView()->hashId($entity->getId())
                )
            );
            $header = '<a href="' . $url . '">' . $header . '</a>';
        }

        $html = '<div class="page-header">' . PHP_EOL
            . '<h3>' . $header . '</h3>' . PHP_EOL
            . '</div>' . PHP_EOL
            . $this->getView()->markdown($entity->getContent());

        return $html;
    }
}
