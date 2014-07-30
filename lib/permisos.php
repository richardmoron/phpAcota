<?php
include_once (dirname(dirname(__FILE__)).'/cnx/connection.php');
include_once ("logs.php");

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Acerca del Autor
 *
 * @author Richard Henry Moron Borda <richardom09@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2012, Richard Henry Moron Borda
 */
class permisos {
    //put your code here

    /**
    * consulta los privilegios que tienen el usuario sobre el
    * archivo que esta accesando
    *
    * @param text $archivo El nombre del archivo al que esta ingresando
    * @example permisos::getIBRAC(__FILE__);
    */
    public static function getIBRAC($archivo) {
        //return permisos::getIBRAC_Fn($archivo);
        return permisos::getIBRAC_Qy($archivo);
    }
    
    private static function getIBRAC_Fn($archivo){
        $archivo = basename($archivo, '');
        $connection = Connection::getinstance()->getConn();

        $user = $_SESSION[SESSION_USER];
        $ibrac = "";
        $PreparedStatement = "SELECT permisosUsuario('".$user."','".$archivo."')  AS IBRAC;";
        $ResultSet = mysql_query($PreparedStatement,$connection);
        while ($row = mysql_fetch_array($ResultSet)) {
            $ibrac = $row["IBRAC"];
        }
        mysql_free_result($ResultSet);
//        $ibrac = "IBRAC";
        return $ibrac;
    }
    
    private static function getIBRAC_Qy($archivo){
        $archivo = basename($archivo, '');
        $connection = Connection::getinstance()->getConn();

        $user = $_SESSION[SESSION_USER];
        $ibrac = "";
        //-- PERMISOS POR AREA
        $v_insertar = "";
        $v_borrar = "";
        $v_reporte = "";
        $v_actualizar = "";
        $v_consultar = "";
        $PreparedStatement = "(SELECT * FROM pa_permisos_x_area WHERE area_id = (SELECT area_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER('".$user."')) AND archivo = '".$archivo."' );";
        $ResultSet = mysql_query($PreparedStatement,$connection);
        //error_log($PreparedStatement,3,SQL_LOG_PATH); // Write log into File
        while ($row = mysql_fetch_array($ResultSet)) {
            if($row["insertar"] == "S")
                $v_insertar = "I";
            if($row["borrar"] == "S")
                $v_borrar = "B";
            if($row["reporte"] == "S")
                $v_reporte =  "R";
            if($row["actualizar"] == "S")
                $v_actualizar = "A";
            if($row["consultar"] == "S")
                $v_consultar = "C";
        }
        //-- PERMISOS POR USUARIO
        $PreparedStatement = "(SELECT * FROM pa_permisos_x_usuario WHERE UPPER(usuario_id) = (SELECT usuario_id FROM pa_usuarios WHERE UPPER(usuario) = UPPER('".$user."')) AND archivo = '".$archivo."' );";
        $ResultSet = mysql_query($PreparedStatement,$connection);
        //error_log($PreparedStatement,3,SQL_LOG_PATH); // Write log into File
        while ($row = mysql_fetch_array($ResultSet)) {
            if($row["insertar"] == "S")
                $v_insertar = "I";
            if($row["borrar"] == "S")
                $v_borrar = "B";
            if($row["reporte"] == "S")
                $v_reporte =  "R";
            if($row["actualizar"] == "S")
                $v_actualizar = "A";
            if($row["consultar"] == "S")
                $v_consultar = "C";
        }
        //--
        mysql_free_result($ResultSet);
        $ibrac = $v_insertar.$v_borrar.$v_reporte.$v_actualizar.$v_consultar;
//        $ibrac = "IBRAC";
        return $ibrac;
    }
}
?>