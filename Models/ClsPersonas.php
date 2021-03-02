<?php
  class clsPersonas extends Model{
		private $cod,$nom,$ape,$tel,$cargo,$email,$fecha,$dir,$dep;

		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->nom = null;
			$this->ape = null;
			$this->tel = null;
			$this->cargo = null;
			$this->email = null;
			$this->fecha = null;
			$this->dir = null;
			$this->dep = null;
		}

		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($Cod,$Nom,$Ape,$Tel,$Cargo,$Email,$Fecha,$Dir,$Dep){
			$this->cod = $this->Limpiar($Cod);
			$this->nom = $this->Limpiar($Nom);
			$this->ape = $this->Limpiar($Ape);
			$this->tel = $this->Limpiar($Tel);
			$this->cargo = $this->Limpiar($Cargo);
			$this->email = $this->Limpiar($Email);
			$this->fecha = $this->Limpiar($Fecha);
			$this->dir = $this->Limpiar($Dir);
			$this->dep = $this->Limpiar($Dep);
		}

		/**
		 * Funcion Insert Para Guardar los datos en la base de datos
		 * @return array
		 */
		public function Insert(){

			try{

				/**
				 * Primero se comprueba si existe una persona con los mismos datos ingresado
				 * para evitar la duplicidad de informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM personas WHERE per_cedula = '$this->cod';")->fetch();

				if(!$confirm){

					/**
					 * Luego se comprueba si ya hay una persona activa en la dependencia ingresada
					 * para evitar que alla 2 personas registradas en una dependenciaf
					 * @return array si hay datos
					 * @return boolean si no hay datos
					 */
					$confirm2 = $this->Query("SELECT * FROM personas WHERE per_estado = '1' AND per_dep_cod = '$this->dep' ;")->fetch();

					if(!$confirm2){

						$con = $this->Prepare("INSERT INTO personas(
							per_cedula,
							per_nombre,
							per_apellido,
							per_estado,
							per_car_cod,
							per_dep_cod,
							per_telefono,
							per_correo,
							per_direccion,
							per_desde,
							per_hasta
							) VALUES(:cod,:nom,:ape,'1',:cargo,:dep,:tel,:email,:dir,:fecha,Null);");

						$con -> bindParam(":cod",$this->cod);
						$con -> bindParam(":nom",$this->nom);
						$con -> bindParam(":ape",$this->ape);
						$con -> bindParam(":cargo",$this->cargo);
						$con -> bindParam(":dep",$this->dep);
						$con -> bindParam(":tel",$this->tel);
						$con -> bindParam(":email",$this->email);
						$con -> bindParam(":dir",$this->dir);
						$con -> bindParam(":fecha",$this->fecha);

						$res = $con->execute();

						if ($res){
							return $this->MakeResponse(200, "Operacion Exitosa!");
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!");
						}
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!","Ya hay una persona registrada en esta dependencia");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!", "Ya hay una persona registrada con esta cedula: V-$this->cod");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Insert(), ERROR = ".$e->getMessage());
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
				 * Primero se comprueba que NO se duplique la informacion de otra persona
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM personas 
					WHERE per_cedula = '$this->cod' 
					AND per_nombre = '$this->nom' 
					AND per_apellido = '$this->ape' 
					AND per_car_cod = '$this->cargo'
					AND per_dep_cod = '$this->dep' 
					AND per_correo = '$this->email'  
					AND per_telefono = '$this->tel' ;")->fetch();

				if(!$confirm){
					
					/**
					 * Se comprueba que no alla 1 persona activa en la dependencia seleccionada
					 * @return array si hay datos
					 * @return boolean si no hay datos
					 */
					$confirm2 = $this->Query("SELECT * FROM personas 
						WHERE per_dep_cod = '$this->dep' 
						AND per_cedula != '$this->cod'
						AND per_estado = '1' ")->fetch();

					if(!$confirm2){

						$con = $this->Prepare("UPDATE personas SET 
						per_nombre = :nom, 
						per_apellido = :ape, 
						per_car_cod = :cargo, 
						per_dep_cod = :dep, 
						per_telefono = :tel, 
						per_correo = :email, 
						per_direccion = :dir, 
						per_desde = :fecha 
						WHERE per_cedula = :cod;");
						
						$con -> bindParam(":cod",$this->cod);
						$con -> bindParam(":nom",$this->nom);
						$con -> bindParam(":ape",$this->ape);
						$con -> bindParam(":cargo",$this->cargo);
						$con -> bindParam(":dep",$this->dep);
						$con -> bindParam(":tel",$this->tel);
						$con -> bindParam(":email",$this->email);
						$con -> bindParam(":dir",$this->dir);
						$con -> bindParam(":fecha",$this->fecha);

						$con -> execute();

						if ($con->rowCount() > 0){
							return $this->MakeResponse(200, "Operacion Exitosa!");
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!");
						}
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!","Ya hay otro encargado activo en esta dependencia");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Estas duplicando datos de otra persona");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Update(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Delete Para "eliminar" (cambiar el estado de activo a innactivo) en los registros
		 * @return array
		 */
		public function Delete($cod,$fecha){

			try{
				/**
				 * Primero se consulta la existencia de la persona
				 * y se consulta su estado
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$con1 = $this->Query("SELECT per_estado FROM personas WHERE per_cedula = '$cod' ;")->fetch();

				if($con1){
					
					if($con1['per_estado'] == 1){
						
						$con = $this->Prepare("UPDATE personas SET per_estado = '0', per_hasta = :fecha WHERE per_cedula = :cod;");

						$con -> bindParam(":cod",   $cod);
						$con -> bindParam(":fecha", $fecha);
						$con -> execute();

						if($con->rowCount() > 0){
							return $this->MakeResponse(200, "Operacion Exitosa!");
						}else{
							return $this->MakeResponse(200, "Operacion Fallida!");
						}

					}else{
						/**
						 * Se consulta la dependencia en la cual esta registrada la persona
						 */
						$confirm = $this->Query("SELECT per_dep_cod FROM personas WHERE per_cedula = '$cod' ;")
						->fetch(PDO::FETCH_ASSOC);
						$depen = $confirm['per_dep_cod'];
						/**
						 * Se consulta la cantidad de personas que estan registradas en esta dependencia
						 * (solo debe de haber una persona activa en esta dependencia)
						 */
						$confirm2 = $this->Query('SELECT COUNT(per_cedula) AS total FROM personas WHERE per_dep_cod = '.$confirm["per_dep_cod"].' ;')->fetch();
						
						//Si la cantidad de personas registradas en una dependencia es mayor a 1
						if($confirm2['total'] > 1){

							//Se consulta el estado de la segunda persona registrada en la dependencia
							$confirm3 = $this->Query("SELECT per_estado FROM personas WHERE per_dep_cod = '$depen' AND per_cedula != '$cod' ;")->fetch();
							
							//si su estado es innactivo, se procede a reactivar a la persona que ingresamos
							if($confirm3['per_estado'] == 0){
							
								$con = $this->Prepare("UPDATE personas SET per_estado = '1', per_hasta = Null, per_desde = :fecha WHERE per_cedula = :cod;");

								$con -> bindParam(":cod",   $cod);
								$con -> bindParam(":fecha", $fecha);
								$con -> execute();

								if($con->rowCount() > 0){
									return $this->MakeResponse(200, "Operacion Exitosa!");
								}else{
									return $this->MakeResponse(400, "Operacion Fallida!");
								}						
							}else{
								return $this->MakeResponse(400, "Operacion Fallida!","Ya hay un encargado activo en la dependencia");
							}
						}else{

							$con = $this->Prepare("UPDATE personas SET per_estado = '1', per_hasta = Null, per_desde = :fecha WHERE per_cedula = :cod;");

							$con -> bindParam(":cod",   $cod);
							$con -> bindParam(":fecha", $fecha);
							$con -> execute();

							if($con->rowCount() > 0){
								return $this->MakeResponse(200, "Operacion Exitosa!");
							}else{
								return $this->MakeResponse(400, "Operacion Fallida!");
							}
						}
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","La cedula ingresada es incorrecta!");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Delete(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Consulta para consultar toda la informacion de una persona
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Prepare("SELECT * FROM personas WHERE per_cedula = :codigo");
				$con -> bindParam(":codigo",$id);
				$con -> execute();
				$res = $con->fetch(PDO::FETCH_ASSOC);
				
				if(gettype($res) == 'array'){

					$Per = array(
						'Cod' => $res['per_cedula'],
						'Name' => $res['per_nombre'],
						'LastName' => $res['per_apellido'],
						'Dir' => $res['per_direccion'],
						'Email' => $res['per_correo'],
						'Tel' => $res['per_telefono'],
						'Fecha' => $res['per_desde'],
						'CodCargo' => $res['per_car_cod'],
						'CodDep' => $res['per_dep_cod']
					);

					return $this->MakeResponse(200, "Operacion Exitosa!", $Per);
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","La cedula es invalida");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Select_Cargos
		 * lista los Cargos registrados
		 * @return string html
		 */
		Public function Select_Cargos(){
			
			try{
				$con = $this->Query("SELECT * FROM cargos;");
				$select = "<option value=''>Seleccione un valor</option>";

				while($res = $con->fetch(PDO::FETCH_ASSOC)){
					$select .= "<option value='".$res['car_cod']."'>".$res['car_des']."</option>";
        }

			return $select;			
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Select_Cargos(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		/**
		 * Funcion Select_Dependencias
		 * lista las Dependencias registradas y activas
		 * @return string html
		 */
		Public function Select_Dependencias(){
			
      try{
				$con = $this->Query("SELECT * FROM dependencia WHERE dep_estado = '1';");
				$select = "<option value=''>Seleccione un valor</option>";

				while($res = $con->fetch(PDO::FETCH_ASSOC)){
					$select .= "<option value='".$res['dep_cod']."'>".$res['dep_des']."</option>";
        }

			return $select;			
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Select_Dependencias(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		
		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){
						
			$encabezados = ['CI','Nombre','Cargo','Dependencia','Estado','Opciones'];
			$columnas = ['per_cedula','per_estado','nombre','car_des','dep_des'];
			$Join = "INNER JOIN cargos ON cargos.car_cod = personas.per_car_cod INNER JOIN dependencia ON dependencia.dep_cod = personas.per_dep_cod";
			
			$Select = "personas.per_cedula,CONCAT(personas.per_nombre,' ',personas.per_apellido) AS nombre,
			cargos.car_des,dependencia.dep_des,personas.per_estado";

			$arreglo = [
        'table' => 'personas',
        'control' => 'PersonasController',
        'actual' => $pagina,
        'columns' => $columnas,
        'cantColumns' => 5,
        'encabezado' => $encabezados,
        'btnEdLegend' => 'Esta persona no puede ser modificada',
        'extraQuery' => $Join,
				'extraSelect' => $Select,
        'sin' => ['']
      ];

      return $this->paginador($arreglo);
		}

    	/**
		 * Function Listar para retornar un registro mas detallado de una persona de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){
			
			$SelectPer = "
			personas.per_cedula, 
			personas.per_nombre, 
			personas.per_apellido, 
			personas.per_estado, 
			personas.per_telefono, 
			personas.per_correo,
			personas.per_direccion, 
			personas.per_desde, 
			personas.per_hasta, 
			cargos.car_des, 
			dependencia.dep_des";
			
			$InnerJoinPer = "INNER JOIN cargos ON cargos.car_cod = personas.per_car_cod INNER JOIN dependencia ON dependencia.dep_cod = personas.per_dep_cod";
			try{
				$con1 = $this->Query("SELECT $SelectPer FROM personas $InnerJoinPer	WHERE personas.per_cedula = '$cod' ;")->fetch(PDO::FETCH_ASSOC);

        $estado = ($con1['per_estado'] == 1) ? 'Activo' : 'Innactivo';
        $hasta = isset($con1['per_hasta']) ? $con1['per_hasta'] : 'Actualmente';
				
				$card = '
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Persona</h3>
										</div>
										<div class="card-body table-responsive p-0">
											<table class="table table-sm">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nombre</th>
														<th>Apellido</th>
														<th>Cargo</th>
														<th>Fecha del cargo</th>
														<th>Telefono</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>'.$con1['per_cedula'].'</td>
														<td>'.$con1['per_nombre'].'</td>
														<td>'.$con1['per_apellido'].'</td>
														<td>'.$con1['car_des'].'</td>
														<td>'.$con1['per_desde'].' - '.$hasta.'</td>
														<td>'.$con1['per_telefono'].'</td>
														<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="card-body p-0">
											<table class="table table-sm">
												<thead>
													<tr>
														<th>Dependencia</th>
														<th>Direccion</th>
														<th>Correo</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>'.$con1['dep_des'].'</td>
														<td>'.$con1['per_direccion'].'</td>
														<td>'.$con1['per_correo'].'</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>';

			  return $card;

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsPersonas->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
  }