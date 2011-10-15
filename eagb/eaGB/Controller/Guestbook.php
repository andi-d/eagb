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
class eaGB_Controller_Guestbook extends eaGB_Controller
{
    protected $storage = null;
    protected $disableLayout = false;
    protected $user = null;

    public function __construct($action, $configFile)
    {
        $action = filter_var($action, FILTER_SANITIZE_STRING);
        parent::__construct($action, $configFile);
        $this->user = new eaGB_Model_User();
    }

    public function indexAction($page = null)
    {
        if ($page == null) {
            $page = 1;
        }
        $page = abs($page);
        $limit = $this->getConfig()->read('pageLimit');
        $offset = ($limit * $page) - $limit;
        $guestbook = new eaGB_Model_Guestbook();
        $entries = $guestbook->paginate($offset, $limit);
        $pages = $guestbook->getPages($limit);
        foreach ($entries as &$entry) {
            $entry['body'] = htmlspecialchars($entry['body'], ENT_QUOTES, 'UTF-8');
            $entry['name'] = htmlspecialchars($entry['name'], ENT_QUOTES, 'UTF-8');
        }
        $smileys = new eaGB_Model_Smiley();
        $entries = $smileys->addSmileys($entries);
        $this->set('page', $page);
        $this->set('pages', $pages);
        $this->set('entries', $entries);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $guestbook = new eaGB_Model_Guestbook();
        $smileyModel = new eaGB_Model_Smiley();
        $smileys = $smileyModel->findAll();
        $this->set('smileys', $smileys);
        $settingsModel = new eaGB_Model_Settings();
        $requiredFields = $settingsModel->getRequiredFields();
        $this->set('required', $requiredFields);
        $this->set('useCaptcha', $settingsModel->getSetting('use_captcha'));
        if ($request->isPost()) {
            $post = $request->getPost();
            $data = array(
                'name'      => $post['guestbook-add-name'],
                'email'     => $post['guestbook-add-email'],
                'homepage'  => $post['guestbook-add-homepage'],
                'body'      => $post['guestbook-add-body'],
                'hide_email'=> isset($post['guestbook-add-hide-email']) ? 1 : 0
            );
            $badwordFilter = new eaGB_Model_Badword();
            $data = $badwordFilter->filterWords($data);
            if ($guestbook->save($data)) {
                $this->redirect('index');
            } else {
                $this->set('data', $guestbook->getInvalidData());
                $this->set('errors', $guestbook->getErrors());
                eaGB_Session::setFlash(__('There was an error with the data you entered.'));
            }
        } else {
            $this->set('data', array(
                'name'      => '',
                'email'     => '',
                'homepage'  => '',
                'body'      => ''
            ));
        }
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $data = array(
            'name' => '',
            'password' => ''
        );
        if ($request->isPost()) {
            if (!$this->user->isLoggedIn()) {
                $post = $request->getPost();
                $data = array(
                    'name' => $post['login-name'],
                    'password' => $post['login-password']
                );
                if ($this->user->login($data['name'], $data['password'])) {
                    $this->redirect('admin');
                } else {
                    eaGB_Session::setFlash(__('LOGIN_ERROR', true));
                }
            }
        }
    }

    public function deleteAction($id)
    {
        $guestbook = new eaGB_Model_Guestbook();
        if ($this->user->isLoggedIn()) {
            $this->disableLayout = true;
            $id = intval($id);
            if ($id > 0 && $guestbook->delete($id)) {
                eaGB_Session::flash(__('ENTRY_DELETED', true));
                $this->redirect('index');
            } else {
                eaGB_Session::flash(__('ENTRY_DELETE_ERROR', true));
            }
        } else {
            $this->redirect('login');
        }
    }

    public function logoutAction()
    {
        $this->user->logout();
        $this->redirect('index');
    }
    
