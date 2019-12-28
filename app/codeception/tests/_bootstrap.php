<?php

use Codeception\Util\Autoload;

$framework_path = realpath( __DIR__.'/../../framework');

Autoload::addNamespace('techPump', $framework_path.'');