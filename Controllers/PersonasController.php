<?php
	class PersonasController extends Controller{
		public function __construct(){
			parent::__construct('Personas');
		}
		/**
		 * Funcion Insert
		 * Guardar registros
		 * @return json
		 */
		public function Insert(){ 

			/**
			 * Validacion si existe post
			 * @return boolean 
			 */
			if($this->Post(['Cod','Nom','Ape','Tel','Cargo','Email','Fecha','Dir','Dep'])){
				$Cod = $this->GetPost('Cod');
				$Nom = $this->GetPost('Nom');
				$Ape = $this->GetPost('Ape');
				$Tel = $this->GetPost('Tel');
				$Cargo = $this->GetPost('Cargo');
				$Email = $this->GetPost('Email');
				$Fecha = $this->GetPost('Fecha');
				$Dir = $this->GetPost('Dir');
				$Dep = $this->GetPost('Dep');
				$this->modelo->setDatos($Cod,$Nom,$Ape,$Tel,$Cargo,$Email,$Fecha,$Dir,$Dep);
				return $this->PJSON($this->modelo->Insert());
			}else{
				return $this->PJSON($this->modelo->MakeResponse(400, 'No hay Post'));
			}
		}

		/**
		 * Funcion Update
		 * Actualiza registros
		 * @return json
		 */
		public function Update(){
			/**
			 * Validacion si existe post
			 * @return boolean 
			 */
			if($this->Post(['Cod','Nom','Ape','Tel','Cargo','Email','Fecha','Dir','Dep'])){
				$Cod = $this->GetPost('Cod');
				$Nom = $this->GetPost('Nom');
				$Ape = $this->GetPost('Ape');
				$Tel = $this->GetPost('Tel');
				$Cargo = $this->GetPost('Cargo');
				$Email = $this->GetPost('Email');
				$Fecha = $this->GetPost('Fecha');
				$Dir = $this->GetPost('Dir');
				$Dep = $this->GetPost('Dep');
				$this->modelo->setDatos($Cod,$Nom,$Ape,$Tel,$Cargo,$Email,$Fecha,$Dir,$Dep);
				return $this->PJSON($this->modelo->Update());
			}else{
				return $this->PJSON($this->modelo->MakeResponse(400, 'No hay Post'));
			}
		}

		/**
		 * Funcion Delete
		 * Eliminar registro
		 * @return json
		 */
		public function Delete(){ 
			/**
			 * Validacion si existe post
			 * @return boolean 
			 */
			if($this->Post(['Cod'])){
				$cod = $this->GetPost('Cod');
				$fecha = $this->fecha();
				return $this->PJSON($this->modelo->Delete($cod,$fecha));
			}else{
				return $this->PJSON($this->modelo->MakeResponse(400, 'No hay Post'));
			}
		}

		/**
		 * Function Consulta 
		 * Busca los registros filtrandolo por el id unico
		 * @return json
		 */
		public function Consulta($id){
			$this->PJSON($this->modelo->Consulta($id[0]));
		}

		/**
		 * Function SelectCargos
		 * Consulta una lista de registro de los Cargos
		 * @return string html
		 */
		public function SelectCargos(){
			return $this->modelo->Select_Cargos();
		}

		/**
		 * Function SelectDeps
		 * Consulta una lista de registro de las dependencias
		 * @return string html
		 */
		public function SelectDeps(){
			return $this->modelo->Select_Dependencias();
		}

		/**
		 * Function FechaActual
		 * @return string fecha actual
		 */
		public function FechaActual(){
			return $this->fecha();
		}
		
		/**
		 * Function Listar 
		 * Lista los datos traidos desde el modelo de forma grafica 
		 * @return string (html)
		 */
		public function Listar($valor){
			echo $this->modelo->Listar($valor[0]);
		}
		
		/**
		 * Function PaginadorController 
		 * Consulta un paginador para mostrar un catalogo de registros
		 * @return string html
		 */
		public function PaginadorController($valor){
			echo $this->modelo->Pag($valor[0]);
		}
	}