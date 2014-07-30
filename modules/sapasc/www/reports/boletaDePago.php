<?php session_start(); 
include_once dirname(dirname(dirname(__FILE__)))."\\dao\\ac_consumos.dao.php";
include_once (dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/lib/parsedate.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <style type="text/css" rel="stylesheet" media="">
            body{
                font-family: sans-serif, verdana, arial;
                font-size: 10pt;
            }
            .left_align{
                float: left;
            }
            .right_align{
                float: right;
            }
            h1{
               text-decoration: underline;
               font-size: 10pt;
               text-align: center;
            }
            .footer{
                text-align: center;
            }
            .sub_title{
                font-style: italic;
                font-weight: normal;
                text-decoration: none;
            }
            .label{
                font-weight: bold;
                width: 160px;
                display: inline-block;
                text-align: right;
                padding-right: 5px;
            }
        </style>
    </head>
    <body>
        <div>
            <span class="left_align"><?php print $_SESSION[SESSION_USER]?></span>
            <span class="right_align"><?php print date("d/m/Y H:i:s")?></span>
        </div>
        <br />
        <div>
            <h1><?php print COMPANY_NAME; ?></h1>
            <h1 class="sub_title">Comprobante de Pago</h1>
        </div>
        <div>
            <?php
                if(isset($_GET["id"]) && strlen(trim($_GET["id"]))>0){
                    $ac_consumosDAO = new ac_consumosDAO();
                    $ac_consumosTO = $ac_consumosDAO->selectByIdac_consumos($_GET["id"]);
                    echo "<span class='label'>Socio:&nbsp;</span>".$ac_consumosTO->getSocio()."<br />";
                    echo "<span class='label'>Medidor:&nbsp;</span>".$ac_consumosTO->getNro_medidor()."<br />";
                    echo "<span class='label'>Mes Consumo:&nbsp;</span>".$ac_consumosTO->getPeriodo_mes()."<br />";
                    echo "<span class='label'>Anio Consumo:&nbsp;</span>".$ac_consumosTO->getPeriodo_anio()."<br />";
                    echo "<span class='label'>Costo del Consumo Bs:&nbsp;</span>".$ac_consumosTO->getCosto_consumo_por_pagar()."<br />";
                    echo "<span class='label'>Pagado Por:&nbsp;</span>".$ac_consumosTO->getPagado_por()."<br />";
                    echo "<span class='label'>CI Pagado Por:&nbsp;</span>".$ac_consumosTO->getCi_pagado_por()."<br />";
                    echo "<hr>";
                    echo "<span class='label'>Usuario Pago:&nbsp;</span>".$ac_consumosTO->getUsuario_pago()."<br />";
                    echo "<span class='label'>Fecha Pago:&nbsp;</span>".  $ac_consumosTO->getFecha_hora_pago()."<br />";
                }
            ?>
        </div>
        <br />
        <div class="footer">
            La Paz, Bolivia
        </div>
    </body>
</html>