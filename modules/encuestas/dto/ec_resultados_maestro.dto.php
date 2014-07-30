<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_resultados_maestroTO {

		private $Resultados_maestro_id;
		private $Usuario;
		private $Grupo_id_actual;
		private $Grupo_id_siguiente;
		private $Encuesta_id;
		private $Estado_usuario;
		private $Estado_encuesta;
		private $Fecha_hora;
		public static $FIELDS = array('Resultados_maestro_id','Usuario','Grupo_id_actual','Grupo_id_siguiente','Encuesta_id','Estado_usuario','Estado_encuesta','Fecha_hora' );
		public static $PK_FIELD = 'resultados_maestro_id';

		function ec_resultados_maestroTO(){
		}

		public function setResultados_maestro_id($Resultados_maestro_id){
			$this->Resultados_maestro_id = strtoupper(utf8_decode($Resultados_maestro_id));
		}

		public function getResultados_maestro_id(){
			return strtoupper(utf8_encode($this->Resultados_maestro_id));
		}

		public function setUsuario($Usuario){
			$this->Usuario = strtoupper(utf8_decode($Usuario));
		}

		public function getUsuario(){
			return strtoupper(utf8_encode($this->Usuario));
		}

		public function setGrupo_id_actual($Grupo_id_actual){
			$this->Grupo_id_actual = strtoupper(utf8_decode($Grupo_id_actual));
		}

		public function getGrupo_id_actual(){
			return strtoupper(utf8_encode($this->Grupo_id_actual));
		}

		public function setGrupo_id_siguiente($Grupo_id_siguiente){
			$this->Grupo_id_siguiente = strtoupper(utf8_decode($Grupo_id_siguiente));
		}

		public function getGrupo_id_siguiente(){
			return strtoupper(utf8_encode($this->Grupo_id_siguiente));
		}

		public function setEncuesta_id($Encuesta_id){
			$this->Encuesta_id = strtoupper(utf8_decode($Encuesta_id));
		}

		public function getEncuesta_id(){
			return strtoupper(utf8_encode($this->Encuesta_id));
		}

		public function setEstado_usuario($Estado_usuario){
			$this->Estado_usuario = strtoupper(utf8_decode($Estado_usuario));
		}

		public function getEstado_usuario(){
			return strtoupper(utf8_encode($this->Estado_usuario));
		}

		public function setEstado_encuesta($Estado_encuesta){
			$this->Estado_encuesta = strtoupper(utf8_decode($Estado_encuesta));
		}

		public function getEstado_encuesta(){
			return strtoupper(utf8_encode($this->Estado_encuesta));
		}

		public function setFecha_hora($Fecha_hora){
			$this->Fecha_hora = strtoupper(utf8_decode($Fecha_hora));
		}

		public function getFecha_hora(){
			return strtoupper(utf8_encode($this->Fecha_hora));
		}

	}
?>
