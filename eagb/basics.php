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

function __($string, $return = false)
{
    $translation = eaGB_Translator::getInstance()->translate($string);
    if ($return) 
        return $translation;
    else 
        echo $translation;
}

function debug($var = false, $showHtml = false, $showFrom = true) {
    if ($showFrom) {
        $calledFrom = debug_backtrace();
        echo '<strong>' . substr(str_replace(ROOT, '', $calledFrom[0]['file']), 1) . '</strong>';
        echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
    }
    echo "\n<pre>\n";
    var_dump($var);
    echo "\n</pre>\n";
}

function eaBaseUrl() {
    $replace = array('<', '>', '*', '\'', '"');
    $dir = str_replace($replace, '', dirname($_SERVER['PHP_SELF']));
	return $dir != "/" ? $dir : '';
}

function eaLoadTheme($themeName = null) {
    if (!$themeName)
        $themeName = 'standard';
    return '<link rel="stylesheet" type="text/css" href="' . eaBaseUrl() . '/eagb/themes/' . $themeName . '/css/style.css" />';
}