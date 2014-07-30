<?php
include_once (dirname(dirname(__FILE__)).'/cnx/connection.php');
include_once (dirname(dirname(__FILE__)).'/modules/php_logs/dao/php_logs.dao.php');

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Store data logs
 *
 * @author Richard Henry Moron Borda <richardom09@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2009, Richard Henry Moron Borda
 */
class logs {
    //put your code here

    /**
    * Registra los Logs del sistema en un archivo .log
    *
    * @param text $source Origen del Log
    * @param text $PreparedStatement El Detalle del Log
    * @example error_log("mimetodo.insertarvalores","insert into mitabla values();"
    */
    public static function set_log_file($source,$PreparedStatement) {
        $connection = Connection::getinstance()->getConn();
        $user = $_SESSION[SESSION_USER];
        $log_head = "SQL statement failed with error:".odbc_error($connection).": ".odbc_errormsg($connection)."\n";
        $log_body = str_replace("\n","",date('d/m/Y H:i:s')." - ".$source." -> ".$log.trim($PreparedStatement))."\n";

        error_log($log_head.$log_body,3,SQL_LOG_PATH); // Write log into File
    }

    /**
    * Registra los Logs del sistema en la base de datos
    *
    * @param text $source Origen del Log
    * @param text $PreparedStatement El Detalle del Log
    * @example error_log("mimetodo.insertarvalores","insert into mitabla values();"
    */
    public static function set_log_data($source,$PreparedStatement) {
        $connection = Connection::getinstance()->getConn();
        $user = $_SESSION[SESSION_USER];
        $log_head = "SQL statement failed with error:".odbc_error($connection).": ".odbc_errormsg($connection)."\n";
        $log_body = str_replace("\n","",date('d/m/Y H:i:s')." - ".$source." -> ".$log.trim($PreparedStatement))."\n";

    }

    /**
    * Registra los Logs del sistema en un archivo .log y en la base de datos
    *
    * @param text $file __FILE__
    * @param text $class __CLASS__
    * @param text $method __METHOD__
    * @param text $PreparedStatement El Detalle del Log
    * @example logs::set_log(__FILE__,__CLASS__,__METHOD__, $PreparedStatement);
    */
    public static function set_log($file,$class,$method,$PreparedStatement) {
        $connection = Connection::getinstance()->getConn();
        $user = $_SESSION[SESSION_USER];
        $log_head = "SQL statement executed successfully \n";
        if( strlen(trim(mysql_error($connection)))>0 )
            $log_head = "SQL statement  failed with error:".mysql_errno($connection).": ".mysql_error($connection)."\n";

        $log_body = str_replace("\n","",date(LOG_DATETIME_FORMAT)." - ".$file.": ".$method." -> ".$PreparedStatement)."\n";
        if(REGISTER_FILE_LOGS == "S")
            error_log($log_head.$log_body,3,SQL_LOG_PATH."logsapp_".date("Ymd").".log"); // Write log into File

        
        $Accion = "S";
        if(strstr($method,"insert")){
            $Accion = "I";
        }else{
            if(strstr($method,"update")){
                $Accion = "U";
            }else{
                if(strstr($method,"delete")){
                    $Accion = "D";
                }
            }
        }

        $php_logsDAO = new php_logsDAO();
        $php_logsTO = new php_logsTO();
        $php_logsTO->setLog_id(0);
        $php_logsTO->setNom_table(str_replace("DAO", "", $class));
        $php_logsTO->setNom_usuario($user);
        $php_logsTO->setFecha_hora(date(LOG_DATETIME_FORMAT));
        $php_logsTO->setAccion($Accion);
        $PreparedStatement = str_replace("'", '"', $PreparedStatement);
        $php_logsTO->setDet_accion($PreparedStatement);
        $php_logsTO->setDet_error($log_head);
        if(REGISTER_DB_LOGS == "S")
            $php_logsDAO->insertphp_logs($php_logsTO);
    }
}
?>
