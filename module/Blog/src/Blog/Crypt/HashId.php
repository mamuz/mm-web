<?php

namespace Blog\Crypt;

use Hashids\Hashids;

class HashId extends Hashids implements CryptInterface
{
    public function encrypt($value)
    {
        return parent::encrypt($value);
    }
}
