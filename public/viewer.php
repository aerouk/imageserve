<?php

require_once(__DIR__ . '/protected/config/config.php');

$index = ! (isset($_GET['type']) && isset($_GET['file']));

if ($index) {
    include_once(__DIR__ . '/protected/templates/index.phtml');
    die();
}

$type = $_GET['type'];
$ext = str_replace("jpeg", "jpg", $_GET['type']);
$file = $_GET['file'];

$filelocation = __DIR__ . "/images/$type/$file.$ext";

if ( ! file_exists($filelocation)) {
    header("HTTP/1.0 404 Not Found");
    include_once(__DIR__ . '/protected/templates/error.phtml');
    die();
}

$filesize = filesize($filelocation);

if (RAW_IMAGE && strpos($_SERVER['HTTP_USER_AGENT'], "Twitterbot") === false) {
    $filecontents = fopen($filelocation, 'rb');

    header("Content-type: image/$type");
    header("Content-length: " . $filesize);

    fpassthru($filecontents);
    exit;
} elseif ($type == "mp4") {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;

        require_once(__DIR__ . '/protected/templates/video-viewer.phtml');
} else {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;

        require_once(__DIR__ . '/protected/templates/viewer.phtml');
            
}
