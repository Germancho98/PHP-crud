<?php 

define("URL", "http://localhost/sistema-usuarios/");

/*=============================================
	FUNCION SCAPAR STRING
=============================================*/
function limpiar($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  //Iniciamos la variable $conn
  global $conn;

  if (PHP_VERSION < 5.3) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  //Agregamos $conn en las funciones mysqli_real_escape_string y mysqli_escape_string
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conn,$theValue) : mysqli_escape_string($conn,$theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

/*=============================================
FORMATEAR URL
=============================================*/

function limpiar_url($url) {
  // Tranformamos todo a minusculas
  $url = strtolower($url);
  //Rememplazamos caracteres especiales latinos
  $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
  $repl = array('a', 'e', 'i', 'o', 'u', 'n');
  $url = str_replace ($find, $repl, $url);
  // Añadimos los guiones
  $find = array(' ', '&', '\r\n', '\n', '+'); 
  $url = str_replace ($find, '-', $url);
  // Eliminamos y Reemplazamos demás caracteres especiales
  $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
  $repl = array('', '-', '');
  $url = preg_replace ($find, $repl, $url);
  
  return $url;
}

/*=============================================
MOSTRANDO TODOS LOS ARTICULOS
=============================================*/

function all_articles($limit)
{
  global $conn;
  $query = "SELECT * FROM ud_articles JOIN ud_users ON ud_users.id = ud_articles.ahutor ORDER BY ud_articles.id_article DESC LIMIT $limit";
  $stmt = $conn->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
  $stmt->close;
}

/*=============================================
MOSTRANDO ARTICULO POR URL
=============================================*/

function item_post($url)
{
  global $conn;
  $query = sprintf("SELECT * FROM ud_articles JOIN ud_users ON ud_users.id = ud_articles.ahutor WHERE url = %s",
                  limpiar($url, "text"));
  $result = mysqli_query($conn, $query);
  $item = mysqli_fetch_assoc($result);
  return $item;
  mysqli_free_result($result);
}

/*=============================================
VALIDACION DE VISITAS
=============================================*/

function count_visitors($id, $ip)
{
  global $conn;
  $query = "SELECT * FROM ud_visitors WHERE idarticle = ? AND ip_location = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('is', $id, $ip);
  $stmt->execute();
  $stmt->store_result();
  $rows = $stmt->num_rows;

  if($rows == 0){
    $query_2 = "INSERT INTO ud_visitors (idarticle, ip_location) VALUES(?,?)";
    $stmt2 = $conn->prepare($query_2);
    $stmt2->bind_param('is', $id, $ip);

    if ($stmt2->execute()) {
      return true;
    }else{
      return false;
    }

    $stmt2->close();

  }

  $stmt->close();
}

/*=============================================
MOSTRANDO TODOS LOS COMENTARIOS EN ARTICULOS
=============================================*/

function all_comments($id_article)
{
  global $conn;
  $query = "SELECT * FROM ud_comments JOIN ud_users ON ud_users.id = ud_comments.ahutor 
            WHERE idarticle = ? ORDER BY ud_comments.id ASC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $id_article);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
  $stmt->close;
}


/*=============================================
MOSTRANDO NOTIFICACIONES
=============================================*/

function all_notifications($ahutor_article)
{
  global $conn;
  $query = "SELECT * FROM ud_notifications 
            INNER JOIN ud_users ON ud_users.id = ud_notifications.ahutor_comment
            INNER JOIN ud_articles ON ud_articles.id_article = ud_notifications.idarticle
            WHERE ahutor_article = ? ORDER BY ud_notifications.id_notification  DESC";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $ahutor_article);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
  $stmt->close;
}

/*=============================================
MOSTRANDO CANTIDAD DE NOTIFICACIONES
=============================================*/

function count_notifications($item)
{
  global $conn;
  $status = 0;
  $query = "SELECT * FROM ud_notifications WHERE ahutor_article = ? AND status_notifications = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('ii', $item, $status);
  $stmt->execute();
  $stmt->store_result();
  $rows = $stmt->num_rows;
  return $rows;
  $stmt->close();
}

/*=============================================
MOSTRANDO ARTICULOS DEL USUARIO
=============================================*/

function all_art_user($limit, $id)
{
  global $conn;

  $stmt = $conn->prepare("SELECT * FROM ud_articles 
                          JOIN ud_users ON ud_users.id = ud_articles.ahutor 
                          WHERE ud_articles.ahutor = ? 
                          ORDER BY ud_articles.id_article DESC LIMIT $limit");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  return $stmt->get_result();
  $stmt->close();
}
