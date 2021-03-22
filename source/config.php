<?php

define('ROOT_PATH', dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . '/');
define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
define('BASE_URL', $url.'/sage/');
define('HTML_BASE_URL', $url.'/sage/public_html/html/');
define('CONFIG_BASE_URL', $url.'/sage/source/configuration/');
define('SOURCE_BASE_URL', $url.'/sage/source/');
define('STYLE_BASE_URL', $url.'/sage/public_html/style/');
define('JS_BASE_URL', $url.'/sage/public_html/js/');
define('PUBLIC_DIR', 'public_html');
define('AJAX_BASE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], PUBLIC_DIR) + strlen(PUBLIC_DIR)));

?>