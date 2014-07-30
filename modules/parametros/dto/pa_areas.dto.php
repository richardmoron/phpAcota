<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_areasTO{

		private $Area_id;
		private $Nombre_area;
		public static $FIELDS = array('Area_id','Nombre_area' );
		public static $PK_FIELD = 'area_id';

		function pa_areasTO(){
		}

		public function setArea_id($Area_id){
			$this->Area_id = (utf8_decode($Area_id));
		}

		public function getArea_id(){
			return utf8_encode($this->Area_id);
		}

		public function setNombre_area($Nombre_area){
			$this->Nombre_area = (utf8_decode($Nombre_area));
		}

		public function getNombre_area(){
			return utf8_encode($this->Nombre_area);
		}

	}
?>
