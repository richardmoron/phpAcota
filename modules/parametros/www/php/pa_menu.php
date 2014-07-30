<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_menu.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
                <title>Men&uacute;s</title>
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
                            lov = "pa_menu_lov.php?es_padre=S";
                            loadMenu(window.showModalDialog(lov, window,'dialogWidth:480px;dialogHeight:600px;status:no;resizable:no'),elem_id,elem_name,false);
                        }
                        function loadMenu(elem,menu_id,nomre_menu,search){
                            document.forms[0].elements[menu_id].value = elem.menu_id;
                            document.forms[0].elements[nomre_menu].value = elem.nomre_menu;
                        }
		</script>
	</head>
	<body onload="xajax_preload();" >
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
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
								<span class="labels" >Nombre</span>
								<input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >
                                                                <span class="labels" >Es Padre</span>
								<select id="txts_es_padre" name="txts_es_padre" style="width: 150px;" >
                                                                    <option value="0" selected="selected">TODO</option>
                                                                    <option value="S">SI</option>
                                                                    <option value="N">NO</option>
                                                                </select>
                                                        </div>
							<div class="inputs_td" >
                                                                <span class="labels" >Es Exclusivo</span>
								<select id="txts_es_exclusivo" name="txts_es_exclusivo" style="width: 150px;" >
                                                                    <option value="0" selected="selected">TODO</option>
                                                                    <option value="S">SI</option>
                                                                    <option value="N">NO</option>
                                                                </select>
                                                        </div>
						</div>
                                                <div class="inputs_tr" >
                                                            <div class="inputs_td" >
                                                                    <span class="labels" >Men&uacute; Padre</span>
                                                                    <input id="txts_menu_padre_id" name="txts_menu_padre_id" type="hidden" maxlength="11"style="width: 250px;" />
                                                                    <input id="txts_menu_padre" name="txts_menu_padre" type="text" maxlength="11" style="width: 185px;" onkeyup="enter(event);" />
                                                                    <input id="btn_link4" name="btn_link4" type="button" value="Buscar" onclick="callLov('txts_menu_padre_id','txts_menu_padre')" style="width: 60px;height: 21px;" />
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
                                        <input id="txt_menu_id" name="txt_menu_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Nombre</span>
							<input id="txt_nombre" name="txt_nombre" type="text" maxlength="50"style="width: 250px;"/>
							<span id="valid_nombre" name="valid_nombre" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">Descripci&oacute;n</span>
                                                        <textarea id="txt_descripcion" name="txt_descripcion" style="width: 250px;" rows="4"></textarea>
							<span id="valid_descripcion" name="valid_descripcion" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Es Padre</span>
                                                        <select id="txt_es_padre" name="txt_es_padre" style="width: 250px;" onchange="if(getSelectedValueFromSelect('txt_es_padre')=='S'){disableField('formulario','txt_link','disabled');disableField('formulario','btn_link1','disabled');document.getElementById('txt_link').value='';}else{disableField('formulario','txt_link','');disableField('formulario','btn_link1','');} ">
                                                            <option value="S">SI</option>
                                                            <option value="N" selected="selected">NO</option>
                                                        </select>
							<span id="valid_es_padre" name="valid_es_padre" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Link</span>
                                                        <input id="txt_link" name="txt_link" type="text" maxlength="255"style="width: 250px;" />
                                                        <input id="btn_link1" name="btn_link1" type="button" value="Buscar" onclick="callFileBrowser('txt_link',true)" style="width: 60px;height: 21px;" />
							<span id="valid_link" name="valid_link" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Menú Padre</span>
                                                        <input id="txt_menu_padre_id" name="txt_menu_padre_id" type="hidden" maxlength="11"style="width: 250px;" />
                                                        <input id="txt_menu_padre" name="txt_menu_padre" type="text" maxlength="11"style="width: 250px;" onkeyup="if(event.keyCode == 13){callLov('txt_menu_padre_id','txt_menu_padre');}" readonly="readonly"/>
                                                        <input id="btn_link2" name="btn_link2" type="button" value="Buscar" onclick="callLov('txt_menu_padre_id','txt_menu_padre')" style="width: 60px;height: 21px;" />
							<span id="valid_menu_padre_id" name="valid_menu_padre_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Es Exclusivo</span>
                                                        <select id="txt_exclusivo" name="txt_exclusivo" style="width: 250px;" onchange="">
                                                            <option value="S">SI</option>
                                                            <option value="N" selected="selected">NO</option>
                                                        </select>
							<span id="valid_exclusivo" name="valid_exclusivo" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Complemento</span>
							<input id="txt_complemento" name="txt_complemento" type="text" maxlength="255" style="width: 250px;"/>
                                                        <input id="btn_link3" name="btn_link3" type="button" value="Buscar" onclick="callFileBrowser('txt_complemento',false)" style="width: 60px;height: 21px;"/>
							<span id="valid_complemento" name="valid_complemento" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels">Posici&oacute;n</span>
                                                        <input id="txt_posicion" name="txt_posicion" type="text" maxlength="11"style="width: 250px;" onkeyup="return ValNumero(this);"/>
							<span id="valid_posicion" name="valid_posicion" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">Es Tab Pane</span>
                                                        <select id="txt_tab" name="txt_tab" style="width: 250px;" onchange="">
                                                            <option value="S">SI</option>
                                                            <option value="N" selected="selected">NO</option>
                                                        </select>
							<span id="valid_tab" name="valid_tab" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>