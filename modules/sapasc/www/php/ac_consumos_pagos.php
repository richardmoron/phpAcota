<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ac_consumos_pagos.xajax.php"; ?>
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
                <style type="text/css" media="screen">
                    
                </style>
	</head>
	<body onload="xajax_preload();">
		<div id="loading"><img src="../../../../media/img/loading-bar.gif" alt="Loading..." id="loadingimg"/><br /> Cargando...</div>
		<form action="#" method="post" id="formulario">
			<div id="header_buttons">
				<ul>
					<!--li><a id="homebutton" name="homebutton" href="#" class="header_button"><img src="../../../../media/img/actions/home.png" alt="Inicio" title="Inicio" border="0">&nbsp;Inicio</a></li-->
					<li><a id="savebutton" name="savebutton" onclick="xajax_save(xajax.getFormValues('formulario'),0);" href="#" class="header_button"><img src="../../../../media/img/actions/save.png" alt="Guardar" title="Guardar" border="0">&nbsp;Guardar</a></li>
					<!--li><a id="addbutton" name="addbutton" onclick="xajax_add();" href="#" class="header_button"><img src="../../../../media/img/actions/add_page.png" alt="Nuevo" title="Nuevo" border="0">&nbsp;Nuevo</a></li>
					<li><a id="editbutton" name="editbutton" onclick="xajax_readOnlyfiles('false',null,'Editar Datos');" href="#" class="header_button"><img src="../../../../media/img/actions/edit_page.png" alt="Editar" title="Editar" border="0">&nbsp;Editar</a></li-->
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
                                                            <span class="labels" style="width: 100px;">Socio</span>
                                                            <input id="txts_socio_id" name="txts_socio_id" type="hidden" maxlength="11" style="width: 250px;"/>
                                                            <input id="txts_nombre_apellido" name="txts_nombre_apellido" type="text" maxlength="11" style="width: 250px;"/>
                                                            <input id="btn_link1" name="btn_link1" type="button" value="Buscar" onclick="callLovGeneric('txts_socio_id','txts_nombre_apellido','<?php echo MY_SUBURL;?>/modules/sapasc/www/php/ac_socios_lov.php',false)" style="width: 60px;height: 21px;" />
							</div>
                                                        <div class="inputs_td" >
                                                            <span class="labels" style="width: 100px;">Nro Medidor</span>
                                                            <input type="text" value="" name="txts_nro_medidor" id="txts_nro_medidor" onkeyup="enter(event);" style="width: 250px;"/>
                                                        </div>
						</div>
                                                <div class="inputs_tr" >
                                                    <div class="inputs_td" >
                                                            <span class="labels">Mes</span>
                                                            <select id="txts_periodo_mes" name="txts_periodo_mes" style="width: 100px;" >
                                                                <option value="0" selected="selected">TODO</option>
                                                                <option value="01">Enero</option>
                                                                <option value="02">Febrero</option>
                                                                <option value="03">Marzo</option>
                                                                <option value="04">Abril</option>
                                                                <option value="05">Mayo</option>
                                                                <option value="06">Junio</option>
                                                                <option value="07">Julio</option>
                                                                <option value="08">Agosto</option>
                                                                <option value="09">Septiembre</option>
                                                                <option value="10">Octubre</option>
                                                                <option value="11">Noviembre</option>
                                                                <option value="12">Diciembre</option>
                                                            </select>
                                                    </div>
                                                    <div class="inputs_td" >
                                                            <span class="labels">A&ntilde;o</span>
                                                            <select id="txts_periodo_anio" name="txts_periodo_anio" style="width: 100px;" >
                                                                <option value="2012">2012</option>
                                                                <option value="2013">2013</option>
                                                                <option value="2014">2014</option>
                                                                <option value="2015">2015</option>
                                                                <option value="2016">2016</option>
                                                                <option value="2017">2017</option>
                                                                <option value="2018">2018</option>
                                                                <option value="2019">2019</option>
                                                            </select>
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
                                        <input id="txt_consumo_id" name="txt_consumo_id" type="hidden" readonly="readonly" maxlength="11" style="width: 250px;"/>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                        <span class="labels" style="width: 200px;">Socio</span>
                                                        <input id="txt_socio_id" name="txt_socio_id" type="hidden" maxlength="11" style="width: 250px;"/>
                                                        <input id="txt_nombre_apellido" name="txt_nombre_apellido" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_socio_id" name="valid_socio_id" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels" style="width: 200px;">Nro Medidor</span>
							<input id="txt_nro_medidor" name="txt_nro_medidor" type="text" maxlength="11" style="width: 250px;">
							<span id="valid_nro_medidor" name="valid_nro_medidor" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels" style="width: 200px;">Fecha Lectura</span>
                                                        <input id="txt_fecha_lectura" name="txt_fecha_lectura" type="text" maxlength="" style="width: 250px;" readonly="readonly"/>
							<span id="valid_fecha_lectura" name="valid_fecha_lectura" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels" style="width: 200px;">Mes</span>
                                                        <input type="text" id="txt_periodo_mes" name="txt_periodo_mes" style="width: 250px;" />
							<span id="valid_periodo_mes" name="valid_periodo_mes" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels" style="width: 200px;">A&ntilde;o</span>
							<input id="txt_periodo_anio" name="txt_periodo_anio" type="text" maxlength="11" style="width: 250px;"/>
							<span id="valid_periodo_anio" name="valid_periodo_anio" class="validfield"></span>
						</div>
					</div>
					<div class="inputs_tr" >
						<div class="inputs_td" >
							<span class="labels" style="width: 200px;">Consumo por pagar</span>
							<input id="txt_consumo_por_pagar" name="txt_consumo_por_pagar" type="text" maxlength="20" style="width: 250px;" onkeyup="ValNumero(this);"/>
                                                        <span class="labels" style="text-align: left;width: 250px;">&nbsp;Expresado en metros c&uacute;bicos</span>
							<span id="valid_consumo_total_lectura" name="valid_consumo_total_lectura" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels" style="width: 200px;">Monto por pagar</span>
							<input id="txt_costo_consumo_por_pagar" name="txt_costo_consumo_por_pagar" type="text" maxlength="11" style="width: 250px;"/>
                                                        <span class="labels" style="text-align: left;width: 250px;">&nbsp;Bs.-</span>
							<span id="valid_costo_consumo_por_pagar" name="valid_costo_consumo_por_pagar" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels" style="width: 200px;">Monto Pagado</span>
							<input id="txt_monto_pagado" name="txt_monto_pagado" type="text" maxlength="11" style="width: 250px;" onkeyup="checkDec(this);"/>
                                                        <span id="valid_monto_pagado" name="valid_monto_pagado" class="validfield"></span>
                                                        <span class="labels" style="text-align: left;width: 50px;">&nbsp;Bs.-</span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels" style="width: 200px;">Pagado Por</span>
							<input id="txt_pagado_por" name="txt_pagado_por" type="text" maxlength="255" style="width: 250px;" />
							<span id="valid_pagado_por" name="valid_pagado_por" class="validfield"></span>
						</div>
					</div>
                                        <div class="inputs_tr" >
						<div class="inputs_td" >
                                                    <span class="labels" style="width: 200px;">CI Pagado Por</span>
							<input id="txt_ci_pagado_por" name="txt_ci_pagado_por" type="text" maxlength="11" style="width: 250px;" onkeyup="ValNumero(this);"/>
							<span id="valid_ci_pagado_por" name="valid_ci_pagado_por" class="validfield"></span>
						</div>
					</div>
				</div>
			</div>
                    </div>
		</form>
	</body>
</html>