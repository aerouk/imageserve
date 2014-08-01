<?php

require_once(__DIR__ . '/../app/config/config.php');

$index = ! (isset($_GET['type']) && isset($_GET['file']));

if ($index) {
    include_once(__DIR__ . '/../app/templates/index.phtml');
    die();
}

$type = $_GET['type'];
$file = $_GET['file'];

if (RAW_IMAGE) {
    $filelocation = __DIR__ . "/images/$type/$file.$type";

    if ( ! file_exists($filelocation)) {
        header("HTTP/1.0 404 Not Found");
        include_once(__DIR__ . '/../app/templates/error.phtml');
        die();
    }

    $filecontents = fopen($filelocation, 'rb');

    header("Content-type: image/$type");
    header("Content-length: " . filesize($filelocation));

    fpassthru($filecontents);
    exit;
} else {
    $filelocation = __DIR__ . "/images/$type/$file.$type";

    require_once(__DIR__ . '/../app/templates/viewer.phtml');
}
