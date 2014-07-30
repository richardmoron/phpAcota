<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/php_logs.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/graybdb.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../../../../media/css/datatable.css" type="text/css" media="screen" />
                <link rel="stylesheet" href="../../../../media/css/datepickr.css" type="text/css" media="screen" />
		<title>Monitor de Logs</title>
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
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
					<!--li><a id="homebutton" name="homebutton" href="#" class="header_button"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li-->
					<!--li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li-->
					<!--li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li-->
					<!--li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li-->
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
								<span class="labels" >Tabla</span>
								<input type="text" value="" name="txts_tabla" id="txts_tabla" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >
                                                            <span class="labels" >Fecha</span>
                                                            <input type="text" value="" name="txts_fecha" id="txts_fecha" onKeyUp="this.value=formateafecha(this.value); " style="width: 150px;"/>
                                                            <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                            <script type="text/javascript">new datepickr('txts_fecha', {'dateFormat': 'd/m/Y'});</script>
                                                        </div>
							<div class="inputs_td" >
                                                            <span class="labels" >Acci&oacute;n</span>
                                                            <select value="" name="txts_accion" id="txts_accion">
                                                                <option value="0">TODO</option>
                                                                <option value="I">INSERT</option>
                                                                <option value="S">SELECT</option>
                                                                <option value="U">UPDATE</option>
                                                                <option value="D">DELETE</option>
                                                            </select>
                                                        </div>
						</div>
                                                <div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels">Usuario</span>
                                                                <input id="txts_usuario_id" name="txts_usuario_id" type="hidden" maxlength="25" />
                                                                <input id="txts_usuario_nombres" name="txts_usuario_nombres" type="text" maxlength="25" style="width: 185px;" onkeyup="enter(event);"/>
                                                                <input id="btn_link3" name="btn_link3" type="button" value="Buscar" onclick="callLovUsuarios('txts_usuario_id','txts_usuario_nombres')" style="width: 60px;height: 21px;" />
							</div>
                                                        
							<div class="inputs_td" >
                                                            <span class="labels" style="width: 260px;">Respuesta</span>
                                                            <select value="" name="txts_respuesta" id="txts_respuesta">
                                                                <option value="0">TODO</option>
                                                                <option value="successfully ">SUCCESS</option>
                                                                <option value="error">ERROR</option>
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
                                        <input id="txt_log_id" name="txt_log_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Tabla</span>
							<input id="txt_nom_table" name="txt_nom_table" type="text" maxlength="30" style="width: 250px;"/>
							<span id="valid_nom_table" name="valid_nom_table" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Usuario</span>
							<input id="txt_nom_usuario" name="txt_nom_usuario" type="text" maxlength="20" style="width: 250px;"/>
							<span id="valid_nom_usuario" name="valid_nom_usuario" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Hora</span>
							<input id="txt_fecha_hora" name="txt_fecha_hora" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_fecha_hora" name="valid_fecha_hora" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">Acci&oacute;n</span>
							<select id="txt_accion" name="txt_accion" style="width: 250px;">
                                                            <option value="I">INSERT</option>
                                                            <option value="S">SELECT</option>
                                                            <option value="U">UPDATE</option>
                                                            <option value="D">DELETE</option>
                                                        </select>
							<span id="valid_accion" name="valid_accion" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">Det Acci&oacute;n</span>
                                                        <textarea id="txt_det_accion" name="txt_det_accion" style="width: 250px;" rows="4"></textarea>
							<span id="valid_det_accion" name="valid_det_accion" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Det Error</span>
                                                        <textarea id="txt_det_error" name="txt_det_error" style="width: 250px;" rows="4"></textarea>
							<span id="valid_det_error" name="valid_det_error" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>