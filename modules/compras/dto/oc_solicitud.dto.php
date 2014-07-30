<?php 
	class oc_solicitudTO {

		private $Oc_solicitud_id;
		private $Cod_empresa;
		private $Anio;
		private $No_solicitud;
		private $Fecha;
		private $Referencia;
		private $Observaciones;
		private $Num_mes;
		private $Cod_persona;
		private $Nombre_persona;
		private $Cod_proyecto;
		private $Cod_agencia;
		private $Cod_seccion;
		private $Centro_costo;
		private $Ind_estado;
		private $Prioridad;
		private $Adicionado_por;
		private $Fec_adicion;
		private $Modificado_por;
		private $Fec_modificacion;
		public static $FIELDS = array('Oc_solicitud_id','Cod_empresa','Anio','No_solicitud','Fecha','Referencia','Observaciones','Num_mes','Cod_persona','Nombre_persona','Cod_proyecto','Cod_agencia','Cod_seccion','Centro_costo','Ind_estado','Prioridad','Adicionado_por','Fec_adicion','Modificado_por','Fec_modificacion' );
		public static $PK_FIELD = 'oc_solicitud_id';

		function oc_solicitudTO(){
		}

		public function setOc_solicitud_id($Oc_solicitud_id){
			$this->Oc_solicitud_id = utf8_decode($Oc_solicitud_id);
		}

		public function getOc_solicitud_id(){
			return utf8_encode($this->Oc_solicitud_id);
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

		public function setFecha($Fecha){
			$this->Fecha = utf8_decode($Fecha);
		}

		public function getFecha(){
			return utf8_encode($this->Fecha);
		}

		public function setReferencia($Referencia){
			$this->Referencia = utf8_decode($Referencia);
		}

		public function getReferencia(){
			return utf8_encode($this->Referencia);
		}

		public function setObservaciones($Observaciones){
			$this->Observaciones = utf8_decode($Observaciones);
		}

		public function getObservaciones(){
			return utf8_encode($this->Observaciones);
		}

		public function setNum_mes($Num_mes){
			$this->Num_mes = utf8_decode($Num_mes);
		}

		public function getNum_mes(){
			return utf8_encode($this->Num_mes);
		}

		public function setCod_persona($Cod_persona){
			$this->Cod_persona = utf8_decode($Cod_persona);
		}

		public function getCod_persona(){
			return utf8_encode($this->Cod_persona);
		}

		public function setNombre_persona($Nombre_persona){
			$this->Nombre_persona = utf8_decode($Nombre_persona);
		}

		public function getNombre_persona(){
			return utf8_encode($this->Nombre_persona);
		}

		public function setCod_proyecto($Cod_proyecto){
			$this->Cod_proyecto = utf8_decode($Cod_proyecto);
		}

		public function getCod_proyecto(){
			return utf8_encode($this->Cod_proyecto);
		}

		public function setCod_agencia($Cod_agencia){
			$this->Cod_agencia = utf8_decode($Cod_agencia);
		}

		public function getCod_agencia(){
			return utf8_encode($this->Cod_agencia);
		}

		public function setCod_seccion($Cod_seccion){
			$this->Cod_seccion = utf8_decode($Cod_seccion);
		}

		public function getCod_seccion(){
			return utf8_encode($this->Cod_seccion);
		}

		public function setCentro_costo($Centro_costo){
			$this->Centro_costo = utf8_decode($Centro_costo);
		}

		public function getCentro_costo(){
			return utf8_encode($this->Centro_costo);
		}

		public function setInd_estado($Ind_estado){
			$this->Ind_estado = utf8_decode($Ind_estado);
		}

		public function getInd_estado(){
			return utf8_encode($this->Ind_estado);
		}

		public function setPrioridad($Prioridad){
			$this->Prioridad = utf8_decode($Prioridad);
		}

		public function getPrioridad(){
			return utf8_encode($this->Prioridad);
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
