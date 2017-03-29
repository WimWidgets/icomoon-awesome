<?php

namespace Widgets\Icomoon;

use Widgets\FileUploader;

class StyleUploader extends FileUploader
{
    public function __construct()
    {
        parent::__construct();
        $this->setAllowedMimeTypes(['css' => 'text/plain']);
    }
}