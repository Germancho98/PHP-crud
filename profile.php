<?php include ('header.php'); 

if (!isset($_SESSION['id']) && !isset($_SESSION['user_name'])) {
	header('Location:'.URL);
	exit();
}

$id = $_SESSION['id'];
$query = sprintf("SELECT * FROM ud_users WHERE id = %s", 
		 limpiar($id, 'int'));
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

/*=============================================
ARTICULOS DE USURIO
=============================================*/
$_SESSION['page'] = 0;
$limit = 6;
$items = all_art_user($limit, $row['id']);
?>
	<!--=====================================
	   PROFILE
	   ======================================-->
	<main role="main" class="user-profile">
		<div class="parallax-container profile">

	      <div class="parallax">

	      	<?php if ($row['banner'] !== ""): ?>
	      		<img src="<?php echo URL . "images/banner/" . $row['banner']; ?>" id="refres_banner">
	      	<?php else: ?>
	      		<img src="<?php echo URL; ?>images/hero-profile.jpg"  id="refres_banner">
	      	<?php endif; ?>

	      </div>
	      	<div class="content-parallx center">
	      		<figure onclick="$('#up_picture').click();" class="pointer">
	      			<?php if ($row['picture'] !== ""): ?>
			      		<img src="<?php echo URL . "images/users/" . $row['picture']; ?>" width="100" class="circle-img" id="refres_picture">
			      	<?php else: ?>
			      		<img src="<?php echo URL; ?>images/person.png" width="100" class="circle-img" id="refres_picture">
			      	<?php endif; ?>

	      		</figure>
	      		<form onsubmit="return false" class="form_picture" style="display: none;">
	      			<input type="file" id="up_picture" name="up_picture" onchange="upload_picture();">
	      			<input type="hidden" id="id_user" name="id_user" value="<?php echo $row['id']; ?>">
	      			<input type="hidden" id="form_picture" name="form_picture" value="picture">
	      		</form>

	      		<h2 class="name-user">
	      			<?php echo $row['user_name']; ?>
	      		</h2>
	      		<a href="javascript:void(0)" class="btn-banner" onclick="$('#up_banner').click();">
	      			<i class="material-icons">image</i>
	      		</a>
	      		<form onsubmit="return false" class="form_banner" style="display: none;">
	      			<input type="file" id="up_banner" name="up_banner" onchange="upload_banner();">
	      			<input type="hidden" id="id_user" name="id_user" value="<?php echo $row['id']; ?>">
	      			<input type="hidden" id="form_banner" name="form_banner" value="banner">
	      		</form>

	      	</div>
	    </div><!-- End parallax -->

	    <div class="container">
	    	<article class="center">
	    		<h3>Sobre mi</h3>
	    		<figcaption>
	    			<?php echo $row['description']; ?>
	    		</figcaption>
	    	</article>


	    	<div class="articles-post-user-profile" id="cascade_page">
	    		<div class="row">
	    			<?php foreach ($items as $value): ?>

	    				<?php if ($value['status'] != 0): ?>
			    			<div class="col s12 m4">
			    				<div class="card">
			    					<div class="card-image scalar">
			    						<a href="javascript:void(0)" data-target="popup_modal_art" class="modal-trigger" 
			    						   onclick="popup_modal_art('<?php echo $value['url']; ?>');">
			    							<?php if ($value['images'] !== ""): ?>
			    								<img src="<?php echo URL . "images/upload/" . $value['images']; ?>">
			    							<?php else: ?>
			    								<img src="<?php echo URL; ?>images/hero.jpg">
			    							<?php endif; ?>			    							
			    						</a>

			    					</div>
			    					<div class="card-content">
			    						<div class="ahutor right">
				    						<a href="<?php echo URL . "user/" . base64_encode($value['user_name']); ?>">
				    							<?php if ($value['picture'] !== ""): ?>
				    								<img src="<?php echo URL . "images/users/" . $value['picture']; ?>" width="60" height="60" class="circle">
				    							<?php else: ?>
				    								<img src="<?php echo URL; ?>images/person.png" width="60" height="60" class="circle">
				    							<?php endif; ?>		
				    						</a>
			    							
			    						</div><!-- End ahitor -->
			    						<a href="javascript:void(0)" data-target="popup_modal_art" class="modal-trigger" 
			    						   onclick="popup_modal_art('<?php echo $value['url']; ?>');">
			    						 <span class="card-title"><?php echo $value['title']; ?></span>
			    							
			    						</a>
			    						<p><?php echo substr($value['description_a'],0,119); ?>...</p>

			    						<div class="card-footer">
			    							<a href="#!" class="tooltipped" data-position="top" data-tooltip="Comentarios: <?php echo $value['comments']; ?>">
			    								<i class="material-icons">comment</i>
			    							</a>
			    							
			    							<a href="#!" class="tooltipped" data-position="top" data-tooltip="Visitas: <?php echo $value['visitors']; ?>">
			    								<i class="material-icons">group</i>
			    							</a>
			    						</div>
			    					</div>
			    				</div><!-- End card -->
			    			</div>
	    					
	    				<?php endif; ?>
	    				
	    			<?php endforeach; ?>

	    		</div><!-- End row -->
	    		<div class="center">
	    			<div class="progress progress_paginate" style="display: none;">
	    				<div class="indeterminate"></div>
	    			</div>
	    		</div>
	    		<div class="center paginate" cargar="user_articles" type="<?php echo $_SESSION['id']; ?>">
	    			<a href="javascript:void(0)" class="waves-effect waves-light btn blue show_cascade">
	    				Cargar más
	    			</a>
	    		</div>
	    	</div>
	    </div>

	    <div class="fixed-action-btn">
	    	<a href="javascript:void(0)" class="btn-floating btn-large red">
	    		<i class="material-icons">mode_edit</i>
	    	</a>
	    	<ul>
	    		<li>
	    		<a href="#edit_user" class="btn-floating blue modal-trigger">
	    			<i class="material-icons">person</i>
	    		</a>
	    	    </li>
	    	    <li>
	    		<a href="#new_post" class="btn-floating red modal-trigger">
	    			<i class="material-icons">edit</i>
	    		</a>
	    	    </li>
	    	</ul>
	    </div>
	</main>

