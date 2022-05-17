/*=============================================
VALIDANDO FORMULARIO DE REGISTRO Y REGISTRAR USUARIO CON AJAX
=============================================*/

function register()
{
	let rg_username = document.querySelector('#rg_username').value;
	let rg_email = document.querySelector('#rg_email').value;
	let rg_pass1 = document.querySelector('#rg_pass1').value;
	let rg_pass2 = document.querySelector('#rg_pass2').value;

	let exp = /^[a-zA-Z0-9]+$/;
	let exp_email = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

	if (rg_username == "") {
		M.toast({html: 'El campo usuario no puede estar vacio!'})
		return;
	}else if (!exp.exec(rg_username)) {
		M.toast({html: 'En el campo usuario no se permiten carácteres especiales!'})
		return;
	}

	if (rg_email == "") {
		M.toast({html: 'El campo email no puede estar vacio!'})
		return;
	}else if (!exp_email.exec(rg_email)) {
		M.toast({html: 'Ingresa un email válido!'})
		return;
	}

	if (rg_pass1 == "" || rg_pass2 == "") {
		M.toast({html: 'El campo contraseña no puede estar vacio!'})
		return;
	}else if (!exp.exec(rg_pass1) || !exp.exec(rg_pass2)) {
		M.toast({html: 'En el campo contraseña no se permiten carácteres especiales!'})
		return;
	}

	if (rg_pass1 !== rg_pass2) {
		M.toast({html: 'Las contraseñas no coinciden!'})
		return;
	}
	var method = "POST";
	var URL = "ajax/users.ajax.php";
	var ajax = new XMLHttpRequest();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var response = ajax.responseText;
			
			if (response == "ok") {
				M.toast({html: 'Se registro con exito se a enviado un email de verificación a su cuenta! ' + rg_email})
				document.querySelector('#form_r').reset();
				
			}else if (response == "user_invalido") {
				M.toast({html: 'En el campo usuario no se permiten carácteres especiales!'})

			}else if (response == "email_invalido") {
				M.toast({html: 'Ingresa un email válido!'})

			}else if (response == "pass_invalido") {
				M.toast({html: 'En el campo contraseña no se permiten carácteres especiales!'})

			}else if (response == "error") {
				M.toast({html: 'Ocurio un error al registrarse!'})

			}else if (response == "email_existe") {
				M.toast({html: 'El email ingresado ya existe, intente con uno diferente!'})

			}else if (response == "user_existe") {
				M.toast({html: 'El usuario ya exixte, intente con uno diferente!'})

			}else if (response == "vacio") {
				M.toast({html: 'Algunos de los campos se encuentran vacios!'})
			}
		}
	};
	ajax.open(method, URL, true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	ajax.send("user_name=" + rg_username + "& email=" + rg_email + "& password=" + rg_pass1 + "& form_rg=" + "registro");
}

/*=============================================
VALIDANDO FORMULARIO LOGIN Y INICIAR SESIÓN  CON AJAX
=============================================*/

