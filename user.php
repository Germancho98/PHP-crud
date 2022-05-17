<?php include ('header.php'); 

if (!isset($_GET['username']) && empty($_GET['username'])) {
	header('Location:'.URL);
	exit();
}

$user_name = trim(base64_decode($_GET['username']));
$query = sprintf("SELECT * FROM ud_users WHERE user_name = %s", 
		 limpiar($user_name, 'text'));
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
	      		<img src="<?php echo URL . "images/banner/" . $row['banner']; ?>" >
	      	<?php else: ?>
	      		<img src="<?php echo URL; ?>images/hero-profile.jpg" >
	      	<?php endif; ?>

	      </div>
	      	<div class="content-parallx center">
	      		<figure >
	      			<?php if ($row['picture'] !== ""): ?>
			      		<img src="<?php echo URL . "images/users/" . $row['picture']; ?>" width="100" class="circle-img" >
			      	<?php else: ?>
			      		<img src="<?php echo URL; ?>images/person.png" width="100" class="circle-img" >
			      	<?php endif; ?>

	      		</figure>

	      		<h2 class="name-user">
	      			<?php echo $row['user_name']; ?>
	      		</h2>

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
	    		<div class="center paginate" cargar="user_articles" type="<?php echo $row['id']; ?>">
	    			<a href="javascript:void(0)" class="waves-effect waves-light btn blue show_cascade">
	    				Cargar más
	    			</a>
	    		</div>
	    	</div>
	    </div>

	</main>


<?php include ('footer.php');
mysqli_free_result($result);
 ?>