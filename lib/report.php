<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style type="text/css">
            <!--
            @page { size:8.5in 11in; margin: 2cm }
            -->
            html, body{
                height: 100%;
                width: 100%;
                min-width: 100%;
                margin: 0px;
                font-size: 10pt;
                font-family: sans-serif, Verdana, Arial;
                font-weight: normal;
            }
            .page-border{
                margin: 1%;
                padding: 15px;
                width: 95%;
                height: 95%;
                /*border: 1px solid #333333;*/
                /*box-shadow: 4px 4px 4px #888888;*/
            }
            .header{
               
                width: 100%;
            }
            #row-header,datatable-column-header{
                 border-bottom: 1px dotted #000000;
            }
            #left-side-header{
                text-align: left;
                width: 20%;
                float: left;
                font-weight: normal;
            }
            #center-side-header{
                text-align: center;
                font-weight: bold;
                width: 70%;
                float: left;
            }
            #right-side-header{
                text-align: right;
                width: 10%;
                float: left;
            }
            .header-label{
                display: inline-block;
                width: 80px;
                white-space: nowrap;
            }
            table { page-break-inside:auto; }
            tr    { page-break-inside:avoid; page-break-after:auto }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }
            td{text-align: left;}
            th{text-align: left;}
        </style>
    </head>
    <body >
        <div class="page-border">
            <table id="datatable">
                <thead>
                    <tr id="row-header">
                        <th colspan="42" id="row-header">
                            <div class="header">
                                <div id="left-side-header">
                                    <span class="header-label">USUARIO</span><span class="header-label-value"><?php echo ".: ".$_SESSION[SESSION_USER];?></span><br />
                                    <span class="header-label">FECHA</span><span class="header-label-value"><?php echo ".: ".date("d/m/Y"); ?></span><br />
                                    <span class="header-label">HORA</span><span class="header-label-value"><?php echo ".: ".date("H:i:s"); ?></span><br />
                                    <span class="header-label">REPORTE</span><span class="header-label-value"><?php echo ".: ";if(isset($reporte)) echo $reporte; ?></span><br />
                                    <span class="header-label">PAG</span><span class="header-label-value"><?php echo ".: ";if(isset($pagina)) echo $pagina; if(isset($pagina_hasta)){ echo " de ".$pagina_hasta;} ?></span><br />
                                </div>
                                <div id="center-side-header">
                                    <span >BANCO DO BRASIL BOLIVIA S.A.</span><br />
                                    <span ><?php if(isset($nombre_reporte)) echo $nombre_reporte; else echo "NOMBRE DE REPORTE"; ?></span><br />
                                    <?php if($fecha_de){ echo '<span>DEL:&nbsp;'.$fecha_de.'</span>'; }else{ echo "&nbsp;";} ?>
                                    <?php if($fecha_a){ echo '<span>&nbsp;AL:&nbsp;'.$fecha_a.'</span>';} else{ echo "&nbsp;";} ?>
                                </div>
                                <div style="right-side-header">
                                    <img src=<?php echo MY_URI."/lib/reports/logo.png"?> border="none" alt="LOGO"/>
                                </div>
                            </div>
                        </th>
                    </tr>
                    <tr id="datatable-column-header">
                        <?php 
                            for ($index = 0; $index < 15; $index++) {
                                echo "<th>column $index</th>";
                            }
                        ?>
                    </tr>
                </thead>
                <tbody id="datatable-body">
                    <?php 
                        for ($row = 0; $row < 500; $row++) {
                            echo "<tr>";
                            for ($col = 0; $col < 15; $col++) {
                                echo "<td>$row $col</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>