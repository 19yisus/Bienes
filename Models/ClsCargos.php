<?php
	class clsCargos extends Model{
		private $cod,$cargo;
		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->cargo = null;

		}
		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($cod,$des){
			$this->cod = (isset($cod)) ? $cod : NULL;
			$this->cargo = $this->Limpiar($des);
		}
		/**
		 * Funcion Insert Para Guardar los datos en la base de datos
		 * @return array
		 */
		public function Insert(){
			
			try{

				/**
				 * Primero se comprueba si existe un cargo con el mismo nombre ingresado
				 * para evitar la duplicidad de nombres
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM cargos WHERE car_des = '$this->cargo' ;")->fetch();

				if(!$confirm){

					$con = $this->Prepare("INSERT INTO cargos(car_des) VALUES(:den);");

					$con -> bindParam(":den",$this->cargo);
					$res = $con->execute();

					if ($res){
						return $this->MakeResponse(200, "Operacion exitosa");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida! ya existe el cargo");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsCargos->Insert(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Update Para Actualizar los datos de una dependencia
		 * @return array
		 */
		public function Update(){

			try{
				/**
				 * Primero se comprueba que NO se duplique la informacion de otra cargo
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM cargos WHERE car_des = '$this->cargo' ;")->fetch();
				
				if(!$confirm){

					$con = $this->Prepare("UPDATE cargos SET car_des = :den WHERE car_cod = :cod;");

					$con -> bindParam(":den",$this->cargo);
					$con -> bindParam(":cod",$this->cod);

					$con -> execute();

					if ($con->rowCount() > 0){
						return $this->MakeResponse(200, "Operacion exitosa");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!, estas duplicando la informacion de otro cargo");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsCargos->Update(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Consulta para consultar toda la informacion de una dependencia
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Prepare("SELECT * FROM cargos WHERE car_cod = :codigo");
				$con -> bindParam(":codigo",$id);

				$con -> execute();
				$res = $con->fetch(PDO::FETCH_ASSOC);
				
				if(gettype($res) == 'array'){

					$Cargo = array(
						'Cod' => $res['car_cod'],
						'Des' => $res['car_des']
					);

					return $this->MakeResponse(200, "Operacion exitosa", $Cargo);
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!, el codigo del cargo es invalido");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsCargos->Consulta();, ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Id para imprimir el proximo codigo auto-incrementado de la tabla ingresada como string
		 */
		public function Id(){
			return $this->showCodIncrements('car_cod','cargos');
		}
		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){

			$arreglo = [
            	'table' => 'cargos',
            	'control' => 'CargosController',
            	'actual' => $pagina,
            	'columns' => ['car_cod','car_des'],
            	'cantColumns' => 2,
            	'encabezado' => [
            		'Codigo','Descripcion','Opciones'],
            	'btnEdLegend' => '',
            	'extraQuery' => '',
            	'sin' => [
            		'estado'
            		]
            	];

			return $this->paginador($arreglo);	
		}
		/**
		 * Function Listar para retornar un registro mas detallado de un cargo de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){

			$SelectPer = "
				personas.per_cedula,
				personas.per_nombre,
				personas.per_apellido,
				cargos.car_des,
				personas.per_direccion,
				personas.per_telefono,
				personas.per_desde,
				personas.per_hasta,
				personas.per_estado";

			try{
				$con = $this->Query("SELECT * FROM cargos WHERE car_cod = '$cod';")->fetch(PDO::FETCH_ASSOC);

				$con2 = $this->Query("SELECT COUNT(per_cedula) AS total FROM personas 
				WHERE per_car_cod = '$cod';")->fetch(PDO::FETCH_ASSOC);

				$con3 = $this->Query("SELECT $SelectPer FROM personas 
				INNER JOIN cargos ON cargos.car_cod = personas.per_car_cod 
				WHERE cargos.car_cod = '$cod' ;");	

				$lista = [];
				while($row = $con3->fetch(PDO::FETCH_ASSOC)){
					array_push($lista,$row);
				}
				
				if(sizeof($con) > 0){
					$card = "
								<div class='card'>
									<div class='card-header'>
										<h3 class='card-title'>Cargos</h3>
									</div>
									<div class='card-body table-responsive p-0'>
										<table class='table table-sm'>
											<thead>
												<tr>
													<th>ID</th>
													<th>Nombre del cargo</th>
													<th>N Personas con este cargo</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>".$con['car_cod']."</td>
													<td>".$con['car_des']."</td>
													<td>".$con2['total']."</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>";
										
					if(gettype($lista) == "array" AND sizeof($lista) > 0){
						$card .= '	<div class="card">
				 						<div class="card-header">
				 							<h3 class="card-title">Personas</h3>
				 						</div>
				 						<div class="card-body table-responsive p-0">
											<table class="table table-sm">
												<thead>
													<tr>
														<th style="width: 10px">ID</th>
														<th>Nombre</th>
														<th>Apellido</th>
														<th>cargo</th>
														<th>direccion</th>
														<th>telefono</th>
														<th>fecha del cargo</th>
														<th>Estado</th>
													</tr>
												</thead>
											<tbody>';
						foreach($lista as $row){
														
							$estado = ( $row['per_estado'] == 1) ? 'Activo' : 'Innactivo';
							
							if(isset($row['per_hasta'])){
								$fechas = $row['per_desde'].'-'.$row['per_hasta'];
							}else{
								$fechas = $row['per_desde'].'- Actualmente';
							}
										$card .= '<tr>
																<td>'.$row["per_cedula"].'</td>
																<td>'.$row["per_nombre"].'</td>
																<td>'.$row["per_apellido"].'</td>
																<td>'.$row["car_des"].'</td>
																<td>'.$row["per_direccion"].'</td>
																<td>'.$row["per_telefono"].'</td>
																<td>'.$fechas.'</td>
																<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
															</tr>';

						}
						
						$card .= '		</tbody>
											</table>
										</div>
									</div>';
					}else{
						$card .= '
							<div class="card">
								<div class="card-body p-2">
									<h4 class="text-center text-danger">Sin Cargos Asignados</h4>
								</div>
							</div>';
					}
					

				}else{

					$card .= '
					<div class="card">
						<div class="card-body p-2">
							<h4 class="text-center text-danger">Sin Cargos Registrados</h4>
						</div>
					</div>';
				}
				return $card;


			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsCargos->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
	}