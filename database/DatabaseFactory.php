<?php

namespace DBC;

use App\Factory;

use DBC\CartDBC;
use DBC\ProductDBC;
use DBC\UserDBC;

class DatabaseFactory
{
    private static $class;
    private $connection;

    private function __construct(){
        $mysqlConf = Factory::getConfigManager()->get('database');

        $host = $mysqlConf['mysql']['host'];
        $dbname = $mysqlConf['mysql']['database'];
        $dbuser = $mysqlConf['mysql']['user'];
        $dbpswd = $mysqlConf['mysql']['password'];

        $this->connection = new PDO("mysql:host=$host;dbname=$dbname",$dbuser,$dbpswd);
    }

    public static function getInstance(){

        if(self::$class == null){
            self::$class = new DatabaseFactory();
        }
        return self::$class;
    }

}

?>
