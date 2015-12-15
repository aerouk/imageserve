<?php

require_once(__DIR__ . '/protected/config/config.php');

if ( ! isset($_POST['password']) || $_POST['password'] !== PASSKEY) {
    die("error,e-401");
}

if ( ! ((filesize($_FILES['file']['tmp_name'])) && $_FILES['file']['type'] == "image/png" || $_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/gif" || $_FILES['file']['type'] == "video/mp4")) {
    die("error,e-418");
}

if ($_FILES['file']['error'] > 0) {
    die("error,e-503");
}

$dir = __DIR__ . '/images/';

saveImage($_FILES['file']['type'], $_FILES['file']['tmp_name']);

function generateNewHash($type)
{
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $str = "";

    for ($i = 0; $i < 5; $i++) {
        $str .= substr($an, rand(0, strlen($an) - 1), 1);
    }

    if ( ! file_exists(__DIR__ . "/images/$type/$str")) {
        return $str;
    } else {
        return generateNewHash($type);
    }
}

function saveImage($mimeType, $tempName)
{
    global $dir;

    switch ($mimeType) {
        case "image/png":   $type = "png"; break;
        case "image/jpeg":  $type = "jpg"; break;
        case "image/gif":   $type = "gif"; break;
        case "video/mp4":   $type = "mp4"; break;

        default: die("error,e-418");
    }

    $hash = generateNewHash($type);

    if (move_uploaded_file($tempName, $dir . "$type/$hash.$type")) {
        die("success," . (RAW_IMAGE_LINK ? $dir . "$type/$hash.$type" : ($type == "png" ? "" : substr($type, 0, 1) . "/") . "$hash"));
    }

    die("error,e-503");
}
