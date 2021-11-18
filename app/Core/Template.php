<?php

namespace App\Core;

class Template
{
    private $__directory;
    private $__layout;
    private $__sections;
    private $__current_section;

    public function __construct($directory)
    {
        $this->__setDirectory($directory);
        $this->__sections = [];
        $this->__layout = null;
        $this->__current_section = null;
    }

    private function __setDirectory(string $directory)
    {
        if (!is_dir($directory)) {
            throw new \Exception("$directory is not exist");
        }

        $this->__directory = $directory;
    }

    private function __resolvePath(string $path)
    {
        $file = $this->__directory . '/' . str_replace('.', '/', $path) . '.php';

        if (!file_exists($file)) {
            throw new \Exception("$file is not exist");
        }

        return $file;
    }

    public function render(string $viewName, array $args = [])
    {
        if (is_array($args)) {
            extract($args);
        }

        ob_start();
        include_once $this->__resolvePath($viewName);
        $content = ob_get_clean();

        if (empty($this->__layout)) {
            return $content;
        }

        ob_clean();
        include_once $this->__resolvePath($this->__layout);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public function renderOnlyView($viewName)
    {
        ob_start();
        include_once $this->__resolvePath($viewName);
        return ob_get_clean();
    }

    public function include(string $viewName)
    {
        ob_start();
        include_once $this->__resolvePath($viewName);
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function section(string $name)
    {
        $this->__current_section = $name;
        ob_start();
    }

    public function end()
    {
        if (empty($this->__current_section)) {
            throw new \Exception("There is not a section start");
        }

        $content = ob_get_contents();
        ob_end_clean();
        $this->__sections[$this->__current_section] = $content;
        $this->__current_section = null;
    }

    public function layout(string $layout)
    {
        $this->__layout = $layout;
    }

    public function renderSection(string $name)
    {
        echo $this->__sections[$name];
    }
}
