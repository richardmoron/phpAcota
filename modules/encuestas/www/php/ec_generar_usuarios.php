<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
            <meta http-equiv="x-ua-compatible" content="IE=8" >
            <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
            <script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
            <script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>
            <script type="text/javascript" src="../../../../media/js/dateformat.js" ></script>
            <script type="text/javascript" src="../../../../media/js/datepickr.js" ></script>
            <title>Generar Usuarios</title>
            <script type="text/javascript">
                function terminate(){
                    if(document.getElementById('txts_fecha_habilitacion').value == ''){
                        alert('Debe seleccionar una fecha');
                        return;
                    }
                        
                      var o = new Object();
                      o.cantidad = document.getElementById('txts_cantidad').value;
                      o.fecha = document.getElementById('txts_fecha_habilitacion').value;
                      window.returnValue = o;
                      window.close();
                }
            </script>
	</head>
	<body onload="">
		<!--div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div-->
		<form action="#" method="post" id="formulario">	
                    <div id="searchfields" name="searchfields" class="title_panel" style="width: 90%;">
                            <div class="panel_title_label">Generar Usuarios</div>
                            <div class="panel_inputs">
                                    <div class="inputs_tr" >
                                            <div class="inputs_td" >
                                                    <span class="labels" >Cantidad</span>
                                                    <input type="text" value="1" name="txts_cantidad" id="txts_cantidad" onkeyup="ValNumero(this);" />
                                            </div>
                                    </div>
                                    <div class="inputs_tr" >
                                            <div class="inputs_td" >
                                                <span class="labels" >Fecha Habilitaci&oacute;n</span>
                                                    <input type="text" value="" name="txts_fecha_habilitacion" id="txts_fecha_habilitacion" />
                                                    <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                    <script type="text/javascript">new datepickr('txts_fecha_habilitacion', {'dateFormat': 'd/m/Y'});</script>
                                            </div>
                                    </div>
                                    <div class="inputs_tr" >
                                            <div class="inputs_td" >
                                                <span class="labels" >&nbsp;</span>
                                                <input type="button" value="GENERAR" onclick="terminate();" style="width: 100px;"/>
                                                <input type="button" value="CANCELAR" onclick="window.close();" style="width: 100px;"/>
                                            </div>
                                    </div>
                            </div>
                    </div>
		</form>
	</body>
</html>