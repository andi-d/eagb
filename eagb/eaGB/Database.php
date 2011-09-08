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
class eaGB_Database
{
    /**
     *
     * @var PDO
     */
    protected $connection;

    /**
     *
     * @param string $dsn
     * @param string $user
     * @param string $pass 
     */
    public function __construct($dsn, $user, $pass)
    {
        $this->connection = new PDO($dsn, $user, $pass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function query($sql, $params = null)
    {
        $statement = $this->connection->prepare($sql);
        if (!$statement) {
            throw new InvalidArgumentException('Invalid SQL query');
        }
        
        $params = (array)$params;

        $statement->setFetchMode(PDO::FETCH_ASSOC);
        if (!empty($params)) {
            $params = array_values($params);
            foreach ($params as $n => $value) {
                $statement->bindValue(++$n, $value);
            }
        }
        $statement->execute();
        if (stripos($sql, 'SELECT') === false) {
            return $statement->rowCount();
        } else {
            return $statement->fetchAll();
        }
    }

    public function save($table, $data)
    {
        if(array_key_exists('id', $data)) {
            $id = $data['id'];
            unset($data['id']);
            return $this->update($table, $id, $data);
        } else {
            return $this->insert($table, $data);
        }
    }

    public function insert($table, $data)
    {
        $data['created'] = date(DATE_ATOM, time());
        $data['modified'] = date(DATE_ATOM, time());
        
        $keys = implode(',', array_keys($data));
        foreach($data as $k => $v) {
            $vals[] = '?';
        }
        $vals = implode(', ', $vals);
        $sql = 'INSERT INTO ' . $table . ' (' . $keys . ') VALUES (' . $vals . ')';

        $statement = $this->connection->prepare($sql);
        return $statement->execute(array_values($data));
    }

    public function update($table, $id, $data)
    {
        $keys = implode('` = ?, `', array_keys($data)) . '` = ?';
        $vals = array_values($data);
        $vals[] = (int)$id;
        $sql = 'UPDATE `' . $table . '` SET `' . $keys . ' WHERE `id` = ? ';
        $statement = $this->connection->prepare($sql, $vals);
        return $statement->execute($vals);
    }

    public function delete($table, $id)
    {
        $sql = 'DELETE FROM `' . $table . '` WHERE `id`= :id';
        $statement = $this->connection->prepare($sql);
        $statement->bindParam(':id', $id);
        return $statement->execute();
    }

    function __destruct()
    {
        $this->connection = null;
    }
    
    /**
     *
     * @param type $path
     * @return type 
     */
    public static function buildSqliteDsn($path = null) {
        if (!$path) {
            $path = _EA_ROOT . '/data/eagb.sqlite';
        }
        return 'sqlite:' . $path;
    }
    
    /**
     *
     * @param type $host
     * @param type $dbName
     * @return type 
     */
    public static function buildMysqlDsn($host, $dbName = null) {
        $db = $dbName != null ? ';dbname=' . (string)$dbName : '';
        $dsn = 'mysql:host=' . $host . $db;
        return $dsn;
    }
}