function login_ajax()
{
	let username = document.querySelector('#username').value;
	let password = document.querySelector('#password').value;
	let form_l = "login";

	let exp = /^[a-zA-Z0-9]+$/;
	let exp_username = /^[@\\.\\_\\#\\a-zA-Z0-9]+$/;

	if (username == "") {
		M.toast({html: 'El campo usuario no puede estar vacio!'})
		return;
	}else if (!exp_username.exec(username)) {
		M.toast({html: 'Ingresa un usuario o un email válido!'})
		return;
	}

	if (password == "") {
		M.toast({html: 'El campo contraseña no puede estar vacio!'})
		return;
	}else if (!exp.exec(password)) {
		M.toast({html: 'En el campo contraseña no se permiten carácteres especiales!'})
		return;
	}

	let xhr = new XMLHttpRequest();
	let URL = 'ajax/users.ajax.php';
	let method = "POST";
	xhr.onreadystatechange = function(){
		if (xhr.readyState == 4 && xhr.status == 200) {
			let response = xhr.responseText;
			// console.log("response", response);

			if (response == "ok") {
				window.location = "perfil";
			}else if (response == "user_no_existe") {
				M.toast({html: 'usuario o contraseña incorrectos!'})
			}else if (response == "vacio") {
				M.toast({html: 'Campos vacios!'})
			}
		}
	}

	xhr.open(method, URL, true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("username=" + username + "& password=" + password + "& form_l=" + form_l);
}

/*=============================================
SUBIENDO BANNER CON AJAX
=============================================*/

function upload_banner(){
	
	let form_data = new FormData($(".form_banner")[0]);
		// form_data.append("form_banner", "banner");
	let banner = document.querySelector('#up_banner').value;

	$.ajax({
			url: 'ajax/users.ajax.php',
			type: 'POST',
			data: form_data,
			contentType: false,
			processData: false,
			cache: false,
			success: function (response) {
				let res = JSON.parse(response);				
				if (res[0] == "ok") {
					$('#refres_banner').attr('src', res[1]);
					$('.form_banner')[0].reset();

				}else if (response == "file_no") {
					M.toast({html: 'Solo se permiten imagenes de tipo JPG, JPEG Y PNG!'})
				}
				
			}
		});
}

/*=============================================
SUBIENDO PICTURE CON AJAX
=============================================*/

function upload_picture(){
	
	let form_data = new FormData($(".form_picture")[0]);
		// form_data.append("form_picture", "banner");
	let banner = document.querySelector('#up_banner').value;

	$.ajax({
			url: 'ajax/users.ajax.php',
			type: 'POST',
			data: form_data,
			contentType: false,
			processData: false,
			cache: false,
			success: function (response) {
				let res = JSON.parse(response);				
				if (res[0] == "ok") {
					$('#refres_picture').attr('src', res[1]);
					$('.form_picture')[0].reset();

				}else if (response == "file_no") {
					M.toast({html: 'Solo se permiten imagenes de tipo JPG, JPEG Y PNG!'})
				}
				
			}
		});
}

/*=============================================
ACTUALIZANDO DATOS DE USURIO CON AJAX
=============================================*/

function update_user()
{
	let username = $('#up_username').val();
	let up_email = $('#up_email').val();
	let up_des = $('#up_des').val();
	let id_user = $('#id_user').val();

	let exp = /^[a-zA-Z0-9]+$/;
	let exp_des = /^[#\\,\\.\\+\\!\\a-zA-Z0-9 ]+$/;
	let exp_email = /^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

	if (username == "") {
		M.toast({html: 'El campo usuario no puede estar vacio!'})
		return;
	}else if (!exp.exec(username)) {
		M.toast({html: 'El campo usuario no se permiten carácteres especiales!'})
		return;
	}

	if (up_email == "") {
		M.toast({html: 'El campo email no puede estar vacio!'})
		return;
	}else if (!exp_email.exec(up_email)) {
		M.toast({html: 'Por favor ingresa un email válido!'})
		return;
	}

	if (up_des == "") {
		M.toast({html: 'El campo descripción no puede estar vacio!'})
		return;
	}else if (!exp_des.exec(up_des)) {
		M.toast({html: 'El campo descripción no se permiten algunos, carácteres especiales!'})
		return;
	}


	let date = new FormData();
		date.append("username", username);
		date.append("email", up_email);
		date.append("description", up_des);
		date.append("id_user", id_user);
		date.append("form_us", "perfil");

	$.ajax({
		url: 'ajax/users.ajax.php',
		type: 'POST',
		data: date,
		cache:false,
		contentType: false,
		processData: false,
		success: function(response){
			
			if (response == "ok") {
				M.toast({html:'Sus datos se actualizaron correctamente!!'})
				setTimeout(function(){
					window.location = "perfil";
				}, 1000)
			}else if (response == "error") {
				M.toast({html:'Ocurrio un error inesperado del servidor!'})

			}else if (response == "vacio") {
				M.toast({html:'Algunos de sus campos están vacios!'})
			}else if(response == "user_invalido"){
				M.toast({html: 'El campo usuario no se permiten carácteres especiales!'})

			}else if(response == "email_invalido"){
				M.toast({html: 'Por favor ingresa un email válido!'})
			}
			else if(response == "des_invalido"){
				M.toast({html: 'El campo descripción no se permiten algunos, carácteres especiales!'})
			}

		}
	})
}

/*=============================================
PUBLICANDO ARTICULOS CON AJAX
=============================================*/

function add_post()
{
	let title = $('#title').val();
	let des = $('#reg_description').val();

	let exp = /^[#\\,\\.\\+\\!\\;\\a-zA-Z0-9áéíóúñÁÉÓÚÑ ]+$/;

	if (title == "") {
		M.toast({html: 'El campo titulo no puede estar vacio'})
		return;
	}else if (!exp.exec(title)) {
		M.toast({html: 'En el campo titulo no se permiten algunos carácteres especiales!'})
		return;
	}else if (title.length > 30) {
		M.toast({html: 'El titulo es mui largo'})
		return;
	}

	if (des == "") {
		M.toast({html: 'El campo descripción no puede estar vacio'})
		return;
	}else if (!exp.exec(des)) {
		M.toast({html: 'En el campo descripción no se permiten algunos carácteres especiales!'})
		return;
	}else if (des.length < 5) {
		M.toast({html: 'La descripción es muy corta'})
		return;
	}

	let date = new FormData($('.form_post')[0]);
		date.append('form_post', 'post');

	$.ajax({
		url: 'ajax/articles.ajax.php',
		type: 'POST',
		data: date,
		contentType: false,
		processData: false,
		cache: false,
		success: function(response){

			if(response == "ok"){
				M.toast({html: 'Su articulo se publico correctamente!!'})
				$('.form_post')[0].reset();

			}else if (response == "error") {
				M.toast({html:'Ocurrio un error inesperado del servidor!'})

			}else if (response == "title_invalido") {
				M.toast({html: 'En el campo titulo no se permiten algunos carácteres especiales!'})

			}else if (response == "des_invalido") {
				M.toast({html: 'En el campo descripción no se permiten algunos carácteres especiales!'})

			}else if (response == "img_inva") {
				M.toast({html: 'Solo se permiten imagenes de tipo JPG, JPEG Y PNG!'})

			}else if (response == "vacio") {
				M.toast({html:'Algunos de los campos se encuentran vacios!'})
			}


		}
	})
} 

/*=============================================
PAGINAR ARTICULOS CON AJAX
=============================================*/
$('.show_cascade').on('click', function(){
	let value = $('.paginate').attr("cargar");
	let type_option = $('.paginate').attr("type");

	$.ajax({
			url: urlw + 'ajax/articles.ajax.php',
			type: 'POST',
			data: "cascade_page=" + value + "& type=" + type_option,
			cache: false,
			dataType: "json",
			beforeSend: function(){
				$('.progress_paginate').show();
			},
			success: function (response) {
				if (response[0] == "error") {
					M.toast({html:'No se encontraron más resultados!'})
					$('.progress_paginate').fadeOut(600);
					$('.show_cascade').fadeOut();
				}else{
					$('.progress_paginate').fadeOut(600);

					response.forEach(functionFor);

					function functionFor(item, index)
					{
						$('.tooltipped').tooltip();
						let description = item["description_a"].substr(0,119);
						let url_username = urlw + "user/" + btoa(item['user_name']);
						var image = null;
						if (item['images'] !== "") {
							image = urlw + "images/upload/" + item['images'];
						}else{
							image = urlw + "images/hero.jpg";
						}

						var picture = null;
						if (item['picture'] !== "") {
							picture = urlw + "images/users/" + item['picture'];
						}else{
							picture = urlw + "images/person.png";
						}
						if (item['status'] !== 0) {
							$('#cascade_page .row').append(` 

								<div class="col s12 m4">
				    				<div class="card">
				    					<div class="card-image scalar">
				    						<a href="javascript:void(0)" data-target="popup_modal_art" class="modal-trigger" 
			    						   onclick="popup_modal_art('${item['url']}');">
				    						<img src="${image}">
				    						</a>

				    					</div>
				    					<div class="card-content">
				    						<div class="ahutor right">
					    						<a href="${url_username}">
					    							<img src="${picture}" width="60" height="60" class="circle">
					    						</a>
				    							
				    						</div><!-- End ahitor -->
				    						<a href="javascript:void(0)" data-target="popup_modal_art" class="modal-trigger" 
			    						   onclick="popup_modal_art('${item['url']}');">
				    						 <span class="card-title">${item['title']}</span>
				    							
				    						</a>
				    						<p>${description}...</p>

				    						<div class="card-footer">
				    							<a href="#!" class="tooltipped" data-position="top" data-tooltip="Comentarios: ${item['comments']}">
				    								<i class="material-icons">comment</i>
				    							</a>
				    							
				    							<a href="#!" class="tooltipped" data-position="top" data-tooltip="Visitas: ${item['visitors']}">
				    								<i class="material-icons">group</i>
				    							</a>
				    						</div>
				    					</div>
				    				</div><!-- End card -->
				    			</div>

							 `);

						}// Cierre del status


					}


				}
				
			}
		});

})


/*=============================================
MOSTRANDO INFO ARTICULO CON AJAX
=============================================*/

function popup_modal_art(item)
{
	if (item !== "") {
		$.ajax({
				url: urlw + 'inc/item.php',
				type: 'POST',
				data: "url=" + item,
				success: function (response) {
					$('.res_modal').html(response)
				}
			});

	}else{
		M.toast({html:'Ocurrio un error inesperado intente más tarde!'})
	}
}

/*=============================================
PUNTUANDON  ARTICULO CON AJAX
=============================================*/

function like_point(id_article, id_user)
{
	if (id_article !== "") {

		$.ajax({
				url: urlw + 'ajax/articles.ajax.php',
				type: 'POST',
				data: "id_article=" + id_article + "& id_user=" + id_user + "& like=" + 1,
				success: function (response) {
					if (response == "ok") {
						M.toast({html:'Puntuación agregada'})
						$('.like i').addClass("like");

					}else if (response == "like") {
						M.toast({html:'Ya le diste me gusta'})
					}else {
						M.toast({html:'Ocurrio un error inesperado!!'})
					}
				}
			});

	}else{
		M.toast({html:'No se puede puntuar el articulo'})
	}
}

/*=============================================
COMENTAR  ARTICULO CON AJAX
=============================================*/

function add_comment(comment, ahutor, picture, username, id_article, ahutor_article)
{
	if (comment !== "") {

		let date = new FormData();
			date.append("comment", comment);
			date.append("ahutor", ahutor);
			date.append("id_article", id_article);
			date.append("ahutor_article", ahutor_article);

		$.ajax({
				url: urlw + 'ajax/articles.ajax.php',
				type: 'POST',
				data: date,
				contentType: false,
				processData: false,
				cache: false,
				success: function (response) {
					
					if (response == "ok") {
						M.toast({html:'Comentario agregado correctamente'})
						$('.fmComment')[0].reset();

						$('.commet_load').append(` 
								<div class="ahutor-flex">
								<div class="picture-img">
									<a href="#!">
										<img src="${picture}" alt="username" width="70" height="70" class="circle">
									</a>
								</div>
								<div class="details-ahutor">
									<p class="ahutor-name f1-4">${username}</p>
									<p class="ahutor-review f1-3">${comment}</p>
								</div>
							</div>
							<div class="divider"></div>
							`);

					}else if (response == "vacio") {

						M.toast({html:'Escribe un comentario por favor'})	
					}else{
						M.toast({html:'Ocurrio un error inesperado'})
					}
				}
			});

	}else{
		M.toast({html:'Escribe un comentario por favor'})
	}
}

/*=============================================
ACTUALIZAR NOTIFICACIÓN CON AJAX
=============================================*/
$('.update_noti').on('click', function(){
	const id_notification = $('.update_noti').attr('id_notification');
	const token_status = $('.update_noti').attr('token_status');

	$.ajax({
			url: urlw + 'ajax/articles.ajax.php',
			type: 'POST',
			data: "id_notification=" + id_notification + "& token_status=" + token_status,
			success: function (response) {
				
				if (response == "ok") {
					$('.contification_li span.counst').text(parseInt($('.contification_li span.counst').text()) - 1);
				}
			}
		});
})