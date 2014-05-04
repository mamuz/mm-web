<?php

namespace Blog\View\Helper;

use Blog\Crypt\CryptInterface;
use Zend\View\Helper\AbstractHelper;

class HashId extends AbstractHelper
{
    /** @var CryptInterface */
    private $cryptEngine;

    public function __construct(CryptInterface $cryptEngine)
    {
        $this->cryptEngine = $cryptEngine;
    }

    /**
     * {@link encrypt()}
     */
    public function __invoke($id)
    {
        return $this->encrypt($id);
    }

    /**
     * @param mixed $id
     * @return mixed string
     */
    public function encrypt($id)
    {
        return $this->cryptEngine->encrypt($id);
    }
}
