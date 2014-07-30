<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_encuestasTO {

		private $Encuesta_id;
		private $Empresa_id;
		private $Nombre;
		private $Descripcion;
		private $Fecha_inicio;
		private $Fecha_fin;
		private $Es_anonimo;
                private $Empresa;
                private $Acuerdo;
		public static $FIELDS = array('Encuesta_id','Empresa_id','Nombre','Descripcion','Fecha_inicio','Fecha_fin','Es_anonimo' );
		public static $PK_FIELD = 'encuesta_id';

		function ec_encuestasTO(){
		}

		public function setEncuesta_id($Encuesta_id){
			$this->Encuesta_id = strtoupper(utf8_decode($Encuesta_id));
		}

		public function getEncuesta_id(){
			return strtoupper(utf8_encode($this->Encuesta_id));
		}

		public function setEmpresa_id($Empresa_id){
			$this->Empresa_id = strtoupper(utf8_decode($Empresa_id));
		}

		public function getEmpresa_id(){
			return strtoupper(utf8_encode($this->Empresa_id));
		}

		public function setNombre($Nombre){
			$this->Nombre = strtoupper(utf8_decode($Nombre));
		}

		public function getNombre(){
			return strtoupper(utf8_encode($this->Nombre));
		}

		public function setDescripcion($Descripcion){
			$this->Descripcion = (($Descripcion));
		}

		public function getDescripcion(){
			return (($this->Descripcion));
		}

		public function setFecha_inicio($Fecha_inicio){
			$this->Fecha_inicio = strtoupper(utf8_decode($Fecha_inicio));
		}

		public function getFecha_inicio(){
			return strtoupper(utf8_encode($this->Fecha_inicio));
		}

		public function setFecha_fin($Fecha_fin){
			$this->Fecha_fin = strtoupper(utf8_decode($Fecha_fin));
		}

		public function getFecha_fin(){
			return strtoupper(utf8_encode($this->Fecha_fin));
		}

		public function setEs_anonimo($Es_anonimo){
			$this->Es_anonimo = strtoupper(utf8_decode($Es_anonimo));
		}

		public function getEs_anonimo(){
			return strtoupper(utf8_encode($this->Es_anonimo));
		}
                
                public function setEmpresa($Empresa){
			$this->Empresa = strtoupper(utf8_decode($Empresa));
		}

		public function getEmpresa(){
			return strtoupper(utf8_encode($this->Empresa));
		}
                
                public function setAcuerdo($Acuerdo){
			$this->Acuerdo = (utf8_decode($Acuerdo));
		}

		public function getAcuerdo(){
			return (utf8_encode($this->Acuerdo));
		}
	}
?>