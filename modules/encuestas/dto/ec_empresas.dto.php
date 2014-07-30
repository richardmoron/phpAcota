<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_empresasTO {

		private $Empresa_id;
		private $Nombre;
		private $Direccion;
		private $Telefono;
		private $Persona_contacto;
		public static $FIELDS = array('Empresa_id','Nombre','Direccion','Telefono','Persona_contacto' );
		public static $PK_FIELD = 'empresa_id';

		function ec_empresasTO(){
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

		public function setDireccion($Direccion){
			$this->Direccion = strtoupper(utf8_decode($Direccion));
		}

		public function getDireccion(){
			return strtoupper(utf8_encode($this->Direccion));
		}

		public function setTelefono($Telefono){
			$this->Telefono = strtoupper(utf8_decode($Telefono));
		}

		public function getTelefono(){
			return strtoupper(utf8_encode($this->Telefono));
		}

		public function setPersona_contacto($Persona_contacto){
			$this->Persona_contacto = strtoupper(utf8_decode($Persona_contacto));
		}

		public function getPersona_contacto(){
			return strtoupper(utf8_encode($this->Persona_contacto));
		}

	}
?>
