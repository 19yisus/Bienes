<?php
	class clsClasificacion extends Model{
		private $cod,$des,$tipo;
		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->des = null;
			$this->tipo = null;
		}
		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($cod,$des,$tip){
			$this->cod = (isset($cod)) ? $cod : NULL;
			$this->des = $this->Limpiar($des);
			$this->tipo = $this->Limpiar($tip);
		}
		/**
		 * Funcion Insert Para Guardar los datos en la base de datos
		 * @return array
		 */
		public function Insert(){

			try{
				/**
				 * Primero se comprueba si existe una clasificacion con el mismo nombre y codigo ingresado
				 * para evitar la duplicidad de informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM clasificacion WHERE cla_des = '$this->des' OR cla_cod = '$this->cod';")->fetch();

				if(!$confirm){

					$con = $this->Prepare("INSERT INTO clasificacion(cla_cod,cla_des,cla_cat_cod,cla_estado) VALUES(:cod,:des,:tip,1);");

					$con -> bindParam(":cod",$this->cod);
					$con -> bindParam(":des",$this->des);
					$con -> bindParam(":tip",$this->tipo);

					$res = $con -> execute();

					if($res){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Esta clasficicacion ya existe");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsClasifiacion->Insert(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Update Para Actualizar los datos de una clasificacion
		 * @return array
		 */
		public function Update(){
			
			try{
				/**
				 * Primero se comprueba que NO se duplique la informacion de otra clasificacion
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM clasificacion WHERE cla_des = '$this->des' AND cla_cod = '$this->cod' AND 
				cla_cat_cod = '$this->tipo' ;")->fetch();

				if(!$confirm){
					$con = $this->Prepare("UPDATE clasificacion SET cla_des = :des, cla_cat_cod = :tip WHERE cla_cod = :cod;");

					$con -> bindParam(":cod",$this->cod);
					$con -> bindParam(":des",$this->des);
					$con -> bindParam(":tip",$this->tipo);

					$con -> execute();

					if($con -> rowCount() > 0){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(200, "Operacion Fallida!","Estas duplicando la informacion de otra clasificacion");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsClasifiacion->Update(), ERROR = ".$e->getMessage());
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
				 * Primero se comprueba que si hay algun bien activo usando esta clasificacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$con1 = $this->Query("SELECT * FROM bien WHERE bien_estado = '1' AND bien_clasificacion_cod = ".$cod.";")->fetch();
				
				if(!$con1){
					//SE consulta el estado actual de la clasificacion para desactivarlo o reactivarlo respectivamente
					$con = $this->Query("SELECT cla_estado FROM clasificacion WHERE cla_cod = ".$cod.";")->fetch();
					
					if($con['cla_estado'] == 1){
						$con2 = $this->Query("UPDATE clasificacion SET cla_estado = '0' WHERE cla_cod = ".$cod." ;");

					}else{
						$con2 = $this->Query("UPDATE clasificacion SET cla_estado = '1' WHERE cla_cod = ".$cod." ;");
					}
					
					if ($con2->rowCount() > 0){
						return $this->MakeResponse(400, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","La clasificacion esta en uso");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsClasifiacion->Delete(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		/**
		 * Funcion SelectCategoria
		 * lista los nucleos activos
		 * @return string html
		 */
		Public function SelectCategoria(){
			
      try{
				$con = $this->Query("SELECT * FROM categoria;");
				$select = "<option value=''>Seleccione un valor</option>";

				while($res = $con->fetch(PDO::FETCH_ASSOC)){
					$select .= "<option value='".$res['cat_cod']."'>".$res['cat_des']."</option>";
        }

				return $select;			

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsClasificacion->SelectCategoria(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		/**
		 * Funcion Consulta para consultar toda la informacion de una dependencia
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Query("SELECT * FROM clasificacion WHERE cla_cod = '$id' ;");

				$res = $con->fetch(PDO::FETCH_ASSOC);

				if(gettype($res) == 'array'){

					$Cla = array(
						'Cod' => $res['cla_cod'],
						'Des' => $res['cla_des'],
						'Cate' => $res['cla_cat_cod']
					);

					return $this->MakeResponse(200, "Operacion Exitosa!", $Cla);

				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","El codigo de la clasificacion es incorrecto");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsClasifiacion->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){
			
			$encabezados = ['Codigo','Descripcion','Categoria','Opciones'];
			$columnas = ['cla_cod','cla_des','cat_des'];

			$arreglo = [
				'table' => 'clasificacion',
				'control' => 'ClasificacionController',
				'actual' => $pagina,
				'columns' => $columnas,
				'cantColumns' => 3,
				'encabezado' => $encabezados,
				'btnEdLegend' => 'Esta Clasificacion no puede ser modificada',
				'extraQuery' => 'INNER JOIN categoria ON categoria.cat_cod = clasificacion.'.'cla_cat_cod'.'',
				'extraSelect' => 'clasificacion.'.'cla_cod'.',clasificacion.'.'cla_des'.',
						categoria.cat_des',
				'sin' => [
					'estado'
					]
				];
				
			return $this->paginador($arreglo);
		}

		/**
		 * Function Listar para retornar un registro mas detallado de una dependencia de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){
			
			try{
				$con = $this->Query("SELECT * FROM clasificacion INNER JOIN categoria ON categoria.cat_cod = clasificacion.cla_cat_cod  
				WHERE cla_cod = '$cod' ;")->fetch();
				
				if($con){

					$con2 = $this->Query("SELECT COUNT(bien_cod) AS total FROM bien WHERE bien_clasificacion_cod = '$cod' ;")->fetch();

					// if($con['cla_estado'] == 1){
					// 	$estado = "Activo";
					// }else{
					// 	$estado = "Inactivo";
					//<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
					// }

					$card = '
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Clasificacion</h3>
									</div>
									<div class="card-body table-responsive p-0">
										<table class="table table-sm">
											<thead>
												<tr>
													<th>ID</th>
													<th>Nombre de la Clasificacion</th>
													<th>Nº bienes con esta clasificacion</th>
													<th>Categoria</th>
													
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>'.$con['cla_cod'].'</td>
													<td>'.$con['cla_des'].'</td>
													<td>'.$con2["total"].'</td>
													<td>'.$con['cat_des'].'</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>';			

				}else{

					$card = '
					<div class="card">
						<div class="card-body p-2">
							<h4 class="text-center text-danger">Sin Clasificaciones Registradas</h4>
						</div>
					</div>';
				}
				return $card;

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsClasifiacion->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Id para imprimir el proximo codigo auto-incrementado de la tabla ingresada como string
		 * @return number [codigo]
		 */
		public function Id(){
			return $this->showCodIncrements('cla_cod','clasificacion');
		}
	}