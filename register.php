<?php include ('header.php'); 

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
	header('Location:'.URL.'perfil');
	exit();
}

?>
	<!--=====================================
	   HERO
	   ======================================-->

	<section class="section-hero">
		<div class="hero">
			<div class="container center">
				<div class="container-form ">
					<div class="card">
						<form onsubmit="return false" id="form_r">
							<div class="row">
								<div class="input-field col s12">
									<i class="material-icons prefix">account_circle</i>
							         <input type="text" id="rg_username" class="validate" autocomplete="off">
							         <label for="rg_username">Usuario</label>
								</div><!-- Enf col -->

								<div class="input-field col s12">
									<i class="material-icons prefix">email</i>
							         <input type="email" id="rg_email" class="validate" autocomplete="off">
							         <label for="rg_email">Email</label>
								</div><!-- Enf col -->

								<div class="input-field col s12">
									<i class="material-icons prefix">lock_outline</i>
							         <input type="password" id="rg_pass1" class="validate" autocomplete="off">
							         <label for="rg_pass1">Contraseña</label>
								</div><!-- Enf col -->

								<div class="input-field col s12">
									<i class="material-icons prefix">login</i>
							         <input type="password" id="rg_pass2" class="validate" autocomplete="off">
							         <label for="rg_pass2">Verificar contraseña</label>
								</div><!-- Enf col -->

								<div class="col s12">
									<div class="center">
										<input type="submit" class="waves-effect waves-light btn blue" value="Registrarme" onclick="register();">
									</div>
								</div>
								<div class="col s12">
									<div class="center pt-2">
										<a href="<?php echo URL; ?>login" class="black-text">Ya tengo una cuenta</a>
									</div>
								</div>
							</div><!-- End row -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php include ('footer.php'); ?>