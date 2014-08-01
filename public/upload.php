<?php

require_once(__DIR__ . '/../app/config/config.php');

if ( ! isset($_POST['password']) || $_POST['password'] !== PASSKEY) {
    die("error,e-401");
}

if ( ! ($_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/gif")) {
    die("error,e-418");
}

if ($_FILES['image']['error'] > 0) {
    die("error,e-503");
}

$dir = __DIR__ . '/images/';

if ($_FILES['image']['type'] == "image/png") {
    $hash = generateNewHash("png");

    if (move_uploaded_file($_FILES['image']['tmp_name'], $dir . "png/$hash.png")) {
        die("success," . RAW_IMAGE_LINK ? "/images/png/$hash.png" : $hash);
    }

    die("error,e-503");
} elseif ($_FILES['image']['type'] == "image/jpeg") {
    $hash = generateNewHash("jpeg");

    if (move_uploaded_file($_FILES['image']['tmp_name'], $dir . "jpeg/$hash.jpg")) {
        die("success," . RAW_IMAGE_LINK ? "/images/jpeg/$hash.jpg" : "j/$hash");
    }

    die("error,e-503");
} elseif ($_FILES['image']['type'] == "image/gif") {
    $hash = generateNewHash("gif");

    if (move_uploaded_file($_FILES['image']['tmp_name'], $dir . "gif/$hash.gif")) {
        die("success," . RAW_IMAGE_LINK ? "/images/gif/$hash.gif" : "g/$hash");
    }

    die("error,e-503");
}

function generateNewHash($type)
{
    $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $str = "";

    for ($i = 0; $i < 5; $i++) {
        $str .= substr($an, rand(0, strlen($an) - 1), 1);
    }

    if ( ! file_exists(__DIR__ . '/images/' . $type . '/' . $str)) {
        return $str;
    } else {
        generateNewHash($type);
    }
}
