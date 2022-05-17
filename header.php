<?php 
require_once ('db_conexion.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobbile-web-app-capable" content="yes">
	<meta name="apple-mobbile-web-app-title" content="">

	<link rel="icon" href="<?php echo URL; ?>images/logo.png">	
	<!--=====================================
	Marcado HTML5
	======================================-->

	<meta name="title" content="USERS">
	<meta name="description" content="Administración de usuarios">
	<meta name="keyword" content="suers, perfil, web"> 
	<!--=====================================
	   CSS STYLES
	   ======================================-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="<?php echo URL; ?>css/normalize.css">
	<link rel="stylesheet" href="<?php echo URL; ?>css/materialize.min.css">
	<link rel="stylesheet" href="<?php echo URL; ?>css/main.css">

	<!--=====================================
	   JAVASCRIPT SCRIPTS
	   ======================================-->
	   <script src="<?php echo URL; ?>js/jquery-3.6.0.min.js"></script>
	<script src="<?php echo URL; ?>js/materialize.min.js"></script>
</head>
<body>
	<!--=====================================
	  HEADER
	   ======================================-->
	<header class="navbar-fixed index-1">
		<nav class="blue">
			<div class="container">
				<div class="nav-wrapper">
					<a href="<?php echo URL; ?>inicio" class="brand-logo left">
						<img src="<?php echo URL; ?>images/logo.png" width="40">
					</a>
					<a href="#" data-target="nav-movil" class="sidenav-trigger right"><i class="material-icons">menu</i></a>
					<ul class="right hide-on-med-and-down">
						<li><a href="<?php echo URL; ?>articulos">Articulos</a></li>
						<?php if (isset($_SESSION['id'])): 
									$notification = all_notifications($_SESSION['id']);
							?>
							<li class="contification_li">
								<a href="javascript:void(0)" class="dropdown-trigger" data-target="open_noti">
									<i class="material-icons">notifications</i>
									<span class="counst"><?php echo count_notifications($_SESSION['id']); ?></span>
								</a>
								<ul id="open_noti" class="dropdown-content">
									<?php foreach ($notification as  $value): ?>
										<?php if ($value['status_notifications'] == 0): ?>
											<li>
												<a href="javascript:void(0)" 
												   data-target="popup_modal_art" 
												   class="modal-trigger update_noti" 
												   id_notification="<?php echo $value['id_notification']; ?>"
												   token_status="<?php echo $value['token_status']; ?>"
			    						   		   onclick="popup_modal_art('<?php echo $value['url']; ?>');">
													Tiene un nuevo comentario en :
													<br>
													<strong><?php echo $value['title']; ?></strong>
												</a>
											</li>
											
										<?php endif; ?>
										
									<?php endforeach; ?>
								</ul>
							</li>
							<li>
								<a href="<?php echo URL; ?>perfil" class="waves-effect waves-light btn  black darken-1">
									<?php echo $_SESSION['user_name']; ?>
								</a>
							</li>
							<li><a href="<?php echo URL; ?>salir" class="waves-effect waves-light btn  red darken-1">x</a></li>
						<?php else: ?><li><a href="<?php echo URL; ?>login" >login</a></li>
							<li><a href="<?php echo URL; ?>registro" class="waves-effect waves-light btn  red darken-1">Registro</a></li>
						<?php endif; ?>
						

					</ul>
				</div>
				
			</div>
		</nav>

		<ul class="sidenav" id="nav-movil">
			<li><a href="<?php echo URL; ?>articulos">Articulos</a></li>
		    <li><a href="<?php echo URL; ?>registro" class="waves-effect waves-light btn  red darken-1">Registro</a></li>
		</ul>
	</header>
