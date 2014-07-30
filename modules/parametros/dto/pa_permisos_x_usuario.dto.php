<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_permisos_x_usuarioTO {

		private $Permisos_x_usuario_id;
                private $Usuario_id;
		private $Usuario;
		private $Archivo;
		private $Insertar;
		private $Borrar;
		private $Reporte;
		private $Actualizar;
		private $Consultar;
		private $Observaciones;
		public static $FIELDS = array('Permisos_x_usuario_id','Usuario','Archivo','Insertar','Borrar','Reporte','Actualizar','Consultar','Observaciones' );
		public static $PK_FIELD = 'permisos_x_usuario_id';

		function pa_permisos_x_usuarioTO(){
		}

		public function setPermisos_x_usuario_id($Permisos_x_usuario_id){
			$this->Permisos_x_usuario_id = strtoupper(utf8_decode($Permisos_x_usuario_id));
		}

		public function getPermisos_x_usuario_id(){
			return strtoupper(utf8_encode($this->Permisos_x_usuario_id));
		}
                
                public function setUsuario_id($Usuario_id){
			$this->Usuario_id = strtoupper(utf8_decode($Usuario_id));
		}

		public function getUsuario_id(){
			return strtoupper(utf8_encode($this->Usuario_id));
		}
                
		public function setUsuario($Usuario){
			$this->Usuario = strtoupper(utf8_decode($Usuario));
		}

		public function getUsuario(){
			return strtoupper(utf8_encode($this->Usuario));
		}

		public function setArchivo($Archivo){
			$this->Archivo = (utf8_decode($Archivo));
		}

		public function getArchivo(){
			return (utf8_encode($this->Archivo));
		}

		public function setInsertar($Insertar){
			$this->Insertar = strtoupper(utf8_decode($Insertar));
		}

		public function getInsertar(){
			return strtoupper(utf8_encode($this->Insertar));
		}

		public function setBorrar($Borrar){
			$this->Borrar = strtoupper(utf8_decode($Borrar));
		}

		public function getBorrar(){
			return strtoupper(utf8_encode($this->Borrar));
		}

		public function setReporte($Reporte){
			$this->Reporte = strtoupper(utf8_decode($Reporte));
		}

		public function getReporte(){
			return strtoupper(utf8_encode($this->Reporte));
		}

		public function setActualizar($Actualizar){
			$this->Actualizar = strtoupper(utf8_decode($Actualizar));
		}

		public function getActualizar(){
			return strtoupper(utf8_encode($this->Actualizar));
		}

		public function setConsultar($Consultar){
			$this->Consultar = strtoupper(utf8_decode($Consultar));
		}

		public function getConsultar(){
			return strtoupper(utf8_encode($this->Consultar));
		}

		public function setObservaciones($Observaciones){
			$this->Observaciones = strtoupper(utf8_decode($Observaciones));
		}

		public function getObservaciones(){
			return strtoupper(utf8_encode($this->Observaciones));
		}

	}
?>
