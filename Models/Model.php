<?php
  abstract class Model extends DB{
    public $session;
    protected $view;

    public function __construct(){
      parent::__construct();
      $this->session = new Session();
      $this->view = new View();
    } 

    protected function Query($sql){
      return $this->Conectar()->query($sql);
    }

    protected function Prepare($sql){
      return $this->Conectar()->prepare($sql);
    }

    protected function Exec($con){
      try{
        return $con->execute();
      }catch(PDOEXception $e){
        print_r("Error = ".$e->getMessages());
        return false;
      }
    }

    public function MakeResponse($status, $respuesta, $datos = ''){
      return ['status' => $status, 'respuesta' => $respuesta, 'datos' => $datos];
    }

    protected function Encript($password){
      return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    /**
     * Funtion Limpiar
     * Limpia las cadenas de texto y valores numericos que puedan contener caracteres no deseados
     * @param var
     * @return var
     */
    protected function Limpiar($cadena){
      $cadena = stripslashes($cadena);
      $cadena = str_ireplace("SELECT * FROM","",$cadena);
      $cadena = str_ireplace("DELETE * FROM","",$cadena);
      $cadena = str_ireplace("INSERT INTO","",$cadena);
      $cadena = str_ireplace("[","",$cadena);
      $cadena = str_ireplace("]","",$cadena);
      $cadena = str_ireplace("(","",$cadena);
      $cadena = str_ireplace(")","",$cadena);
      $cadena = str_ireplace("{","",$cadena);
      $cadena = str_ireplace("_","",$cadena);
      $cadena = str_ireplace("-","",$cadena);
      $cadena = str_ireplace("}","",$cadena);
      $cadena = str_ireplace("==","",$cadena);
      $cadena = str_ireplace("=","",$cadena);
      $cadena = str_ireplace("<script>","",$cadena);
      $cadena = str_ireplace("<script src= >","",$cadena);
      $cadena = str_ireplace("src=","",$cadena);
          
      if(!is_numeric($cadena)){
        $cadena = strtoupper($cadena);
      }else{
        $cadena = str_ireplace(" ","",$cadena);
      }
      return $cadena;
    }

    /**
     * Function ShowCodIncrements
     * Consulta el codigo mas alto de una tabla de la base de datos y le suma 1 para representar el proximo codigo
     * @param primaryKey
     * @param TableName
     * @return number 
     */
    public function showCodIncrements($primariKey,$table){

      try{

          $con = $this->Query("SELECT MAX($primariKey) AS maximo FROM $table ;")->fetch();
          
          $res = $con['maximo'] + 1;
          return $res;

      }catch(PDOException $e){
        error_log("Error en la consulta::models/ModelBase->showCodINcrements(), ERROR = ".$e->getMessage());
        return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
      }
    }

    /**
   * /
   * @param  array  $array Datos necesarios para realizar la consulta de cada modelo
   * Todos apadtados a una sola funcion de paginador
   * @return String        Pagina html con el paginador para todos los modelos
   */
    public function paginador(array $array){
      /**
       * Variables locales para el paginador
       * @var integer
       */
      $nLotes = 5;
      $bodyTable = '';
      $Paginas = '';


      /**
       * [$array description]
       * @var [array] => variables globales para cada modelo
       * @var  $array['table'] => Nombre de la tabla a consultar
       * @var  $array['actual'] => Pagina actual del paginador
       * @var  $array['columns'] => Columnas del paginador
       * @var  $array['cantColumns'] => Cantidad de columnas
       * @var  $array[''encabezado]  => Encabezados del paginador
       * @var  $array['extraQuery'] => Comando Sql extra para la consulta
       * @var  $array['sin'] => Columnas que no deben de aparecer en el paginador
       * @var  $array['extraSelect'] Columnas a consulas en la db (opcional)
       */
      $table = $array['table'];
      $control = $array['control'];
      $PaginaActual = $array['actual'];
      $columns = $array['columns'];
      $cantColumnsTable = $array['cantColumns'];
      $encabezado = $array['encabezado'];
      $extra = isset($array['extraQuery']) ? $array['extraQuery'] : '';
      $select = isset($array['extraSelect']) ? $array['extraSelect'] : '*';
      $sin = isset($array['sin']) ? $array['sin'] : '*';
      $ifMaterialesbtn = isset($array['btnMaterial']) ? true : false;
      $tipo = isset($array['tipo']) ? $array['tipo'] : null;

      /**
       * [$bted_Legend description]
       * @var string
       * Titles para los botones del catalogo
       */
      $btn_edit_title1 = "title = 'Boton para Modificar'";
      $btn_del_title1 = "title = 'Boton para Desactivar'";
      $btn_con_title1 = "title = 'Boton para consultar'";
      $btn_edit_title2 = "title = '".$array['btnEdLegend']."' ";

      try{
        $con = $this->Query("SELECT COUNT(*) AS total FROM ".$table." ".$extra." ;")->fetch();
        $TotalRes = $con['total'];
        $nPaginas = ceil($TotalRes / $nLotes);
        
        $limiteLinks = 0;
        // $control = ucwords($table);
        
        if(!$ifMaterialesbtn){
            

            if($PaginaActual > 1){
                $infoPadinador = "'$control',".($PaginaActual - 1)."";

                $Paginas = '<li class="paginate_button page-item previous">
                         <a href="#" onclick="Paginador('.$infoPadinador.');" class="page-link">Anterior</a></li>';
            }

            for($i = $PaginaActual; $i <= $nPaginas;$i++){

                $limiteLinks = 1 + $limiteLinks;

                if($limiteLinks == 20){
                    break;
                }
                $infoPadinador = "'$control', $i";

                if($i == $PaginaActual){
                    $Paginas = $Paginas.'<li class="paginate_button page-item active">
                    <a href="#" onclick="Paginador('.$infoPadinador.');" class="page-link">'.$i.'</a></li>';
                }else{
                    $Paginas = $Paginas.'<li class="paginate_button page-item">
                    <a href="#" onclick="Paginador('.$infoPadinador.');" class="page-link">'.$i.'</a></li>';
                }
            }

            $infoPadinador = "'$control',".($PaginaActual + 1)."";

            if($PaginaActual < $nPaginas){
                $Paginas = $Paginas.'<li class="paginate_button page-item next">
                    <a href="#" onclick="Paginador('.$infoPadinador.');" class="page-link">Siguiente</a></li>';
            }
            
        }else{
                                
            if($PaginaActual > 1){
              $btnP = "ModalBienes('$tipo',".($PaginaActual - 1 ).");";
              $Paginas = '<li class="paginate_button page-item previous"><a href="#" onclick="'.$btnP.'" class="page-link">Anterior</a></li>';
            }                  

            for($i = $PaginaActual; $i <= $nPaginas;$i++){

              $limiteLinks = 1 + $limiteLinks;
              if($limiteLinks == 20){
                break;
              }
              
              $btnVar = "ModalBienes('$tipo',".($i).");";
              if($i == $PaginaActual){
                  $Paginas = $Paginas.'
                  <li class="paginate_button page-item active">
                    <a href="#" onclick="'.$btnVar.'" class="page-link">'.$i.'</a>
                  </li>';
              }else{
                $Paginas = $Paginas.'
                  <li class="paginate_button page-item ">
                    <a href="#" onclick="'.$btnVar.'" class="page-link">'.$i.'</a>
                  </li>';
              }
            }

            if($PaginaActual < $nPaginas){

                $btnN = "ModalBienes('$tipo',".($PaginaActual + 1 ).");";
                $Paginas = $Paginas.'
                  <li class="paginate_button page-item next" id="example1_next">
                    <a href="#" onclick="'.$btnN.'" class="page-link">Siguiente</a>
                  </li>';
            }
            
        }

        if($PaginaActual <= 1){
            $limite = 0;
        }else{
            $limite = $nLotes * ($PaginaActual-1);
        }
        
        if(constant("DBHOST") == "mysql"){
            $sql = "SELECT $select FROM $table $extra LIMIT :limite,:lotes  ;";
        }else{
            $sql = "SELECT $select FROM $table $extra  OFFSET :limite LIMIT :lotes ;";
        }

        $con2 = $this->Prepare($sql);
        $con2 -> execute([':limite' => $limite, ':lotes' => $nLotes]);
        $datos = $con2->fetchAll();
                
        if(isset($datos[0])){

            $bodyTable = '
            
              <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                        <thead>
                          <tr role="row">';


            foreach($encabezado as $head){
                $bodyTable .= '<th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" style="width: 50px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">
                              '.$head.'
                            </th>';
            }

            $bodyTable .= '
                          </thead>
                      <tbody>';

            foreach($datos as $row){
                
                $column = '';

                $bodyTable .='
                    <tr role="row" class="odd" >
                      <td class="sorting_1">'.$row[$columns[0]].'</td>';

                    if($cantColumnsTable == 2 || in_array('estado', $sin) && $cantColumnsTable == 3){
                      $ciclo = 1;
                    }else{
                      $ciclo = 2;
                    }

                    for($i = $ciclo; $i < $cantColumnsTable; $i++){
                        $column .= '<td>'.$row[$columns[$i]].'</td>';
                    }
                
                if(in_array('estado',$sin)){

                    $estado = '';
                    $boton_eliminar = '';
                    $modelEstado = 1;


                }else{

                  $modelEstado = $row[$columns[1]];

                    $estado = '<td>'.(($modelEstado == 1) ? "Activo" : "Inactivo").'</td>';
                    $boton_eliminar = '
                      <button class="btn btn-sm btn-'.(($modelEstado == 1) ? "success" : "danger").'"
                          onclick="bDelet(this);" data-form="form-del-'.$row[$columns[0]].'" data-dismiss="modal" '.$btn_del_title1.' >
                        <i class="fas fa-power-off"></i>
                      </button>
                    ';
                }

                $statusBtnEdit = (in_array('estado',$columns) ? $row[$columns[1]] : 1);
                
                //Si no es material
                if(!$ifMaterialesbtn){
                    
                  $btnList = '
                    <button class="btn btn-sm btn-default" data-control="'.$control.'" onclick="bConsul(this);" data-codigo="'.$row[$columns[0]].'" 
                      data-toggle="modal" data-target="#ModalConsultar" data-dismiss="modal"  '.$btn_con_title1.'>
                        <i class="fas fa-list"></i>
                    </button>';

                  $btnEdit = '
                    <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="'.$row[$columns[0]].'"
                        data-toggle="modal" data-target="#ModalEdit" 
                        '.(($modelEstado == 1) ? "" : "disabled").' '.(($modelEstado == 1) ? $btn_edit_title1 : $btn_edit_title2).'>
                      <i class="fas fa-edit"></i>
                    </button>';
                    
                    if(!in_array('options', $sin)){
                      $td = '
                        <td>
                          <form name="form-del-'.$row[$columns[0]].'" id="form-del-'.$row[$columns[0]].'">
                            <input type="hidden" name="Cod" value="'.$row[$columns[0]].'">
                          </form>
                          <div class="btn-group m-0 p-0">
                            '.$btnEdit.' 
                            '.$boton_eliminar.' 
                            '.((in_array('consul',$sin)) ? "" : $btnList ).'
                          </div>
                        </td>
                      </tr>';
                    }else{
                      $td = '</tr>';
                    }

                    $bodyTable .= $column.$estado.$td;

                        
                }else{
                    $bodyTable .= $column.' 
                    '.$estado.'
                    <td>
                        <div class="btn-group m-0 p-0">
                            <button class="btn btn-sm btn-info" onclick="AddForm(this);" data-form="'.$tipo.'" data-codigo = "'.$row[$columns[0]].'"
                                data-dismiss="modal" >
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </div>
                        </td>
                    </tr>';

                }
            }

            $bodyTable .='
                      </tbody>
                    </table>
                  </div>
                </div>
                  </div>
                    <div class="row">

                      <div class="col-sm-12 col-md-9 ml-2">
                        <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                          <ul class="pagination">'.$Paginas.'
                          </ul>
                        </div>
                      </div>
                    </div>
                </div>
            ';
        }else{
            $bodyTable = "
            <div class='m-3 p-3' >
                <h3 class='text-red text-center' >No hay registros disponibles</h3>
            </div>
            ";
        }

        return $bodyTable;
      }catch(PDOException $e){
        error_log("Error en la consulta::models/ModelBase->Paginador(), ERROR = ".$e->getMessage());
        return $this->MakeResponse(400, "Error desconocido, Revisar php-error.log");
      }
    }
  }