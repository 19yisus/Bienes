<?php
	class DependenciasController extends Controller{
		public function __construct(){
			parent::__construct('Dependencias');
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
			if($this->Post(['Des','Nu'])){
				$cod = null;
				$des = $this->GetPost('Des');
				$nu = $this->GetPost('Nu');
				$this->modelo->setDatos($cod,$des,$nu);
				return $this->PJSON($this->modelo->Insert());
			}else{
				return $this->PJSON($this->modelo->MakeResponse(400, 'No hay Post'));
			}
		}
		/**
		 * Funcion Update
		 * Actualizar registros
		 * @return json
		 */
		public function Update(){
			/**
			 * Validacion si existe post
			 * @return boolean 
			 */
			if($this->Post(['Cod','Des','Nu'])){
				$cod = $this->GetPost('Cod');
				$des = $this->GetPost('Des');
				$nu = $this->GetPost('Nu');
				$this->modelo->setDatos($cod,$des,$nu);
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
				return $this->PJSON($this->modelo->Delete($this->GetPost('Cod')));
			}else{
				return $this->PJSON($this->modelo->MakeResponse(400, 'No hay Post'));
			}
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
		 * Function Consulta 
		 * Busca los registros filtrandolo por el id unico
		 * @return json
		 */
		public function Consulta($id){
			return $this->PJSON($this->modelo->Consulta($id[0]));
		}
		/**
		 * Function ShowCodigoIncrementado
		 * Consulta la secuencia actual y le suma +1 para mostrar cual sera el proximo codigo
		 * @return number
		 */
		public function ShowCodigoIncrementado(){
			echo $this->modelo->Id();
		}
		/**
		 * Function Select_Nucleos
		 * Consulta una lista de registro de los nucleos 
		 * @return string html
		 */
		public function Select_Nucleos($d = []){
			if($d[0] == 1){
				echo $this->modelo->Select_Nucleos();		
			}else{
				return $this->modelo->Select_Nucleos();
			}
		}
		/**
		 * Function PaginadorController 
		 * Consulta un paginador para mostrar un catalogo de registros
		 * @return string html
		 */
		public function PaginadorController(){
			return $this->PJSON($this->modelo->All());
		}

		public function Isthereprincipal(){
			return $this->PJSON($this->modelo->Isthereprincipal());
		}
	}