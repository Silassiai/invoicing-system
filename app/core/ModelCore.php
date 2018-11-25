<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:55
 *
 * ModelCore parent model that loads the database
 */

namespace core;
use PDO;

class ModelCore
{
    protected $db = null;

    public function __construct()
    {
        Database::load($this);
//        $db = Database::load($this);
//        $this->db = $db->connect();
    }

    public function setConnection($connection){
        $this->db = $connection;
    }
}