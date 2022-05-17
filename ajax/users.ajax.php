<?php 

require_once '../db_conexion.php';
/*=============================================
RECIBIENDO INFORMACIÓN DEL REGISTRO
=============================================*/
if (isset($_POST['form_rg'])) {
	
	if (!empty($_POST['user_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {

		if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['user_name'])) {
			echo "user_invalido";
			exit();
		}elseif(!preg_match('/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $_POST['email'])){
			echo "email_invalido";
			exit();
		}elseif (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])) {
			echo "pass_invalido";
			exit();
		}

		$user_name = trim($_POST['user_name']);
		$email = trim($_POST['email']);
		$password = md5(trim($_POST['password']));
		$description = "";
		$picture = "";
		$banner = "";
		$status = 0;
		$token = md5(trim($_POST['email']));

		/*=============================================
		EVITANDO REPETIR USUARIO
		=============================================*/

		$query = sprintf("SELECT * FROM `ud_users` WHERE user_name = %s",
						 limpiar($user_name, 'text'));
		$result = mysqli_query($conn, $query);
		$row = mysqli_num_rows($result);
		if ($row  == 0) {

			/*=============================================
			EVITANDO REPETIR EMAIL
			=============================================*/
			$query_e = sprintf("SELECT * FROM `ud_users` WHERE email = %s",
						 limpiar($email, 'text'));
			$result_e = mysqli_query($conn, $query_e);
			$row_e = mysqli_num_rows($result_e);

			if ($row_e == 0) {

				/*=============================================
				INSETANDO DATOS
				=============================================*/

				$stmt = $conn->prepare("INSERT INTO `ud_users`(`user_name`, `email`, `password`, `description`, `picture`, `banner`, `status`, `token`) VALUES (?,?,?,?,?,?,?,?)");
				$stmt->bind_param('ssssssis', $user_name, $email, $password, $description, $picture, $banner, $status, $token);

				if ($stmt->execute()) {
					$para      = $email;
					$titulo    = 'Verifique su correco electronico';
					$mensaje   = "Utilice este enlace " . URL ."verificar/".$token . " para verificar su cuenta.";
					// Para enviar un correo HTML, debe establecerse la cabecera Content-type
					$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
					$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					// Cabeceras adicionales
					$cabeceras .= 'From: Sistema de usuarios <saavedraorozcog@gmail.com>' . "\r\n";
					error_reporting(0);
					mail($para, $titulo, $mensaje, $cabeceras);


					echo "ok";
				}else{
					echo "error";
				}
				$stmt->close();
				//================================================
				
			}else{
				echo "email_existe";
			}
			mysqli_free_result($result_e);
			
			
			//================================================
		}else{ echo "user_existe";}
		mysqli_free_result($result);
		//================================================
	}else{
		echo "vacio";
	}
}

/*=============================================
RECIBIENDO INFORMACIÓN DEL LOGIN
=============================================*/

if (isset($_POST['form_l']) && $_POST['form_l'] == "login") {
	if (!empty($_POST['username']) && !empty($_POST['password']) ) {

		if (!preg_match('/^[@\\.\\_\\#\\a-zA-Z0-9]+$/', $_POST['username'])) {
			echo "user_invalido";
			exit();
		}else if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])) {
			echo "password_invalido";
			exit();
		}


		$username = trim($_POST['username']);
		$password = md5($_POST['password']);

		$query = sprintf("SELECT * FROM ud_users WHERE user_name = %s AND password = %s AND status > 0",
						 limpiar($username, "text"),
						 limpiar($password, "text"));

		$result = mysqli_query($conn, $query);
		$fetch = mysqli_fetch_assoc($result);
		$row = mysqli_num_rows($result);

		if ($row == 1) {

			$_SESSION['id'] = $fetch['id'];
			$_SESSION['user_name'] = $fetch['user_name'];
			$_SESSION['picture'] = $fetch['picture'];
			
			echo "ok";
		}else{
			echo "user_no_existe";
		}
		mysqli_free_result($result);
		
	}else{
		echo "vacio";
	}

}

/*=============================================
SUBIENDO BANNER DE USUSARIOI
=============================================*/

if (isset($_POST['form_banner']) && $_POST['form_banner'] == "banner") {
	
	if ($_FILES["up_banner"]["type"] == "image/png" || $_FILES["up_banner"]["type"] == "image/jpg" || $_FILES["up_banner"]["type"] == "image/jpeg") {
		
		$id_user = trim($_POST['id_user']);

		$name_banner = $id_user . "-" . $_FILES["up_banner"]["name"];
		
		move_uploaded_file($_FILES["up_banner"]["tmp_name"], "../images/banner/" . $name_banner);

		$query = "UPDATE ud_users SET banner = ? WHERE id = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('si', $name_banner, $id_user);

		if ($stmt->execute()) {
			$json = array("ok", "images/banner/{$name_banner}");
			echo json_encode($json);
		}else{
			echo "error";
		}

		$stmt->close();
	}else{
		echo "file_no";
	}
}


/*=============================================
SUBIENDO picture DE USUSARIOI
=============================================*/

if (isset($_POST['form_picture']) && $_POST['form_picture'] == "picture") {
	
	if ($_FILES["up_picture"]["type"] == "image/png" || $_FILES["up_picture"]["type"] == "image/jpg" || $_FILES["up_picture"]["type"] == "image/jpeg") {
		
		$id_user = trim($_POST['id_user']);

		$name_picture = $id_user . "-" . $_FILES["up_picture"]["name"];
		
		move_uploaded_file($_FILES["up_picture"]["tmp_name"], "../images/users/" . $name_picture);

		$query = "UPDATE ud_users SET picture = ? WHERE id = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('si', $name_picture, $id_user);

		if ($stmt->execute()) {
			$json = array("ok", "images/users/{$name_picture}");
			echo json_encode($json);
		}else{
			echo "error";
		}

		$stmt->close();
	}else{
		echo "file_no";
	}
}

/*=============================================
ACTUALIZANDO DATOS DE PERFIL
=============================================*/

if (isset($_POST['form_us']) && $_POST['form_us'] == "perfil") {
	
	if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['description'])) {
		
		if (!preg_match('/^[a-zA-Z0-9]+$/', $_POST['username'])) {
			echo "user_invalido";
			exit();

		}else if (!preg_match('/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $_POST['email'])) {
			echo "email_invalido";
			exit();

		}else if (!preg_match('/^[#\\,\\.\\+\\!\\a-zA-Z0-9 ]+$/', $_POST['description'])) {
			echo "des_invalido";
			exit();
		}

		$user_name 		= trim($_POST['username']);
		$email 			= trim($_POST['email']);
		$description 	= trim($_POST['description']);
		$id_user 		= trim($_POST['id_user']);

		$query = "UPDATE ud_users SET user_name = ?, email = ?, description = ? WHERE id = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('sssi', $user_name, $email, $description, $id_user);

		if ($stmt->execute()) {
			echo "ok";
		}else{
			echo "error";
		}
	}else{
		echo "vacio";
	}
}