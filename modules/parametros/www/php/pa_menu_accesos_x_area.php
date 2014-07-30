<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_menu_accesos_x_area.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
                <title>Accesos al Men&uacute; por &Aacute;rea</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
                <script type="text/javascript" src="../../../../media/js/jquery-latest.js"></script> 
                <script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js"></script>
                <script type="text/javascript">
                        function callLov(elem_id, elem_name){
                            nombre = document.forms[0].elements[elem_name].value;
                            lov = "pa_menu_lov.php";
                            loadMenu(window.showModalDialog(lov, window,'dialogWidth:480px;dialogHeight:600px;status:no;resizable:no'),elem_id,elem_name,false);
                        }
                        function loadMenu(elem,menu_id,nomre_menu,search){
                            document.forms[0].elements[menu_id].value = elem.menu_id;
                            document.forms[0].elements[nomre_menu].value = elem.nomre_menu;
                        }
		</script>
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
                                                                <span class="labels" >Men&uacute;</span>
                                                                <input id="txts_menu_id" name="txts_menu_id" type="hidden" maxlength="11"style="width: 250px;" />
                                                                <input id="txts_menu" name="txts_menu" type="text" maxlength="11" style="width: 185px;" onkeyup="enter(event);" />
                                                                <input id="btn_link4" name="btn_link4" type="button" value="Buscar" onclick="callLov('txts_menu_id','txts_menu')" style="width: 60px;height: 21px;" />
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
                                        <input id="txt_menu_acceso_area_id" name="txt_menu_acceso_area_id" type="hidden" readonly="readonly" maxlength="11" />
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">&Aacute;rea</span>
                                                        <span id="ctn_cbx_area" name="ctn_cbx_area"></span>
							<span id="valid_area_id" name="valid_area_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">Men&uacute;</span>
                                                        <input id="txt_menu_id" name="txt_menu_id" type="hidden" maxlength="11"style="width: 250px;" />
                                                        <input id="txt_menu" name="txt_menu" type="text" maxlength="11" style="width: 250px;" onkeyup="enter(event);" />
                                                        <input id="btn_link" name="btn_link" type="button" value="Buscar" onclick="callLov('txt_menu_id','txt_menu')" style="width: 60px;height: 21px;" />
                                                        <span id="valid_menu_id" name="valid_menu_id" class="validfield"></span>
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