<?php

use Codeception\Util\Autoload;

$framework_path = dirname( __DIR__, 2 );

Autoload::addNamespace( 'techPump', $framework_path . '' );