<?php
require 'builder.php';

build(function($will) {
    $will->create->directory->named('build');
    $will->run->phplint;
    $will->run->phpunit;
});
