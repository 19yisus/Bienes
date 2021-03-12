$(document).ready( () =>{
	if($('#catalogo_table').is(":visible")){
		catalogo = 'catalogo_table';
	}else{
		catalogo = 'catalogo_table2';
	}

	$(`#${catalogo}`).DataTable({
    responsive: true, lengthChange: true, autoWidth: true,
    ajax:{
      url: Paginador_url,
      dataSrc: 'data',
    },
    columns:[
      {data: 'bien_cod'},
      {data: 'bien_des'},
      {data: 'cat_des'},
      {data: 'bien_fecha_ingreso'},
      {data: 'bien_precio'},
      {data: 'bien_estado', render: function(data){ return (data == 1) ? 'Activo': 'Innactivo'; }},
      {defaultContent: "",
      render: function(data, type, row, meta){
        let estado = (row.bien_estado == 0) ? 'disabled': '';
        let title_edit = (row.bien_estado == 0) ? 'Este Bien no puede ser modificado': 'Modificar';
        let title_desac = (row.bien_estado == 0) ? 'Activar':'Desactivar';
        let clase = (row.bien_estado == 0) ? 'danger':'success';
        let btn = `
          <form name="form-del-${row.bien_cod}" id="form-del-${row.bien_cod}">
            <input type="hidden" name="Cod" value="${row.bien_cod}">
          </form>
          <div class='btn-group'>
            <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.bien_cod}"
              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-${clase}" onclick="bDelet(this);" id="bDelete" data-form="form-del-${row.bien_cod}" 
            data-dismiss="modal" title="${title_desac}">
              <i class="fas fa-power-off"></i>
            </button>
            <button class="btn btn-sm btn-default" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.bien_cod}"
              data-toggle="modal" data-target="#ModalConsultar" data-dismiss="modal"  title="Consultar">
              <i class="fas fa-list"></i>
            </button>
           </div>`;
        return btn;
      }
      }],
    language:{
      url: `${host_url}/Views/Js/DataTables.config.json`
    }
  	});

	$("input[name='Fecbien']").each( (index,element)=>{
		$(`#${element.id}`).attr('title', `Ingrese una fecha valida (${$("input[name='Fecbien']").attr('min')} - ${$("input[name='Fecbien']").attr('max')})`);
	});

	$.validator.addMethod('valida_fecha', (value, element) =>{
		
    if(value >= element.min && value <= element.max){
      return true;
    }
    return false;
  }, "La fecha ingresada es invalida" );

	$.validator.addMethod('decimal', function(value, element) {
		return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
	}, "Please enter a correct number, format 0.00");

	$.validator.setDefaults({
		onsubmit: true,
		debug: true,
	    errorClass: 'invalid-feedback',
	    highlight: function(element) {
	      $(element)
	        .closest('.form-group')
	        .removeClass('has-success')
	        .addClass('has-error');
	    },
	    unhighlight: function(element) {
	      $(element)
	        .closest('.form-group')
	        .removeClass('has-error')
	        .addClass('has-success');
	    },			   
	    errorPlacement: function (error, element) {
	      if (element.prop('type') === 'checkbox') {
	        error.insertAfter(element.parent());
	      }else {
	      	// var id = element[0].attributes.id.value;
	      	// console.log( $(`#${id}`)[0].attr('aria-invalid'))
	      	// $(element).attr('aria-invalid', true);
	        error.insertAfter(element);
	      }

				if(element.parent().parent().parent().parent()[0].id == 'formulario'){
					$('#formulario').addClass('was-validated');
				}else{
					$('#FormEdit').addClass('was-validated');
				}
	    }
	});

	$('#FormEdit').validate({
		rules:{
			Codbien:{
				required: true,
				minlength: 7,
				maxlength:7,
				number: true,
			},
			Desbien:{
				required: true,
				minlength: 2,
				maxlength:90,
			},
			Valbien:{
				required: true,
				min: 1,
				minlength: 1,
				maxlength:12,
				decimal: true,
			},
			Fecbien:{
				required: true,
				valida_fecha: true,
			},
			Marca:{
				required: true,
			},
			Modelo:{
				required: true,
			},
			Color:{
				required: true,
			},
			Catalogo:{
				required: true,
				minlength: 12,
				maxlength: 12,
				number: true,
			},
			Serial:{
				required: true,
				minlength: 4,
				maxlength: 20,
			},
			Depre:{
				required: true,
				min: 1,
				minlength: 1,
				maxlength: 12,
				decimal: true,
			},
			Placa:{
				required: true,
				minlength: 6,
				maxlength: 6,
			},
			Anio:{
				required: true,
				minlength: 4,
				maxlength: 4,
				number: true,
				valida_fecha: true,
			},
			Terreno:{
				required: true,
				minlength: 10,
				maxlength: 120,
			},
			Esp:{
				required: true,
			},
			Raza:{
				required: true,
			},
			Peso:{
				required: true,
				minlength: 2,
				maxlength: 6,
				min: 1,
				decimal: true,
			},
			Sexo:{
				required: true,
			}
		},
		messages:{
			Codbien:{
				required: "No hay codigo del bien",
				minlength: "El codigo tiene 7 caracteres de longitud",
				maxlength: "El codigo tiene 7 caracteres de longitud",
				number: "Solo se permiten numeros",
			},
			Desbien:{
				required: "Ingrese la descripcion del bien",
				minlength: "Ingrese al menos 2 caracteres",
				maxlength: "Ingrese menos de 90 caracteres",
				pattern: "Solo se permiten letras",
			},
			Valbien:{
				required: "Ingrese el valor del bien",
				minlength: "Minimo 1 caracter numerico",
				maxlength: "NO puedes ingresar mas de 12 caracteres",
				min: "Ingrese una precio mayor a 0",
				decimal: "Solo se permiten caracteres decimales",
			},
			Fecbien:{
				required: "Ingrese la fecha de registro",
				valida_fecha: "La fecha es invalida",
			},
			Cantbien:{
				required: "Debe de ingresar la cantidad de bienes",
				minlength: "Minimo 1 caracter numerico",
				maxlength: "Maximo de 3 caracteres numericos",
				min: "Ingrese un numero mayor a cero",
				number: "Solo se permiten numeros",
			},
			Marca:{
				required: "Seleccione la marca del bien",
			},
			Modelo:{
				required: "Seleccione el modelo del bien",
			},
			Color:{
				required: "Seleccione un color para el bien",
			},
			Catalogo:{
				required: "Debe de ingresar el catalogo del bien",
				minlength: "Debe de ingresar 12 caracteres",
				maxlength: "NO puedes ingresar mas de 12 caracteres",
				pattern: "Solo se permiten 12 caracteres numericos",
			},
			Serial:{
				required: "Debe de ingresar el serial del bien",
				minlength: "Debe de ingresar al menos 4 caracteres",
				maxlength: "NO puedes ingresar mas de 20 caracteres",
			},
			Depre:{
				required: "Debe de ingresar la deprecion del bien",
				minlength: "Debe de ingresar al menos 1 caracter numerico",
				maxlength: "No ingreses mas de 12 caracteres",
				decimal: "Solo se permiten caracteres decimales",
				min: "Ingrese una depreciacion mayor a 0",
			},
			Placa:{
				required: "Debe de ingresar la placa del transporte",
				minlength: "Debe de ingresar los 6 caracteres del transporte",
				maxlength: "Debe de ingresar los 6 caracteres del transporte",
			},
			Anio:{
				required: "Ingrese el año de este transporte",
				minlength: "Debe de ingresar 4 caracteres numericos",
				maxlength: "Debe de ingresar 4 caracteres numericos",
				number: "Solo se permiten numeros",
				max: 'El año ingresado es invalido',
				min: 'Minimo hasta el año 1990',
			},
			Terreno:{
				required: "Debe de ingresar obsevacion del semoviente",
				minlength: "Ingrese minimo 10 caracteres",
				maxlength: "Ingrese menos de 120 caracteres",
			},
			Esp:{
				required: "Seleccione la Especie del semoviente",
			},
			Raza:{
				required: "Seleccione la Raza del semoviente",
			},
			Peso:{
				required: "Debe de ingresar el peso",
				minlength: "Debe de ingresar al menos 2 caracter numerico",
				maxlength: "El peso ingresado es invalido",
				decimal: "Solo se permiten decimales",
				min: "Debe de ingresar una cantidad mayor a 0",
			},
			Sexo:{
				required: "Debe se seleccionar el sexo del semoviente",
			},
		}
	});
	
	$('#formulario').validate({
		rules:{
			Tbien:{
				required: true,
			},
			Clbien:{
				required: true,
			},
			Codbien:{
				required: true,
				minlength: 7,
				maxlength:7,
				number: true,
			},
			Desbien:{
				required: true,
				minlength: 2,
				maxlength:90,
			},
			Valbien:{
				required: true,
				minlength: 1,
				maxlength:12,
				min: 1,
				decimal: true,
			},
			Fecbien:{
				required: true,
				valida_fecha: true,
			},
			Cantbien:{
				required: true,
				minlength:1,
				maxlength:3,
				min: 1,
				number: true,
			},
			Marca:{
				required: true,
			},
			Modelo:{
				required: true,
			},
			Color:{
				required: true,
			},
			Catalogo:{
				required: true,
				minlength: 12,
				maxlength: 12,
			},
			Serial:{
				required: true,
				minlength: 4,
				maxlength: 20,
			},
			Depre:{
				required: true,
				min: 1,
				minlength: 1,
				maxlength: 12,
				decimal: true,
			},
			Placa:{
				required: true,
				minlength: 6,
				maxlength: 6,
			},
			Anio:{
				required: true,
				minlength: 4,
				maxlength: 4,
				number: true,
				valida_fecha: true,
			},
			Terreno:{
				required: true,
				minlength: 10,
				maxlength: 120,
			},
			Esp:{
				required: true,
			},
			Raza:{
				required: true,
			},
			Peso:{
				required: true,
				minlength: 2,
				maxlength: 6,
				min: 1,
				decimal: true,
			},
			Sexo:{
				required: true,
			}
		},
		messages:{
			Tbien:{
				required: "Seleccione el tipo de bien",
			},
			Clbien:{
				required: "Seleccione la clasificacion del bien",
			},
			Codbien:{
				required: "No hay codigo del bien",
				minlength: "El codigo tiene 7 caracteres de longitud",
				maxlength: "El codigo tiene 7 caracteres de longitud",
				number: "Solo se permiten numeros",
			},
			Desbien:{
				required: "Ingrese la descripcion del bien",
				minlength: "Ingrese al menos 2 caracteres",
				maxlength: "Ingrese menos de 90 caracteres",
				pattern: "Solo se permiten letras",
			},
			Valbien:{
				required: "Ingrese el valor del bien",
				minlength: "Minimo 1 caracter numerico",
				maxlength: "NO puedes ingresar mas de 12 caracteres",
				min: "Ingrese una precio mayor a 0",
				deciam: "Solo se permiten valores decimales",
			},
			Fecbien:{
				required: "Ingrese la fecha de registro",
				valida_fecha: "La fecha es invalida",
			},
			Cantbien:{
				required: "Debe de ingresar la cantidad de bienes",
				minlength: "Minimo 1 caracter numerico",
				maxlength: "Maximo de 3 caracteres numericos",
				min: "Ingrese un numero mayor a cero",
				number: "Solo se permiten numeros",
			},
			Marca:{
				required: "Seleccione la marca del bien",
			},
			Modelo:{
				required: "Seleccione el modelo del bien",
			},
			Color:{
				required: "Seleccione un color para el bien",
			},
			Catalogo:{
				required: "Debe de ingresar el catalogo del bien",
				minlength: "Debe de ingresar 12 caracteres",
				maxlength: "NO puedes ingresar mas de 12 caracteres",
				pattern: "Solo se permiten 12 caracteres numericos",
			},
			Serial:{
				required: "Debe de ingresar el serial del bien",
				minlength: "Debe de ingresar al menos 4 caracteres",
				maxlength: "NO puedes ingresar mas de 20 caracteres",
			},
			Depre:{
				required: "Debe de ingresar la deprecion del bien",
				minlength: "Debe de ingresar al menos 1 caracter numerico",
				maxlength: "No ingreses mas de 12 caracteres",
				decimal: "Solo se permiten valores decimales",
				min: "Ingrese una depreciacion mayor a 0",
			},
			Placa:{
				required: "Debe de ingresar la placa del transporte",
				minlength: "Debe de ingresar los 6 caracteres del transporte",
				maxlength: "Debe de ingresar los 6 caracteres del transporte",
			},
			Anio:{
				required: "Ingrese el año de este transporte",
				minlength: "Debe de ingresar 4 caracteres numericos",
				maxlength: "Debe de ingresar 4 caracteres numericos",
				number: "Solo se permiten numeros",
				max: 'El año ingresado es invalido',
				min: 'Minimo hasta el año 1990',
			},
			Terreno:{
				required: "Debe de ingresar obsevacion del semoviente",
				minlength: "Ingrese minimo 10 caracteres",
				maxlength: "Ingrese menos de 120 caracteres",
			},
			Esp:{
				required: "Seleccione la Especie del semoviente",
			},
			Raza:{
				required: "Seleccione la Raza del semoviente",
			},
			Peso:{
				required: "Debe de ingresar el peso",
				minlength: "Debe de ingresar al menos 2 caracter numerico",
				maxlength: "El peso ingresado es invalido",
				decimal: "Solo se permiten valores decimales",
				min: "Debe de ingresar una cantidad mayor a 0"
			},
			Sexo:{
				required: "Debe se seleccionar el sexo del semoviente",
			},
		}
	});

	$('#btnAdd').click( () =>{
				
		if($('#formulario').valid()){
			confirmacion(`${host_url}/${controller}/Insert`, $('#formulario')[0]).then( (response1) =>{
				if(response1){
					POST(response1[0],response1[1]).then( (res) =>{
						if(res.status == 200){
							FormDinamic('');
							reloadCatalogo();
							ShowCodigo_incrementado(`${host_url}/${controller}`,document.formulario.Cod);
						}
					});
				}
			});
		}
	});

	$('#btnUp').click( () =>{
		
		if($('#FormEdit').valid()){
			confirmacion(`${host_url}/${controller}/Update`, $('#FormEdit')[0]).then( (response1) =>{
				if(response1){
					POST(response1[0],response1[1]).then( (res) =>{
						FormDinamic('');
						reloadCatalogo();
						return true;
					});
				}
			});
		}
	});

  $('#Tbien').change( (e) =>{
		rebootForm();
		FormDinamic(e.target.value);	
		
		if($('#Tbien').valid()) ConsultaClasificacion(e.target.value); else rebootForm();
  });

  $('#Clbien').change( (e) =>{
		if($('#Clbien').valid()) CodificacionBien(e.target.value); else
			
			$('#Cod').attr('disabled', true);
			$('#Cod').val('');

			$('#Desbien').attr('disabled', true);
			$('#Desbien').val('');
  });

	$('#Desbien').on('keyup', ()=>{
		if($('#Desbien').valid()){
			$('#Valbien').val('');
			$('#Valbien').attr('disabled', false);
		}else{
			$('#Valbien').attr('disabled', true);
		}
	});

	$('#Valbien').on('keyup', ()=>{
		if($('#Valbien').valid()){
			$('#Fecbien').val('');
			$('#Fecbien').attr('disabled', false);
		}else{
			$('#Fecbien').attr('disabled',true);
		}
	});

	$('#Fecbien').on('keyup', () =>{
		if($('#Fecbien').valid()){
			$('#Cantbien').val('');
			$('#Cantbien').attr('disabled',false);
		}else{
			$('#Cantbien').attr('disabled',true);
		}
	});

	$('#Cantbien').on('keyup', ()=>{
		if($('#Cantbien').valid()){
			let tipo = $('#Tbien').val();
			switch(tipo){
				case 'IN':
					$('#Terreno').attr('disabled', false);
				break;

				default:
					$('#Terreno').attr('disabled', true);
					FullSelect1(tipo).then( (res) =>{
						if(tipo == 'BS'){
							$('#Esp').attr('disabled', false); 
							$('#Esp').html(res);
						}else $('#Marca').attr('disabled',false); $('#Marca').html(res);
					});					
				break;
			}
		}
	});

	$('#Marca').change( (e) =>{
		if($('#Marca').valid()){
			FullSelect2( e.target.value ).then( (res) =>{
				$('#Raza').attr('disabled', true);
				$('#Modelo').attr('disabled',false);
				$('#Modelo').html(res);
			});
			
		} else $('#Modelo').attr('disabled', true);
	});

	$('#Marca_edit').change( (e) =>{
		if($('#Marca_edit').valid()){
			FullSelect2( e.target.value ).then( (res) =>{
				$('#Raza_edit').attr('disabled', true);
				$('#Modelo_edit').attr('disabled',false);
				$('#Modelo_edit').html(res);
			});
			
		} else $('#Modelo_edit').attr('disabled', true);
	});

	$('#Esp').change( (e) =>{
		if($('#Esp').valid()){
			FullSelect2( e.target.value ).then( (res) =>{
				$('#Modelo').attr('disabled',true);
				$('#Raza').attr('disabled', false);
				$('#Raza').html(res);
			});			

		} else $('#Raza').attr('disabled', true);
	});

	$('#Esp_edit').change( (e) =>{
		if($('#Esp_edit').valid()){
			FullSelect2( e.target.value ).then( (res) =>{
				$('#Modelo_edit').attr('disabled',true);
				$('#Raza_edit').attr('disabled', false);
				$('#Raza_edit').html(res);
			});
			
		} else $('#Raza_edit').attr('disabled', true);
	});

	$('#Raza').change( (e) =>{
		if($('#Raza').valid()) $('#Peso').attr('disabled', false); else $('#Peso').attr('disabled', true);		
	});

	$('#Modelo').change( (e) =>{
		if($('#Modelo').valid()) $('#Color').attr('disabled', false); else $('#Color').attr('disabled', true);
	});

	$('#Color').change( (e) =>{
		if($('#Color').valid()) if($('#Tbien').val() != 'TP') $('#Catalogo').attr('disabled', false); 
		else $('#Placa').attr('disabled', false);
		else $('#Catalogo').attr('disabled', true);
	});

	$('#Catalogo').on('keyup', () =>{
		if($('#Catalogo').valid()) $('#Serial').attr('disabled', false); else $('#Serial').attr('disabled', true);
	});

	$('#Serial').on('keyup', () =>{
		if($('#Serial').valid()) $('#Depre').attr('disabled', false); else $('#Depre').attr('disabled', true);
	});

	$('#Depre').on('keyup', ()=>{
		if($('#Depre').valid()) $('#if_componente').attr('disabled',false);
	});

	$('#Peso').on('keyup', () =>{
		if($('#Peso').valid()) $('#S1, #S2').attr('disabled', false); else $('#S1, #S2').attr('disabled', true);
	});

	$('#Depre').on('keyup', ()=>{
		if($('#Tbien').val() == 'TP' && $('#Depre').valid()) $('#Placa').attr('disabled', false); else $('#Placa').attr('disabled', true);
	});

	$('#Placa').on('keyup', () =>{
		if($('#Placa').valid()) $('#Anio').attr('disabled', false); else $('#Anio').attr('disabled', true);
	});
});
