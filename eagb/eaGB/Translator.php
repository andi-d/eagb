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
class eaGB_Translator
{

    protected $language = 'eng';
    protected $translations = array();
    protected $stringsFound = array();
    protected static $instance = null;
    const TRANSLATION_EXT = '.txt';


    /**
     *
     * @return eaGB_Translator
     */
    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self();
        return self::$instance;
    }

    public function init($textlist, $language)
    {
        $textlist = str_replace('.', '', str_replace('/', '', str_replace('\\', '', $textlist)));
        $language = str_replace('.', '', str_replace('/', '', str_replace('\\', '', $language)));
        if (!$textlist OR !$language) {
            throw new InvalidArgumentException('Textlist or Language invalid');
        }
        
        $this->language = (string) $language;
        $fileName = _EA_ROOT . DIRECTORY_SEPARATOR . 'translation' . DIRECTORY_SEPARATOR . $textlist . DIRECTORY_SEPARATOR . $language . self::TRANSLATION_EXT;
        if (!file_exists($fileName)) {
            throw new Exception('Could not load translation');
        }
        $file = file_get_contents($fileName);
        preg_match_all('/(#[\w_]+)\s*=\s*(.*)/', $file, $match);
        $this->translations = array_combine($match[1], $match[2]);
    }

    public function translate($string)
    {
        $string = '#' . ltrim($string, '#');
        if (!in_array($string, $this->stringsFound)) {
            $this->stringsFound[] = $string;
        }
        if(isset($this->translations[$string])) {
            $trans = $this->translations[$string];
        } else {
            $trans = $string;
        }
        return $trans;
    }

    public function __destruct()
    {
        /*
        $strings = (array) json_decode(file_get_contents(_EA_ROOT . DIRECTORY_SEPARATOR . 'translation' . DIRECTORY_SEPARATOR . 'found' . self::TRANSLATION_EXT));

        foreach($this->stringsFound as $i => $string) {
            $strings[$string] = (isset($this->translations[$string])) ?
                                 $this->translations[$string] :
                                 $string;
        }
        file_put_contents(_EA_ROOT . DIRECTORY_SEPARATOR . 'translation' . DIRECTORY_SEPARATOR . 'found' . self::TRANSLATION_EXT, json_encode($strings));
*/
    }
 }