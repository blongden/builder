<?php
namespace Nocarrier\Build;

abstract class Thing {
    protected $thing = "file";

    protected $name = null;

    public function directory()
    {
        $this->thing = "directory";
        return $this;
    }

    public function named($name)
    {
        $this->name = $name;
        return $this;
    }

    public function in($dir)
    {
        if (file_exists($dir)) {
            $this->cwd = $dir;
        }
        return $this;
    }

    public function __get($var)
    {
        if (method_exists($this, $var)) {
            return call_user_func(array($this, $var));
        }
    }

    abstract public function go();

    public function action()
    {
        $dir = getcwd();
        if ($this->cwd && file_exists($this->cwd)) chdir($this->cwd);
        $this->go();
        if ($this->cwd && file_exists($dir)) chdir($dir);
    }
}
