<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_grupos_preguntasTO {

		private $Grupo_id;
		private $Encuesta_id;
		private $Nombre;
		private $Tipo;
                private $Encuesta;
                private $Tipo_desc;
		public static $FIELDS = array('Grupo_id','Encuesta_id','Nombre','Tipo' );
		public static $PK_FIELD = 'grupo_id';

		function ec_grupos_preguntasTO(){
		}

		public function setGrupo_id($Grupo_id){
			$this->Grupo_id = strtoupper(utf8_decode($Grupo_id));
		}

		public function getGrupo_id(){
			return strtoupper(utf8_encode($this->Grupo_id));
		}

		public function setEncuesta_id($Encuesta_id){
			$this->Encuesta_id = strtoupper(utf8_decode($Encuesta_id));
		}

		public function getEncuesta_id(){
			return strtoupper(utf8_encode($this->Encuesta_id));
		}

		public function setNombre($Nombre){
			$this->Nombre = strtoupper(utf8_decode($Nombre));
		}

		public function getNombre(){
			return strtoupper(utf8_encode($this->Nombre));
		}

		public function setTipo($Tipo){
			$this->Tipo = strtoupper(utf8_decode($Tipo));
		}

		public function getTipo(){
			return strtoupper(utf8_encode($this->Tipo));
		}
                
                public function setEncuesta($Encuesta){
			$this->Encuesta = strtoupper(utf8_decode($Encuesta));
		}

		public function getEncuesta(){
			return strtoupper(utf8_encode($this->Encuesta));
		}
                
                public function setTipo_desc($Tipo_desc){
			$this->Tipo_desc = strtoupper(utf8_decode($Tipo_desc));
		}

		public function getTipo_desc(){
			return strtoupper(utf8_encode($this->Tipo_desc));
		}
	}
?>
