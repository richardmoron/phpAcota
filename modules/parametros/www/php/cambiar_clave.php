<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/cambiar_clave.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
                <title>&Aacute;reas</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
                <script type="text/javascript" src="../../../../media/js/jquery-latest.js"></script> 
                <script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js"></script>
                <style type="text/css">
                    .labels{
                        width: 150px;
                    }
                </style>
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
                                    <li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
				</ul>
			</div>
			<div id="content">
			<!--//-- IBRAC -->
			<input id="ibrac" name="ibrac" type="hidden"/>
			<!--//-- IBRAC -->
                        <div id="fields" name="fields" class="title_panel" style="visibility: visible;margin-top: 0;">
				<div class="panel_title_label" id="fields_title_panel" name="fields_title_panel">Cambio Clave de Usuario</div>
				<div class="panel_inputs">
                                        <input id="txt_usuario_id" name="txt_usuario_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Clave Actual</span>
							<input id="txt_password_actual" name="txt_password_actual" type="password" maxlength="" style="width: 250px;"/>
							<span id="valid_password_actual" name="valid_password_actual" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nueva Clave</span>
							<input id="txt_password" name="txt_password" type="password" maxlength="" style="width: 250px;"/>
							<span id="valid_password" name="valid_password" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Confirmar Clave</span>
                                                        <input id="txt_password1" name="txt_password1" type="password" maxlength="" style="width: 250px;"/>
							<span id="valid_password1" name="valid_password1" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>