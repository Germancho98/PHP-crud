<?php 
require_once '../db_conexion.php';

if (isset($_POST['url']) && $_POST['url'] !== "") {
	$url = trim($_POST['url']);
	$item = item_post($url);
	$id_article = $item['id_article'];

	if (count_visitors($id_article, $_SERVER['REMOTE_ADDR']) == true) {
		
		$query = "UPDATE ud_articles SET visitors = (visitors + 1) WHERE id_article = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param('i', $id_article);
		$stmt->execute();

		$stmt->close();

	}
	$comment = all_comments($id_article);

}else{
	echo "ERROR 404";
	exit();
}

 ?>
<div class="center">
	<?php if ($item['images'] !== ""): ?>
		<img src="<?php echo URL . "images/upload/" . $item['images']; ?>" class="responsive-img materialboxed">	
	<?php endif; ?>

</div><!-- End file content -->



<div class="content-post pt-4">
	<h3><?php echo $item['title']; ?></h3>
	<p class="f1-8 date"><strong>Publicado:</strong> <?php echo $item['created']; ?></p>

	<p><?php echo $item['description_a']; ?></p>
</div><!-- End content-post -->

<div class="content-ahutor pt-4 pb-3">
	<p class="f2">Publicado por:</p>
	<div class="ahutor-flex">
		<div class="picture-img">
			<a href="<?php echo URL . "user/" . base64_encode($item['user_name']); ?>">
				<?php if ($item['picture'] !== ""): ?>
					<img src="<?php echo URL . "images/users/" . $item['picture']; ?>" alt="username" width="100" height="100" class="circle">
					<?php else: ?>
						<img src="<?php echo URL; ?>images/person.png" alt="username" width="100" height="100" class="circle">
				<?php endif ?>
			</a>
		</div>
		<div class="details-ahutor">
			<p class="ahutor-name"><?php echo $item['user_name']; ?></p>
			<p class="ahutor-review"><?php echo $item['description']; ?></p>
		</div>
	</div>
</div><!-- End conetent ahutor -->

<div class="divider"></div>
<div class="card-footer-item right">
	<a href="javascript:void(0)" class="tooltipped" data-position="top" data-tooltip="Comentarios: <?php  echo $item['comments']; ?>">
		<i class="material-icons">comment</i>
	</a>

	<a href="javascript:void(0)" class="tooltipped" data-position="top" data-tooltip="Visitas: <?php  echo $item['visitors']; ?>">
		<i class="material-icons">groups</i>
	</a>
	<?php if (isset($_SESSION['id'])): ?>

		<a href="javascript:void(0)" class="tooltipped like" onclick="like_point('<?php echo $item['id_article']; ?>', '<?php echo $_SESSION['id']; ?>');" data-position="top" data-tooltip="Me gusta: <?php  echo $item['like_points']; ?>">
			<i class="material-icons">thumb_up_alt</i>
		</a>

	<?php else: ?>
		<a href="javascript:void(0)" class="tooltipped" onclick="M.toast({html:'Debe de ingresar para poder darle me gusta!!'})" data-position="top" data-tooltip="Me gusta: <?php  echo $item['like_points']; ?>">
			<i class="material-icons">thumb_up_alt</i>
		</a>
		
	<?php endif; ?>

</div>

<div class="content-commnets pt-4 pb-4">
	<p class="f2">Comentarios</p>
	<?php foreach ($comment as $value): ?>

		<?php if ($value['status'] !== 0): ?>
			<div class="ahutor-flex">
				<div class="picture-img">
					<a href="<?php echo URL . "user/" . base64_encode($value['user_name']); ?>" >
						<?php if ($value['picture'] !== ""): ?>
							<img src="<?php echo URL . "images/users/" . $value['picture']; ?>" alt="<?php echo $value['user_name']; ?>" width="70" height="70" class="circle">
						<?php else: ?>
							<img src="<?php echo URL; ?>images/person.png" alt="<?php echo $value['user_name']; ?>" width="70" height="70" class="circle">
							
						<?php endif; ?>

					</a>
				</div>
				<div class="details-ahutor">
					<p class="ahutor-name f1-4"><?php echo $value['user_name']; ?></p>
					<p class="ahutor-review f1-3"><?php echo $value['comment']; ?></p>
				</div>
			</div>
			<div class="divider"></div>
			
		<?php endif; ?>
		
	<?php endforeach; ?>

	<div class="commet_load"></div>

	<?php if (isset($_SESSION['id'])): ?>
		<form onsubmit="return false" class="fmComment pt-4" >
			<div class="input-field col s12">
				<i class="material-icons prefix">mode_edit</i>
                <textarea id="comment" name="comment" class="materialize-textarea"></textarea>
                <label for="description">Escribe un comentario</label>
			</div><!-- Enf col -->
			<input type="hidden" name="ahutor" value="<?php echo $_SESSION['id']; ?>" />

			<?php if ($_SESSION['picture'] !== ""): ?>
				<input type="hidden" name="picture" value="<?php echo URL . 'images/users/' . $_SESSION['picture']; ?>" />
				<?php else: ?>
				<input type="hidden" name="picture" value="<?php echo URL . 'images/person.png'; ?>" />
			<?php endif; ?>
				
			<input type="hidden" name="username" value="<?php echo $_SESSION['user_name']; ?>" />
			<input type="hidden" name="id_article" value="<?php echo $item['id_article']; ?>" />
			<input type="hidden" name="ahutor_article" value="<?php echo $item['ahutor']; ?>" />

			<button class="red darken-2 btn"  type="button" 
					onclick="add_comment(comment.value, ahutor.value, picture.value, username.value, id_article.value, ahutor_article.value);">Comentar</button>
		</form>
	<?php else: ?>
		<div class="card-panel red darkent-2" style="color: #fff; margin-top: 30px;">
			Inicia sesión para poder comentar
		</div>
		
	<?php endif; ?>


</div><!-- End conetent commnets -->


<script>
	$('.tooltipped').tooltip();
	$('.materialboxed').materialbox();
</script>
