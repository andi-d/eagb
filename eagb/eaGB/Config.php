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

class eaGB_Config implements ArrayAccess
{

    protected $settings = array();

    protected $sourceFile = null;


    protected $defaults = array(
        'dsn' => 'sqlite::memory:',
        'user' => '',
        'password' => '',
        'locale' => 'ger'
    );

    public function __construct($input = null)
    {
        $settings = $this->defaults;
        
        if (is_array($input)) {
            $settings = array_merge($settings, $input);
        } elseif ($input !== null && file_exists($input)) {
            $this->sourceFile = $input;
            $loadedSettings = include $input;
            $settings = array_merge($settings, $loadedSettings);
        } elseif ($input !== null) {
            throw new Exception('Could not load config file (' . $input . ')');
        }
        
        $this->write($settings);
    }
    
    public function load(array $settings)
    {
        foreach($settings as $key => $value) {
            $this->write($key, $value);
        }
    }

    public function write($name, $value = null)
    {
        if (is_array($name)) {
            foreach($name as $key => $v) {
                $this->write($key, $v);
            }
        } else {
            $this->settings[$name] = $value;
        }
    }

    public function read($name)
    {
        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        }
        return null;
    }
    
    public function save($file = null) {
        $accessWard = "<?php defined('_EA_EXEC') or die('No direct access allowed');\n";
        $configContent = $accessWard . 'return ' . var_export($this->settings, true) . ';';
        
        $writeTo = $file != null ? $file : $this->sourceFile =! null ? $this->sourceFile : null;
        if ($writeTo === null) {
            throw new Exception('Config file not specified');
        }
        return file_put_contents($writeTo, $configContent);
    }
    
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->settings[] = $value;
        } else {
            $this->settings[$offset] = $value;
        }
    }
    public function offsetExists($offset) {
        return isset($this->settings[$offset]);
    }
    public function offsetUnset($offset) {
        unset($this->settings[$offset]);
    }
    public function offsetGet($offset) {
        return isset($this->settings[$offset]) ? $this->settings[$offset] : null;
    }
}