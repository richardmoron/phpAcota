<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ec_valores_respuesta.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>ec_valores_respuesta</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js" ></script>
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<form action="#" method="post" id="formulario">
                    <div id="content" style="margin-top: 0px;">
                            <div id="searchfields" name="searchfields" class="title_panel" style="width: 90%">
					<div class="panel_title_label">Adicionar Respuesta</div>
					<div class="panel_inputs">
                                                <div class="inputs_tr" >
                                                    <span class="labels" style="width: 100px;text-align: center;">Valor</span>
                                                    <span class="labels">Etiqueta</span>
                                                </div>
                                                <div class="inputs_tr" >
                                                    <div class="inputs_td" style="width: 110px;padding-left: 10px;">
                                                        <input id="txt_valor" name="txt_valor" type="text" maxlength="" style="width: 100px;"/>
                                                        <span id="valid_valor" name="valid_valor" class="validfield"></span>
                                                    </div>
                                                    <div class="inputs_td" style="width: 200px;">
                                                        <input id="txt_etiqueta" name="txt_etiqueta" type="text" maxlength="255" style="width: 200px;"/>
                                                        <span id="valid_etiqueta" name="valid_etiqueta" class="validfield"></span>
                                                    </div>
                                                    <input type="button" onclick="xajax_save(xajax.getFormValues('formulario'),0);" value="Guardar" style="margin-left: 10px;"/>
						</div>
					</div>
				</div>
			<!--//-- IBRAC -->
			<input id="ibrac" name="ibrac" type="hidden"/>
			<!--//-- IBRAC -->
                        <div class="tablebox" id="datatable_box" name="datatable_box" style="width: 91%;"></div>
                        
                        <input id="txt_valor_respuesta_id" name="txt_valor_respuesta_id" type="hidden" maxlength="11" style="width: 250px;" value="0"/>
                        <input id="txt_pregunta_id" name="txt_pregunta_id" type="hidden" maxlength="11" style="width: 250px;"/>
			</div>
		</form>
	</body>
</html>