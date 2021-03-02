<?php 
	class clsMateriales extends model{
		private $bien,$material,$oldMaterial,$oldBeneficiado;

		public function __construct(){
			parent::__construct();
			$this->bien = null;
			$this->material = null;
			$this->oldBeneficiado = null;
			$this->oldMaterial = null;
		}

		public function setDatos($bien,$material, $oldMaterial, $oldBeneficiado){
			$this->bien = $this->Limpiar($bien); //Bien beneficiado
			$this->material = $this->Limpiar($material); //Material 
			$this->oldMaterial = isset($oldMaterial) && $oldMaterial != 'null' ? $this->Limpiar($oldMaterial) : null;
			$this->oldBeneficiado = isset($oldBeneficiado) && $oldBeneficiado != 'null' ? $this->Limpiar($oldBeneficiado) : null;
		}

		public function Asignar(){

			try{

				$con = $this->Prepare("UPDATE bien SET bien_link_bien = :bien WHERE bien_cod = :material ;");
				$con -> bindParam(":bien", $this->bien);
				$con -> bindParam(":material", $this->material);
				$res = $con -> execute();

				if($res){
					return $this->MakeResponse(200, "Operacion exitosa");
				}else{
					return $this->MakeResponse(400, "Operacion Fallida");
				}

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsMateriales->Asignar(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		public function Update(){

			try{

				if(is_null($this->oldBeneficiado)){				
					$con = $this->Query("SELECT bien_link_bien FROM bien WHERE bien_cod = '$this->oldMaterial' ;")->fetch();

					if(isset($con) && $con['bien_link_bien'] == $this->bien){
						$con2 = $this->Prepare("UPDATE bien SET bien_link_bien = null WHERE bien_cod = :Old_bien_material ;");
						$con2 -> bindParam(":Old_bien_material", $this->oldMaterial);
						$res = $con2 -> execute();

						if($res){
							return $this->Asignar();
						}
						return $this->MakeResponse(400, "Operacion Fallida");
					}

					return $this->MakeResponse(400, "Operacion Fallida");
				}else{
					$con = $this->Query("SELECT bien_link_bien FROM bien WHERE bien_cod = '$this->material' ;")->fetch();

					if(isset($con) && $con['bien_link_bien'] == $this->oldBeneficiado){
						$con2 = $this->Prepare("UPDATE bien SET bien_link_bien = :beneficiado WHERE bien_cod = :material ;");
						$con2 -> bindParam(":material", $this->material);
						$con2 -> bindParam(":beneficiado", $this->bien);
						$res = $con2 ->execute();

						if($res){
							return $this->MakeResponse(200, "Operacion exitosa");
						}
						return $this->MakeResponse(400, "Operacion Fallida");
					}
				}
			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsMateria->Update(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		public function Consulta($cod){

			try{

				$con = $this->Query("SELECT bien_link_bien,bien_des,bien_precio,bien_fecha_ingreso FROM bien WHERE 
				bien_cod = '$cod' ;")->fetch(PDO::FETCH_ASSOC);

				$Material = array(
					'Cod' => $cod,
					'Des' => $con['bien_des'],
					'Pre' => $con['bien_precio'],
					'Fecha' => $con['bien_fecha_ingreso']
				);

				$con2 = $this->Query("SELECT bien_des,bien_precio,bien_fecha_ingreso FROM bien WHERE 
				bien_cod = ".$con['bien_link_bien']." ;")->fetch(PDO::FETCH_ASSOC);

				$Bien = array(
					'Cod' => $con['bien_link_bien'],
					'Des' => $con2['bien_des'],
					'Pre' => $con2['bien_precio'],
					'Fecha' => $con2['bien_fecha_ingreso']
				);

				return [
					'Bien' => $Bien, 'Material' => $Material
				];

			}catch(PDOException $e){
				error_log("Error en la consulta::models/ClsMateriales->Consulta(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}

		public function Pag($pagina){

			$encabezados = ['Codigo','Descripcion','Categoria','Asignado al bien','operaciones'];
			$columnas = ['bien_cod','bien_estado','bien_des','cat_des','bien_link_bien'];

			$arreglo = [
        'table' => 'bien',
        'control' => 'MaterialesController',
        'actual' => $pagina,
        'columns' => $columnas,
        'cantColumns' => 5,
        'encabezado' => $encabezados,
        'btnEdLegend' => 'Este Material no puede ser modificado',
        'extraQuery' => 'INNER JOIN clasificacion ON clasificacion.cla_cod = bien.bien_clasificacion_cod 
					INNER JOIN categoria ON categoria.cat_cod = clasificacion.cla_cat_cod
					WHERE clasificacion.cla_cat_cod = "MA" AND bien.bien_link_bien IS NOT NULL ',

				'extraSelect' => 'bien.bien_cod,bien.bien_link_bien,bien.bien_des,categoria.cat_des,bien.bien_estado',
				'sin' => ['estado','consul']
      ];
			return $this->paginador($arreglo);

		}

		public function ModalAsign(array $tipo){
			
			if($tipo[0] == 'Materiales'){

				$encabezados = ['Codigo','Descripcion','Categoria','Estado','Opciones'];
				$columnas = ['bien_cod','bien_estado','bien_des','cat_des',];

				$arreglo = [
					'table' => 'bien',
					'control' => 'MaterialesController',
					'actual' => $tipo[1],
					'columns' => $columnas,
					'cantColumns' => 4,
					'encabezado' => $encabezados,
					'btnEdLegend' => '',
					'extraQuery' => 'INNER JOIN clasificacion ON clasificacion.cla_cod = bien.bien_clasificacion_cod 
						INNER JOIN categoria ON categoria.cat_cod = clasificacion.cla_cat_cod
						WHERE clasificacion.cla_cat_cod = "MA" AND bien.bien_link_bien IS NULL',
					'extraSelect' => '
						bien.bien_cod,
						bien.bien_des,
						categoria.cat_des,
						bien.bien_estado',
					'sin' => [
						
						],
					'btnMaterial' => true,
					'tipo' => 'Materiales'
					];

			}else{

				$encabezados = ['Codigo','Descripcion','Categoria','Estado','Opciones'];
				$columnas = ['bien_cod','bien_estado','bien_des','cat_des',];
				
				$arreglo = [
					'table' => 'bien',
					'control' => 'MaterialesController',
					'actual' => $tipo[1],
					'columns' => $columnas,
					'cantColumns' => 4,
					'encabezado' => $encabezados,
					'btnEdLegend' => '',
					'extraQuery' => 'INNER JOIN clasificacion ON clasificacion.cla_cod = bien.bien_clasificacion_cod 
						INNER JOIN categoria ON categoria.cat_cod = clasificacion.cla_cat_cod
						WHERE clasificacion.cla_cat_cod = "EL" OR clasificacion.cla_cat_cod = "TP" ',
					'extraSelect' => '
						bien.bien_cod,
						bien.bien_des,
						categoria.'.'cat_des'.',
						bien.bien_estado',
					'sin' => [
						
						],
					'btnMaterial' => true,
					'tipo' => 'Bienes'
					];
			}

			return $this->paginador($arreglo);
		}

		public function SearchById($cod){

			try{
				$Select = "bien_cod,bien_des,bien_precio,bien_fecha_ingreso";
				$con = $this->Query("SELECT $Select FROM bien WHERE bien_cod = $cod ;");
				
				$res = $con->fetch(PDO::FETCH_ASSOC);

				return [
					'Cod' => $res['bien_cod'],
					'Des' => $res['bien_des'],
					'Pre' => $res['bien_precio'],
					'Fecha' => $res['bien_fecha_ingreso']
				];

			}catch(PDOEXception $e){
				error_log("Error en la consulta::models/ClsMateriales->SearchById(), ERROR = ".$e->getMessage());
				return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
			}
		}
	}