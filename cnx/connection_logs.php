<?php 
include_once (dirname((dirname(__FILE__))).'/conf/configure.php');
include_once (dirname((dirname(__FILE__))).'/conf/'.MESSAGES_FILE);
class ConnectionLogs{
    private static $instance = NULL;
    private $connection = null;

    public function  __construct() {
        //$this->connection = mysql_connect(DB_DSN, DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
        $this->connection = mysql_connect(DB_LOGS_SERVER, DB_LOGS_SERVER_USERNAME,DB_LOGS_SERVER_PASSWORD, true);
        mysql_select_db(DB_LOGS_DATABASE,$this->connection);
    }

    //public create instance function to create singleton
    public function getinstance(){
        if(self::$instance === null){
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    //get the open connection
    public function getConn(){
        if(isset ($this->connection)){
            //$this->connection = mysql_connect($dsn, $user,$password);
        }
        return $this->connection;
    }

    //prevent clone
    public function __clone(){
        throw new Exception("Cannot clone ".__CLASS__." class");
    }
}
?>