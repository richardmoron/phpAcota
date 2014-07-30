<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class php_logsTO {

		private $Log_id;
		private $Nom_table;
		private $Nom_usuario;
		private $Fecha_hora;
		private $Accion;
		private $Det_accion;
		private $Det_error;
		public static $FIELDS = array('Log_id','Nom_table','Nom_usuario','Fecha_hora','Accion','Det_accion','Det_error' );
		public static $PK_FIELD = 'log_id';

		function php_logsTO(){
		}

		public function setLog_id($Log_id){
			$this->Log_id = strtoupper(utf8_decode($Log_id));
		}

		public function getLog_id(){
			return strtoupper(utf8_encode($this->Log_id));
		}

		public function setNom_table($Nom_table){
			$this->Nom_table = (utf8_decode($Nom_table));
		}

		public function getNom_table(){
			return (utf8_encode($this->Nom_table));
		}

		public function setNom_usuario($Nom_usuario){
			$this->Nom_usuario = strtoupper(utf8_decode($Nom_usuario));
		}

		public function getNom_usuario(){
			return strtoupper(utf8_encode($this->Nom_usuario));
		}

		public function setFecha_hora($Fecha_hora){
			$this->Fecha_hora = strtoupper(utf8_decode($Fecha_hora));
		}

		public function getFecha_hora(){
			return strtoupper(utf8_encode($this->Fecha_hora));
		}

		public function setAccion($Accion){
			$this->Accion = strtoupper(utf8_decode($Accion));
		}

		public function getAccion(){
			return strtoupper(utf8_encode($this->Accion));
		}

		public function setDet_accion($Det_accion){
			$this->Det_accion = (utf8_decode($Det_accion));
		}

		public function getDet_accion(){
			return (utf8_encode($this->Det_accion));
		}

		public function setDet_error($Det_error){
			$this->Det_error = (utf8_decode($Det_error));
		}

		public function getDet_error(){
			return (utf8_encode($this->Det_error));
		}

	}
?>
