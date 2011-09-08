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
class eaGB_Model_User extends eaGB_Model
{

    protected $table = 'eagb_users';
    protected $id;
    protected $name;
    protected $email;
    protected $password;
    protected $salt;
    protected $created;
    protected $modified;
    protected $loggedIn = false;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        if ($this->isValid() === true) {
            $userId = eaGB_Session::read('userId');
            if ($userId != null) {
                $userId = (int)$userId;
                //$storage = eaGB_Controller::getDefaultStorage();
                $userData = $this->find('id = ?', $userId);
                if ($userData != null) {
                    $this->updateSessionLifetime();
                    $this->id = $userData['id'];
                    $this->name = $userData['name'];
                    $this->email = $userData['email'];
                    $this->password = $userData['password'];
                    $this->salt = $userData['salt'];
                    $this->created = $userData['created'];
                    $this->modified = $userData['modified'];
                    $this->loggedIn = true;
                }
            }
        } else {
            $this->logout();
        }
    }

    /**
     * Checks if credentials are correct
     *
     * @param  $user
     * @param  $password
     * @return bool
     */
    public function auth($user, $password)
    {
        $user     = (string) $user;
        $password = (string) $password;
        $password = $this->generatePassword($user, $password);

        $user = $this->find('name = ? AND password = ?', array($user, $password));
        if ($user)
            return true;
        return false;
    }

    protected function generatePassword($user, $password)
    {
        $config = eaGB_Controller::getConfig();
        return hash($config->read('hash'), $password . $this->getSalt($user));
    }

    public function login($user, $password)
    {
        if ($this->isLoggedIn()) {
            return true;
        }

        $user = (string) $user;
        $result = $this->find('name = ?', $user, array('id', 'salt'));
        if(!$result) {
            return false;
        }

        if($this->auth($user, $password)) {
            eaGB_Session::write('userId', $result['id']);
            $this->updateSessionLifetime();
            eaGB_Session::regenerate();
            $this->loggedIn = true;
        } else {
            $this->logout();
        }
        return $this->isLoggedIn();
    }

    /**
     * Deletes the usersession
     *
     * return void
     */
    public function logout()
    {
        eaGB_Session::write('userId', null);
        eaGB_Session::write('validUntil', null);
        eaGB_Session::regenerate();
        $this->loggedIn = false;
    }

    protected function updateSessionLifetime()
    {
        $config = eaGB_Controller::getConfig();
        return eaGB_Session::write('validUntil', strtotime($config->read('sessionLifetime')));
    }

    public function isLoggedIn()
    {
        if ($this->loggedIn == true && $this->isValid())
            $this->updateSessionLifetime();
        return $this->loggedIn;
    }

    public function isValid()
    {
        $now = new DateTime('now');
        $validUntil = new DateTime(date('Y-m-d H:i:s', eaGB_Session::read('validUntil')));
        return $now < $validUntil;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function changePassword($password)
    {
        $password = (string) $password;
        if ($this->update($this->getId(), array('password' => $this->generatePassword($this->getName(), $password)))) {
            $this->password = $password;
            return true;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt($user = null)
    {
        if ($user !== null) {
            $salt = $this->find('name = ?', $user, 'salt');
            return $salt != null ? $salt['salt'] : null;
        }
        return $this->salt;
    }

    protected function getTable()
    {
        return $this->table;
    }

    protected function validate(array $data)
    {
        // TODO: Implement validate() method.
    }
}