<?php
// setup folders
$types = array('png', 'jpeg', 'gif', 'webm');
foreach ($types as $type) {
    if (!is_dir('images/' . $type)) mkdir('images/' . $type);
}

// required
if (getenv('PASSKEY') === false) {
    http_response_code(500);
    die('PASSKEY must not be unset!');
}

// defaults
$IMAGESERVE_DIR = getenv('IMAGESERVE_DIR') !== false ? getenv('IMAGESERVE_DIR') : '';
$TWITTER_HANDLE = getenv('TWITTER_HANDLE') !== false ? getenv('TWITTER_HANDLE') : '';
$APP_NAME = getenv('APP_NAME') !== false ? getenv('APP_NAME') : 'imageserve';

define('PASSKEY', getenv('PASSKEY'));
define('RAW_IMAGE', getenv('RAW_IMAGE') !== false);
define('RAW_IMAGE_LINK', getenv('RAW_IMAGE_LINK') !== false);
define('IMAGE_EXTENSION', getenv('IMAGE_EXTENSION') !== false);
define('TWITTER_CARDS', getenv('TWITTER_CARDS') !== false);
define('IMAGESERVE_DIR', $IMAGESERVE_DIR);
define('TWITTER_HANDLE', $TWITTER_HANDLE);
define('APP_NAME', $APP_NAME);
