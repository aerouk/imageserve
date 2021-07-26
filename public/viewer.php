<?php

require_once __DIR__ . '/protected/config/config.php';

$types = array(
    'png'  => 'image/png',
    'jpeg' => 'image/jpeg',
    'gif'  => 'image/gif',
    'webm' => 'video/webm',
);

$index = ! (isset($_GET['type']) && isset($_GET['file']));

if ($index) {
    include_once __DIR__ . '/protected/templates/index.phtml';
    die();
}

$type = $_GET['type'];
$file = $_GET['file'];

if ($type == '') {
    // try to guess the type
    foreach ($types as $i => $v) {
        if (file_exists(__DIR__ . "/images/$i/$file.$i")) {
            $type = $i;
            break;
        }
    }
}

$filelocation = __DIR__ . "/images/$type/$file.$type";

if ( ! array_key_exists($type, $types) || ! file_exists($filelocation)) {
    http_response_code(404);
    include_once __DIR__ . '/protected/templates/error.phtml';
    die();
}

$filesize = filesize($filelocation);

if (RAW_IMAGE && strpos($_SERVER['HTTP_USER_AGENT'], 'Twitterbot') === false) {
    $filecontents = fopen($filelocation, 'rb');

    header('Content-type: ' . $types[$type]);
    header('Content-length: ' . $filesize);

    fpassthru($filecontents);
    exit;
} else {
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $start = $time;

    require_once __DIR__ . '/protected/templates/viewer.phtml';
}
