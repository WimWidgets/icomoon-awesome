<?php

namespace Widgets\Icomoon;

class FontAwesome
{
    const CLASS_NAME = 'im';

    private $lessDirectory;
    private $lessFiles;
    private $style;

    public function setVendorPath($vendorPath)
    {
        $this->lessDirectory = $vendorPath . 'fortawesome/font-awesome/less/';
        if (!file_exists($this->lessDirectory)) {
            throw new \RuntimeException('The Font Awesome package is not installed.');
        }
    }

    public function setStyle(StyleReader $style)
    {
        $this->style = $style;
    }

    public function convert()
    {
        $this->lessFiles = [];
        $this->createLessFile('animated');
        $this->createLessFile('bordered-pulled');
        $this->createLessFile('core');
        $this->createLessFile('fixed-width');
        $this->createLessFile('larger');
        $this->createLessFile('list');
        $this->createLessFile('mixins');
        $this->createLessFile('rotated-flipped');
        $this->createLessFile('screen-reader');
        $this->createLessFile('stacked');
        $this->createIcomoonFile();
        $this->createPathFile();
        $this->createVariablesFile();
        $this->createIconsFile();
        return $this->lessFiles;
    }

    private function createLessFile($name)
    {
        $file = $this->convertLessFile($name);
        $this->lessFiles[$name] = $file;
    }

    private function convertLessFile($name)
    {
        $file = file_get_contents($this->lessDirectory . $name . '.less');
        $file = str_replace('fa-', self::CLASS_NAME . '-', $file);
        $file = str_replace('FontAwesome', 'icomoon', $file);
        $file = str_replace('fontawesome-webfont', 'icomoon', $file);
        $file = str_replace('#fontawesomeregular', '#icomoon', $file);
        return $file;
    }

    private function createIcomoonFile()
    {
        $file = $this->convertLessFile('font-awesome');
        $this->lessFiles['icomoon'] = $file;
    }

    private function createPathFile()
    {
        $file = $this->convertLessFile('path');
        $file = preg_replace('/\s+url\(\'@\{'.self::CLASS_NAME.'\-font\-path\}\/icomoon\.woff2\?v=@\{'.self::CLASS_NAME.'\-version\}\'\)\sformat\(\'woff2\'\),/', '', $file);
        $this->lessFiles['path'] = $file;
    }

    private function createVariablesFile()
    {
        $file = $this->convertLessFile('variables');
        $file = str_replace('14px', '16px', $file);
        $file = preg_replace('/(\s+)fa;/', '$1'.self::CLASS_NAME.';', $file);
        $file = preg_replace('/"[0-9\.?]+"/', '"'.$this->style->getFontVersion().'"', $file);
        $file = preg_replace('/@'.self::CLASS_NAME.'\-var\-([a-zA-Z0-9\-_]+):\s"\\\([a-z0-9]+)";\n/', '', $file);
        foreach ($this->style->getIcons() as $name => $code) {
            $file .= "@".self::CLASS_NAME."-var-".$name.": \"".$code."\";\n";
        }
        $this->lessFiles['variables'] = $file;
    }

    private function createIconsFile()
    {
        $file = '';
        foreach ($this->style->getIcons() as $name => $code) {
            $file .= ".@{".self::CLASS_NAME."-css-prefix}-".$name.":before { content: @".self::CLASS_NAME."-var-".$name."; }\n";
        }
        $this->lessFiles['icons'] = $file;
    }
}