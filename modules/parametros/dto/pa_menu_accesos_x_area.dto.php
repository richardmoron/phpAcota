<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_menu_accesos_x_areaTO {

		private $Menu_acceso_area_id;
		private $Area_id;
		private $Menu_id;
		private $Observaciones;
                private $Area;
		private $Menu;
		public static $FIELDS = array('Menu_acceso_area_id','Area_id','Menu_id','Observaciones' );
		public static $PK_FIELD = 'menu_acceso_area_id';

		function pa_menu_accesos_x_areaTO(){
		}

		public function setMenu_acceso_area_id($Menu_acceso_area_id){
			$this->Menu_acceso_area_id = strtoupper(utf8_decode($Menu_acceso_area_id));
		}

		public function getMenu_acceso_area_id(){
			return strtoupper(utf8_encode($this->Menu_acceso_area_id));
		}

		public function setArea_id($Area_id){
			$this->Area_id = strtoupper(utf8_decode($Area_id));
		}

		public function getArea_id(){
			return strtoupper(utf8_encode($this->Area_id));
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
                
                public function setArea($Area){
			$this->Area = strtoupper(utf8_decode($Area));
		}

		public function getArea(){
			return strtoupper(utf8_encode($this->Area));
		}

		public function setMenu($Menu){
			$this->Menu = strtoupper(utf8_decode($Menu));
		}

		public function getMenu(){
			return strtoupper(utf8_encode($this->Menu));
		}
	}
?>
