<?php

namespace Blog\View\Helper;

use Blog\Options\RangeInterface;
use Zend\View\Helper\AbstractHelper;

class PagerNext extends AbstractHelper
{
    /** @var RangeInterface */
    private $range;

    public function __construct(RangeInterface $range)
    {
        $this->range = $range;
    }

    /**
     * {@link render()}
     */
    public function __invoke(\Countable $collection, $route, array $params, $pageKey = 'page')
    {
        return $this->render($collection, $route, $params, $pageKey);
    }

    /**
     * @param \Countable $collection
     * @param string     $route
     * @param array      $params
     * @param string     $pageKey
     * @return string
     */
    public function render(\Countable $collection, $route, array $params, $pageKey = 'page')
    {
        $totalCount = count($collection);
        $pagesCount = ceil($totalCount / $this->range->getSize());
        $currentPage = $params[$pageKey];

        $paramsNext = $params;
        $paramsNext[$pageKey]++;

        $html = '';

        if ($pagesCount > 1 && $currentPage < $pagesCount) {
            $url = $this->getView()->url($route, $paramsNext);
            $html .= '<a class="next" href="' . $url . '">&raquo;</a>' . PHP_EOL;
        }

        return $html;
    }
}
