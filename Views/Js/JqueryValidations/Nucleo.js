$(document).ready( () =>{
	let catalogo;
	
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
	      {data: 'nuc_cod'},
	      {data: 'nuc_des'},
	      {data: 'nuc_codigo_postal'},
	      {data: 'nuc_tipo_nucleo', render: function(data){
	        switch(data){
	          case 'SP':
	            return 'Sede Principal';
	          break;
	          case 'NU':
	            return 'Nucleo';
	          break;
	          case 'EX':
	            return 'Extension';
	          break;
	          case 'PR':
	            return 'Programa';
	          return;
	        }
	      }},
	      {data: 'nuc_estado', render: function(data){
	        return (data == 1) ? 'Activo': 'Innactivo';
	      }},
	          {defaultContent: "",
	      render: function(data, type, row, meta){
	        let estado = (row.nuc_estado == 0) ? 'disabled': '';
	        let title_edit = (row.nuc_estado == 0) ? 'Este nucleo no puede ser modificado': 'Modificar';
	        let title_desac = (row.nuc_estado == 0) ? 'Activar':'Desactivar';
	        let clase = (row.nuc_estado == 0) ? 'danger':'success';
	        let btnDestroy = '';

	        if(row.nuc_estado == 0){
	        	btnDestroy = `
	        	<button class="btn btn-sm btn-warning b-destroy" onclick="bDelet(this);" data-function="Destroy" id="bDestroy" data-form="form-del-${row.nuc_cod}" 
	            data-dismiss="modal" title="Eliminar regitro">
	              <i class="fas fa-trash"></i>
	            </button>`;
	        }

	        let btn = `
	          <form name="form-del-${row.nuc_cod}" id="form-del-${row.nuc_cod}">
	            <input type="hidden" name="Cod" value="${row.nuc_cod}">
	          </form>
	          <div class='btn-group'>
	            <button class="btn btn-sm btn-info b-editar" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.nuc_cod}"
	              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
	              <i class="fas fa-edit"></i>
	            </button>
	            <button class="btn btn-sm btn-${clase} b-desactivar" onclick="bDelet(this);" data-function="Delete" id="bDelete" data-form="form-del-${row.nuc_cod}" 
	            data-dismiss="modal" title="${title_desac}">
	              <i class="fas fa-power-off"></i>
	            </button>
	            <button class="btn btn-sm btn-default b-consultar" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.nuc_cod}"
	              data-toggle="modal" data-target="#ModalConsultar" data-dismiss="modal"  title="Consultar">
	              <i class="fas fa-list"></i>
	            </button>
	            ${btnDestroy}
	          </div>`;
	        return btn;
	      }
	      }],
	    language:{
	      url: `${host_url}/Views/Js/DataTables.config.json`
	    }
  	});
	let table = $(`#${catalogo}`).DataTable();
	table.on( 'processing', async ()=>{
		let res = await permisosUser();
		if(res.eliminar == 0) $('.b-destroy').remove();
		if(res.modificar == 0){$('.b-editar').remove(); $('.b-desactivar').remove();}
		if(res.consultar == 0) $('.b-consultar').remove();	
	});
  	

  	$.validator.addMethod('valida_postal', (value, element) => {
  		let resultado = false;

  		$('#codigos_postales option').each( (o,e)=>{
  			
  			if(e.value == value){
  				resultado = true;
  				return;
  			}
  		});
  		$(`#${element.id}`).attr('aria-invalid', false);
  		return resultado;  		
	}, "El codigo postal ingresado no esta disponible");
	
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
			Des:{
				required: true,
				minlength: 4,
				maxlength: 30,
			},
			CP:{
				required: true,
				number: true,
				minlength: 4,
				maxlength: 4,
				valida_postal: true,
			},
			Dir:{
				required: true,
				minlength: 10,
				maxlength: 150,
			},
			Tip:{
				required: true,
			}
		},
		messages:{
			Des:{
				required: 'Debe ingresar el nombre del nucleo',
				minlength: 'Debe de ingresar al menos 4 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			CP:{
				required: 'Debe de ingresar el codigo postal',
				minlength: 'Debe de ingresar 4 caracteres',
				maxlength: 'Debe de ingresar 4 caracteres',
				valida_postal: 'El codigo postal ingresado no esta disponible',
			},
			Dir:{
				required: 'La direccion es obligatoria',
				minlength: 'Debe de ingresar al menos 10 caracteres',
				maxlength: 'No debes de ingresar mas de 150 caracteres',
			},
			Tip:{
				required: 'Debe de seleccionar un tipo de nucleo',
			}
		}
	});

	$('#formulario').validate({
		rules:{
			Des:{
				required: true,
				minlength: 4,
				maxlength: 30,
			},
			CP:{
				required: true,
				number: true,
				minlength: 4,
				maxlength: 4,
				valida_postal: true,
			},
			Dir:{
				required: true,
				minlength: 10,
				maxlength: 150,
			},
			Tip:{
				required: true,
			}
		},
		messages:{
			Des:{
				required: 'Debe ingresar el nombre del nucleo',
				minlength: 'Debe de ingresar al menos 4 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			CP:{
				required: 'Debe de ingresar el codigo postal',
				minlength: 'Debe de ingresar 4 caracteres',
				maxlength: 'Debe de ingresar 4 caracteres',
				valida_postal: 'El codigo postal ingresado no esta disponible',
			},
			Dir:{
				required: 'La direccion es obligatoria',
				minlength: 'Debe de ingresar al menos 10 caracteres',
				maxlength: 'No debes de ingresar mas de 150 caracteres',
			},
			Tip:{
				required: 'Debe de seleccionar un tipo de nucleo',
			}
		}
	});

	$('#btnAdd').click( () =>{

		if($('#formulario').valid()){
			confirmacion(`${host_url}/${controller}/Insert`, $('#formulario')[0]).then( (response1) =>{
				if(response1){
					POST(response1[0],response1[1]).then( (res) =>{
						if(res.status == 200){
							IsthereSede();
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
						IsthereSede();
						reloadCatalogo();
						return true;
					});
				}
			});
		}
	});
});
