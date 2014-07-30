<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

@session_start();
include_once (dirname((dirname(__FILE__))).'/conf/configure.php');


function verifySession($objResponse){
    //-- VERIFICAR SESSION
    if(!isset($_SESSION[SESSION_USER])){
            $objResponse->script("window.location.href=".MY_URL);
    }
    return $objResponse;
}
?>