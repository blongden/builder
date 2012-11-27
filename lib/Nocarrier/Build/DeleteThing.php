<?php
namespace Nocarrier\Build;

class DeleteThing extends Thing {
    public function go()
    {
        switch ($this->thing) {
            case "directory":
                rmdir($this->name);
                break;
            case "file":
                break;
        }
    }
}

