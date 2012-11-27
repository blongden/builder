<?php
namespace Nocarrier\Build;

class CreateThing extends Thing {
    public function go()
    {
        switch ($this->thing) {
            case "directory":
                if (!file_exists($this->name)) mkdir($this->name);
                break;
            case "file":
                break;
        }
    }
}

