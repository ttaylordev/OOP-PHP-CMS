<?php

final class DbConnection {
    
    private static function drawCredentials(){
        
        $path = $_SERVER['DOCUMENT_ROOT'] . "/oop-php-cms";
        $file = $path . "/badplacetohidecredentials.txt";
        $password = '';
    
        $pw = $password;
        
        if($handle = fopen($file, 'r')){
            $readFile = fread($handle, filesize($file));
            fclose($handle);
            $password = $readFile;
            return $password;
        } else{
            echo "not able to read the file";
        }
    }

    private static $instance = null;
    private static $connection;
    private static $password;

    private function __construct() {

    }

    private function __clone() {

    }
    
    public function __wakeup() {

    }

    public static function connect($host, $dbName, $user){
        self::$password = DbConnection::drawCredentials();
        self::$connection = new PDO("mysql:dbname=$dbName;host=$host", $user, self::$password);
    }
    
    public static function getConnection() {
        return self::$connection;
    }

    public static function getInstance(){
        if (is_null(self::$instance)){
            self::$instance = new DbConnection();
        }
        return self::$instance;
    }
}
