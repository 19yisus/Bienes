<?php 
	/**
	 * Las clases ClsModelos y CLsRazas son clases duplicadas porque la nomenclatura de los controladores lo requeria asi
	 * ambas clases son casi identicas y consultan a la misma tabla modelos en la base de datos, sin embargo
	 * estos modelos estan orientados a modelos(objetos) y razas(animales) respectivamente
	 */
	class clsRazas extends Model{
		private $cod,$Raza,$Esp;
		/**
		 * Construct 
		 * Inicializa las variables privadas del modelo en null
		 */
		public function __construct(){
			parent::__construct();
			$this->cod = null;
			$this->Raza = null;
			$this->Esp = null;
		}
		/**
		 * Funcion setDatos para Definir las variables privadas del modelo
		 */
		public function setDatos($cod,$Raza,$Esp){
			$this->cod = (isset($cod)) ? $cod : NULL;
			$this->Raza = $this->Limpiar($Raza);
			$this->Esp = $this->Limpiar($Esp);
		}
		/**
		 * Funcion Insert Para Guardar los datos en la base de datos
		 * @return array
		 */
		public function Insert(){

			try{

				/**
				 * Primero se comprueba si existe una raza con el mismo nombre ingresado
				 * para evitar la duplicidad de nombres
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM modelos WHERE mod_des = '$this->Raza';")->fetch();

				if(!$confirm){

					$con = $this->Prepare("INSERT INTO modelos(mod_des,mod_marca_cod,mod_estado) VALUES(:Raza,:Esp,'1');");

					$con -> bindParam(":Raza", $this->Raza);
					$con -> bindParam(":Esp", $this->Esp);
					$res = $con->execute();

					if ($res){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallid!","La Raza: '$this->Raza' ya esta registrada");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsRazas->Insert(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Update Para Actualizar los datos de un modelo
		 * @return array
		 */
		public function Update(){

			try{
				/**
				 * Primero se comprueba que NO se duplique la informacion de otra raza
				 * al momento de actualizar la informacion
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
				$confirm = $this->Query("SELECT * FROM modelos WHERE mod_des = '$this->Raza' AND mod_marca_cod = '$this->Esp';")->fetch();

				if(!$confirm){
					$con = $this->Prepare("UPDATE modelos SET mod_des = :Raza, mod_marca_cod = :Esp WHERE mod_cod = :cod;");

					$con -> bindParam(":cod", $this->cod);
					$con -> bindParam(":Raza", $this->Raza);
					$con -> bindParam(":Esp", $this->Esp);

					$con -> execute();

					if ($con->rowCount() > 0){
						return $this->MakeResponse(200, "Operacion Exitosa!");
					}else{
						return $this->MakeResponse(400, "Operacion Fallida!","La raza no esta registrada");
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","Estas duplicando la informacion de otra Raza de la misma Especie");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsRazas->Update(), ERROR = ".$e->getMessage());
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
				 * Primero se comprueba que alla bienes activos que esten usando esta raza
				 * @return array si hay datos
				 * @return boolean si no hay datos
				 */
        $confirm = $this->Query("SELECT * FROM bien WHERE bien_estado = '1' AND bien_mod_cod = '$cod';")->fetch();
				
				if(!$confirm){
          $con1 = $this->Query("SELECT mod_estado FROM modelos WHERE mod_cod = '$cod' ;")->fetch();
          $confirm2 = $this->Query("SELECT mar_estado FROM marcas 
          INNER JOIN modelos ON modelos.mod_marca_cod = marcas.mar_cod WHERE modelos.mod_cod = '$cod';")->fetch();
          
					if($con1['mod_estado'] == 1){
						$con = $this->Prepare("UPDATE modelos SET mod_estado = '0' WHERE mod_cod = :cod;");	
						$con -> bindParam(":cod",   $cod);
						$con->execute();

						if ($con->rowCount() > 0){
							return $this->MakeResponse(200, "Operacion Exitosa!");
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!");
						}
					}else{

						if($confirm2['mar_estado'] == 1){
							$con = $this->Prepare("UPDATE modelos SET mod_estado = '1' WHERE mod_cod = :cod;");
							$con -> bindParam(":cod",   $cod);
							$con->execute();

							if ($con->rowCount() > 0){
								return $this->MakeResponse(200, "Operacion Exitosa!");
							}else{
								return $this->MakeResponse(400, "Operacion Fallida!");
							}
						}else{
							return $this->MakeResponse(400, "Operacion Fallida!","La Especie de esta Raza esta innactiva");
						}	
					}
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","La Raza esta siendo utilizada");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsRazas->Delete(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Consulta para consultar toda la informacion de una raza
		 * @return array
		 */
		public function Consulta($id){

			try{
				$con = $this->Prepare("SELECT * FROM modelos WHERE mod_cod = :cod;");
				$con -> bindParam(":cod",$id);

				$con -> execute();
				$res = $con->fetch(PDO::FETCH_ASSOC);
				
				if(gettype($res) == 'array'){

					$Raza = array(
						'Cod' => $res['mod_cod'],
						'Des' => $res['mod_des'],
						'Raza' => $res['mod_marca_cod']
					);

					return $this->MakeResponse(200, "Operacion Exitosa!", $Raza);
				}else{
					return $this->MakeResponse(400, "Operacion Fallida!","El codigo de la Raza es invalido");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsRazas->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Select_Marcas
		 * lista los Marcas activos
		 * @return string html
		 */
		Public function Select_Especies(){
      try{
				$con = $this->Query("SELECT * FROM marcas WHERE mar_estado = '1' AND mar_categoria_cod = 'BS';");
				$select = "<option value=''>Seleccione un valor</option>";

				while($res = $con->fetch(PDO::FETCH_ASSOC)){
					$select .= "<option value='".$res['mar_cod']."'>".$res['mar_des']."</option>";
        }
				return $select;			

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsRazas->Select_especies(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Funcion Pag para retornar el paginador creado a partir del modelo principal
		 * (Esta funcion solo requiere un array con la informacion para realizar dichas consultas)
		 * @return string html 
		 */
		public function Pag($pagina){
			
			$encabezados = ['Codigo','Descripcion','Especie','Estado','Opciones'];
		  $columnas = ['mod_cod','mod_estado','mod_des','mar_des'];

		  $arreglo = [
        'table' => 'modelos',
        'control' => 'RazasController',
        'actual' => $pagina,
        'columns' => $columnas,
        'cantColumns' => 4,
        'encabezado' => $encabezados,
        'btnEdLegend' => 'Este Raza no puede ser modificado',
        'extraQuery' => "INNER JOIN marcas ON marcas.mar_cod = modelos.mod_marca_cod WHERE marcas.mar_categoria_cod = 'BS' ",
        'extraSelect' => 'modelos.mod_cod,modelos.mod_des,marcas.mar_des,modelos.mod_estado',
        'sin' => ['']
			];
			   
		  return $this->paginador($arreglo);
		}
		public function All(){

			try{
				$data = $this->Query("SELECT modelos.mod_cod,modelos.mod_des,marcas.mar_des,modelos.mod_estado
				FROM modelos INNER JOIN marcas ON marcas.mar_cod = modelos.mod_marca_cod 
				WHERE marcas.mar_categoria_cod = 'BS' ;")->fetchAll(PDO::FETCH_ASSOC);

				return ['data' => $data];

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsNucleo->All(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Listar para retornar un registro mas detallado de un modelo de forma mas grafica
		 * @return string html
		 */
		public function Listar($cod){
			$SelectModelos = "modelos.mod_cod,modelos.mod_des,marcas.mar_des,modelos.mod_estado";
			$InnerJoinModelos = "INNER JOIN marcas ON marcas.mar_cod = modelos.mod_marca_cod";

			try{

				$con1 = $this->Query("SELECT $SelectModelos FROM modelos $InnerJoinModelos WHERE modelos.mod_cod = '$cod' ;")->fetch();

				$con2 = $this->Query("SELECT COUNT(bien_cod) AS total FROM bien WHERE bien_estado = '1' AND bien_mod_cod = '$cod' ")->fetch();
				//$con2 = $this->Query("SELECT * FROM dependencia WHERE nucleo_cod = '".$cod."' ;")->fetchAll();

				$estado = ($con1['mod_estado'] == 1) ? 'Activo' : 'Innactivo';

				$card = '
									<div class="card">
										<div class="card-header">
											<h3 class="card-title">Razas</h3>
										</div>
										<div class="card-body table-responsive p-0">
											<table class="table table-sm">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nombre de la Raza</th>
														<th>Especie</th>
														<th>Nº bienes con esta Raza</th>
														<th>Estado</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>'.$con1["mod_cod"].'</td>
														<td>'.$con1["mod_des"].'</td>
														<td>'.$con1["mar_des"].'</td>
														<td>'.$con2["total"].'</td>
														<td class="text-'.(($estado == "Activo") ? "success" : "danger").'" >'.$estado.'</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>';

				return $card;
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsRazas->Listar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
		/**
		 * Function Id para imprimir el proximo codigo auto-incrementado de la tabla ingresada como string
		 * @return number [codigo]
		 */
		public function Id(){
			return $this->showCodIncrements('mod_cod','modelos');
		}

	}
