<?php error_reporting(E_ALL & ~(E_STRICT | E_NOTICE | E_DEPRECATED)); require_once dirname(dirname(dirname(__FILE__)))."/xajax/ec_encuestas.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>ec_encuestas</title>
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
                <script type="text/javascript">
                    bkLib.onDomLoaded(function() {
                            new nicEditor().panelInstance('txt_descripcion');
                            new nicEditor().panelInstance('txt_acuerdo');
                    });
                    
                    function getDataContent(elem){
//                        var nicE = new nicEditors.findEditor(elem);
//                        nicE.saveContent();
//                        content = nicE.getContent();
                        nicEditors.findEditor(elem).saveContent();
                        //content = nicEditors.findEditor(elem).getContent();
                        //document.getElementById(elem).innerHTML = content;
                    }
                    function setDataContentFF(elem){
                        nicEditors.findEditor(elem).setContent($('<div />').html(document.getElementById(elem).innerHTML).text());
                        nicEditors.findEditor(elem).saveContent();
                    }
                    function setDataContentIE(elem,content){
                        nicEditors.findEditor(elem).setContent(content);
                        nicEditors.findEditor(elem).saveContent();
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
					<li><a id="savebutton" name="savebutton" onclick="getDataContent('txt_descripcion');getDataContent('txt_acuerdo');xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
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
								<span class="labels" >Nombre</span>
								<input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >
                                                            <span class="labels" >Empresa</span>
                                                            <span id="ctns_cbx_clientes"></span>
                                                        </div>
							<!--div class="inputs_td" >&nbsp;</div-->
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
                                        <input id="txt_encuesta_id" name="txt_encuesta_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Cliente</span>
							<!--input id="txt_empresa_id" name="txt_empresa_id" type="text" maxlength="11" style="width: 250px;"/-->
                                                        <span id="ctn_cbx_clientes"></span>
							<span id="valid_empresa_id" name="valid_empresa_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nombre</span>
							<input id="txt_nombre" name="txt_nombre" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_nombre" name="valid_nombre" class="validfield"></span>
						</div>
					</div>
					<div >
                                            <span class="labels">Descripci&oacute;n</span>
                                            <div style="margin-left: 125px;">
                                                    <textarea id="txt_descripcion" name="txt_descripcion" cols="50" rows="10"></textarea>
                                                    <span id="valid_descripcion" name="valid_descripcion" class="validfield"></span>
                                            </div>
                                            <div class="inputs_td" style="width: 1px;"></div>
                                            <div class="inputs_td" style="width: 1px;"></div>
					</div>
                                        <div >
                                            <span class="labels">Acuerdo</span>
                                            <div style="margin-left: 125px;">
                                                    <textarea id="txt_acuerdo" name="txt_acuerdo" cols="50" rows="10"></textarea>
                                                    <span id="valid_acuerdo" name="valid_acuerdo" class="validfield"></span>
                                            </div>
                                            <div class="inputs_td" style="width: 1px;"></div>
                                            <div class="inputs_td" style="width: 1px;"></div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Inicio</span>
							<input id="txt_fecha_inicio" name="txt_fecha_inicio" type="text" maxlength="" style="width: 250px;"/>
                                                        <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                        <script type="text/javascript">new datepickr('txt_fecha_inicio', {'dateFormat': 'd/m/Y'});</script>
							<span id="valid_fecha_inicio" name="valid_fecha_inicio" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Fecha Fin</span>
							<input id="txt_fecha_fin" name="txt_fecha_fin" type="text" maxlength="" style="width: 250px;"/>
                                                        <img src="../../../../media/img/actions/calendar.png" alt="Inicio" title="Inicio" border="0" style="margin-bottom: -5px;" />
                                                        <script type="text/javascript">new datepickr('txt_fecha_fin', {'dateFormat': 'd/m/Y'});</script>
							<span id="valid_fecha_fin" name="valid_fecha_fin" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Anonimo</span>
							<select id="txt_es_anonimo" name="txt_es_anonimo" style="width: 250px;">
                                                            <option value="S">SI</option>
                                                            <option value="N">NO</option>
                                                        </select>
							<span id="valid_es_anonimo" name="valid_es_anonimo" class="validfield"></span>
						</div>
					</div>
                                        
				</div>
			</div>
			</div>
		</form>
	</body>
</html>