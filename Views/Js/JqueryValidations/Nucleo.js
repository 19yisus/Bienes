$(document).ready( () =>{
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
				maxlength: 4
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
});
