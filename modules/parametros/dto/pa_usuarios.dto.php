<?php 
	/**
	* Acerca del Autor
	*
	* @author Richard Henry Moron Borda <richardom09@gmail.com>
	* @version 1.0
	* @copyright Copyright (c) 2012, Richard Henry Moron Borda
	*/
	class pa_usuariosTO {

		private $Usuario_id;
		private $Usuario;
		private $Password;
		private $Nombres;
		private $Apellidos;
		private $Email;
		private $Agencia_id;
		private $Area_id;
		private $Estado;
		private $Tipo_usuario_id;
		private $Persona_id;
		private $Pregunta_secreta;
		private $Respuesta_secreta;
                private $Area;
		public static $FIELDS = array('Usuario_id','Usuario','Password','Nombres','Apellidos','Email','Agencia_id','Area_id','Estado','Tipo_usuario_id','Persona_id','Pregunta_secreta','Respuesta_secreta' );
		public static $PK_FIELD = 'usuario_id';

		function pa_usuariosTO(){
		}

		public function setUsuario_id($Usuario_id){
			$this->Usuario_id = strtoupper(utf8_decode($Usuario_id));
		}

		public function getUsuario_id(){
			return strtoupper(utf8_encode($this->Usuario_id));
		}

		public function setUsuario($Usuario){
			$this->Usuario = strtoupper(utf8_decode($Usuario));
		}

		public function getUsuario(){
			return strtoupper(utf8_encode($this->Usuario));
		}

		public function setPassword($Password){
			$this->Password = (utf8_decode($Password));
		}

		public function getPassword(){
			return (utf8_encode($this->Password));
		}

		public function setNombres($Nombres){
			$this->Nombres = strtoupper(utf8_decode($Nombres));
		}

		public function getNombres(){
			return strtoupper(utf8_encode($this->Nombres));
		}

		public function setApellidos($Apellidos){
			$this->Apellidos = strtoupper(utf8_decode($Apellidos));
		}

		public function getApellidos(){
			return strtoupper(utf8_encode($this->Apellidos));
		}

		public function setEmail($Email){
			$this->Email = strtoupper(utf8_decode($Email));
		}

		public function getEmail(){
			return strtoupper(utf8_encode($this->Email));
		}

		public function setAgencia_id($Agencia_id){
			$this->Agencia_id = strtoupper(utf8_decode($Agencia_id));
		}

		public function getAgencia_id(){
			return strtoupper(utf8_encode($this->Agencia_id));
		}

		public function setArea_id($Area_id){
			$this->Area_id = strtoupper(utf8_decode($Area_id));
		}

		public function getArea_id(){
			return strtoupper(utf8_encode($this->Area_id));
		}

		public function setEstado($Estado){
			$this->Estado = strtoupper(utf8_decode($Estado));
		}

		public function getEstado(){
			return strtoupper(utf8_encode($this->Estado));
		}

		public function setTipo_usuario_id($Tipo_usuario_id){
			$this->Tipo_usuario_id = strtoupper(utf8_decode($Tipo_usuario_id));
		}

		public function getTipo_usuario_id(){
			return strtoupper(utf8_encode($this->Tipo_usuario_id));
		}

		public function setPersona_id($Persona_id){
			$this->Persona_id = strtoupper(utf8_decode($Persona_id));
		}

		public function getPersona_id(){
			return strtoupper(utf8_encode($this->Persona_id));
		}

		public function setPregunta_secreta($Pregunta_secreta){
			$this->Pregunta_secreta = strtoupper(utf8_decode($Pregunta_secreta));
		}

		public function getPregunta_secreta(){
			return strtoupper(utf8_encode($this->Pregunta_secreta));
		}

		public function setRespuesta_secreta($Respuesta_secreta){
			$this->Respuesta_secreta = strtoupper(utf8_decode($Respuesta_secreta));
		}

		public function getRespuesta_secreta(){
			return strtoupper(utf8_encode($this->Respuesta_secreta));
		}
                
                public function setArea($Area){
			$this->Area = strtoupper(utf8_decode($Area));
		}

		public function getArea(){
			return strtoupper(utf8_encode($this->Area));
		}
	}
?>