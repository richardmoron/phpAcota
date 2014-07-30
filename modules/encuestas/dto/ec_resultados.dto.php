<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_resultadosTO {

		private $Resultado_id;
		private $Encuesta_id;
		private $Usuario_id;
		private $Grupo_id;
		private $Pregunta_id;
		private $Nombre_encuesta;
		private $Pregunta;
		private $Respuesta;
		private $Grupo;
		private $Fecha_hora;
                private $Encuesta_id_nro;
                private $Usuario;
                
		public static $FIELDS = array('Resultado_id','Encuesta_id','Usuario_id','Grupo_id','Pregunta_id','Nombre_encuesta','Pregunta','Respuesta','Grupo','Fecha_hora' );
		public static $PK_FIELD = 'resultado_id';

		function ec_resultadosTO(){
		}

		public function setResultado_id($Resultado_id){
			$this->Resultado_id = strtoupper(utf8_decode($Resultado_id));
		}

		public function getResultado_id(){
			return strtoupper(utf8_encode($this->Resultado_id));
		}

		public function setEncuesta_id($Encuesta_id){
			$this->Encuesta_id = strtoupper(utf8_decode($Encuesta_id));
		}

		public function getEncuesta_id(){
			return strtoupper(utf8_encode($this->Encuesta_id));
		}

		public function setUsuario_id($Usuario_id){
			$this->Usuario_id = strtoupper(utf8_decode($Usuario_id));
		}

		public function getUsuario_id(){
			return strtoupper(utf8_encode($this->Usuario_id));
		}

		public function setGrupo_id($Grupo_id){
			$this->Grupo_id = strtoupper(utf8_decode($Grupo_id));
		}

		public function getGrupo_id(){
			return strtoupper(utf8_encode($this->Grupo_id));
		}

		public function setPregunta_id($Pregunta_id){
			$this->Pregunta_id = strtoupper(utf8_decode($Pregunta_id));
		}

		public function getPregunta_id(){
			return strtoupper(utf8_encode($this->Pregunta_id));
		}

		public function setNombre_encuesta($Nombre_encuesta){
			$this->Nombre_encuesta = strtoupper(utf8_decode($Nombre_encuesta));
		}

		public function getNombre_encuesta(){
			return strtoupper(utf8_encode($this->Nombre_encuesta));
		}

		public function setPregunta($Pregunta){
			$this->Pregunta = strtoupper(utf8_decode($Pregunta));
		}

		public function getPregunta(){
			return strtoupper(utf8_encode($this->Pregunta));
		}

		public function setRespuesta($Respuesta){
			$this->Respuesta = strtoupper(utf8_decode($Respuesta));
		}

		public function getRespuesta(){
			return strtoupper(utf8_encode($this->Respuesta));
		}

		public function setGrupo($Grupo){
			$this->Grupo = strtoupper(utf8_decode($Grupo));
		}

		public function getGrupo(){
			return strtoupper(utf8_encode($this->Grupo));
		}

		public function setFecha_hora($Fecha_hora){
			$this->Fecha_hora = strtoupper(utf8_decode($Fecha_hora));
		}

		public function getFecha_hora(){
			return strtoupper(utf8_encode($this->Fecha_hora));
		}
                
                public function setEncuesta_id_nro($Encuesta_id_nro){
			$this->Encuesta_id_nro = strtoupper(utf8_decode($Encuesta_id_nro));
		}

		public function getEncuesta_id_nro(){
			return strtoupper(utf8_encode($this->Encuesta_id_nro));
		}
                
                public function setUsuario($Usuario){
			$this->Usuario = strtoupper(utf8_decode($Usuario));
		}

		public function getUsuario(){
			return strtoupper(utf8_encode($this->Usuario));
		}
	}
?>