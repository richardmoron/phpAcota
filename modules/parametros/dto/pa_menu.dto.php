<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_menuTO {

		private $Menu_id;
		private $Nombre;
		private $Descripcion;
		private $Link;
		private $Menu_padre_id;
		private $Area_id;
		private $Es_padre;
		private $Exclusivo;
		private $Complemento;
		private $Posicion;
                private $Menu_padre;
                private $Tab;
		public static $FIELDS = array('Menu_id','Nombre','Descripcion','Link','Menu_padre_id','Area_id','Es_padre','Exclusivo','Complemento','Posicion' );
		public static $PK_FIELD = 'menu_id';

		function pa_menuTO(){
		}

		public function setMenu_id($Menu_id){
			$this->Menu_id = strtoupper(utf8_decode($Menu_id));
		}

		public function getMenu_id(){
			return strtoupper(utf8_encode($this->Menu_id));
		}

		public function setNombre($Nombre){
			$this->Nombre = strtoupper(utf8_decode($Nombre));
		}

		public function getNombre(){
			return strtoupper(utf8_encode($this->Nombre));
		}

		public function setDescripcion($Descripcion){
			$this->Descripcion = strtoupper(utf8_decode($Descripcion));
		}

		public function getDescripcion(){
			return strtoupper(utf8_encode($this->Descripcion));
		}

		public function setLink($Link){
			$this->Link = (utf8_decode($Link));
		}

		public function getLink(){
			return (utf8_encode($this->Link));
		}

		public function setMenu_padre_id($Menu_padre_id){
			$this->Menu_padre_id = strtoupper(utf8_decode($Menu_padre_id));
		}

		public function getMenu_padre_id(){
			return strtoupper(utf8_encode($this->Menu_padre_id));
		}

		public function setArea_id($Area_id){
			$this->Area_id = strtoupper(utf8_decode($Area_id));
		}

		public function getArea_id(){
			return strtoupper(utf8_encode($this->Area_id));
		}

		public function setEs_padre($Es_padre){
			$this->Es_padre = strtoupper(utf8_decode($Es_padre));
		}

		public function getEs_padre(){
			return strtoupper(utf8_encode($this->Es_padre));
		}

		public function setExclusivo($Exclusivo){
			$this->Exclusivo = strtoupper(utf8_decode($Exclusivo));
		}

		public function getExclusivo(){
			return strtoupper(utf8_encode($this->Exclusivo));
		}

		public function setComplemento($Complemento){
			$this->Complemento = strtoupper(utf8_decode($Complemento));
		}

		public function getComplemento(){
			return strtoupper(utf8_encode($this->Complemento));
		}

		public function setPosicion($Posicion){
			$this->Posicion = strtoupper(utf8_decode($Posicion));
		}

		public function getPosicion(){
			return strtoupper(utf8_encode($this->Posicion));
		}
                
                public function setMenu_padre($Menu_padre){
			$this->Menu_padre = strtoupper(utf8_decode($Menu_padre));
		}

		public function getMenu_padre(){
			return strtoupper(utf8_encode($this->Menu_padre));
		}
                
                public function setTab($Tab){
			$this->Tab = strtoupper(utf8_decode($Tab));
		}

		public function getTab(){
			return strtoupper(utf8_encode($this->Tab));
		}
	}
?>
