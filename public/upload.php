<?php

require_once __DIR__ . '/protected/config/config.php';

$allowedTypes = array('image/png', 'image/jpeg', 'image/gif', 'video/webm');

if ( ! isset($_POST['password']) || $_POST['password'] !== PASSKEY) {
    die('error,e-401');
}

if ( ! (filesize($_FILES['image']['tmp_name']) > 0 && in_array($_FILES['image']['type'], $allowedTypes))) {
    die('error,e-415');
}

if ($_FILES['image']['error'] > 0) {
    die('error,e-500');
}

$dir = __DIR__ . '/images/';

saveImage($_FILES['image']['type'], $_FILES['image']['tmp_name']);

function generateNewHash($type)
{
    $an = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $str = '';

    for ($i = 0; $i < 5; $i++) {
        $str .= substr($an, rand(0, strlen($an) - 1), 1);
    }

    if ( ! file_exists(__DIR__ . "/images/$type/$str.$type")) {
        return $str;
    } else {
        return generateNewHash($type);
    }
}

function saveImage($mimeType, $tempName)
{
    global $dir;

    $mimeTypeArray = explode('/', $mimeType);
    $type = $mimeTypeArray[1];
    $hash = generateNewHash($type);

    if (move_uploaded_file($tempName, $dir . "$type/$hash.$type")) {
        die('success,' . (RAW_IMAGE_LINK ? $dir . "$type/$hash.$type" : ($type == 'png' ? '' : substr($type, 0, 1) . '/') . "$hash" . (IMAGE_EXTENSION ? ".$type" : '')));
    }

    die('error,e-500x');
}
