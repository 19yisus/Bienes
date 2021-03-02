<?php
	class clsDependencias extends Model{
		private $cod,$des,$nucleo;
		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->des = null;
			$this->nucleo = null;
		}
		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($cod,$des,$nucleo){
			$this->cod = (isset($cod)) ? ((is_numeric($cod) == true) ? $cod : NULL) : NULL;
			$this->des = $this->Limpiar($des);
			$this->nucleo = (isset($nucleo))? ((is_numeric($nucleo) == true) ? $nucleo : NULL) :  NULL;
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
        $con1 = $this->Query("SELECT * FROM dependencia WHERE dep_nucleo_cod = '$this->nucleo' 
        AND dep_des = '$this->des';")->fetch();

				if(!$con1){
					$sql = "INSERT INTO dependencia(dep_des,dep_nucleo_cod,dep_estado) VALUES(:den,:nucleo,'1');";
					$con = $this->Prepare($sql);

					$con -> bindParam(":den",$this->des);
					$con -> bindParam(":nucleo",$this->nucleo);
					$res = $con->execute();

					if ($res){
						return $this->MakeResponse(200, "Operacion exitosa");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida");
					}	
				}else{
					return $this->MakeResponse(400, "Operacion Fallida","La Dependencia ya existe");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsDependencias->Insert(), ERROR = ".$e->getMessage());
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
				 * Primero se comprueba que NO se duplique la informacion de otra dependencia
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
        $confirm = $this->Query("SELECT * FROM dependencia 
        WHERE dep_des = '$this->des' AND dep_nucleo_cod = '$this->nucleo'")->fetch();

				if(!$confirm){
					
					/**
					 * Primero se comprueba que el nucleo este activo
					 * @return array si hay datos
					 */
          $confirm2 = $this->Query("SELECT * FROM nucleo WHERE nuc_estado = '1' AND 
          nuc_cod = '$this->nucleo'")->fetch();

					if($confirm2){
            $con = $this->Prepare("UPDATE dependencia SET dep_des = :den, dep_nucleo_cod = :nu 
            WHERE dep_cod = :cod");
						
						$con -> bindParam(":den",$this->des);
						$con -> bindParam(":nu",$this->nucleo);
						$con -> bindParam(":cod",$this->cod);
						$con -> execute();

				 		if ($con->rowCount() > 0){
							return $this->MakeResponse(200, "Operacion Exitosa!");
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!","La dependencia no esta registrada");
						}
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!","El nucleo seleccionado esta innactivo");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Estas duplicando la informacion de otra dependencia");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsDependencias->Update(), ERROR = ".$e->getMessage());
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
				 * Primero se comprueba que si hay personas acivas en la dependencia
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
        $var1 = $this->Query("SELECT * FROM personas WHERE per_estado = '1' AND per_dep_cod = '$cod'")->fetch();
				/**
				 * se comprueba que si hay comprobantes activos en la dependencia
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
        $var2 = $this->Query("SELECT * FROM comprobantes WHERE com_estado = '1' AND com_dep_user = '$cod';")->fetch();
				/**
				 *se comprueba que el nucleo de la dependdencia este activo
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
        $var3 = $this->Query("SELECT * FROM nucleo INNER JOIN dependencia ON 
        dependencia.dep_nucleo_cod = nucleo.nuc_cod 
        WHERE dependencia.dep_cod = '$cod';")->fetch();
				
				if(!$var1 && !$var2){
					$con2 = $this->Query("SELECT * FROM dependencia WHERE dep_cod = '$cod';")->fetch();

					if($con2['dep_estado'] == 1){
					
						if($var3["nuc_estado"] == 1){
							
              $con3 = $this->Prepare("UPDATE dependencia SET dep_estado = '0' WHERE dep_cod = :cod");

							$con3 -> bindParam(":cod",   $cod);
							$con3 -> execute();

							if ($con3->rowCount() > 0){
								return $this->MakeResponse(200, "Operacion Exitosa!");
							}else{
								return $this->MakeResponse(400, "Operacion Fallida!");
							}						
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!, El nucleo esta desactivado");
						}

					}else if($con2['dep_estado'] == 0){
						
						if($var3['nuc_estado'] == 1){
              $con3 = $this->Prepare("UPDATE dependencia SET dep_estado = '1' WHERE dep_cod = :cod;");
							$con3 -> bindParam(":cod",   $cod);
							$con3 -> execute();

							if ($con3->rowCount() > 0){
								return $this->MakeResponse(200, "Operacion Exitosa!");
							}else{
								return $this->MakeResponse(400, "Operacion Fallida!");
							}	
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!","El nucleo de esta Dependencia seleccionada esta desactivada");
						}
					}				
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","La Dependencia esta en uso");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsDependencias->Delete, ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Consulta para consultar toda la informacion de una dependencia
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Prepare("SELECT * FROM dependencia WHERE dep_cod = :codigo");
				$con -> bindParam(":codigo",$id);

				$con -> execute();
				$res = $con->fetch(PDO::FETCH_ASSOC);

				if(gettype($res) == 'array'){
					$Dep = array(
						'Cod' => $id,
						'Des' => $res['dep_des'],
						'Nu' => $res['dep_nucleo_cod']
					);

					return $this->MakeResponse(200, "Operacion Exitosa!", $Dep);
				}else{
					return $this->MakeResponse(400, "El codigo de la dependencia es invalido");
				}			
				
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsDependencias->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Select_Nucleos
		 * lista los nucleos activos
		 * @return string html
		 */
		Public function Select_Nucleos(){
			$tipos = [
				'NU' => 'Nucleo',
				'EX' => 'Extension',
				'PR' => 'Programa'
			];

			try{
				$con = $this->Query("SELECT * FROM nucleo WHERE nuc_estado = '1' ;");
				$select = "<option value=''>Seleccione un valor</option>";

				while($res = $con->fetch(PDO::FETCH_ASSOC)){
					$tipo = $res['nuc_tipo_nucleo'];
					$select .= "<option value='".$res['nuc_cod']."'>".$res['nuc_des']." - ".$tipos[$tipo]."</option>";
        }

				return $select;			

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsDependencias->Select_Nucleo(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){
		
			$columnas = ['dep_cod','dep_estado','dep_des','nuc_des'];
			$encabezados = ['Codigo','Descripcion','Pertenece a','Estado','Opciones'];

			$arreglo = [
            	'table' => 'dependencia',
            	'control' => 'DependenciasController',
            	'actual' => $pagina,
            	'columns' => $columnas,
            	'cantColumns' => 4,
            	'encabezado' => $encabezados,
            	'btnEdLegend' => 'Esta dependencia no puede ser modificada',
            	'extraQuery' => 'INNER JOIN nucleo ON nucleo.nuc_cod = dependencia.dep_nucleo_cod',
				'extraSelect' => 'dependencia.dep_cod,
								dependencia.dep_estado,
								dependencia.dep_des,
								nucleo.nuc_des',
            	'sin' => [
            		''
            		]
            	];

      return $this->paginador($arreglo);
		}
		/**
		 * Function Listar para retornar un registro mas detallado de una dependencia de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){
			
			$SelectDep = "dependencia.dep_cod,dependencia.dep_des,nucleo.nuc_des,dependencia.dep_estado";
			$InnerJoinDep = "INNER JOIN nucleo ON nucleo.nuc_cod = dependencia.dep_nucleo_cod";
			$SelectPer = "
				personas.per_cedula,
				personas.per_nombre,
				personas.per_apellido,
				cargos.car_des,
				personas.per_direccion,
				personas.per_correo,
				personas.per_telefono,
				personas.per_desde,
				personas.per_hasta,
				personas.per_estado";

			$InnerJoinPer = "
			INNER JOIN dependencia ON dependencia.dep_cod = personas.per_dep_cod
			INNER JOIN cargos ON cargos.car_cod = personas.per_car_cod";

			try{
				$con1 = $this->Query("SELECT $SelectDep
				 FROM dependencia $InnerJoinDep WHERE dependencia.dep_cod = '$cod' ;")->fetch();

				$con2 = $this->Query("SELECT $SelectPer FROM personas $InnerJoinPer	WHERE dependencia.dep_cod = '$cod';")->fetchAll(PDO::FETCH_ASSOC);

				// $con3 = $this->db->conectar()->query("SELECT * FROM comprobantes COUNT(movimientos.cod_bien)
				// 	INNER JOIN movimientos ON movimientos.c_incorporacion = comprobantes.cod_comprobante WHERE comprobantes.dependencia_user = '".$cod."' ;")->fetch();

				$estado = ($con1['dep_estado'] == 1) ? 'Activo' : 'Innactivo';

				$card = '
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Dependencia</h3>
										</div>
										<div class="card-body table-responsive p-0">
											<table class="table table-sm">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nombre de la dependencia</th>
														<th>Nucleo</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>'.$con1["dep_cod"].'</td>
														<td>'.$con1["dep_des"].'</td>
														<td>'.$con1["nuc_des"].'</td>
														<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>';
				if(sizeof($con2) > 0){

					$i = 0;

					$card .= '		<div class="card">
				 						<div class="card-header">
				 							<h3 class="card-title">Encargado</h3>
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
														<th>correo</th>
														<th>telefono</th>
														<th>fecha del cargo</th>
														<th>Estado</th>
													</tr>
												</thead>
							        <tbody>';
					while($i < sizeof($con2)){
						
						$estado = ($con2[$i]['per_estado'] == 1) ? 'Activo' : 'Innactivo';
						$hasta = isset($con[$i]['per_hasta']) ? $con[$i]['per_hasta'] : 'Sigue';

						$card .= '				<tr>
						                   			<td>'.$con2[$i]["per_cedula"].'</td>
						                   			<td>'.$con2[$i]["per_nombre"].'</td>
							                   		<td>'.$con2[$i]["per_apellido"].'</td>
							                    	<td>'.$con2[$i]["car_des"].'</td>
								                    <td>'.$con2[$i]["per_direccion"].'</td>
								                    <td>'.$con2[$i]["per_correo"].'</td>
								                    <td>'.$con2[$i]["per_telefono"].'</td>
								                    <td>'.$con2[$i]["per_desde"].' - '.$hasta.' </td>
								                    <td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
						                   		</tr>';

						
						$i += 1;
					}
					
					$card .= '</tbody>';
				}else{
					$card .= '
					<div class="card">
						<div class="card-body p-2">
							<h4 class="text-center text-danger">Sin encargado asignado</h4>
						</div>
					</div>';
				}

				return $card;


			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsDependencias->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Id para imprimir el proximo codigo auto-incrementado de la tabla ingresada como string
		 * @return number [codigo]
		 */
		public function Id(){
			return $this->showCodIncrements('dep_cod','dependencia');
		}
	}