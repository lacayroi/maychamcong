<?php
// HTTP
define('HTTP_SERVER', 'http://localhost:81/pav/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost:81/pav/');

// DIR
define('DIR_APPLICATION', 'E:/xampp/htdocs/pav/catalog/');
define('DIR_SYSTEM', 'E:/xampp/htdocs/pav/system/');
define('DIR_IMAGE', 'E:/xampp/htdocs/pav/image/');
define('DIR_STORAGE', 'E:/xampp/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'pav');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');