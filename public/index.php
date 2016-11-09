<?php

require_once(__DIR__.'../vendor/autoload.php');

use ExquisiteCorpse\Application;

$app = new Application('dev', true);
$app->run();