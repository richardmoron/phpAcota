<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ec_preguntas.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>ec_preguntas</title>
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
                <script type="text/javascript">
                    function dispatchPostLov(){
                        xajax_loadGruposAndNroPregunta(document.getElementById('txt_encuesta_id').value,'_new');
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
							<span class="labels">Encuesta</span>
                                                        <input id="txts_encuesta_id" name="txts_encuesta_id" type="hidden" maxlength="11" style="width: 250px;"/>
                                                        <input id="txts_nombre_encuesta" name="txts_nombre_encuesta" type="text" maxlength="11" style="width: 250px;"/>
                                                        <input id="btn_link1" name="btn_link1" type="button" value="Buscar" onclick="callLovGeneric('txts_encuesta_id','txts_nombre_encuesta','<?php echo MY_SUBURL;?>/modules/encuestas/www/php/ec_encuestas_lov.php',false)" style="width: 60px;height: 21px;" />
                                                    </div>
                                                    <!--div class="inputs_td" >
							<span class="labels">Grupo</span>
                                                        <span id="ctns_cbx_grupo_pregunta"><select style="width: 250px;"></select></span>
                                                    </div-->    
                                                </div>
						<div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels" >Pregunta</span>
                                                                <input type="text" value="" name="txts_pregunta" id="txts_pregunta" onkeyup="enter(event);" style="width: 250px;"/>
							</div>
							<div class="inputs_td" >
                                                            <span class="labels" >Tipo</span>
                                                            <span id="ctns_cbx_tipo_respuesta"></span>
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
                                    <input id="txt_pregunta_id" name="txt_pregunta_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">Encuesta</span>
                                                    <input id="txt_encuesta_id" name="txt_encuesta_id" type="hidden" maxlength="11" style="width: 250px;"/>
                                                    <input id="txt_nombre_encuesta" name="txt_nombre_encuesta" type="text" maxlength="11" style="width: 250px;"/>
                                                    <input id="btn_link1" name="btn_link1" type="button" value="Buscar" onclick="callLovGeneric('txt_encuesta_id','txt_nombre_encuesta','<?php echo MY_SUBURL;?>/modules/encuestas/www/php/ec_encuestas_lov.php',true)" style="width: 60px;height: 21px;" />
                                                </div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Grupo</span>
                                                        <span id="ctn_cbx_grupo_pregunta"><select style="width: 250px;"></select></span>
							<!--input id="txt_grupo_id" name="txt_grupo_id" type="text" maxlength="11" style="width: 250px;"/-->
							<span id="valid_grupo_id" name="valid_grupo_id" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nro Pregunta</span>
							<input id="txt_nro_pregunta" name="txt_nro_pregunta" type="text" maxlength="20" style="width: 250px;"/>
							<span id="valid_nro_pregunta" name="valid_nro_pregunta" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Pregunta</span>
							<input id="txt_pregunta" name="txt_pregunta" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_pregunta" name="valid_pregunta" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Tipo Respuesta</span>
                                                        <span id="ctn_cbx_tipo_respuesta"></span>
							<span id="valid_tipo_respuesta" name="valid_tipo_respuesta" class="validfield"></span>
						</div>
					</div>
					<!--div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">respuesta</span>
							<input id="txt_respuesta" name="txt_respuesta" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_respuesta" name="valid_respuesta" class="validfield"></span>
						</div>
					</div-->
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Atributo Extra</span>
							<input id="txt_atributo_extra" name="txt_atributo_extra" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_atributo_extra" name="valid_atributo_extra" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">Alineaci&oacute;n</span>
							<select id="txt_alineacion_respuesta" name="txt_alineacion_respuesta" style="width: 250px;">
                                                            <option value="V">VERTICAL</option>
                                                            <option value="H">HORIZONTAL</option>
                                                        </select>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Label Izq</span>
							<input id="txt_label_izq" name="txt_label_izq" type="text" maxlength="" style="width: 250px;"/>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Label Der</span>
							<input id="txt_label_der" name="txt_label_der" type="text" maxlength="" style="width: 250px;"/>
						</div>
					</div>
                                        <!--div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Respuestas</span>
                                                        <input id="btn_respuestas" name="btn_respuestas" type="button" maxlength="" style="width: 250px;" value="Especificar"/>
						</div>
					</div-->
				</div>
			</div>
			</div>
		</form>
	</body>
</html>