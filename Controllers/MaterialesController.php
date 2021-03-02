<?php 
	class MaterialesController extends Controller{
		public function __construct(){
			parent::__construct('Materiales');
		}

		/**
		 * Function PaginadorController 
		 * Consulta un paginador para mostrar un catalogo de registros
		 * @return string html
		 */
		public function PaginadorController($valor){
			echo $this->modelo->Pag($valor[0]);
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
			if($this->Post(['CodB','Material'])){
				$bien = $this->GetPost('CodB');
				$material  = $this->GetPost('Material');
				$oldBien = null;
				$this->modelo->setDatos($bien, $material,null, null);
				return $this->PJSON($this->modelo->Asignar());
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
			if($this->Post(['CodB','Material','CodM_old','CodB_old'])){
				$bien = $this->GetPost('CodB');
				$material  = $this->GetPost('Material');
				$oldMaterial = $this->GetPost('CodM_old');
				$oldBeneficiado = $this->GetPost('CodB_old');
				$this->modelo->setDatos($bien, $material, $oldMaterial, $oldBeneficiado);
				return $this->PJSON($this->modelo->Update());
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

		public function ModalAsignacion($tipo){
			echo $this->modelo->ModalAsign($tipo);
		}

		public function SearchById($cod){
			$this->PJSON($this->modelo->SearchById($cod[0]));
		}
	}