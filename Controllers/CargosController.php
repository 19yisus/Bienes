<?php
	class CargosController extends Controller{
		public function __construct(){
			parent::__construct('Cargos');
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
			if( $this->Post(['Des']) ){
				$cod = null;
				$des = $this->GetPost('Des');

				$this->modelo->setDatos($cod,$des);
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
			if( $this->Post(['Des','Cod']) ){
				$cod = $this->GetPost('Cod');
				$des = $this->GetPost('Des');
				
				$this->modelo->setDatos($cod,$des);
				return $this->PJSON($this->modelo->Update());
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
		public function Consulta($id){ //FUNCION CONSULTA PARA CONSULTAR LOS CARGOS ANTES DE MODIFICAR SUS DATOS
			$this->PJSON($this->modelo->Consulta($id[0]));
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
