<?php

/**
 * Kurze Beschreibung der Datei
 *
 * Lange Beschreibung der Datei (wenn vorhanden)...
 *
 * LICENSE: Einige Lizenz Informationen
 *
 * @category   
 * @package    
 * @copyright   Copyright (c) 2010 Andreas Derksen andreasderksen.de
 * @license     http://www.andreasderksen.de/license   BSD License
 * @version     $Id:$
 * @link        http://www.andreasderksen.de/package/PackageName
 * @since       Datei vorhanden seit Release 0.0.0
 * @author      Andreas Derksen
 */
define('_EA_EXEC', true);
define('_EA_ROOT', dirname(__FILE__));
header("Content-Type: text/html; charset=utf-8");
require_once 'eaGB/Session.php';
eaGB_Session::start('eaGB');

$start_time = microtime(true);

register_shutdown_function('my_shutdown');

function my_shutdown()
{
    global $start_time;

    echo "<!-- execution took: " . (microtime(true) - $start_time) . " seconds. -->";
}
require_once _EA_ROOT . '/eaGB/Loader.php';
require_once _EA_ROOT . '/eaGB/Config.php';
require_once _EA_ROOT . '/basics.php';
eaGB_Loader::register();
require_once _EA_ROOT . '/eaGB/eaGB.php';
$timezone = ini_get('date.timezone');
if (!$timezone) {
    $timezone = 'Europe/Paris';
}
date_default_timezone_set($timezone);