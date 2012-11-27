<?php
namespace Nocarrier\Build;

class Controller {
    protected $things = array();

    protected function addThing(Thing $thing)
    {
        $this->things[] = $thing;
        return $thing;
    }

    public function create()
    {
        return $this->addThing(new CreateThing());
    }

    public function delete()
    {
        return $this->addThing(new DeleteThing());
    }

    public function run()
    {
        return $this->addThing(new RunThing());
    }

    public function go()
    {
        foreach ($this->things as $thing) {
            $thing->action();
        }
    }

    public function __get($var)
    {
        if (method_exists($this, $var)) {
            return call_user_func(array($this, $var));
        }
    }

}
