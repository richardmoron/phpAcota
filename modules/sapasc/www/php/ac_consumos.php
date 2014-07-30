<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ac_consumos.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
		<title>ac_consumos</title>
		<?php $xajax->printJavascript(MY_URI."/lib/xajax/"); ?>
		<script type="text/javascript">
			xajax.callback.global.onRequest = function() {xajax.$('loading').style.display = 'block';}
			xajax.callback.global.beforeResponseProcessing = function() {xajax.$('loading').style.display='none';}
		</script>
		<script type="text/javascript" src="../../../../media/js/localUse.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery-latest.js" ></script>
		<script type="text/javascript" src="../../../../media/js/jquery.tablesorter.js" ></script>
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
								<span class="labels" >Nombre</span>
								<input type="text" value="" name="txts_nombre" id="txts_nombre" onkeyup="enter(event);"/>
							</div>
							<div class="inputs_td" >&nbsp;</div>
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
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">consumo_id</span>
							<input id="txt_consumo_id" name="txt_consumo_id" type="text" readonly="readonly" maxlength="11" style="width: 250px;"/>
							<span id="valid_consumo_id" name="valid_consumo_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">socio_id</span>
							<input id="txt_socio_id" name="txt_socio_id" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_socio_id" name="valid_socio_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">nro_medidor</span>
							<input id="txt_nro_medidor" name="txt_nro_medidor" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_nro_medidor" name="valid_nro_medidor" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">fecha_lectura</span>
							<input id="txt_fecha_lectura" name="txt_fecha_lectura" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_fecha_lectura" name="valid_fecha_lectura" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">fecha_emision</span>
							<input id="txt_fecha_emision" name="txt_fecha_emision" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_fecha_emision" name="valid_fecha_emision" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">periodo_mes</span>
							<input id="txt_periodo_mes" name="txt_periodo_mes" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_periodo_mes" name="valid_periodo_mes" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">periodo_anio</span>
							<input id="txt_periodo_anio" name="txt_periodo_anio" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_periodo_anio" name="valid_periodo_anio" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">consumo_total_lectura</span>
							<input id="txt_consumo_total_lectura" name="txt_consumo_total_lectura" type="text" maxlength="20,0" style="width: 250px;"/>
							<span id="valid_consumo_total_lectura" name="valid_consumo_total_lectura" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">consumo_por_pagar</span>
							<input id="txt_consumo_por_pagar" name="txt_consumo_por_pagar" type="text" maxlength="20,0" style="width: 250px;"/>
							<span id="valid_consumo_por_pagar" name="valid_consumo_por_pagar" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">costo_consumo_por_pagar</span>
							<input id="txt_costo_consumo_por_pagar" name="txt_costo_consumo_por_pagar" type="text" maxlength="5,2" style="width: 250px;"/>
							<span id="valid_costo_consumo_por_pagar" name="valid_costo_consumo_por_pagar" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">estado</span>
							<input id="txt_estado" name="txt_estado" type="text" maxlength="1" style="width: 250px;"/>
							<span id="valid_estado" name="valid_estado" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">fecha_hora_pago</span>
							<input id="txt_fecha_hora_pago" name="txt_fecha_hora_pago" type="text" maxlength="" style="width: 250px;"/>
							<span id="valid_fecha_hora_pago" name="valid_fecha_hora_pago" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">usuario_pago</span>
							<input id="txt_usuario_pago" name="txt_usuario_pago" type="text" maxlength="15" style="width: 250px;"/>
							<span id="valid_usuario_pago" name="valid_usuario_pago" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">monto_pagado</span>
							<input id="txt_monto_pagado" name="txt_monto_pagado" type="text" maxlength="5,2" style="width: 250px;"/>
							<span id="valid_monto_pagado" name="valid_monto_pagado" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">pagado_por</span>
							<input id="txt_pagado_por" name="txt_pagado_por" type="text" maxlength="255" style="width: 250px;"/>
							<span id="valid_pagado_por" name="valid_pagado_por" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels">ci_pagado_por</span>
							<input id="txt_ci_pagado_por" name="txt_ci_pagado_por" type="text" maxlength="15" style="width: 250px;"/>
							<span id="valid_ci_pagado_por" name="valid_ci_pagado_por" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
			</div>
		</form>
	</body>
</html>