<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ec_usuarios.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
    <meta http-equiv="x-ua-compatible" content="IE=8" >
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>ec_usuarios</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js" ></script>
                <script type="text/javascript" src="../../../../media/js/dateformat.js" ></script>
                <script type="text/javascript" src="../../../../media/js/datepickr.js" ></script>
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<!--div id="header">
		<div id="header_title" name="header_title">Nombre de la Empresa</div>
			<div id="header_content">&nbsp;</div>
			<div id="header_user">
				<span>Usuario:&nbsp;</span><span id="header_user_data">Nombre de Usuario</span><br />
				<span>Fecha:&nbsp;</span><span id="header_date_data">21/12/2012</span>
			</div>
		</div-->
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
					<!--li><a id="homebutton" name="homebutton" href="#" class="header_button"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li-->
					<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0" />&nbsp;Guardar</a></li>
					<li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0" />&nbsp;Nuevo</a></li>
					<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0" />&nbsp;Editar</a></li>
					<li><a id="searchbutton" name="searchbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/search_page.png" alt="Buscar" title="Buscar" border="0"/>&nbsp;Buscar</a></li>
					<li><a id="cancelbutton" name="cancelbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/back.png" alt="Cancelar" title="Cancelar" border="0" />&nbsp;Cancelar</a></li>
                                        <li><a id="generatebutton" onclick="xajax_genUserAndPasswordsRandom(window.showModalDialog('ec_generar_usuarios.php', window,'dialogWidth:500px;dialogHeight:350px;status:no;resizable:no'))" href="#" class="header_button"><img src="../../../../media/img/actions/users.png" alt="Generar" title="Generar" border="0" />&nbsp;Generar</a></li>
                                        <li><a id="exportbutton" onclick="" href="exportar_usuarios.php" class="header_button" style="width: 110px;"><img src="../../../../media/img/actions/users.png" alt="Exportar" title="Exportar" border="0" />Exportar</a></li>                                      
				</ul>
			</div>
			<div id="content">
				<div id="searchfields" name="searchfields" class="title_panel">
					<div class="panel_title_label">Buscar Por</div>
					<div class="panel_inputs">
						<div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels" >Usuario</span>
                                                                <input type="text" value="" name="txts_usuario" id="txts_usuario" onkeyup="enter(event);" style="width: 250px;"/>
							</div>
							<div class="inputs_td" >
                                                            <span class="labels" >Estado</span>
                                                            <select id="txts_estado_usuario" name="txts_estado_usuario" tyle="width: 250px;">
                                                                <option value="0">TODO</option>
                                                                <option value="A">ACTIVO</option>
                                                                <option value="I">INACTIVO</option>
                                                            </select>
                                                        </div>
						</div>
					</div>
				</div>
			<!--//-- IBRAC -->
			<input id="ibrac" name="ibrac" type="hidden"/>
			<!--//-- IBRAC -->
			<div class="tablebox" id="datatable_box" name="datatable_box"></div>
			<div id="fields" name="fields" class="title_panel">
				<div class="panel_title_label" id="fields_title_panel" name="fields_title_panel"></div>
				<div class="panel_inputs">
                                        <input id="txt_usuario_id" name="txt_usuario_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nombre</span>
							<input id="txt_nombre_usuario" name="txt_nombre_usuario" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_nombre_usuario" name="valid_nombre_usuario" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Clave</span>
							<input id="txt_clave_usuario" name="txt_clave_usuario" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_clave_usuario" name="valid_clave_usuario" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Estado</span>
							<select id="txt_estado_usuario" name="txt_estado_usuario" tyle="width: 250px;">
                                                            <option value="A">ACTIVO</option>
                                                            <option value="I">INACTIVO</option>
                                                        </select>
							<span id="valid_estado_usuario" name="valid_estado_usuario" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Hab.</span>
							<input id="txt_fecha_habilitacion" name="txt_fecha_habilitacion" type="text" maxlength="" style="width: 250px;"/>
                                                        <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                        <script type="text/javascript">new datepickr('txt_fecha_habilitacion', {'dateFormat': 'd/m/Y'});</script>
							<span id="valid_fecha_habilitacion" name="valid_fecha_habilitacion" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>