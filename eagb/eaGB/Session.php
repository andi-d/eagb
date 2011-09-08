<?php

/**
 * Wrapper and security additions to the session functions
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
class eaGB_Session
{

    protected static $vars = array();

    public static function start($name, $lifetime = 0, $path = '/', $domain = null, $secure = null)
    {
        session_name($name . '_session');
        $https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
        session_set_cookie_params($lifetime, $path, $domain, $https, true);
        session_start();

        if (self::isValid()) {
            if (self::isNew() OR self::isHijacked()) {
                // Initialize a new Session
                $_SESSION = array();
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
                self::regenerate();
            } elseif (rand(1, 100) <= 5) {
                self::regenerate();
            }
        } else {
            $_SESSION = array();
            session_destroy();
            session_start();
        }
    }

    public static function regenerate()
    {
        if (isset($_SESSION['Obsolete']) || (isset($_SESSION['Obsolete']) && $_SESSION['Obsolete'] == true))
            return false;

        $_SESSION['Obsolete'] = true;
        $_SESSION['Expires'] = time() + 10;
        session_regenerate_id(false);

        $newSession = session_id();
        session_write_close();

        session_id($newSession);
        session_start();

        unset($_SESSION['Obsolete']);
        unset($_SESSION['Expires']);
    }

    protected static function isValid()
    {
        if (isset($_SESSION['Obsolete']) AND !isset($_SESSION['Expires']))
            return false;

        if (isset($_SESSION['Expires']) AND $_SESSION['Expires'] < time())
            return false;

        return true;
    }

    protected static function isNew()
    {
        if (!isset($_SESSION['ipAddress']) OR !isset($_SESSION['userAgent']))
            return true;

        return false;
    }

    protected static function isHijacked()
    {
        if (isset($_SESSION['ipAddress']) AND ($_SESSION['ipAddress'] != $_SERVER['REMOTE_ADDR']))
            return true;

        if (isset($_SESSION['userAgent']) AND ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']))
            return true;

        return false;
    }
    
    public static function read($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public static function write($name, $value)
    {
        $name = (string) $name;
        if ($value === null)
            unset($_SESSION[$name]);
        else
            $_SESSION[$name] = $value;
    }

    public static function setFlash($text)
    {
        self::write('_flash', $text);
    }

    public static function flash($class = null)
    {
        if ($class !== null)
            $class = ' class="' . $class . '"';
        
        $flash = self::read('_flash');
        if ($flash) {
            self::write('_flash', null);
            return '<div id="flash"' . $class . '>' . $flash . '</div>';
        }
        return null;
    }

}