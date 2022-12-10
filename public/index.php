<?php

use app\App;

require __DIR__ . '/../vendor/autoload.php';

(new App($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']))->run();