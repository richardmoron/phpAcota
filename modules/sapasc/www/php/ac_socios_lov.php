<?php require_once dirname(dirname(dirname(__FILE__)))."/xajax/ac_socios_lov.xajax.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="x-ua-compatible" content="IE=8" >
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="../../../../media/css/4forms.css" type="text/css" media="screen" />
                <title>Socios</title>
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
                    <div id="content" style="margin-top: 0px;">
                        <div id="searchfields" name="searchfields" class="title_panel" style="width: 90%">
					<div class="panel_title_label">Buscar Por</div>
					<div class="panel_inputs">
						<div class="inputs_tr" >
							<div class="inputs_td" >
								<span class="labels" >Nombres</span>
                                                                <input type="text" value="" name="txts_nombres" id="txts_nombres" onkeyup="enter(event);" style="width: 250px;"/>
							</div>
						</div>
                                                <div class="inputs_tr" >
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
						</div>
					</div>
				</div>
			<!--//-- IBRAC -->
			<input id="ibrac" name="ibrac" type="hidden"/>
			<!--//-- IBRAC -->
			<div class="tablebox" id="datatable_box" name="datatable_box" style="width: 91%"></div>
                    </div>
		</form>
	</body>
</html>