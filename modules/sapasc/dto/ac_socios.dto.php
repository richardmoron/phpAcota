<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ac_sociosTO {

		private $Socio_id;
		private $Grupo_id;
                private $Grupo;
		private $Nro_medidor;
		private $Marca_medidor;
		private $Nombres;
		private $Apellidos;
		private $Ci;
		private $Ci_expedido_en;
		private $Direccion;
		private $Comunidad_id;
                private $Comunidad;
		private $Zona;
		private $Registrado_por;
		private $Fecha_registro;
		public static $FIELDS = array('Socio_id','Grupo_id','Nro_medidor','Marca_medidor','Nombres','Apellidos','Ci','Ci_expedido_en','Direccion','Comunidad_id','Zona','Registrado_por','Fecha_registro' );
		public static $PK_FIELD = 'socio_id';

		function ac_sociosTO(){
		}

		public function setSocio_id($Socio_id){
			$this->Socio_id = strtoupper(utf8_decode($Socio_id));
		}

		public function getSocio_id(){
			return strtoupper(utf8_encode($this->Socio_id));
		}

		public function setGrupo_id($Grupo_id){
			$this->Grupo_id = strtoupper(utf8_decode($Grupo_id));
		}

		public function getGrupo_id(){
			return strtoupper(utf8_encode($this->Grupo_id));
		}

		public function setNro_medidor($Nro_medidor){
			$this->Nro_medidor = strtoupper(utf8_decode($Nro_medidor));
		}

		public function getNro_medidor(){
			return strtoupper(utf8_encode($this->Nro_medidor));
		}

		public function setMarca_medidor($Marca_medidor){
			$this->Marca_medidor = strtoupper(utf8_decode($Marca_medidor));
		}

		public function getMarca_medidor(){
			return strtoupper(utf8_encode($this->Marca_medidor));
		}

		public function setNombres($Nombres){
			$this->Nombres = strtoupper(utf8_decode($Nombres));
		}

		public function getNombres(){
			return strtoupper(utf8_encode($this->Nombres));
		}

		public function setApellidos($Apellidos){
			$this->Apellidos = strtoupper(utf8_decode($Apellidos));
		}

		public function getApellidos(){
			return strtoupper(utf8_encode($this->Apellidos));
		}

		public function setCi($Ci){
			$this->Ci = strtoupper(utf8_decode($Ci));
		}

		public function getCi(){
			return strtoupper(utf8_encode($this->Ci));
		}

		public function setCi_expedido_en($Ci_expedido_en){
			$this->Ci_expedido_en = strtoupper(utf8_decode($Ci_expedido_en));
		}

		public function getCi_expedido_en(){
			return strtoupper(utf8_encode($this->Ci_expedido_en));
		}

		public function setDireccion($Direccion){
			$this->Direccion = strtoupper(utf8_decode($Direccion));
		}

		public function getDireccion(){
			return strtoupper(utf8_encode($this->Direccion));
		}

		public function setComunidad_id($Comunidad_id){
			$this->Comunidad_id = strtoupper(utf8_decode($Comunidad_id));
		}

		public function getComunidad_id(){
			return strtoupper(utf8_encode($this->Comunidad_id));
		}

		public function setZona($Zona){
			$this->Zona = strtoupper(utf8_decode($Zona));
		}

		public function getZona(){
			return strtoupper(utf8_encode($this->Zona));
		}

		public function setRegistrado_por($Registrado_por){
			$this->Registrado_por = strtoupper(utf8_decode($Registrado_por));
		}

		public function getRegistrado_por(){
			return strtoupper(utf8_encode($this->Registrado_por));
		}

		public function setFecha_registro($Fecha_registro){
			$this->Fecha_registro = strtoupper(utf8_decode($Fecha_registro));
		}

		public function getFecha_registro(){
			return strtoupper(utf8_encode($this->Fecha_registro));
		}
                
                public function setComunidad($Comunidad){
			$this->Comunidad = strtoupper(utf8_decode($Comunidad));
		}

		public function getComunidad(){
			return strtoupper(utf8_encode($this->Comunidad));
		}
                
                public function setGrupo($Grupo){
			$this->Grupo = strtoupper(utf8_decode($Grupo));
		}

		public function getGrupo(){
			return strtoupper(utf8_encode($this->Grupo));
		}

	}
?>
