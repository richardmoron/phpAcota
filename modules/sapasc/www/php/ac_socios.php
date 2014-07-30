<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ac_socios.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
                <meta http-equiv="x-ua-compatible" content="IE=8" >
                <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>ac_socios</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js" ></script>
                <style type="text/css">
                    .labels{
                        width: 150px;
                    }
                </style>
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
					<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
					<li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li>
					<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li>
					<li><a id="searchbutton" name="searchbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/search_page.png" alt="Buscar" title="Buscar" border="0">&nbsp;Buscar</a></li>
					<li><a id="cancelbutton" name="cancelbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/back.png" alt="Cancelar" title="Cancelar" border="0">&nbsp;Cancelar</a></li>
                                        <!--li><a id="exportbutton" name="exportbutton" onclick="xajax_exrpotexcel(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/page_down.png" alt="Exportar" title="Exportar" border="0">&nbsp;Exportar</a></li-->
				</ul>
			</div>
			<div id="content">
				<div id="searchfields" name="searchfields" class="title_panel">
					<div class="panel_title_label">Buscar Por</div>
					<div class="panel_inputs">
						<div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels" >Nombres</span>
                                                                <input type="text" value="" name="txts_nombres" id="txts_nombres" onkeyup="enter(event);" style="width: 250px;"/>
							</div>
                                                        <div class="inputs_td" >
                                                                    <span class="labels" >Apellidos</span>
                                                                    <input type="text" value="" name="txts_apellidos" id="txts_apellidos" onkeyup="enter(event);" style="width: 250px;"/>
                                                        </div>
						</div>
                                                <div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels" >CI</span>
								<input type="text" value="" name="txts_ci" id="txts_ci" onkeyup="ValNumero(this);enter(event);" style="width: 250px;"/>
							</div>
                                                        <div class="inputs_td" >
                                                                    <span class="labels" >Nro Medidor</span>
                                                                    <input type="text" value="" name="txts_nro_medidor" id="txts_nro_medidor" onkeyup="enter(event);" style="width: 250px;"/>
                                                        </div>
						</div>
                                                <div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels" >Grupo</span>
								<span id="ctns_cbx_grupo" ></span>
							</div>
                                                        <div class="inputs_td" >
                                                                    <span class="labels" >Comunidad</span>
                                                                    <span id="ctns_cbx_comunidad" ></span>
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
                                        <input id="txt_socio_id" name="txt_socio_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Grupo</span>
                                                        <span id="ctn_cbx_grupo" ></span>
							<!--input id="txt_grupo_id" name="txt_grupo_id" type="text" maxlength="11" style="width: 250px;"/-->
							<span id="valid_grupo_id" name="valid_grupo_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nro Medidor</span>
							<input id="txt_nro_medidor" name="txt_nro_medidor" type="text" maxlength="255" style="width: 250px;" />
							<span id="valid_nro_medidor" name="valid_nro_medidor" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Marca Medidor</span>
							<input id="txt_marca_medidor" name="txt_marca_medidor" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_marca_medidor" name="valid_marca_medidor" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nombres</span>
							<input id="txt_nombres" name="txt_nombres" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_nombres" name="valid_nombres" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Apellidos</span>
							<input id="txt_apellidos" name="txt_apellidos" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_apellidos" name="valid_apellidos" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Ci</span>
							<input id="txt_ci" name="txt_ci" type="text" maxlength="11" style="width: 250px;" onkeyup="ValNumero(this);"/>
							<span id="valid_ci" name="valid_ci" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Ci Expedido</span>
                                                        <select id="txt_ci_expedido_en" name="txt_ci_expedido_en">
                                                            <option value="lp">LA PAZ</option>
                                                            <option value="cb">COCHABAMBA</option>
                                                            <option value="sc">SANTA CRUZ</option>
                                                            <option value="tj">TARIJA</option>
                                                            <option value="bn">BENI</option>
                                                            <option value="pt">POTOSI</option>
                                                            <option value="or">ORURO</option>
                                                            <option value="ch">CHUQUISACA</option>
                                                            <option value="pn">PANDO</option>
                                                        </select>
							<span id="valid_ci_expedido_en" name="valid_ci_expedido_en" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">Direcci&oacute;n</span>
                                                        <textarea id="txt_direccion" name="txt_direccion" style="width: 250px;" rows="5" cols="10"></textarea>
							<span id="valid_direccion" name="valid_direccion" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Comunidad</span>
                                                        <span id="ctn_cbx_comunidad" ></span>
							<!--input id="txt_comunidad_id" name="txt_comunidad_id" type="text" maxlength="11" style="width: 250px;"/-->
							<span id="valid_comunidad_id" name="valid_comunidad_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Zona</span>
							<input id="txt_zona" name="txt_zona" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_zona" name="valid_zona" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Registrado Por</span>
                                                        <input id="txt_registrado_por" name="txt_registrado_por" type="text" maxlength="11" style="width: 250px;" readonly="readonly"/>
							<span id="valid_registrado_por" name="valid_registrado_por" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Registro</span>
                                                        <input id="txt_fecha_registro" name="txt_fecha_registro" type="text" maxlength="" style="width: 250px;" readonly="readonly"/>
							<span id="valid_fecha_registro" name="valid_fecha_registro" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>