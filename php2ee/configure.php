<?php
    define('DB_DSN','DRIVER={MySQL ODBC 5.1 Driver};Server=127.0.0.1;Database=php');
//    define('DB_DSN','MySQLODBC');
    define('DB_SERVER', 'LPZWSCZ19\SQLEXPRESS');
    define('DB_SERVER_USERNAME', 'root');
    define('DB_SERVER_PASSWORD', 'root');
    define('DB_DATABASE', 'files');
    define('DB_PORT', '3306');
    define('SQL_LOG_PATH', "C:/logs.log");
    define('TABLE_ROW_VIEW','5');
    define('ODBC_DEFAULTLRL','4096');
    define('ODBC_MAXLRL','2000000');
    define('DB_DATETIME_FORMAT','Y-m-d H:i:s');
    define('LOG_DATETIME_FORMAT','Y-m-d H:i:s');
    define('ROOT_FOLDER','C:/inetpub/wwwroot/TestDoBrasil');
    define('MY_URI','http://172.27.52.92');
    define('UPGRADE_VERSION','2');
    define('SESSION_USER','zuser');
    define('ADMIN_USER','z1111111');
    define('ADMIN_PASSWORD','z1111111');

    define('SHOW_DATABASES','show databases;'); //MSSQL
    define('SHOW_TABLES','show tables;');//MSSQL
    define('DESC_TABLE','desc');//MSSQL
    define('COLUMN_NAME','Field');
    define('TYPE_NAME','Type');
    define('COLUMN_LENGTH','LENGTH');
    define('PRIMARY_KEY','Key');
    define('PRIMARY_KEY_VALUE','PRI');
    
    define('DATABASE_COLUMN_NAME','Database'); //repsuesta de show databases 
    define('TABLES_COLUMN_NAME','Tables_in_'); //repsuesta de show tabes 
    define('CLASS_PATH','C:/inetpub/wwwroot/php/php2ee/class/');
    //define('CLASS_PATH','C:\\inetpub\\wwwroot\\php\\php2ee\\class\\');
?>