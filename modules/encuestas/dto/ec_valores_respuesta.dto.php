<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ec_valores_respuestaTO {

		private $Valor_respuesta_id;
		private $Pregunta_id;
		private $Valor;
		private $Etiqueta;
		public static $FIELDS = array('Valor_respuesta_id','Pregunta_id','Valor','Etiqueta' );
		public static $PK_FIELD = 'valor_respuesta_id';

		function ec_valores_respuestaTO(){
		}

		public function setValor_respuesta_id($Valor_respuesta_id){
			$this->Valor_respuesta_id = strtoupper(utf8_decode($Valor_respuesta_id));
		}

		public function getValor_respuesta_id(){
			return strtoupper(utf8_encode($this->Valor_respuesta_id));
		}

		public function setPregunta_id($Pregunta_id){
			$this->Pregunta_id = strtoupper(utf8_decode($Pregunta_id));
		}

		public function getPregunta_id(){
			return strtoupper(utf8_encode($this->Pregunta_id));
		}

		public function setValor($Valor){
			$this->Valor = strtoupper(utf8_decode($Valor));
		}

		public function getValor(){
			return strtoupper(utf8_encode($this->Valor));
		}

		public function setEtiqueta($Etiqueta){
			$this->Etiqueta = strtoupper(utf8_decode($Etiqueta));
		}

		public function getEtiqueta(){
			return strtoupper(utf8_encode($this->Etiqueta));
		}

	}
?>
