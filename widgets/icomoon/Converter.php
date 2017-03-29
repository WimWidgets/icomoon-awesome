<?php

namespace Widgets\Icomoon;

class Converter
{
    private $rootPath;
    private $name;
    private $file;
    private $style;

    public function setRootPath($path)
    {
        $this->rootPath = $path;
    }

    public function convert($fileInputName)
    {
        $this->name = $fileInputName;
        $this->upload();
        $this->read();
        $files = $this->convertFontAwesome();
        return $this->createZip($files);
    }

    private function upload()
    {
        $uploader = new StyleUploader();
        $this->file = $uploader->upload($this->name);
    }

    private function read()
    {
        $this->style = new StyleReader();
        $this->style->read($this->file);
    }

    private function convertFontAwesome()
    {
        $fa = new FontAwesome();
        $fa->setVendorPath($this->rootPath.'/vendor/');
        $fa->setStyle($this->style);
        return $fa->convert();
    }

    private function createZip($files)
    {
        $dir = 'output';
        if (!file_exists($this->rootPath.'/'.$dir)) {
            mkdir($this->rootPath.'/'.$dir, 0777, true);
        }
        $path = $dir.'/icomoon-awesome.zip';
        $zip = new \ZipArchive();
        if ($zip->open($this->rootPath.'/'.$path, \ZipArchive::CREATE) !== true) {
            throw new \RuntimeException('Cannot create a zip file.');
        }
        foreach ($files as $name => $data) {
            $zip->addFromString($name.'.less', $data);
        }
        $zip->close();
        return $path;
    }
}