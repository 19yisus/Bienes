<?php 
	class EspeciesController extends Controller{
		public function __construct(){
			parent::__construct('Especies');
		}
		/**
		 * Funcion Render 
		 * Para renderizar la vista de este controlador
		 * @return function Render de la clase view
		 */
		public function Render(){
			$this->view->Render("Especies/Index");
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
			if($this->Post(['Esp'])){
				$cod = null;
				$Esp = $this->GetPost('Esp');
				$this->modelo->setDatos($cod,$Esp);
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
			if($this->Post(['Cod','Esp'])){
				$cod = $this->GetPost('Cod');
				$esp = $this->GetPost('Esp');
				$this->modelo->setDatos($cod,$esp);
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
		 * Function Consulta 
		 * Busca los registros filtrandolo por el id unico
		 * @return json
		 */
		public function Consulta($id){ 
			return $this->PJSON($this->modelo->Consulta($id[0]));
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
		 * Function ShowCodigoIncrementado
		 * Consulta la secuencia actual y le suma +1 para mostrar cual sera el proximo codigo
		 * @return number
		 */
		public function ShowCodigoIncrementado(){
			echo $this->modelo->Id();
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