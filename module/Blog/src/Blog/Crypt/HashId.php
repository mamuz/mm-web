<?php

namespace Blog\Crypt;

use Hashids\Hashids;

class HashId extends Hashids implements CryptInterface
{
    public function decrypt($value)
    {
        $decrypted = parent::decrypt($value);
        if (is_array($decrypted)) {
            $decrypted = $decrypted[0];
        }
        return $decrypted;
    }

    public function encrypt($value)
    {
        return parent::encrypt($value);
    }
}
