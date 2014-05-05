<?php

namespace Blog\View\Helper;

use Blog\Entity\Post as PostEntity;
use Zend\View\Helper\AbstractHelper;

class PostPanel extends AbstractHelper
{
    /**
     * {@link render()}
     */
    public function __invoke(PostEntity $entity)
    {
        return $this->render($entity);
    }

    /**
     * @param PostEntity $entity
     * @return string
     */
    public function render(PostEntity $entity)
    {
        $url = $this->getView()->url(
            'blogActivePost',
            array(
                'title' => $entity->getTitle(),
                'id'    => $this->getView()->hashId($entity->getId())
            )
        );

        $html = '<div class="page-header">' . PHP_EOL
            . '<h3><a href="' . $url . '">' . $entity->getTitle() . '</a></h3>' . PHP_EOL
            . '</div>' . PHP_EOL
            . '<p>' . $entity->getContent() . '</p>' . PHP_EOL;

        return $html;
    }
}
