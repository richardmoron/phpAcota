<?php 
	class oc_solicitud_detalleTO {

		private $Oc_solicitud_detalle_id;
		private $Cod_empresa;
		private $Anio;
		private $No_solicitud;
		private $No_linea;
		private $Tipo_solicitud;
		private $Cod_tipo;
		private $Cod_grupo;
		private $Cod_subgrupo;
		private $Codigo_referencia;
		private $Nombre_referencia;
		private $Unidad_medida;
		private $Cantidad;
		private $Cantidad_aprobada;
		private $Cantidad_pendiente;
		private $Observaciones;
		private $No_docto_referencia;
		private $Adicionado_por;
		private $Fec_adicion;
		private $Modificado_por;
		private $Fec_modificacion;
		public static $FIELDS = array('Oc_solicitud_detalle_id','Cod_empresa','Anio','No_solicitud','No_linea','Tipo_solicitud','Cod_tipo','Cod_grupo','Cod_subgrupo','Codigo_referencia','Nombre_referencia','Unidad_medida','Cantidad','Cantidad_aprobada','Cantidad_pendiente','Observaciones','No_docto_referencia','Adicionado_por','Fec_adicion','Modificado_por','Fec_modificacion' );
		public static $PK_FIELD = 'oc_solicitud_detalle_id';

		function oc_solicitud_detalleTO(){
		}

		public function setOc_solicitud_detalle_id($Oc_solicitud_detalle_id){
			$this->Oc_solicitud_detalle_id = utf8_decode($Oc_solicitud_detalle_id);
		}

		public function getOc_solicitud_detalle_id(){
			return utf8_encode($this->Oc_solicitud_detalle_id);
		}

		public function setCod_empresa($Cod_empresa){
			$this->Cod_empresa = utf8_decode($Cod_empresa);
		}

		public function getCod_empresa(){
			return utf8_encode($this->Cod_empresa);
		}

		public function setAnio($Anio){
			$this->Anio = utf8_decode($Anio);
		}

		public function getAnio(){
			return utf8_encode($this->Anio);
		}

		public function setNo_solicitud($No_solicitud){
			$this->No_solicitud = utf8_decode($No_solicitud);
		}

		public function getNo_solicitud(){
			return utf8_encode($this->No_solicitud);
		}

		public function setNo_linea($No_linea){
			$this->No_linea = utf8_decode($No_linea);
		}

		public function getNo_linea(){
			return utf8_encode($this->No_linea);
		}

		public function setTipo_solicitud($Tipo_solicitud){
			$this->Tipo_solicitud = utf8_decode($Tipo_solicitud);
		}

		public function getTipo_solicitud(){
			return utf8_encode($this->Tipo_solicitud);
		}

		public function setCod_tipo($Cod_tipo){
			$this->Cod_tipo = utf8_decode($Cod_tipo);
		}

		public function getCod_tipo(){
			return utf8_encode($this->Cod_tipo);
		}

		public function setCod_grupo($Cod_grupo){
			$this->Cod_grupo = utf8_decode($Cod_grupo);
		}

		public function getCod_grupo(){
			return utf8_encode($this->Cod_grupo);
		}

		public function setCod_subgrupo($Cod_subgrupo){
			$this->Cod_subgrupo = utf8_decode($Cod_subgrupo);
		}

		public function getCod_subgrupo(){
			return utf8_encode($this->Cod_subgrupo);
		}

		public function setCodigo_referencia($Codigo_referencia){
			$this->Codigo_referencia = utf8_decode($Codigo_referencia);
		}

		public function getCodigo_referencia(){
			return utf8_encode($this->Codigo_referencia);
		}

		public function setNombre_referencia($Nombre_referencia){
			$this->Nombre_referencia = utf8_decode($Nombre_referencia);
		}

		public function getNombre_referencia(){
			return utf8_encode($this->Nombre_referencia);
		}

		public function setUnidad_medida($Unidad_medida){
			$this->Unidad_medida = utf8_decode($Unidad_medida);
		}

		public function getUnidad_medida(){
			return utf8_encode($this->Unidad_medida);
		}

		public function setCantidad($Cantidad){
			$this->Cantidad = utf8_decode($Cantidad);
		}

		public function getCantidad(){
			return utf8_encode($this->Cantidad);
		}

		public function setCantidad_aprobada($Cantidad_aprobada){
			$this->Cantidad_aprobada = utf8_decode($Cantidad_aprobada);
		}

		public function getCantidad_aprobada(){
			return utf8_encode($this->Cantidad_aprobada);
		}

		public function setCantidad_pendiente($Cantidad_pendiente){
			$this->Cantidad_pendiente = utf8_decode($Cantidad_pendiente);
		}

		public function getCantidad_pendiente(){
			return utf8_encode($this->Cantidad_pendiente);
		}

		public function setObservaciones($Observaciones){
			$this->Observaciones = utf8_decode($Observaciones);
		}

		public function getObservaciones(){
			return utf8_encode($this->Observaciones);
		}

		public function setNo_docto_referencia($No_docto_referencia){
			$this->No_docto_referencia = utf8_decode($No_docto_referencia);
		}

		public function getNo_docto_referencia(){
			return utf8_encode($this->No_docto_referencia);
		}

		public function setAdicionado_por($Adicionado_por){
			$this->Adicionado_por = utf8_decode($Adicionado_por);
		}

		public function getAdicionado_por(){
			return utf8_encode($this->Adicionado_por);
		}

		public function setFec_adicion($Fec_adicion){
			$this->Fec_adicion = utf8_decode($Fec_adicion);
		}

		public function getFec_adicion(){
			return utf8_encode($this->Fec_adicion);
		}

		public function setModificado_por($Modificado_por){
			$this->Modificado_por = utf8_decode($Modificado_por);
		}

		public function getModificado_por(){
			return utf8_encode($this->Modificado_por);
		}

		public function setFec_modificacion($Fec_modificacion){
			$this->Fec_modificacion = utf8_decode($Fec_modificacion);
		}

		public function getFec_modificacion(){
			return utf8_encode($this->Fec_modificacion);
		}

	}
?>
