<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/pa_configure.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
                <title>Variables de Configuraci&oacute;n</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
                <style type="text/css" media="screen">
                    .labels{
                        width: 180px;
                        font-size: 10pt;
                    }
                    .inputs{
                        width: 200px;
                    }
                </style>
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
                                        <li style="visibility: hidden;"><a id="homebutton" name="homebutton" href="<?php echo HOME;?>" class="header_button" style="margin-top: -7px; padding-top: 10px;"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li>
					<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
					<!--li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li>
					<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li>
					<li><a id="searchbutton" name="searchbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/search_page.png" alt="Buscar" title="Buscar" border="0">&nbsp;Buscar</a></li>
					<li><a id="cancelbutton" name="cancelbutton" onclick="xajax_searchfields(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/back.png" alt="Cancelar" title="Cancelar" border="0">&nbsp;Cancelar</a></li-->
				</ul>
			</div>
			<div id="content">
			<!--//-- IBRAC -->
			<input id="ibrac" name="ibrac" type="hidden"/>
			<!--//-- IBRAC -->
                            <div id="fields" name="fields" class="title_panel" style="visibility: visible;margin-top: 20px;">
                                <div class="panel_title_label" id="fields_title_panel" name="fields_title_panel">Variables de Configuraci&oacute;n</div>
                                    <div class="panel_inputs">
                                            <input id="txt_area_id" name="txt_area_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_DSN</span>
                                                            <input id="txt_DB_DSN" name="txt_DB_DSN" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_SERVER_USERNAME</span>
                                                            <input id="txt_DB_SERVER_USERNAME" name="txt_DB_SERVER_USERNAME" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_DATABASE</span>
                                                            <input id="txt_DB_DATABASE" name="txt_DB_DATABASE" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_SERVER_PASSWORD</span>
                                                            <input id="txt_DB_SERVER_PASSWORD" name="txt_DB_SERVER_PASSWORD" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_PORT</span>
                                                            <input id="txt_DB_PORT" name="txt_DB_PORT" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">SQL_LOG_PATH</span>
                                                            <input id="txt_SQL_LOG_PATH" name="txt_SQL_LOG_PATH" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">TABLE_ROW_VIEW</span>
                                                            <input id="txt_TABLE_ROW_VIEW" name="txt_TABLE_ROW_VIEW" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">TABLE_ROW_VIEW_LOGS</span>
                                                            <input id="txt_TABLE_ROW_VIEW_LOGS" name="txt_TABLE_ROW_VIEW_LOGS" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">ODBC_DEFAULTLRL</span>
                                                            <input id="txt_ODBC_DEFAULTLRL" name="txt_ODBC_DEFAULTLRL" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">ODBC_MAXLRL</span>
                                                            <input id="txt_ODBC_MAXLRL" name="txt_ODBC_MAXLRL" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_DATETIME_FORMAT</span>
                                                            <input id="txt_DB_DATETIME_FORMAT" name="txt_DB_DATETIME_FORMAT" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">LOG_DATETIME_FORMAT</span>
                                                            <input id="txt_LOG_DATETIME_FORMAT" name="txt_LOG_DATETIME_FORMAT" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">APP_DATETIME_FORMAT</span>
                                                            <input id="txt_APP_DATETIME_FORMAT" name="txt_APP_DATETIME_FORMAT" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">ROOT_FOLDER</span>
                                                            <input id="txt_ROOT_FOLDER" name="txt_ROOT_FOLDER" type="text" maxlength="500" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">MY_URI</span>
                                                            <input id="txt_MY_URI" name="txt_MY_URI" type="text" maxlength="500" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">MY_URL</span>
                                                            <input id="txt_MY_URL" name="txt_MY_URL" type="text" maxlength="500" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">HOME</span>
                                                            <input id="txt_HOME" name="txt_HOME" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">UPGRADE_VERSION</span>
                                                            <input id="txt_UPGRADE_VERSION" name="txt_UPGRADE_VERSION" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">SESSION_USER</span>
                                                            <input id="txt_SESSION_USER" name="txt_SESSION_USER" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">SESSION_ID</span>
                                                            <input id="txt_SESSION_ID" name="txt_SESSION_ID" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">MAX_SEARCH_RESULT_ROW</span>
                                                            <input id="txt_MAX_SEARCH_RESULT_ROW" name="txt_MAX_SEARCH_RESULT_ROW" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">COMPANY_NAME</span>
                                                            <input id="txt_COMPANY_NAME" name="txt_COMPANY_NAME" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">REQUERIDO</span>
                                                            <input id="txt_REQUERIDO" name="txt_REQUERIDO" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">MESSAGES_FILE</span>
                                                            <input id="txt_MESSAGES_FILE" name="txt_MESSAGES_FILE" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">DB_LOGS</span>
                                                            <input id="txt_DB_LOGS" name="txt_DB_LOGS" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">MY_SUBURL</span>
                                                            <input id="txt_MY_SUBURL" name="txt_MY_SUBURL" type="text" maxlength="50" style="width: 250px;"/>
                                                    </div>
                                            </div>
                                            <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">REGISTER_FILE_LOGS</span>
                                                            <select id="txt_REGISTER_FILE_LOGS" name="txt_REGISTER_FILE_LOGS" style="width: 250px;">
                                                                <option value="S">SI</option>
                                                                <option value="N">NO</option>
                                                            </select>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">REGISTER_DB_LOGS</span>
                                                            <select id="txt_REGISTER_DB_LOGS" name="txt_REGISTER_DB_LOGS" style="width: 250px;">
                                                                <option value="S">SI</option>
                                                                <option value="N">NO</option>
                                                            </select>
                                                            
                                                    </div>
                                            </div>
                                    </div>
                            </div>
			</div>
		</form>
	</body>
</html>