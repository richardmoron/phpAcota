<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_permisos_x_area.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
                <title>Permisos por &Aacute;rea</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
                <script type="text/javascript" src="../../../../media/js/jquery-latest.js"></script> 
                <script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js"></script>
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
                                                            <span class="labels" >&Aacute;rea</span>
                                                            <span id="ctns_cbx_area" name="ctns_cbx_area"></span>
                                                        </div>
                                                        <div class="inputs_td" >
								<span class="labels" >Archivo</span>
								<input type="text" value="" name="txts_archivo" id="txts_archivo" onkeyup="enter(event);"/>
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
                                        <input id="txt_permisos_x_area_id" name="txt_permisos_x_area_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">&Aacute;rea</span>
							<span id="ctn_cbx_area" name="ctn_cbx_area"></span>
							<span id="valid_area_id" name="valid_area_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Archivo</span>
							<input id="txt_archivo" name="txt_archivo" type="text" maxlength="50" style="width: 250px;"/>
                                                        <input id="btn_link1" name="btn_link1" type="button" value="Buscar" onclick="callFileBrowser('txt_archivo',false)" style="width: 60px;height: 21px;" />
							<span id="valid_archivo" name="valid_archivo" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Insertar</span>
							<select id="txt_insertar" name="txt_insertar" style="width: 250px;">
                                                            <option value="S">SI</option>
                                                            <option value="N">NO</option>
                                                        </select>
							<span id="valid_insertar" name="valid_insertar" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Borrar</span>
							<select id="txt_borrar" name="txt_borrar" style="width: 250px;">
                                                            <option value="S">SI</option>
                                                            <option value="N">NO</option>   
                                                        </select>
							<span id="valid_borrar" name="valid_borrar" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Reporte</span>
							<select id="txt_reporte" name="txt_reporte" style="width: 250px;">
                                                            <option value="S">SI</option>
                                                            <option value="N">NO</option>
                                                        </select>
							<span id="valid_reporte" name="valid_reporte" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Actualizar</span>
							<select id="txt_actualizar" name="txt_actualizar" style="width: 250px;">
                                                            <option value="S">SI</option>
                                                            <option value="N">NO</option>
                                                        </select>
							<span id="valid_actualizar" name="valid_actualizar" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Consultar</span>
							<select id="txt_consultar" name="txt_consultar" style="width: 250px;">
                                                            <option value="S">SI</option>
                                                            <option value="N">NO</option>
                                                        </select>
							<span id="valid_consultar" name="valid_consultar" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Obs</span>
							<textarea id="txt_observaciones" name="txt_observaciones" style="width: 250px;" rows="4"></textarea>
							<span id="valid_observaciones" name="valid_observaciones" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>