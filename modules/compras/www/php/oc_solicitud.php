<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/oc_solicitud.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/graybdb.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="../../../../media/css/datatable.css" type="text/css" media="screen" />
		<title>oc_solicitud</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<div id="header">
		<div id="header_title" name="header_title">Nombre de la Empresa</div>
			<div id="header_content">&nbsp;</div>
			<div id="header_user">
				<span>Usuario:&nbsp;</span><span id="header_user_data">Richard Moron</span><br />
				<span>Fecha:&nbsp;</span><span id="header_date_data">01/06/2012</span>
			</div>
		</div>
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
					<li><a id="homebutton" name="homebutton" href="#" class="header_button"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li>
					<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media../img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
					<li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li>
					<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media../img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li>
					<li><a id="searchbutton" name="searchbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/search_page.png" alt="Buscar" title="Buscar" border="0">&nbsp;Buscar</a></li>
					<li><a id="cancelbutton" name="cancelbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/back.png" alt="Cancelar" title="Cancelar" border="0">&nbsp;Cancelar</a></li>
				</ul>
			</div>
			<div id="content">
                            <div class="title_panel" style="">
                                    <div class="panel_title_label">Solitud</div>
                                    <div class="panel_inputs">
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            &nbsp;
                                                            <input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);" style="width: 50px;"/>
                                                            <span class="labels" >Gary Gomez</span>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="title_panel" style="width: 300px;float: left;">
                                    <div class="panel_title_label">Destino</div>
                                    <div class="panel_inputs">
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            &nbsp;
                                                            <input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);" style="width: 50px;"/>
                                                            <span class="labels" >Gary Gomez</span>
                                                    </div>
                                            </div>
                                    </div>
                            </div>
                            <div class="title_panel" style="width: 300;">
                                    <div class="panel_title_label">Contable</div>
                                    <div class="panel_inputs">
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            &nbsp;
                                                            <input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);" style="width: 50px;"/>
                                                            <span class="labels" >Gary Gomez</span>
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
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">oc_solicitud_id</span>
							<input id="txt_oc_solicitud_id" name="txt_oc_solicitud_id" type="text" readonly="readonly" maxlength="" style="width: 250px;"/>
							<span id="valid_oc_solicitud_id" name="valid_oc_solicitud_id"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">cod_empresa</span>
							<input id="txt_cod_empresa" name="txt_cod_empresa" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_cod_empresa" name="valid_cod_empresa"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">anio</span>
							<input id="txt_anio" name="txt_anio" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_anio" name="valid_anio"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">no_solicitud</span>
							<input id="txt_no_solicitud" name="txt_no_solicitud" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_no_solicitud" name="valid_no_solicitud"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">fecha</span>
							<input id="txt_fecha" name="txt_fecha" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_fecha" name="valid_fecha"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">referencia</span>
							<input id="txt_referencia" name="txt_referencia" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_referencia" name="valid_referencia"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">observaciones</span>
							<input id="txt_observaciones" name="txt_observaciones" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_observaciones" name="valid_observaciones"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">num_mes</span>
							<input id="txt_num_mes" name="txt_num_mes" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_num_mes" name="valid_num_mes"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">cod_persona</span>
							<input id="txt_cod_persona" name="txt_cod_persona" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_cod_persona" name="valid_cod_persona"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">nombre_persona</span>
							<input id="txt_nombre_persona" name="txt_nombre_persona" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_nombre_persona" name="valid_nombre_persona"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">cod_proyecto</span>
							<input id="txt_cod_proyecto" name="txt_cod_proyecto" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_cod_proyecto" name="valid_cod_proyecto"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">cod_agencia</span>
							<input id="txt_cod_agencia" name="txt_cod_agencia" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_cod_agencia" name="valid_cod_agencia"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">cod_seccion</span>
							<input id="txt_cod_seccion" name="txt_cod_seccion" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_cod_seccion" name="valid_cod_seccion"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">centro_costo</span>
							<input id="txt_centro_costo" name="txt_centro_costo" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_centro_costo" name="valid_centro_costo"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">ind_estado</span>
							<input id="txt_ind_estado" name="txt_ind_estado" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_ind_estado" name="valid_ind_estado"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">prioridad</span>
							<input id="txt_prioridad" name="txt_prioridad" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_prioridad" name="valid_prioridad"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">adicionado_por</span>
							<input id="txt_adicionado_por" name="txt_adicionado_por" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_adicionado_por" name="valid_adicionado_por"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">fec_adicion</span>
							<input id="txt_fec_adicion" name="txt_fec_adicion" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_fec_adicion" name="valid_fec_adicion"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">modificado_por</span>
							<input id="txt_modificado_por" name="txt_modificado_por" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_modificado_por" name="valid_modificado_por"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">fec_modificacion</span>
							<input id="txt_fec_modificacion" name="txt_fec_modificacion" type="text" maxlength=" style="width: 250px;""/>
							<span id="valid_fec_modificacion" name="valid_fec_modificacion"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>