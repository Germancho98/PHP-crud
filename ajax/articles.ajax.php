<?php 

require_once ('../db_conexion.php');

/*=============================================
AGREGANDO ARTICULOS
=============================================*/

if (isset($_POST['form_post']) && $_POST['form_post'] == "post") {
	
	if (!empty($_POST['title']) && !empty($_POST['reg_description'])) {
		
		if (!preg_match('/^[#\\,\\.\\+\\!\\;\\a-zA-Z0-9áéíóúñÁÉÓÚÑ ]+$/', $_POST['title'])) {
			echo "title_invalido";
			exit();
		}else if (!preg_match('/^[#\\,\\.\\+\\!\\;\\a-zA-Z0-9áéíóúñÁÉÓÚÑ ]+$/', $_POST['reg_description'])) {
			echo "des_invalido";
			exit();
		}
		$image = "";
		if (isset($_FILES['image'])) {
			if ($_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/jpeg") {
				
				$image = limpiar_url($_POST['title']) . '-' . $_FILES['image']['name'];

				move_uploaded_file($_FILES['image']['tmp_name'], '../images/upload/' . $image);

			}else{
				echo "img_inva";
				exit();
			}
		}

		$title = trim($_POST['title']);
		$url = limpiar_url($_POST['title']);
		$description = trim($_POST['reg_description']);
		$id_user = trim($_POST['id_user']);
		$visitors = 0;
		$comments = 0;
		$like_points = 0;
		$status = 1;

		$query = "INSERT INTO ud_articles(title, url, description_a, images, ahutor, visitors, comments, like_points, status) VALUES (?,?,?,?,?,?,?,?,?)";

		$stmt = $conn->prepare($query);
		$stmt->bind_param('ssssiiiii', $title, $url, $description, $image, $id_user, $visitors, $comments, $like_points, $status);

		if ($stmt->execute()) {
			echo "ok";
		}else{
			echo "error";
		}

		$stmt->close();

	}else{
		echo "vacio";
	}
}

/*=============================================
PAGINACIÓN DE ARTICULOS
=============================================*/
if (isset($_POST['cascade_page'])) {
	$_SESSION['page'] += 6;
	$indice = $_SESSION['page'];
	$type = trim($_POST['type']);
	if ($_POST['cascade_page'] == "all_articles") {

		$query = sprintf("SELECT * FROM ud_articles JOIN ud_users ON ud_users.id = ud_articles.ahutor ORDER BY ud_articles.id_article DESC LIMIT $indice, 6");

	}else if($_POST['cascade_page'] == "user_articles"){
		$query = sprintf("SELECT * FROM ud_articles 
						  JOIN ud_users ON ud_users.id = ud_articles.ahutor 
						  WHERE ud_articles.ahutor = $type
						  ORDER BY ud_articles.id_article 
						  DESC LIMIT $indice, 6");
	}

	$stmt = mysqli_query($conn, $query);
	// MUESTRA TODOS LOS DATOS COMO UN ARRAY
	$result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);

	$row = mysqli_num_rows($stmt);

	if ($row !== 0) {
		echo json_encode($result);
	}else{
		echo json_encode(array('error'));
	}


	mysqli_free_result($stmt);
}

/*=============================================
PUNTUACIÓN DE ARTICULOS
=============================================*/

if (isset($_POST['like'])) {
	if (!empty($_POST['id_article']) && !empty($_POST['id_user'])) {
		
		$id_user = trim($_POST['id_user']);
		$id_article = trim($_POST['id_article']);
		$like = trim($_POST['like']);

		$stmt1 = $conn->prepare("SELECT * FROM ud_like WHERE idarticle = ? AND ahutor = ?");
		$stmt1->bind_param('ii', $id_article, $id_user);

		if ($stmt1->execute()) {
			$res = $stmt1->store_result();
			$rows = $stmt1->num_rows;

			if ($rows == 0) {
				$query = "INSERT INTO ud_like (idarticle, ahutor, like_point) VALUES (?,?,?)";
				$stmt = $conn->prepare($query);
				$stmt->bind_param('iii', $id_article, $id_user, $like);

				if ($stmt->execute()) {

					$query_2 = "UPDATE ud_articles SET like_points = (like_points + 1) WHERE id_article = ?";
					$stmt2 = $conn->prepare($query_2);
					$stmt2->bind_param('i', $id_article);
					$stmt2->execute();
					$stmt2->close();

					echo "ok";
				}else{
					echo "error";
				}

				$stmt->close();
			}else{
				echo "like";
			}
			
		}

		$stmt1->close();

	}

}

/*=============================================
COMENTARIOS DE ARTICULOS
=============================================*/

if (isset($_POST['comment']) && isset($_POST['ahutor'])) {
	
	if (!empty($_POST['comment']) && !empty($_POST['ahutor']) && !empty($_POST['id_article'])) {
		
		if (!preg_match('/^[#\\,\\.\\+\\!\\;\\a-zA-Z0-9áéíóúñÁÉÓÚÑ ]+$/', $_POST['comment'])) {
			echo "com_inva";
			exit();
		}

		$comment = trim($_POST['comment']);
		$ahutor = trim($_POST['ahutor']);
		$id_article = trim($_POST['id_article']);
		$ahutor_article = trim($_POST['ahutor_article']);
		$status = 1;

		$query = "INSERT INTO ud_comments(idarticle, ahutor, comment, status) VALUES (?,?,?,?)";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('iisi', $id_article, $ahutor, $comment, $status);

		if ($stmt->execute()) {

			$stmt2 = $conn->prepare("UPDATE ud_articles SET comments = (comments + 1) WHERE id_article = ?");
			$stmt2->bind_param('i', $id_article);
			$stmt2->execute();
			$stmt2->close();

			// INSERTAR NOTIFICACIÓN
			$status_notifications = 0;
			$token = md5(uniqid(mt_rand(), true));
			$query_2 = "INSERT INTO ud_notifications(idarticle, ahutor_comment, ahutor_article, status_notifications, token_status) VALUES (?,?,?,?,?)";
			$stmt3 = $conn->prepare($query_2);
			$stmt3->bind_param('iiiis', $id_article, $ahutor, $ahutor_article, $status_notifications, $token);
			$stmt3->execute();
			$stmt3->close();

			echo "ok";
		}else{
			echo "error";
		}

		$stmt->close();

	}else{
		echo "vacio";
	}
}

/*=============================================
ACTUALIZANDO NOTIFICACIÓN
=============================================*/

if (isset($_POST['token_status'])) {
	
	if (!empty($_POST['token_status'])) {
		
		$status_notifications = 1;
		$id_notification = trim($_POST['id_notification']);
		$token_status = trim($_POST['token_status']);

		$stmt2 = $conn->prepare("UPDATE ud_notifications SET status_notifications = ?  WHERE id_notification  = ? AND token_status = ?");
		$stmt2->bind_param('iis', $status_notifications, $id_notification, $token_status);
		if ($stmt2->execute()) {
			echo "ok";
		}
		$stmt2->close();
	}
}