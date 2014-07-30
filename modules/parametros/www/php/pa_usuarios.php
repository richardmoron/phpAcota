<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_usuarios.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>Usuarios</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
                <script type="text/javascript" src="../../../../media/js/jquery-latest.js"></script> 
                <script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js"></script>
                <style type="text/css" media="screen">
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
					<!--li><a id="homebutton" name="homebutton" href="<?php echo HOME;?>" class="header_button"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li-->
					<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
					<li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li>
					<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li>
					<li><a id="searchbutton" name="searchbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/search_page.png" alt="Buscar" title="Buscar" border="0">&nbsp;Buscar</a></li>
					<li><a id="cancelbutton" name="cancelbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/back.png" alt="Cancelar" title="Cancelar" border="0">&nbsp;Cancelar</a></li>
				</ul>
			</div>
			<div id="content">
				<div id="searchfields" name="searchfields" class="title_panel">
					<div class="panel_title_label">Buscar Por</div>
					<div class="panel_inputs">
						<div class="inputs_tr" >
							<div class="inputs_td" >
                                                            <span class="labels" style="width: 100px;" >Usuario</span>
                                                            <input type="text" value="" name="txts_usuario" id="txts_usuario" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >
                                                            <span class="labels" style="width: 100px;" >Nombres</span>
                                                            <input type="text" value="" name="txts_nombres" id="txts_nombres" onkeyup="enter(event);"/>
                                                        </div>
                                                        <div class="inputs_td" >
                                                            <span class="labels" style="width: 100px;" >Apellidos</span>
                                                            <input type="text" value="" name="txts_apellidos" id="txts_apellidos" onkeyup="enter(event);"/>
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
							<span class="labels">Usuario</span>
							<input id="txt_usuario" name="txt_usuario" type="text" maxlength="15"style="width: 250px;"/>
							<span id="valid_usuario" name="valid_usuario" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Clave</span>
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
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nombres</span>
							<input id="txt_nombres" name="txt_nombres" type="text" maxlength="50" style="width: 250px;"/>
							<span id="valid_nombres" name="valid_nombres" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Apellidos</span>
							<input id="txt_apellidos" name="txt_apellidos" type="text" maxlength="50" style="width: 250px;"/>
							<span id="valid_apellidos" name="valid_apellidos" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Email</span>
							<input id="txt_email" name="txt_email" type="text" maxlength="50" style="width: 250px;""/>
							<span id="valid_email" name="valid_email" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Agencia</span>
							<input id="txt_agencia_id" name="txt_agencia_id" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_agencia_id" name="valid_agencia_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Area</span>
							<!--input id="txt_area_id" name="txt_area_id" type="text" maxlength="11" style="width: 250px;"/-->
                                                        <span id="ctn_cbx_area" name="ctn_cbx_area"></span>
							<span id="valid_area_id" name="valid_area_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Estado</span>
                                                        <select id="txt_estado" name="txt_estado" style="width: 250px;">
                                                            <option value="A">ACTIVO</option>
                                                            <option value="I">INACTIVO</option>
                                                            <option value="B">BLOQUEADO</option>
                                                        </select>
							<span id="valid_estado" name="valid_estado" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Tipo Usuario</span>
							<input id="txt_tipo_usuario_id" name="txt_tipo_usuario_id" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_tipo_usuario_id" name="valid_tipo_usuario_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Persona</span>
							<input id="txt_persona_id" name="txt_persona_id" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_persona_id" name="valid_persona_id" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>