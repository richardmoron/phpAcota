<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_preguntasTO {

		private $Pregunta_id;
		private $Encuesta_id;
		private $Grupo_id;
		private $Pregunta;
		private $Tipo_respuesta;
		private $Respuesta;
		private $Atributo_extra;
		private $Nro_pregunta;
                private $Encuesta;
		private $Grupo;
                private $Tipo_respuesta_desc;
                private $Tipo_respuesta_html;
                private $Alineacion_respuesta;
                private $Label_izq;
                private $Label_der;
		public static $FIELDS = array('Pregunta_id','Encuesta_id','Grupo_id','Pregunta','Tipo_respuesta','Respuesta','Atributo_extra','Nro_pregunta' );
		public static $PK_FIELD = 'pregunta_id';

		function ec_preguntasTO(){
		}
                
		public function setPregunta_id($Pregunta_id){
			$this->Pregunta_id = strtoupper(utf8_decode($Pregunta_id));
		}

		public function getPregunta_id(){
			return strtoupper(utf8_encode($this->Pregunta_id));
		}

		public function setEncuesta_id($Encuesta_id){
			$this->Encuesta_id = strtoupper(utf8_decode($Encuesta_id));
		}

		public function getEncuesta_id(){
			return strtoupper(utf8_encode($this->Encuesta_id));
		}

		public function setGrupo_id($Grupo_id){
			$this->Grupo_id = strtoupper(utf8_decode($Grupo_id));
		}

		public function getGrupo_id(){
			return strtoupper(utf8_encode($this->Grupo_id));
		}

		public function setPregunta($Pregunta){
			$this->Pregunta = strtoupper(utf8_decode($Pregunta));
		}

		public function getPregunta(){
			return strtoupper(utf8_encode($this->Pregunta));
		}

		public function setTipo_respuesta($Tipo_respuesta){
			$this->Tipo_respuesta = strtoupper(utf8_decode($Tipo_respuesta));
		}

		public function getTipo_respuesta(){
			return strtoupper(utf8_encode($this->Tipo_respuesta));
		}

		public function setRespuesta($Respuesta){
			$this->Respuesta = strtoupper(utf8_decode($Respuesta));
		}

		public function getRespuesta(){
			return strtoupper(utf8_encode($this->Respuesta));
		}

		public function setAtributo_extra($Atributo_extra){
			$this->Atributo_extra = strtoupper(utf8_decode($Atributo_extra));
		}

		public function getAtributo_extra(){
			return strtoupper(utf8_encode($this->Atributo_extra));
		}

		public function setNro_pregunta($Nro_pregunta){
			$this->Nro_pregunta = strtoupper(utf8_decode($Nro_pregunta));
		}

		public function getNro_pregunta(){
			return strtoupper(utf8_encode($this->Nro_pregunta));
		}
                
                public function setEncuesta($Encuesta){
			$this->Encuesta = strtoupper(utf8_decode($Encuesta));
		}

		public function getEncuesta(){
			return strtoupper(utf8_encode($this->Encuesta));
		}

		public function setGrupo($Grupo){
			$this->Grupo = strtoupper(utf8_decode($Grupo));
		}

		public function getGrupo(){
			return strtoupper(utf8_encode($this->Grupo));
		}
                
                public function setTipo_respuesta_desc($Tipo_respuesta_desc){
			$this->Tipo_respuesta_desc = strtoupper(utf8_decode($Tipo_respuesta_desc));
		}

		public function getTipo_respuesta_desc(){
			return strtoupper(utf8_encode($this->Tipo_respuesta_desc));
		}
                
                public function setTipo_respuesta_html($Tipo_respuesta_html){
			$this->Tipo_respuesta_html = strtoupper(utf8_decode($Tipo_respuesta_html));
		}

		public function getTipo_respuesta_html(){
			return strtoupper(utf8_encode($this->Tipo_respuesta_html));
		}
                
                 public function setAlineacion_respuesta($Alineacion_respuesta){
			$this->Alineacion_respuesta = strtoupper(utf8_decode($Alineacion_respuesta));
		}

		public function getAlineacion_respuesta(){
			return strtoupper(utf8_encode($this->Alineacion_respuesta));
		}
                
                public function setLabel_izq($Label_izq){
			$this->Label_izq = strtoupper(utf8_decode($Label_izq));
		}

		public function getLabel_izq(){
			return strtoupper(utf8_encode($this->Label_izq));
		}
                
                 public function setLabel_der($Label_der){
			$this->Label_der = strtoupper(utf8_decode($Label_der));
		}

		public function getLabel_der(){
			return strtoupper(utf8_encode($this->Label_der));
		}
	}
?>
