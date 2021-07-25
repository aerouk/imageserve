<?php

require_once __DIR__ . '/protected/config/config.php';

$allowedTypes = array('image/png', 'image/jpeg', 'image/gif', 'video/webm');

if ( ! isset($_POST['password']) || $_POST['password'] !== PASSKEY) {
    http_response_code(401);
    die('error,e-401');
}

if ( ! (filesize($_FILES['image']['tmp_name']) > 0 && in_array($_FILES['image']['type'], $allowedTypes))) {
    http_response_code(415);
    die('error,e-415');
}

if ($_FILES['image']['error'] > 0) {
    http_response_code(500);
    die('error,e-500');
}

$dir = __DIR__ . '/images/';

saveImage($_FILES['image']['type'], $_FILES['image']['tmp_name']);

function generateNewHash()
{
    global $allowedTypes;
    global $dir;
    $an = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $str = '';

    for ($i = 0; $i < 5; $i++) {
        $str .= substr($an, rand(0, strlen($an) - 1), 1);
    }

    // check if generated hash is unique across all types
    foreach ($allowedTypes as $mime) {
        $type = explode('/', $mime)[1];
        if (file_exists($dir . "$type/$str.$type")) {
            // hash already used, generate another one
            return generateNewHash();
        }
    }

    return $str;
}

function saveImage($mimeType, $tempName)
{
    global $dir;

    $type = explode('/', $mimeType)[1];
    $hash = generateNewHash();

    if (move_uploaded_file($tempName, $dir . "$type/$hash.$type")) {
        if (RAW_IMAGE_LINK) {
            $str = "images/$type/$hash.$type";
        } else {
            $str = $hash;
            if (IMAGE_EXTENSION) $str .= ".$type";
        }

        die('success,' . $str);
    }

    http_response_code(500);
    die('error,e-500x');
}
