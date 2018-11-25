<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 24-11-2018
 * Time: 14:54
 *
 * Database
 * This Class makes the connections to the configured database
 */

namespace core;
use PDO;

class Database
{
    // Hold the class instance.
    private static $instance = null;
    private $conn;

    private $host = '';
    private $user = '';
    private $pass = '';
    private $name = '';

    /**
     * Database constructor.
     * The db connection is established
     */
    public function __construct()
    {
        if (file_exists(SDR_PATH_CONFIG.'database.php')) {
            require_once SDR_PATH_CONFIG.'database.php';
        }
        if (isset($db) && is_array($db)) {
            $this->host = isset($db['host']) ? $db['host'] : '';
            $this->user = isset($db['user']) ? $db['user'] : '';
            $this->pass = isset($db['pass']) ? $db['pass'] : '';
            $this->name = isset($db['name']) ? $db['name'] : '';
        }

        $this->conn = new PDO("mysql:host={$this->host};
    dbname={$this->name}", $this->user,$this->pass,
            [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    }

    /**
     * load
     * Loading database using a Singleton pattern.
     * This will save some memory
     * Only allows application models loading this database object
     * @param ModelCore $model
     * @return void
     */
    public static function load(ModelCore $model)
    {
        if($model instanceof ModelCore){
            if(!self::$instance)
            {
                self::$instance = new Database();
            }
            $model->setConnection(self::$instance->connect());
        }
    }

    /**
     * connect
     * Return the PDO connection or false if there is no connection
     * @return bool|PDO
     */
    public function connect()
    {
        return $this->conn instanceof PDO ? $this->conn : false;
    }
}