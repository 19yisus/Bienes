<?php
	class ClsNucleo extends Model{
		private $cod,$des,$cp,$dir,$tip,$nu;
		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->des = null;
			$this->cp = null;
			$this->dir = null;
			$this->tip = null;
			$this->nu = null;
		}
		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($cod,$des,$cp,$dir,$tip,$nu){
			$this->cod = (isset($cod)) ? ((is_numeric($cod) == true) ? $cod : NULL) : NULL;
			$this->des = $this->Limpiar($des);
			$this->cp = $this->Limpiar($cp);
			$this->dir = $this->Limpiar($dir);
			$this->tip = $this->Limpiar($tip);
			$this->nu = (isset($nu)) ? ((is_numeric($nu) == true) ? $nu : NULL) : NUll;
		}
		/**
		 * Funcion Insert Para Guardar los datos en la base de datos
		 * @return array
		 */
		public function Insert(){

			try{
				/**
				 * Primero se comprueba si existe un nucleo con el mismo nombre ingresado
				 * para evitar la duplicidad de nombres
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$con1 = $this->Query("SELECT * FROM nucleo WHERE nuc_des = '$this->des' ;")->fetch();

				if(!$con1){
					
					$con = $this->Prepare("INSERT INTO nucleo( nuc_des, nuc_direccion, nuc_codigo_postal, nuc_estado, nuc_tipo_nucleo, nuc_nucleo_principal) 
						VALUES(:de,:dir,:cp,'1',:tip,:per);");

					$con -> bindParam(":de", $this->des);
					$con -> bindParam(":cp",  $this->cp);
					$con -> bindParam(":dir", $this->dir);
					$con -> bindParam(":tip", $this->tip);
					$con -> bindParam(":per", $this->nu);

					$res = $con->execute();

					if ($res){
						return $this->MakeResponse(200, "Operacion exitosa");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida");
					}
				}else{
					return $this->MakeResponse(400, "Ya existe este nucleo");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->Insert(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Update Para Actualizar los datos de un nucleo
		 * @return array
		 */
		public function Update(){

			try{
				/**
				 * Primero se comprueba que NO se duplique la informacion de otro nucleo
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM nucleo WHERE nuc_des = '$this->des' AND 
				nuc_codigo_postal = '$this->cp' AND nuc_direccion = '$this->dir' AND nuc_tipo_nucleo = '$this->tip' ;")->fetch();

				if(!$confirm){
					
					$con = $this->Prepare("UPDATE nucleo SET nuc_des = :den, 
					nuc_direccion = :dir, nuc_codigo_postal = :cp, nuc_tipo_nucleo = :tip, nuc_nucleo_principal = :nu WHERE nuc_cod = :cod;");

					$con -> bindParam(":cod", $this->cod);
					$con -> bindParam(":den", $this->des);
					$con -> bindParam(":cp",  $this->cp);
					$con -> bindParam(":dir", $this->dir);
					$con -> bindParam(":tip", $this->tip);
					$con -> bindParam(":nu", $this->nu);

					$con -> execute();

					if ($con->rowCount() > 0){

						return $this->MakeResponse(200, "Operacion exitosa");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!","El Nucleo no esta registrado");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Estas duplicando informacion de otro Nucleo");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->Update(), ERROR = ".$e->getMessage());
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
				 * Primero se comprueba que el nucleo seleccionado no este siendo utilizado por una dependencia activa
				 * @return boolean
				 */
				$con1 = $this->Query("SELECT * FROM dependencia WHERE dep_estado = '1' AND dep_nucleo_cod = '$cod' ;")->fetch();
				
				if(!$con1){
					/**
					 * Luego se comprueba que estado tiene dicho nucleo (activo o innactivo)
					 * ya que aqui se podra tanto desactivar como reactivar
					 * @return array [estado del nucleo]
					 */
					$con = $this->Query("SELECT nuc_estado FROM nucleo WHERE nuc_cod = '$cod' ;")->fetch();

					if($con['nuc_estado'] == 1){
						$con2 = $this->Prepare("UPDATE nucleo SET nuc_estado = '0' WHERE nuc_cod = :cod;");
					}else{
						$con2 = $this->Prepare("UPDATE nucleo SET nuc_estado = '1' WHERE nuc_cod = :cod;");
					}

					$con2 -> bindParam(":cod",   $cod);
					$con2->execute();

					if ($con2->rowCount() > 0){
						return $this->MakeResponse(200, "Operacion exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","El Nucleo esta en uso");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->Delete(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Consulta para consultar toda la informacion de un nucleo
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Prepare("SELECT * FROM nucleo WHERE nuc_cod = :codigo;");
				$con -> bindParam(":codigo",$id);
				$con -> execute();
				$res = $con->fetch(PDO::FETCH_ASSOC);
				
				if(gettype($res) == 'array'){
					  					
					$Nucleo = array(
						'Cod' => $id,
						'Des' => $res['nuc_des'],
						'Dir' => $res['nuc_direccion'],
						'CodPostal' => $res['nuc_codigo_postal'],
						'TipeNu' => $res['nuc_tipo_nucleo']
					);

					return $this->MakeResponse(200, "Operacion exitosa", $Nucleo);
				}else{

					return $this->MakeResponse(400, "El codigo del nucleo es invalido");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Id para imprimir el proximo codigo auto-incrementado de la tabla ingresada como string
		 * @return number [codigo]
		 */
		public function Id(){

			return $this->showCodIncrements('nuc_cod','nucleo');
		}
		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){
			$Columnas = [
				'nuc_cod',
				'nuc_estado',
				'nuc_des',
				'nuc_direccion',
				'nuc_codigo_postal'
			];	
						
			$arreglo = [
				'table' => 'nucleo',
				'control' => 'NucleoController',
				'actual' => $pagina,
				'columns' => $Columnas,
				'cantColumns' => 5,
				'encabezado' => [
					'Codigo','Descripcion','Direccion','Codigo Postal','Estado','Opciones'],
				'btnEdLegend' => 'Este nucleo no puede ser modificado',
				'extraQuery' => '',
				'sin' => [
					''
					]
				];

			return $this->paginador($arreglo);	
		}
		/**
		 * Function Listar para retornar un registro mas detallado de un nucleo de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){
			try{
								
				$con1 = $this->Query("SELECT * FROM nucleo WHERE nuc_cod = '$cod' ;")->fetch();
				$con2 = $this->Query("SELECT * FROM dependencia WHERE dep_nucleo_cod = '$cod' ;")->fetchAll();

				$estado = ($con1['nuc_estado'] == 1) ? 'Activo' : 'Innactivo';

				switch($con1['nuc_tipo_nucleo']){
					case 'NU':
						$tipo = "Nucleo";
						break;
					case 'EX':
						$tipo = "Extension";
						break;
					case 'PR':
						$tipo = "Programa";
						break;
				}

				$card = '
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Nucleo</h3>
										</div>
										<div class="card-body table-responsive p-0">
											<table class="table table-sm">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nombre del nucleo</th>
														<th>Direccion</th>
														<th>Codigo Postal</th>
														<th>Tipo de nucleo</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>'.$con1['nuc_cod'].'</td>
														<td>'.$con1['nuc_des'].'</td>
														<td>'.$con1['nuc_direccion'].'</td>
														<td>'.$con1['nuc_codigo_postal'].'</td>
														<td>'.$tipo.'</td>
														<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>';
				if(sizeof($con2) > 0){
					$card .= '<div class="card">
								<div class="card-header">
									<h3 class="card-title">Dependencias</h3>
								</div>
								<div class="card-body table-responsive p-0">
									<table class="table table-sm">
										<thead>
											<tr>
												<th style="width: 10px">ID</th>
												<th>Nombre de la dependencia</th>
												<th>Estado</th>
											</tr>
										</thead>
										<tbody>
					';
					
					foreach ($con2 as $key) {
						$estado = ($key['dep_estado'] == '1') ? 'Activo' : 'Innactivo';
						
						$card .= '
											<tr>
												<td>'.$key['dep_cod'].'</td>
												<td>'.$key['dep_des'].'</td>
												<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
											</tr>';
					}

					$card .= '</tbody>
								</table>
							</div>';
				}else{
					$card .= '
					<div class="card">
						<div class="card-body p-2">
							<h4 class="text-center text-danger">Sin dependencias asignadas</h4>
						</div>
					</div>';
				}
				return $card;
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion ThereIsNucleo para verificar la existencia de un nucleo principal
		 * (Esto para evitar el intento de registro de un segundo nucleo)
		 * @return boolean
		 */
		public function ThereIsNucleo(){

			try{
				$con = $this->Query("SELECT (nuc_cod) FROM nucleo WHERE nuc_tipo_nucleo = 'NU';")->fetch();

				if($con == false){
					return false;
				}
				return true;
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->ThereIsNucleo(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion CodNucleo para consular el codigo del nucleo principal registrado
		 * @return array [codigo]
		 */
		public function CodNucleo(){
			try{
				$con = $this->Query("SELECT (nuc_cod) FROM nucleo WHERE nuc_tipo_nucleo = 'NU';")->fetch(PDO::FETCH_ASSOC);
				return $con['nuc_cod'];
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->CodNucleo(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
	}