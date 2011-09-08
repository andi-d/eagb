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
 * @copyright  Copyright (c) 2010 Andreas Derksen andreasderksen.de
 * @license    http://www.andreasderksen.de/license   BSD License
 * @version    $Id:$
 * @link       http://www.andreasderksen.de/package/PackageName
 * @since      Datei vorhanden seit Release 0.0.0
 */
class eaGB_Loader
{

    private static $srcFolder;

    public static function register()
    {
        spl_autoload_register(array('eaGB_Loader', 'load'));
    }

    public static function unregister()
    {
        spl_autoload_unregister(array(self, 'load'));
    }

    public static function load($class)
    {
        if (substr($class, 0, 4) == 'eaGB') {
            $file = _EA_ROOT . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
            if (file_exists($file)) {
                include_once $file;
            }
        }
    }

}