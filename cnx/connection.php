<?php 
include_once (dirname((dirname(__FILE__))).'/conf/configure.php');
include_once (dirname((dirname(__FILE__))).'/conf/'.MESSAGES_FILE);
class Connection{
    private static $instance = NULL;
    private $connection = null;

    public function  __construct() {
        //$this->connection = mysql_connect(DB_DSN, DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
        $this->connection = mysql_connect(DB_SERVER, DB_SERVER_USERNAME,DB_SERVER_PASSWORD);
        mysql_select_db(DB_DATABASE,$this->connection);
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
    
    /**
     * Prevent SQL injection
    */
    public function inject($value){
    // Stripslashes
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        // Quote if not integer
        if (!is_numeric($value)) {
            $value = mysql_real_escape_string($value);
        }
        return $value;
    }
}
?>