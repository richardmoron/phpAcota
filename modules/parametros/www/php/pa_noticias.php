<?php error_reporting(E_ALL & ~(E_STRICT | E_NOTICE | E_DEPRECATED));require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_noticias.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>pa_noticias</title>
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
                <script type="text/javascript" src="../../../../media/js/nicEdit.js" ></script>
                <style type="text/css">
                    .labels{
                        width: 150px;
                    }
                </style>
                <script type="text/javascript">
                    bkLib.onDomLoaded(function() {
                            new nicEditor().panelInstance('txt_descripcion');
                    });
                    
                    function getDataContent(){
                        var nicE = new nicEditors.findEditor('txt_descripcion');
                        nicE.saveContent();
                        content = nicE.getContent();
                        document.getElementById('txt_descripcion').innerHTML = content;
                    }
                    function setDataContent(content){
                        var nicE = new nicEditors.findEditor('txt_descripcion');
                        nicE.setContent(content);
                    }
                </script>
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
					<li><a id="savebutton" name="savebutton" onclick="getDataContent();xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
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
                                                            <span class="labels" style="width: 80px;">T&iacute;tulo</span>
                                                            <input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >
                                                            <span class="labels" style="width: 80px;">&Aacute;rea</span>
                                                            <span id="ctns_cbx_area" name="ctns_cbx_area"></span>
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
                                        <input id="txt_noticia_id" name="txt_noticia_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
                                        <input id="txt_usuario_id" name="txt_usuario_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">T&iacute;tulo</span>
							<input id="txt_titulo" name="txt_titulo" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_titulo" name="valid_titulo" class="validfield"></span>
						</div>
					</div>
                                        <div >
                                            <span class="labels">Descripci&oacute;n</span>
                                            <div style="margin-left: 175px;">
                                                    <textarea id="txt_descripcion" name="txt_descripcion" cols="50" rows="10"></textarea>
                                                    <span id="valid_descripcion" name="valid_descripcion" class="validfield"></span>
                                            </div>
                                            <div class="inputs_td" style="width: 1px;"></div>
                                            <div class="inputs_td" style="width: 1px;"></div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Registro</span>
                                                        <input id="txt_fecha_registro" name="txt_fecha_registro" type="text" maxlength="" style="width: 250px;" readonly="readonly"/>
							<span id="valid_fecha_registro" name="valid_fecha_registro" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Desde</span>
							<input id="txt_fecha_desde" name="txt_fecha_desde" type="text" maxlength="" style="width: 250px;" onKeyUp="this.value=formateafecha(this.value);"/>
                                                        <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                        <script type="text/javascript">new datepickr('txt_fecha_desde', {'dateFormat': 'd/m/Y'});</script>
							<span id="valid_fecha_desde" name="valid_fecha_desde" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Hasta</span>
							<input id="txt_fecha_hasta" name="txt_fecha_hasta" type="text" maxlength="" style="width: 250px;" onKeyUp="this.value=formateafecha(this.value);"/>
                                                        <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                        <script type="text/javascript">new datepickr('txt_fecha_hasta', {'dateFormat': 'd/m/Y'});</script>
							<span id="valid_fecha_hasta" name="valid_fecha_hasta" class="validfield"></span>
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
							<span class="labels">Tipo</span>
							<span name="ctn_cbx_tipo" id="ctn_cbx_tipo"></span>
							<span id="valid_tipo_id" name="valid_tipo_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">&Aacute;rea</span>
                                                        <span id="ctn_cbx_area" name="ctn_cbx_area"></span>
							<span id="valid_area_id" name="valid_area_id" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>