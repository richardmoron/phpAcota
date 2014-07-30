<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
session_unset(); 
unset($_SESSION[SESSION_USER]);
session_destroy();
$_SESSION = array();
header("Location:login.php");
?>
