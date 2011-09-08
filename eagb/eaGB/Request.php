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
class eaGB_Request
{

    protected $server;
    protected $request;
    protected $params;
    protected $action;

    public function __construct($action = 'index')
    {
        $parsedUrl = $this->parseUrl($action);
        $this->action = $parsedUrl['action'];
        $this->params = $parsedUrl['params'];
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function isPost()
    {
        return strtolower($this->server['REQUEST_METHOD']) == 'post';
    }

    protected function parseUrl($urlString)
    {
        $pieces = array();
        $action = '';
        $methods = array();
        $params = array();
        
        $urlString = trim($urlString, '/');
        $pieces = explode('/', $urlString);
        $action = array_shift($pieces);
        $methods = get_class_methods('eaGB_Controller_Guestbook');
        if(!in_array($action . 'Action', $methods)) {
            $action = 'index';
        }
        $ret = array('action' => $action, 'params' => $pieces);
        return $ret;
    }
/*
    public function sanitize($data)
    {
        if (is_array($data)) {
            array_map(array($this, 'quote'), $data);
        }
    }

    protected function quote($string)
    {
        return addcslashes($string, "\x00\n\r\'\x1a\x3c\x3e\x25");
    }
*/
    public function getPost()
    {
        return $this->post;
    }
}