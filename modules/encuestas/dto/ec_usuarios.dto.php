<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_usuariosTO {

		private $Usuario_id;
		private $Nombre_usuario;
		private $Clave_usuario;
		private $Estado_usuario;
		private $Fecha_habilitacion;
		public static $FIELDS = array('Usuario_id','Nombre_usuario','Clave_usuario','Estado_usuario','Fecha_habilitacion' );
		public static $PK_FIELD = 'usuario_id';

		function ec_usuariosTO(){
		}

		public function setUsuario_id($Usuario_id){
			$this->Usuario_id = strtoupper(utf8_decode($Usuario_id));
		}

		public function getUsuario_id(){
			return strtoupper(utf8_encode($this->Usuario_id));
		}

		public function setNombre_usuario($Nombre_usuario){
			$this->Nombre_usuario = strtoupper(utf8_decode($Nombre_usuario));
		}

		public function getNombre_usuario(){
			return strtoupper(utf8_encode($this->Nombre_usuario));
		}

		public function setClave_usuario($Clave_usuario){
			$this->Clave_usuario = strtoupper(utf8_decode($Clave_usuario));
		}

		public function getClave_usuario(){
			return strtoupper(utf8_encode($this->Clave_usuario));
		}

		public function setEstado_usuario($Estado_usuario){
			$this->Estado_usuario = strtoupper(utf8_decode($Estado_usuario));
		}

		public function getEstado_usuario(){
			return strtoupper(utf8_encode($this->Estado_usuario));
		}

		public function setFecha_habilitacion($Fecha_habilitacion){
			$this->Fecha_habilitacion = strtoupper(utf8_decode($Fecha_habilitacion));
		}

		public function getFecha_habilitacion(){
			return strtoupper(utf8_encode($this->Fecha_habilitacion));
		}

	}
?>
