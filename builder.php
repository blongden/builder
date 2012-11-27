<?php
require_once 'autoloader.php';

$loader = new SplClassLoader('Nocarrier', 'lib');
$loader->register();

function build($callback)
{
    $will = new \Nocarrier\Build\Controller();
    $callback($will);
    $will->go();
}
