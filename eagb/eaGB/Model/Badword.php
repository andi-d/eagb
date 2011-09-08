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
class eaGB_Model_Badword extends eaGB_Model
{

    protected $table = 'eagb_badwords';

    protected function getTable()
    {
        return $this->table;
    }

    protected function validate(array $data)
    {
        if (isset($data['word']) AND $data['word'] != '') {
            return true;
        }
        return false;
    }

    public function filterWords(array $entries)
    {
        $single = false; // quick and dirty...
        if (isset($entries['body'])) {
            $entries = array($entries);
            $single = true;
        }
        $badwords = $this->findAll();
        for ($i = 0; $i < count($entries); $i++) {
            foreach ($badwords as $badword) {
                $entries[$i]['body'] = str_replace($badword['word'], $this->generateFilteredWord(strlen($badword['word'])), $entries[$i]['body']);
            }
        }
        if ($single === true) {
            $entries = $entries[0];
        }
        return $entries;
    }

    function generateFilteredWord($length)
    {
        $string = "";
        static $chars = array('#', '*', '$', '?', '!', '%');
        for ($i = 0; $i < $length; $i++)
        {
            $string .= $chars[rand(0, (count($chars)-1))];
        }

        return $string;
    }
}