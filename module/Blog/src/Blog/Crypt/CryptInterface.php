<?php

namespace Blog\Crypt;

interface CryptInterface
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public function decrypt($value);

    /**
     * @param mixed $value
     * @return mixed
     */
    public function encrypt($value);
}
