<?php

namespace Widgets;

class FileUploader
{
    private $maximumFileSize;
    private $allowedMimeTypes;
    private $fileName;

    public function __construct()
    {
        $this->maximumFileSize = 1024 * 1024;
        $this->allowedMimeTypes = [];
    }

    public function setMaximumFileSize($size)
    {
        $this->maximumFileSize = $size;
        return $this;
    }

    public function getMaximumFileSize()
    {
        return $this->maximumFileSize;
    }

    public function setAllowedMimeTypes($mimeTypes)
    {
        $this->allowedMimeTypes = $mimeTypes;
        return $this;
    }

    public function getAllowedMimeTypes()
    {
        return $this->allowedMimeTypes;
    }

    public function upload($name)
    {
        $this->fileName = $name;
        $this->hasError();
        $this->checkErrorType();
        $this->checkFileSize();
        $this->checkMimeType();
        return $_FILES[$this->fileName]['tmp_name'];
    }

    private function hasError()
    {
        if (
            !isset($_FILES[$this->fileName]['error']) ||
            is_array($_FILES[$this->fileName]['error'])
        ) {
            throw new \RuntimeException('Invalid parameters.');
        }
    }

    private function checkErrorType()
    {
        switch ($_FILES[$this->fileName]['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new \RuntimeException('Exceeded filesize limit.');
            default:
                throw new \RuntimeException('Unknown errors.');
        }
    }

    private function checkFileSize()
    {
        if ($_FILES[$this->fileName]['size'] > 5 * 1024 * 1024) {
            throw new \RuntimeException('Exceeded filesize limit.');
        }
    }

    private function checkMimeType()
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search(
                $finfo->file($_FILES[$this->fileName]['tmp_name']),
                $this->allowedMimeTypes,
                true
            )) {
            throw new \RuntimeException('Invalid file format.');
        }
    }
}