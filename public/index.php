<?php

use app\App;

require __DIR__ . '/../vendor/autoload.php';

$filePath = __DIR__ . '/../public' . ($_SERVER['REQUEST_URI'] ?? '');
$fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
if(is_file($filePath) && in_array($fileExt, ['css', 'js', 'json'])) {
    header('Content-Type: ' . finfo_file(finfo_open(FILEINFO_MIME_TYPE), $filePath));
    echo file_get_contents($filePath);
} else {
    (new App)->runAction();
}