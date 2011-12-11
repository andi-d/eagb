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

class eaGB_Model_Settings extends eaGB_Model
{
    protected $table = "eagb_settings";

    public function getSetting($setting)
    {
        $var = $this->find('`name` = ?', $setting);
        
        if(!$var)
            throw new Exception('Unknown setting ' . $setting);

        return $var['setting'];
    }

    public function getRequiredFields()
    {
        $settings = $this->findAll('`name` = "required_name" OR `name` = "required_email" OR `name` = "required_homepage" OR `name` = "required_body" OR `name` = "use_captcha"');
        $ret = array();
        foreach ($settings as $setting)
            $ret[$setting['name']] = $setting['setting'];
        return $ret;
    }

    public function setOptions(array $data)
    {
        $oldValues = $this->findAll('`name` = "required_name" OR `name` = "required_email" OR `name` = "required_homepage" OR `name` = "required_body"');
        foreach ($oldValues as $k => &$setting) {
            if (isset($data[str_replace('_', '-', $setting['name'])])) {
                $setting['setting'] = 1;
            } else {
                $setting['setting'] = 0;
            }
        }
        foreach ($oldValues as $o)
            $this->save($o);

        return $oldValues;
    }
    
    protected function getTable()
    {
        return $this->table;
    }

    public function validate(array $data)
    {
        $error = false;
        $return = array(
            'name' => '',
            'setting' => ''
        );

        $data = array_merge($return, $data);

        if (empty($data['name'])) {
            $error = true;
        }
        
        if ($error === true) {
            $this->invalidData = $data;
            return false;
        } else {
            return true;
        }
    }
}