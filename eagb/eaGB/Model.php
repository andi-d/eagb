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
abstract class eaGB_Model
{
    /**
     *
     * @var eaGB_Database
     */
    protected $database = null;
    
    public function __construct()
    {
        $this->database = eaGB_Controller::getDefaultStorage();
    }

    public function find($condition, $value, $columns = '*')
    {

        if($columns != '*') {
            $columns = (array) $columns;
            if (count($columns) > 0) {
                $columns = implode(', ', $columns);
            } else {
                throw new InvalidArgumentException('Invalid columns provided');
            }
        }

        $sql = 'SELECT ' . $columns . ' FROM ' . $this->getTable() . ' WHERE ' . $condition . ' LIMIT 1';
        $result = $this->database->query($sql, $value);
        if (!empty($result)) {
            return $result[0];
        }
        return null;
    }
    
    public function insert($data)
    {
        return $this->database->insert($this->getTable(), $data);
    }

    public function update($id, array $data)
    {
        $data['id'] = $id;
        $data['modified'] = date(DATE_ATOM, time());
        //$keys = implode('` = ?, `', array_keys($data)) . '` = ?';
        //$vals = array_values($data);
        //$sql = 'UPDATE `' . $this->getTable() . '` SET ' . $keys . ' WHERE id=' . $id . ' LIMIT 1';

        return $this->database->save($this->getTable(), $data);

        //var_dump($this->storage->query($sql, $vals));
    }

    public function findAll($condition = null, $order = null, $limit = null)
    {
        if ($condition !== null)
            $condition = ' WHERE ' . $condition;

        if ($order != null)
            $order = ' ORDER BY ' . $order;

        if ($order != null)
            $order = ' LIMIT ' . ($limit + 0);

        $query = 'SELECT * FROM ' . implode(' ', array($this->getTable(), $condition, $order, $limit));
        $rows = $this->database->query($query);
        $data = array();
        /*
        if(!empty($rows)) {
            foreach($rows as $row) {
                $data[] = array(
                    'id'        => $row['id'],
                    'name'      => $row['name'],
                    'email'     => $row['email'],
                    'homepage'  => $row['homepage'],
                    'body'      => $row['body'],
                    'created'   => $row['created'],
                    'modified'  => $row['modified']
                );
            }
        }
         */
        return $rows;
    }
    
    protected function quote($value)
    {
        if (is_int($value)) {
            return $value;
        } elseif (is_float($value)) {
            return sprintf('%F', $value);
        }
        return "'" . addcslashes($value, "\000\n\r\\'\"\032") . "'";
    }

    /**
     *
     * @param array $data Data to save
     * @return bool
     */
    public function save($data)
    {
        if ($this->validate($data)) {
            return $this->database->save($this->getTable(), $data);
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        return $this->database->delete($this->getTable(), $id);
    }

    protected abstract function validate(array $data);
    protected abstract function getTable();
}
