<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_noticiasTO {

		private $Noticia_id;
		private $Titulo;
		private $Descripcion;
		private $Fecha_registro;
		private $Fecha_desde;
		private $Fecha_hasta;
		private $Registrado_por;
		private $Tipo_id;
		private $Area_id;
                private $Tipo;
		private $Area;
                private $Registrado_porstr;
		public static $FIELDS = array('Noticia_id','Titulo','Descripcion','Fecha_registro','Fecha_desde','Fecha_hasta','Registrado_por','Tipo_id','Area_id' );
		public static $PK_FIELD = 'noticia_id';

		function pa_noticiasTO(){
		}

		public function setNoticia_id($Noticia_id){
			$this->Noticia_id = strtoupper(utf8_decode($Noticia_id));
		}

		public function getNoticia_id(){
			return strtoupper(utf8_encode($this->Noticia_id));
		}

		public function setTitulo($Titulo){
			$this->Titulo = strtoupper(utf8_decode($Titulo));
		}

		public function getTitulo(){
			return strtoupper(utf8_encode($this->Titulo));
		}

		public function setDescripcion($Descripcion){
			$this->Descripcion = strtoupper(utf8_decode($Descripcion));
		}

		public function getDescripcion(){
			return strtoupper(utf8_encode($this->Descripcion));
		}

		public function setFecha_registro($Fecha_registro){
			$this->Fecha_registro = strtoupper(utf8_decode($Fecha_registro));
		}

		public function getFecha_registro(){
			return strtoupper(utf8_encode($this->Fecha_registro));
		}

		public function setFecha_desde($Fecha_desde){
			$this->Fecha_desde = strtoupper(utf8_decode($Fecha_desde));
		}

		public function getFecha_desde(){
			return strtoupper(utf8_encode($this->Fecha_desde));
		}

		public function setFecha_hasta($Fecha_hasta){
			$this->Fecha_hasta = strtoupper(utf8_decode($Fecha_hasta));
		}

		public function getFecha_hasta(){
			return strtoupper(utf8_encode($this->Fecha_hasta));
		}

		public function setRegistrado_por($Registrado_por){
			$this->Registrado_por = strtoupper(utf8_decode($Registrado_por));
		}

		public function getRegistrado_por(){
			return strtoupper(utf8_encode($this->Registrado_por));
		}

		public function setTipo_id($Tipo_id){
			$this->Tipo_id = strtoupper(utf8_decode($Tipo_id));
		}

		public function getTipo_id(){
			return strtoupper(utf8_encode($this->Tipo_id));
		}

		public function setArea_id($Area_id){
			$this->Area_id = strtoupper(utf8_decode($Area_id));
		}

		public function getArea_id(){
			return strtoupper(utf8_encode($this->Area_id));
		}
                
                public function setTipo($Tipo){
			$this->Tipo = strtoupper(utf8_decode($Tipo));
		}

		public function getTipo(){
			return strtoupper(utf8_encode($this->Tipo));
		}

		public function setArea($Area){
			$this->Area = strtoupper(utf8_decode($Area));
		}

		public function getArea(){
			return strtoupper(utf8_encode($this->Area));
		}
                
                public function setRegistrado_porstr($Registrado_porstr){
			$this->Registrado_porstr = strtoupper(utf8_decode($Registrado_porstr));
		}

		public function getRegistrado_porstr(){
			return strtoupper(utf8_encode($this->Registrado_porstr));
		}
	}
?>