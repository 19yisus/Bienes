<?php 
	class RazasController extends Controller{
		public function __construct(){
			parent::__construct('Razas');
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
			if($this->Post(['Raza','Esp'])){
				$cod = null;
				$Raza = $this->GetPost('Raza'); 
				$Esp = $this->GetPost('Esp');
				$this->modelo->setDatos($cod,$Raza,$Esp);
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
			if($this->Post(['Cod','Raza','Esp'])){
				$cod = $this->GetPost('Cod');
				$Raza = $this->GetPost('Raza'); 
				$Esp = $this->GetPost('Esp');
				$this->modelo->setDatos($cod,$Raza,$Esp);
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
			$this->PJSON($this->modelo->Consulta($id[0]));
		}

		/**
		 * Function Select_Especies
		 * Consulta una lista de registro de las especies
		 * @return string html
		 */
		public function Select_Especies(){
      return $this->modelo->Select_Especies();			
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