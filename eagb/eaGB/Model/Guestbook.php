<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Andi
 * Date: 19.03.11
 * Time: 12:52
 * To change this template use File | Settings | File Templates.
 */
 

class eaGB_Model_Guestbook extends eaGB_Model
{

    /**
     * Primary key defined in the table
     * @var string
     */
    protected $primary = 'id';
    /**
     *
     */
    protected $table = 'eagb_entries';
    /**
     *
     * @var eaGB_Config
     */
    protected $config;
    /**
     *
     * @var array
     */
    protected $entries = array();
    /**
     *
     * @var array
     */
    protected $invalidData = array();
    /**
     *
     * @var array
     */
    protected $errors = array();

    public function validate(array $data)
    {
        $errors = false;
        $this->errors = array();
        $return = array(
            'id' => '',
            'name' => '',
            'email' => '',
            'homepage' => '',
            'body' => ''
        );
        $data = array_merge($return, $data);
        $settingsModel = new eaGB_Model_Settings();
        $settings = $settingsModel->getRequiredFields();

        if (count($settings) < 4) {
            throw new Exception('Invalid settings data');
        }

        if(($settings['required_name'] || !empty($data['required_name'])) && (trim($data['name']) == '' || strlen($data['name']) > 50)) {
            $data['name'] = '';
            $errors['name'] = array('message' => 'VALIDATION_NAME_INVALID');
        }

        if (($settings['required_email'] || !empty($data['email'])) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            $data['email'] = '';
            $errors['email'] = array('message' => 'VALIDATION_EMAIL_INVALID');
        }

        $data['homepage'] = 'http://' . ltrim($data['homepage'], 'http://');
        var_dump($data['homepage']);
        var_dump(filter_var($data['homepage'], FILTER_VALIDATE_URL));
        var_dump(($settings['required_homepage'] || !empty($data['homepage'])));
        if (($settings['required_homepage'] || !empty($data['homepage'])) && ((filter_var($data['homepage'], FILTER_VALIDATE_URL) === false) || strlen($data['homepage'] > 255))) {
            $data['homepage'] = '';
            $errors['homepage'] = array('message' => 'VALIDATION_HOMEPAGE_INVALID');
        }
        
        if (($settings['required_body'] || !empty($data['body'])) && ((strlen($data['body']) > 1000) || empty($data['body']))) {
            $data['body'] = '';
            $errors['body'] = array('message' => 'VALIDATION_BODY_INVALID');
        }

        //if ($settings['use_captcha'] && isset($_SESSION['captcha_code']) && strcmp(strtolower($_SESSION['captcha_code']), strtolower($data['captcha']))) {
        //    $errors['captcha'] = array('message' => 'VALIDATION_CAPTCHA_INVALID');
        //}

        if ($errors) {
            $this->errors = $errors;
            $this->invalidData = $data;
            return false;
        } else {
            return true;
        }
    }
    
    public function paginate($offset, $limit)
    {
        $query = sprintf('SELECT * FROM %s ORDER BY `id` DESC LIMIT %d OFFSET %s', $this->getTable(), $limit, $offset);
        return $this->database->query($query);
    }

    public function getPages($limit)
    {
        $query = sprintf('SELECT COUNT(1) FROM %s', $this->getTable());
        $result = $this->database->query($query);
        $r = ceil($result[0]['COUNT(1)'] / $limit);
        return $r;
    }


    /**
     *
     * @return array
     */
    public function getInvalidData()
    {
        return $this->invalidData;
    }

    /**
     *
     * @return string
     */
    protected function getTable()
    {
        return $this->table;
    }
    
    /**
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
