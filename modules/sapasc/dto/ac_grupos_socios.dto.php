<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class ac_grupos_sociosTO {

		private $Grupo_id;
		private $Nombre_grupo;
		private $Consumo_minimo_permitido;
		private $Costo_consumo_minimo;
		private $Costo_consumo_excedido;
		public static $FIELDS = array('Grupo_id','Nombre_grupo','Consumo_minimo_permitido','Costo_consumo_minimo','Costo_consumo_excedido' );
		public static $PK_FIELD = 'grupo_id';

		function ac_grupos_sociosTO(){
		}

		public function setGrupo_id($Grupo_id){
			$this->Grupo_id = strtoupper(utf8_decode($Grupo_id));
		}

		public function getGrupo_id(){
			return strtoupper(utf8_encode($this->Grupo_id));
		}

		public function setNombre_grupo($Nombre_grupo){
			$this->Nombre_grupo = strtoupper(utf8_decode($Nombre_grupo));
		}

		public function getNombre_grupo(){
			return strtoupper(utf8_encode($this->Nombre_grupo));
		}

		public function setConsumo_minimo_permitido($Consumo_minimo_permitido){
			$this->Consumo_minimo_permitido = strtoupper(utf8_decode($Consumo_minimo_permitido));
		}

		public function getConsumo_minimo_permitido(){
			return strtoupper(utf8_encode($this->Consumo_minimo_permitido));
		}

		public function setCosto_consumo_minimo($Costo_consumo_minimo){
			$this->Costo_consumo_minimo = strtoupper(utf8_decode($Costo_consumo_minimo));
		}

		public function getCosto_consumo_minimo(){
			return strtoupper(utf8_encode($this->Costo_consumo_minimo));
		}

		public function setCosto_consumo_excedido($Costo_consumo_excedido){
			$this->Costo_consumo_excedido = strtoupper(utf8_decode($Costo_consumo_excedido));
		}

		public function getCosto_consumo_excedido(){
			return strtoupper(utf8_encode($this->Costo_consumo_excedido));
		}

	}
?>
