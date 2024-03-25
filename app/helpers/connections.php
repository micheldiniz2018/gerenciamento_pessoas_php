<?php

namespace app\helpers;

use PDO;
use PDOException;

/**
 * Set Connection Mysql
 */
class ConnectionMsql 
{
    protected static function msql_connect() 
    {
        try{
            $pdo = new PDO('mysql:host=localhost;dbname=gereciar_pessoas', "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Error ".$e->getMessage();
            return;
        }
        
        return $pdo;
    }
}
 ?>