<?php

namespace Bootstrap;

use Exception;

class View
{
    const FOLDER = __DIR__ . "/../resources";
    const LAYOUT_FOLDER = self::FOLDER . self::DS . 'layouts';
    const DS = DIRECTORY_SEPARATOR;
    const FILE_EXTENSION = ".php";

    private $layout = 'app';
    private $title = null;
    private $styles = [];
    private $scripts = [];
    private $bottom_scripts = [];

    /**
     * @param string $view
     * @param array $data
     * @throws Exception
     */
    public function render(string $view, array $data)
    {
        $view = self::FOLDER . self::DS . 'views' . self::DS . $view . self::FILE_EXTENSION;

        if (file_exists($view))
            echo $this->getLayout($view, $data);
        else
            throw new Exception(
                sprintf("%s view was not found on the server", $view)
            );
    }

    /**
     * @param string $view
     * @param $data
     * @return false|string
     */
    private function getView(string $view, $data)
    {
        ob_start();
        extract($data);
        include_once $view;
        return ob_get_clean();
    }

    /**
     * @param $view
     * @param $data
     * @return false|string
     */
    public function getLayout($view, $data)
    {
        ob_start();
        $content = $this->getView($view, $data);

        $layout = self::LAYOUT_FOLDER . self::DS . $this->layout . self::FILE_EXTENSION;

        if (!file_exists($layout))
            throw new Exception("%s layout was not found on the server", $layout);

        include_once $layout;
        return ob_get_clean();
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function setStyles(array $styles)
    {
        $this->styles = $styles;
    }

    public function setTopScripts(array $scripts)
    {
        $this->scripts = $scripts;
    }

    public function setBottomScripts(array $scripts)
    {
        $this->bottom_scripts = $scripts;
    }

    public function getBottomScripts()
    {
        foreach($this->bottom_scripts as $script) {
            echo $this->scriptTag(array_shift($script), array_shift($script));
        }
    }

    public function getTopScripts()
    {
        foreach($this->scripts as $script) {
            echo $this->scriptTag(array_shift($script), array_shift($script));
        }
    }

    public function getStyles()
    {
        foreach($this->styles as $style) {
            echo $this->styleTag(array_shift($style), array_shift($style));
        }
    }

    public function scriptTag($script, $additonal)
    {
        return '<script src="'. $script .'" '. $additional . '></script>' . PHP_EOL;
    }

    public function styleTag($style, $additonal)
    {
        return '<link rel="stylesheet" href="'. $style .'" '. $additional . '>' . PHP_EOL;
    }
}
