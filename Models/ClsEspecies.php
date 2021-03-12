<?php
	/**
	 * Las clases ClsMarcas y CLsEpecies son clases duplicadas porque la nomenclatura de los controladores lo requeria asi
	 * ambas clases son casi identicas y consultan a la misma tabla marcas en la base de datos, sin embargo
	 * estos modelos estan orientados a Marcas(objetos) y Especies(animales) respectivamente
	 */
	class clsEspecies extends Model{
		private $cod,$marca;
		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->marca = null;
		}
		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($cod,$marca){
			$this->cod = (isset($cod)) ? $cod : NULL;
			$this->marca = $this->Limpiar($marca);
		}
		/**
		 * Funcion Insert Para Guardar los datos en la base de datos
		 * @return array
		 */
		public function Insert(){

			try{

				/**
				 * Primero se comprueba si existe una marca con el mismo nombre ingresado
				 * para evitar la duplicidad de nombres
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM marcas WHERE mar_des = '$this->marca' ;")->fetch();

				if(!$confirm){

					$con = $this->Prepare("INSERT INTO marcas(mar_des,mar_categoria_cod,mar_estado) VALUES(:marca,'BS','1');");

					$con -> bindParam(":marca", $this->marca);
					$res = $con->execute();

					if ($res){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}	
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Ya existe la especie: '$this->marca' ");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsMarcas->Insert(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Update Para Actualizar los datos de una especie
		 * @return array
		 */
		public function Update(){

			try{

				/**
				 * Primero se comprueba que NO se duplique la informacion de otra especie
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM marcas WHERE mar_des = '$this->marca' AND mar_categoria_cod = 'BS';")->fetch();

				if(!$confirm){

					$con = $this->Prepare("UPDATE marcas SET mar_des = :des WHERE mar_cod = :cod;");

					$con -> bindParam(":cod", $this->cod);
					$con -> bindParam(":des", $this->marca);
					$con -> execute();

					if ($con->rowCount() > 0){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!","La Especie no esta registrada");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Estas duplicando la informacion de otra Especie");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsEspecies->Update(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Delete Para "eliminar" (cambiar el estado de activo a innactivo) en los registros
		 * @return array
		 */
		public function Delete($cod){
			
			try{

				/**
				 * Primero se comprueba que alla razas acivos usando esta especie
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
        $confirm = $this->Query("SELECT * FROM modelos WHERE mod_estado = '1' AND mod_marca_cod = '$cod' ;")->fetch();

				if(!$confirm){
					//Se consulta el estado actual de esta marca para desactivar o reactivar la misma
					$con1 = $this->Query("SELECT mar_estado FROM marcas WHERE mar_cod = '$cod';")->fetch();

					if($con1['mar_estado'] == 1){
						$con = $this->Prepare("UPDATE marcas SET mar_estado = '0' WHERE mar_cod = :cod;");
					}else{
						$con = $this->Prepare("UPDATE marcas SET mar_estado = '1' WHERE mar_cod = :cod;");
					}

					$con -> bindParam(":cod",$cod);
					$con->execute();

					if ($con->rowCount() > 0){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","La Especie esta siendo utilizada");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsEspecie->Delete(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Consulta para consultar toda la informacion de una dependencia
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Prepare("SELECT * FROM marcas WHERE mar_cod = :cod;");
				$con -> bindParam(":cod",$id);

				$con -> execute();
				$res = $con->fetch(PDO::FETCH_ASSOC);

				if(gettype($res) == 'array'){

					$Esp = array(
						'Cod' => $res['mar_cod'],
						'Des' => $res['mar_des']
					);

					return $this->MakeResponse(200, "Operacion Exitosa", $Esp);
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","El codigo de la Especie invalido");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsEspecie->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){
			$encabezados = ['Codigo','Descripcion','Estado','Opciones'];
      $columnas = ['mar_cod','mar_estado','mar_des'];
			$Select = 'marcas.mar_cod, marcas.mar_des, marcas.mar_estado';
			$Join = "INNER JOIN categoria ON categoria.cat_cod = marcas.mar_categoria_cod WHERE marcas.mar_categoria_cod = 'BS' ";

			$arreglo = [
        'table' => 'marcas',
        'control' => 'EspeciesController',
        'actual' => $pagina,
        'columns' => $columnas,
        'cantColumns' => 3,
        'encabezado' => $encabezados,
        'btnEdLegend' => 'Esta Especie no puede ser modificada',
        'extraQuery' => $Join,
				'extraSelect' => $Select,
        'sin' => ['']
			];
			return $this->paginador($arreglo);
		}

		public function All(){

			try{
				$data = $this->Query("SELECT marcas.mar_cod,marcas.mar_des,marcas.mar_estado
				FROM marcas INNER JOIN categoria ON categoria.cat_cod = marcas.mar_categoria_cod 
				WHERE marcas.mar_categoria_cod = 'BS';")->fetchAll(PDO::FETCH_ASSOC);

				return ['data' => $data];

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->All(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Listar para retornar un registro mas detallado de una especie de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){
			
			try{

				$InnerJoinBien = "INNER JOIN modelos ON modelos.mod_cod = bien.bien_mod_cod 
				INNER JOIN marcas ON marcas.mar_cod = modelos.mod_marca_cod";

				$con = $this->Query("SELECT * FROM marcas WHERE mar_cod = '$cod';")->fetch(PDO::FETCH_ASSOC);

				$con2 = $this->Query("SELECT COUNT(bien_cod) AS total FROM bien $InnerJoinBien WHERE marcas.mar_cod = '$cod' ;")
					->fetch(PDO::FETCH_ASSOC);

				if(sizeof($con) > 0){
					$estado = ($con['mar_estado'] == 1) ? 'Activo' : 'Innactivo';
					$card = '
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Marcas</h3>
									</div>
									<div class="card-body table-responsive p-0">
										<table class="table table-sm">
											<thead>
												<tr>
													<th>ID</th>
													<th>Nombre de la Especie</th>
													<th>Nº bienes de esta Especie</th>
													<th>Estado</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>'.$con["mar_cod"].'</td>
													<td>'.$con["mar_des"].'</td>
													<td>'.$con2["total"].'</td>
													<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>';

				}else{

					$card .= '
					<div class="card">
						<div class="card-body p-2">
							<h4 class="text-center text-danger">Sin Especies Registradas</h4>
						</div>
					</div>';
				}
				return $card;


			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsEspecie->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Id para imprimir el proximo codigo auto-incrementado de la tabla ingresada como string
		 * @return number [codigo]
		 */
		public function Id(){
			return $this->showCodIncrements('mar_cod','marcas');
		}
	}