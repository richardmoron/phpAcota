<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_parametrosTO {

		private $Parametro_id;
		private $Entidad;
		private $Codigo;
		private $Valor;
		private $Descripcion;
		public static $FIELDS = array('Parametro_id','Entidad','Codigo','Valor','Descripcion' );
		public static $PK_FIELD = 'parametro_id';

		function pa_parametrosTO(){
		}

		public function setParametro_id($Parametro_id){
			$this->Parametro_id = strtoupper(utf8_decode($Parametro_id));
		}

		public function getParametro_id(){
			return strtoupper(utf8_encode($this->Parametro_id));
		}

		public function setEntidad($Entidad){
			$this->Entidad = strtoupper(utf8_decode($Entidad));
		}

		public function getEntidad(){
			return strtoupper(utf8_encode($this->Entidad));
		}

		public function setCodigo($Codigo){
			$this->Codigo = strtoupper(utf8_decode($Codigo));
		}

		public function getCodigo(){
			return strtoupper(utf8_encode($this->Codigo));
		}

		public function setValor($Valor){
			$this->Valor = strtoupper(utf8_decode($Valor));
		}

		public function getValor(){
			return strtoupper(utf8_encode($this->Valor));
		}

		public function setDescripcion($Descripcion){
			$this->Descripcion = strtoupper(utf8_decode($Descripcion));
		}

		public function getDescripcion(){
			return strtoupper(utf8_encode($this->Descripcion));
		}

	}
?>
