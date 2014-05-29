<?php

namespace MamuzApplication\View\Helper\Navigation;

use Zend\Navigation\Page\AbstractPage;
use Zend\View\Helper\AbstractHelper;

class Item extends AbstractHelper
{
    /**
     * Proxies to {@link render()}
     */
    public function __invoke(AbstractPage $page)
    {
        return $this->render($page);
    }

    /**
     * @param  AbstractPage $page
     * @return string
     */
    public function render(AbstractPage $page)
    {
        $attributes = array('class' => array());
        if ($page->isActive($page->hasPages())) {
            $attributes['class'][] = 'active';
        }
        if ($page->hasPages()) {
            $attributes['class'][] = 'dropdown';
        }

        $html = '<li' . $this->createStringFrom($attributes) . '>' . $this->createAnchorFrom($page);

        if ($page->hasPages()) {
            $html .= PHP_EOL . '<ul class="dropdown-menu">' . PHP_EOL;
            foreach ($page->getPages() as $child) {
                $html .= $this->render($child);
            }
            $html .= '</ul>' . PHP_EOL;
        }

        return $html . '</li>' . PHP_EOL;
    }

    /**
     * @param  AbstractPage $page
     * @return string
     */
    private function createAnchorFrom(AbstractPage $page)
    {
        $label = $page->getLabel();
        $attributes = array('href' => $page->getHref());

        if ($page->hasPages()) {
            $attributes['class'] = "dropdown-toggle";
            $attributes['data-toggle'] = "dropdown";
            $label .= '<b class="caret"></b>';
        }
        if ($page->getTarget()) {
            $attributes['target'] = $page->getTarget();
        }

        return '<a' . $this->createStringFrom($attributes) . '>' . $label . '</a>';
    }

    /**
     * @param array $attributes
     * @return string
     */
    private function createStringFrom(array $attributes)
    {
        $strings = array();
        foreach ($attributes as $property => $value) {
            if (is_array($value)) {
                $value = implode(' ', $value);
            }
            if (strlen($value) > 0) {
                $strings[] = $property . '="' . $value . '"';
            }
        }

        if (empty($strings)) {
            return '';
        }

        return ' ' . implode(' ', $strings);
    }
}
