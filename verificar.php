<?php include ('header.php'); 

if (isset($_GET['verificar'])) {
	$token = trim($_GET['verificar']);

	$query = sprintf("SELECT * FROM `ud_users` WHERE token = %s",
						 limpiar($token, 'text'));
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	if ($row['token'] == $token) {
		$stmt = $conn->prepare("UPDATE `ud_users` SET `status`= 1 WHERE token = ?");
		$stmt->bind_param('s', $token);

		if ($stmt->execute()) {
			$mesaage = "Su cuenta se verifico con exito, puede iniciar sesión.";
		}else{
			$mesaage = "Su cuenta no pudo ser verificada.";
		}
	}else{
		$mesaage = "Su cuenta no pudo ser verificada.";
	}

?>
	<!--=====================================
	   HERO
	   ======================================-->

	<section class="section-hero">
		<div class="hero">
			<div class="container">
				<div class="container-hero">
					<h2 class="title-hero">
						Bienvenido al sistema de usuarios
					</h2>
					<p><?php echo $mesaage; ?></p>
					<a href="<?php echo URL; ?>login" class="waves-effect waves-light btn  blue darken-1">Iniciar</a>
					
				</div>
			</div>
		</div>
	</section>

<?php include ('footer.php'); 
}else{
	header('Location:'.URL);
}

$stmt->close();

mysqli_free_result($result);

?>