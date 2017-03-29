<?php

namespace Widgets\Icomoon;

class StyleReader
{
    private $css;
    private $fontVersion;
    private $icons;

    public function getFontVersion()
    {
        return $this->fontVersion;
    }

    public function getIcons()
    {
        return $this->icons;
    }

    public function read($file)
    {
        $this->css = file_get_contents($file);
        $this->setFontVersion();
        $this->setIcons();
    }

    private function setFontVersion()
    {
        $split1 = explode('icomoon.eot?', $this->css);
        $split2 = explode("');", $split1[1]);
        $this->fontVersion = $split2[0];
    }

    private function setIcons()
    {
        preg_match_all('/\.icon\-([a-zA-Z0-9\-_]+):before\s\{\n\s{2}content:\s"(\\\[a-z0-9]+)";\n\}/', $this->css, $matches, PREG_SET_ORDER);
        $this->icons = [];
        foreach ($matches as $match) {
            $this->icons[$match[1]] = $match[2];
        }
    }
}