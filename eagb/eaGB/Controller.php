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
abstract class eaGB_Controller
{
    /**
     * The current action for the request
     * @var string
     */
    protected $action;
    /**
     * Holds the app configuration
     * @var eaGB_Config
     */
    protected static $config;

    /**
     * Holds all variables that are made accessible to the view
     * through eaGB_Controller::set()
     *
     * @var array
     */
    protected $viewVars = array();

    /**
     *
     * @var eaGB_Request
     */
    protected $request = null;

    /**
     *
     * @var eaGB_Storage
     */
    protected static $defaultStorage;

    /**
     *
     * @var string
     */
    protected $output;

    /**
     * Holds the parameters with wich the action is called
     * 
     * @var array
     */
    protected $params;

    /**
     * 
     */
    public function init()
    {

    }

    /**
     * Will be executed BEFORE every action
     */
    public function startUp()
    {

    }

    /**
     * Will be executed AFTER every action
     */
    public function shutDown()
    {

    }

    public function __construct($action, $configFile)
    {
        //$this->action = $this->parseAction($action);
        self::setConfig(new eaGB_Config($configFile));
        $this->request = new eaGB_Request($action);
        list($dsn, $user, $pass) = array(
            self::$config->read('dsn'),
            self::$config->read('user'),
            self::$config->read('password')
        );
        eaGB_Translator::getInstance()->init('eagb', self::$config->read('locale'));
        $database = new eaGB_Database($dsn, $user, $pass);
        self::setDefaultStorage($database);
        // Set Locale
        $language = self::$config->read('locale');
    }

    /**
     *
     * @param eaGB_Storage $storage
     */
    public static function setDefaultStorage(eaGB_Database $storage)
    {
        self::$defaultStorage = $storage;
    }

    /**
     *
     * @return eaGB_Storage
     */
    public static function getDefaultStorage()
    {
        return self::$defaultStorage;
    }

    /**
     *
     * @param eaGB_Config $config
     */
    public static function setConfig(eaGB_Config $config)
    {
        self::$config = $config;
    }

    /**
     *
     * @return eaGB_Config
     */
    public static function getConfig()
    {
        return self::$config;
    }

    public function dispatch()
    {
        $action = $this->request->getAction();
        // 'guestbook' durch das aktuelle model austauschen
        $actionDirectory = _EA_ROOT . DIRECTORY_SEPARATOR . 'eaGB' . DIRECTORY_SEPARATOR. 'views' . DIRECTORY_SEPARATOR . 'guestbook' . DIRECTORY_SEPARATOR;
        $viewFile = $actionDirectory . $action . '.php';
        $this->init();
        $this->runAction($action . 'Action');
        if (!file_exists($viewFile) and !$this->disableLayout)
            throw new Exception('view file ' . $viewFile . ' not found');
        extract($this->viewVars);
        ob_start();
        if (!$this->disableLayout)
        {
            $preloadFile  = realpath(_EA_ROOT . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . self::$config->read('theme') . DIRECTORY_SEPARATOR . 'header.php');
            $postloadFile = realpath(_EA_ROOT . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . self::$config->read('theme') . DIRECTORY_SEPARATOR . 'footer.php');
            if ($preloadFile !== false AND file_exists($preloadFile))
                include $preloadFile;
            include $viewFile;
            if ($postloadFile !== false AND file_exists($postloadFile))
                include $postloadFile;
        }
        $this->output = ob_get_clean();
        $this->shutDown();
        return $this->output;
    }

    protected function runAction($action)
    {
        $params = $this->request->getParams();
        $classMethods = get_class_methods($this);
        if (!is_callable(array($this, $action)) OR !in_array($action, $classMethods)) {
            throw new Exception('Action "' . (string) $action . '" not found or accessible');
        }
        $count = count($params);
        // Dedicated method calls for more performance
        switch ($count) {
            case 0:
                $this->$action();
                break;
            case 1:
                $this->$action($params[0]);
                break;
            case 2:
                $this->$action($params[0], $params[1]);
                break;
            case 3:
                $this->$action($params[0], $params[1], $params[2]);
                break;
            case 4:
                $this->$action($params[0], $params[1], $params[2], $params[3]);
                break;
            case 5:
                $this->$action($params[0], $params[1], $params[2], $params[3], $params[4]);
                break;
            default:
                // Slower call
                return call_user_func_array(array($this, $action), $params);
                break;
        }
    }


    /**
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $name = (string) $name;
        $this->viewVars[$name] = $value;
    }

    /**
     *
     * @return eaGB_Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    public function __toString()
    {
        return $this->output;
    }

    protected function redirect($action)
    {
        $getParam = $this->getConfig()->read('getParam');
        $action = (string)$action;
        $action = '?' . $getParam . '=' . $action;
        header('Location: ' . $action);
        exit;
    }
}