    public function adminAction()
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('index');
        }
        $url = $this->getConfig()->read('updateUrl');
        $response = (array)@json_decode(file_get_contents($url));
        if (!$response) {
            $response = 'N/A';
        }
        $version = $this->getConfig()->read('version');
        
        $guestbook = new eaGB_Model_Guestbook();
        $entries = $guestbook->findAll();

        $badwordsModel = new eaGB_Model_Badword();
        $badWords = $badwordsModel->findAll();

        $smileyModel = new eaGB_Model_Smiley();
        $smileys = $smileyModel->findAll();

        $settings = new eaGB_Model_Settings();
        $fields = $settings->getRequiredFields();

        $this->set('currentLanguage', $this->getConfig()->read('locale'));
        $this->set('version', $version);
        $this->set('updateCheck', $response);
        $this->set('smileys', $smileys);
        $this->set('badWords', $badWords);
        $this->set('entries', $entries);
        $this->set('fields', $fields);
    }

    public function changerequiredAction()
    {
        $this->disableLayout = true;
        if ($this->user->isLoggedIn() && $this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $settingModel = new eaGB_Model_Settings();
            $settingModel->setOptions($post);
            $this->redirect('admin');
        } else {
            $this->redirect('login');
        }
    }

    public function changelanguageAction()
    {
        $this->disableLayout = true;
        if ($this->user->isLoggedIn() && $this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $language = $post['language'];
            $this->getConfig()->write('locale', $language);
            $this->getConfig()->save();
        }
        $this->redirect('admin');
    }
    
    public function changepassAction()
    {
        $this->disableLayout = true;
        if ($this->user->isLoggedIn() && $this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            $userData = $this->user->find('id = ?', eaGB_Session::read('userId'));
            if (count($userData) > 0 && $this->user->auth($userData['name'], $post['current-pass'])) {
                if (!empty($post['new-pass']) && strcmp($post['new-pass'], $post['new-pass-confirm']) == 0) {
                    if ($this->user->changePassword($post['new-pass'])) {
                        eaGB_Session::setFlash(__('PASSWORD_CHANGE_SUCCESS', true));
                    } else {
                        eaGB_Session::setFlash(__('CHANGE_PASSWORD_FAIL', true));
                    }
                } else {
                    eaGB_Session::setFlash(__("PASSWORD_MATCH_ERROR", true));
                }
            } else {
                eaGB_Session::setFlash(__('CURRENT_PASSWORD_WRONG', true));
            }
        } else {
            $this->redirect('login');
        }
        $this->redirect('admin');
    }

    public function addbadwordAction()
    {
        if ($this->getRequest()->isPost() AND $this->user->isLoggedIn()) {
            $data = $this->getRequest()->getPost();
            $badwordModel = new eaGB_Model_Badword();
            if ($badwordModel->save($data)) {
                eaGB_Session::setFlash(__('BADWORD_SAVED', true));
            } else {
                eaGB_Session::setFlash(__('SAVE_ERROR', true));
            }
        }
        $this->redirect('admin');
    }

    public function badworddeleteAction($id = null)
    {
        if ($id == null) {
            $this->redirect('admin');
        }
        if (!$this->user->isLoggedIn()) {
            eaGB_Session::setFlash(__('NOT_LOGGED_IN', true));
            $this->redirect('login');
        }
        $badwords = new eaGB_Model_Badword();
        if ($badwords->delete($id)) {
            eaGB_Session::setFlash(__('DELETE_SUCCESS', true));
        } else {
            eaGB_Session::setFlash(__('DELETE_ERROR', true));
        }
        $this->redirect('admin');
    }

    public function addsmileyAction()
    {
        if ($this->user->isLoggedIn() and $this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            $smileyModel = new eaGB_Model_Smiley();
            if ($smileyModel->save($data)) {
                eaGB_Session::setFlash(__('SMILEY_SAVED_SUCCESS', true));
            } else {
                eaGB_Session::setFlash(__("SAVE_ERROR", true));
            }
        }
        $this->redirect('admin');
    }

    public function deletesmileyAction($id = null)
    {
        if ($id === null) {
            $this->redirect('admin');
        }
        if ($this->user->isLoggedIn()) {
            $id = (int)$id;
            $smileyModel = new eaGB_Model_Smiley();
            if ($smileyModel->delete($id)) {
                eaGB_Session::setFlash(__('SMILEY_DELETED_SUCCESS', true));
            } else {
                eaGB_Session::setFlash(__("DELETE_ERROR", true));
            }
        }
        $this->redirect('admin');
    }
}











