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
      {data: 'dep_cod'},
      {data: 'dep_des'},
      {data: 'nuc_des'},
      {data: 'dep_estado', render: function(data){ return (data == 1) ? 'Activo': 'Innactivo'; }},
      {defaultContent: "",
      render: function(data, type, row, meta){
        let estado = (row.dep_estado == 0) ? 'disabled': '';
        let title_edit = (row.dep_estado == 0) ? 'Esta Dependencia no puede ser modificada': 'Modificar';
        let title_desac = (row.dep_estado == 0) ? 'Activar':'Desactivar';
        let clase = (row.dep_estado == 0) ? 'danger':'success';
        

        let btn = `
          <form name="form-del-${row.dep_cod}" id="form-del-${row.dep_cod}">
            <input type="hidden" name="Cod" value="${row.dep_cod}">
          </form>
          <div class='btn-group'>
            <button class="btn btn-sm btn-info" id="btn-edit" onclick="Consulta(this)" data-codigo="${row.dep_cod}"
              data-toggle="modal" data-target="#ModalEdit" ${estado} title="${title_edit}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-${clase}" onclick="bDelet(this);" id="bDelete" data-form="form-del-${row.dep_cod}" 
            data-dismiss="modal" title="${title_desac}">
              <i class="fas fa-power-off"></i>
            </button>
            <button class="btn btn-sm btn-default" data-control="${controller}" onclick="bConsul(this);" data-codigo="${row.dep_cod}"
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
			Nu:{
				required: true,
			}
		},
		messages:{
			Des:{
				required: 'Debe ingresar el nombre de la dependencia',
				minlength: 'Debe de ingresar al menos 4 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			Nu:{
				required: 'Debe de seleccionar a que nucleo pertenece',
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
			Nu:{
				required: true,
			}
		},
		messages:{
			Des:{
				required: 'Debe ingresar el nombre de la dependencia',
				minlength: 'Debe de ingresar al menos 4 caracteres',
				maxlength: 'No puede ingresar mas de 30 caracteres',
				pattern: 'Este campo solo acepta letras',
			},
			Nu:{
				required: 'Debe de seleccionar a que nucleo pertenece',
			}
		}
	});

	$('#btnAdd').click( () =>{
				
		if($('#formulario').valid()){
			confirmacion(`${host_url}/${controller}/Insert`, $('#formulario')[0]).then( (response1) =>{
				if(response1){
					POST(response1[0],response1[1]).then( (res) =>{
						if(res.status == 200){
							reloadCatalogo();
							Isthereprincipal();
							SelectNucleos();
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
						reloadCatalogo();
						return true;
					});
				}
			});
		}
	});
});
