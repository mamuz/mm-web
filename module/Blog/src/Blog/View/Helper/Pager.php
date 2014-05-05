<?php

namespace Blog\View\Helper;

use Blog\Options\RangeInterface;
use Zend\View\Helper\AbstractHelper;

class Pager extends AbstractHelper
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

        $paramsNext = $paramsPrev = $params;
        $paramsNext[$pageKey]++;
        $paramsPrev[$pageKey]--;

        $html = '';

        if ($pagesCount > 1) {

            $html .= '<ul class="pagination">' . PHP_EOL;

            if ($currentPage > 1) {
                $url = $this->getView()->url($route, $paramsPrev);
                $html .= '<li class="prev"><a href="' . $url . '">&laquo;</a></li>' . PHP_EOL;
            }

            for ($i = 1; $i <= $pagesCount; $i++) {
                $params[$pageKey] = $i;
                $class = $i == $currentPage ? ' class="active"' : '';
                $url = $this->getView()->url($route, $params);
                $html .= '<li' . $class . '><a href="' . $url . '">' . $i . '</a></li>' . PHP_EOL;
            }

            if ($currentPage < $pagesCount) {
                $url = $this->getView()->url($route, $paramsNext);
                $html .= '<li class="next"><a href="' . $url . '">&raquo;</a></li>' . PHP_EOL;
            }

            $html .= '</ul>' . PHP_EOL;
        }

        return $html;
    }
}
