<?php defined('_EA_EXEC') or die('No direct access allowed'); 
return array(
    'dsn'               => 'mysql:host=localhost;dbname=eagb',
    'user'              => "root",
    'password'          => "root",
    'locale'            => "ger",
    'sessionLifetime'   => "+10 minutes",
    'theme'             => "standard",
    'getParam'          => "eagb",
    'salt'              => 'ijoeJOIJ123§1!"DgkQWl*',
    'userSessionKey'    => "eagb_user",
    'hash'              => "sha1",
    'version'           => 2.0,
    'updateUrl'         => 'http://ea-style.de/version.php',
    'pageLimit'         => 10,
);
