<?php

namespace Blog\Options;

interface RangeInterface
{
    /**
     * @return int
     */
    public function getSize();

    /**
     * @param int $point
     * @return int
     */
    public function getOffsetBy($point);
}
