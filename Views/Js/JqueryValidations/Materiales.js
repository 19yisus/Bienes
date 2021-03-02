$(document).ready( () =>{
	$.validator.addMethod('ValidFormEdit', () =>{
	
		if($('#CodB_old_edit').is(':disabled') || $('#CodM_old_edit').is(':disabled')){
			return false;
		}
		return true;
	
	}, "No has cambiado ningun valor");
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
	
	$('#formulario').validate({
		rules:{
			Material:{
				required: true,
			},
			CodB:{
				required: true,
			}
		},
		messages:{
			Material:{
				required: 'Debe seleccionar un material para asignar',
			},
			CodB:{
				required: 'Debe de seleccionar un bien',
			}
		}
	});

	$('#FormEdit').validate({
		rules:{
			Material:{
				required: true,
				ValidFormEdit: true,
			},
			CodB:{
				required: true,
				ValidFormEdit: true,
			}
		},
		messages:{
			Material:{
				required: 'Debe seleccionar un material para asignar',
			},
			CodB:{
				required: 'Debe de seleccionar un bien',
			}
		}
	});

	$('#btnAdd').click( () =>{
				
		if($('#formulario').valid()){
			confirmacion(`${url}/${controller}/Insert`, $('#formulario')[0]).then( (response1) =>{
				if(response1){
					POST(response1[0],response1[1]).then( (res) =>{
						if(res.status == 200){
							ShowCodigo_incrementado(`${url}/${controller}`,document.formulario.Cod);
						}
					});
				}
			});
		}
	});

	$('#btnUp').click( () =>{
		
		if($('#FormEdit').valid()){
			confirmacion(`${url}/${controller}/Update`, $('#FormEdit')[0]).then( (response1) =>{
				if(response1){
					POST(response1[0],response1[1]).then( (res) =>{
						return true;
					});
				}
			});
		}
	});


  $('#btnAddMaterial').click( ()=>{
    ModalBienes('Materiales',1);
  });
  
  $('#btnAddBien').click( ()=>{
    ModalBienes('Bienes',1);
  });
});
