<?php

namespace MamuzApplication\View\Helper;

use Zend\View\Helper\AbstractHelper;

class AutoVersion extends AbstractHelper
{
    /** @var string */
    private $documentRoot;

    /**
     * @param string $documentRoot
     */
    public function __construct($documentRoot)
    {
        $this->documentRoot = $documentRoot;
    }

    /**
     * @param  string $file
     * @return string
     */
    public function __invoke($file)
    {
        if (strpos($file, '/') !== 0
            || !file_exists($this->documentRoot . $file)
        ) {
            return $file;
        }

        $mtime = filemtime($this->documentRoot . $file);
        return preg_replace('{\\.([^./]+)$}', ".$mtime.\$1", $file);
    }
}
