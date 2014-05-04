<?php

namespace Blog\Crypt;

use Hashids\Hashids;

class HashId extends Hashids implements CryptInterface
{
    public function decrypt($value)
    {
        return parent::decrypt($value);
    }

    public function encrypt($value)
    {
        return parent::encrypt($value);
    }
}
