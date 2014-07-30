<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_menu_accesos_x_usuarioTO {

		private $Menu_acceso_x_usuario_id;
		private $Usuario_id;
		private $Menu_id;
		private $Observaciones;
                private $Usuario;
		private $Menu;
		public static $FIELDS = array('Menu_acceso_x_usuario_id','Usuario','Menu_id','Observaciones' );
		public static $PK_FIELD = 'menu_acceso_x_usuario_id';

		function pa_menu_accesos_x_usuarioTO(){
		}

		public function setMenu_acceso_x_usuario_id($Menu_acceso_x_usuario_id){
			$this->Menu_acceso_x_usuario_id = strtoupper(utf8_decode($Menu_acceso_x_usuario_id));
		}

		public function getMenu_acceso_x_usuario_id(){
			return strtoupper(utf8_encode($this->Menu_acceso_x_usuario_id));
		}

		public function setUsuario_id($Usuario_id){
			$this->Usuario_id = strtoupper(utf8_decode($Usuario_id));
		}

		public function getUsuario_id(){
			return strtoupper(utf8_encode($this->Usuario_id));
		}

		public function setMenu_id($Menu_id){
			$this->Menu_id = strtoupper(utf8_decode($Menu_id));
		}

		public function getMenu_id(){
			return strtoupper(utf8_encode($this->Menu_id));
		}

		public function setObservaciones($Observaciones){
			$this->Observaciones = strtoupper(utf8_decode($Observaciones));
		}

		public function getObservaciones(){
			return strtoupper(utf8_encode($this->Observaciones));
		}
                
                public function setUsuario($Usuario){
			$this->Usuario = strtoupper(utf8_decode($Usuario));
		}

		public function getUsuario(){
			return strtoupper(utf8_encode($this->Usuario));
		}

		public function setMenu($Menu){
			$this->Menu = strtoupper(utf8_decode($Menu));
		}

		public function getMenu(){
			return strtoupper(utf8_encode($this->Menu));
		}

	}
?>