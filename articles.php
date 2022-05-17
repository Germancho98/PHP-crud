<?php include ('header.php'); 
$_SESSION['page'] = 0;
$limit = 6;
$items = all_articles($limit);

?>
	<!--=====================================
	   PROFILE
	   ======================================-->
	<main role="main" class="user-profile">

	    <div class="container">



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
	    		<div class="center paginate" cargar="all_articles" type="articles">
	    			<a href="javascript:void(0)" class="waves-effect waves-light btn blue show_cascade">
	    				Cargar más
	    			</a>
	    		</div>
	    	</div><!-- End articles-post-user-profile -->
	    </div><!-- End container -->
	</main>
	


<?php include ('footer.php'); ?>