<div id="edit_user" class="modal">
	<div class="modal-content">
		<div class="center">
			<h4>Editar datos del perfil</h4>

			<form onsubmit="return false" class="pt-2 form_edit_user">
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">account_circle</i>
				         <input type="text" id="up_username" class="validate" value="<?php echo $row['user_name']; ?>" autocomplete="off">
				         <label for="up_username">Usuario</label>
					</div><!-- Enf col -->

					<div class="input-field col s12">
						<i class="material-icons prefix">email</i>
				         <input type="email" id="up_email" class="validate" value="<?php echo $row['email']; ?>" autocomplete="off">
				         <label for="up_email">Email</label>
					</div><!-- Enf col -->

					<div class="input-field col s12">
						<i class="material-icons prefix">mode_edit</i>
				          <textarea id="up_des" name="up_des" class="materialize-textarea"><?php echo $row['description']; ?></textarea>
				          <label for="up_des">Descripción</label>
					</div><!-- Enf col -->
					<input type="hidden" id="id_user" name="id_user" value="<?php echo $row['id']; ?>">
					<div class="col s12">
						<div class="center">
							<button type="submit" class="waves-effect waves-light btn blue white-text" onclick="update_user();">
								Actualizar
							</button>
						</div>
					</div>
				</div><!-- End row -->
			</form>
		</div>
	</div>
</div>


<div id="new_post" class="modal">
	<div class="modal-content">
		<div class="center">
			<h4>Publicar un nuevo articulo</h4>

			<form onsubmit="return false" class="pt-2 form_post">
				<div class="row">
					<div class="input-field col s12">
						<i class="material-icons prefix">mode_edit</i>
				         <input type="text" id="title" name="title" class="validate" autocomplete="off">
				         <label for="title">Titulo</label>
					</div><!-- Enf col -->


					<div class="input-field col s12">
						<i class="material-icons prefix">mode_edit</i>
				          <textarea id="reg_description" name="reg_description" class="materialize-textarea"></textarea>
				          <label for="reg_description">Descripción</label>
					</div><!-- Enf col -->

					<div class="input-field file-field col s12">
						<div class="btn">
					        <span>Imagen</span>
					        <input type="file" id="image" name="image">
					      </div>
					      <div class="file-path-wrapper">
					        <input class="file-path validate" type="text">
					    </div>
					</div><!-- Enf col -->
					<input type="hidden" id="id_user" name="id_user" value="<?php echo $row['id']; ?>">
					<div class="col s12">
						<div class="center">
							<button type="submit" class="waves-effect waves-light btn blue white-text" onclick="add_post();">
								Agregar
							</button>
						</div>
					</div>
				</div><!-- End row -->
			</form>
		</div>
	</div>
</div>
	
<?php include ('footer.php');
mysqli_free_result($result);
 ?>