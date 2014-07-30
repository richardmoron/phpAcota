<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_parametros.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>Parametros</title>
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
								<span class="labels" >Entidad</span>
								<input type="text" value="" name="txts_entidad" id="txts_entidad" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >
								<span class="labels" >Valor</span>
								<input type="text" value="" name="txts_valor" id="txts_valor" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >&nbsp;</div>
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
                                        <input id="txt_parametro_id" name="txt_parametro_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Entidad</span>
							<input id="txt_entidad" name="txt_entidad" type="text" maxlength="50" style="width: 250px;"/>
							<span id="valid_entidad" name="valid_entidad" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">C&oacute;digo</span>
							<input id="txt_codigo" name="txt_codigo" type="text" maxlength="20" style="width: 250px;"/>
							<span id="valid_codigo" name="valid_codigo" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Valor</span>
							<input id="txt_valor" name="txt_valor" type="text" maxlength="25" style="width: 250px;"/>
							<span id="valid_valor" name="valid_valor" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels">Descripci&oacute;n</span>
                                                    <textarea id="txt_descripcion" name="txt_descripcion" style="width: 250px;" rows="4"></textarea>
							<span id="valid_descripcion" name="valid_descripcion" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>