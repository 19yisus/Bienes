<?php 
	class MarcasController extends Controller{
		public function __construct(){
			parent::__construct('Marcas');
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
			if($this->Post(['Marca','Tip'])){
				$cod = null;
				$marca = $this->GetPost('Marca'); 
				$cate = $this->GetPost('Tip');
				$this->modelo->setDatos($cod,$marca,$cate);
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
			if($this->Post(['Cod','Marca'])){
				$cod = $this->GetPost('Cod');
				$marca = $this->GetPost('Marca');
				$cate = $this->GetPost('Tip');
				$this->modelo->setDatos($cod,$marca,$cate);
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
		 * Function Listar 
		 * Lista los datos traidos desde el modelo de forma grafica 
		 * @return string (html)
		 */
		public function Listar($valor){
			echo $this->modelo->Listar($valor[0]);
		}

		/**
		 * Function SelectCategoria
		 * Consulta una lista de registro de los nucleos 
		 * @return string html
		 */
		public function SelectCategoria(){
			return $this->modelo->SelectCategoria();
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