<?php
namespace Nocarrier\Build;

class RunThing extends Thing {
    protected $cmd = null;

    public function phpunit()
    {
        $this->cmd = "phpunit";
        return $this;
    }

    public function phplint()
    {
        $this->cmd = "phplint";
        return $this;
    }

    public function go()
    {
        switch ($this->cmd) {
            case 'phplint':
                $directory = new \RecursiveDirectoryIterator(getcwd());
                $iterator = new \RecursiveIteratorIterator($directory);
                $regex = new \RegexIterator($iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);
                foreach($regex as $file) {
                    $output = array();
                    $retvar = 0;
                    exec(sprintf("php -l %s 2>&1", escapeshellarg($file[0])), $output, $retvar);

                    if ($retvar !== 0) {
                        throw new PhpLintException("phplint failed on {$file[0]}");
                    }
                }
                break;
            default:
                exec(sprintf("%s 2>&1", escapeshellcmd($this->cmd)), $output, $retvar);
                if ($retvar !== 0) {
                    throw new PhpUnitException("phpunit failed");
                }
                foreach ($output as $line) {
                   printf("phpunit> %s\n", $line);
                }
                break;
        }
    }
}

