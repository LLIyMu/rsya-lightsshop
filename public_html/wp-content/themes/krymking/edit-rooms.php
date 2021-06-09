<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

 	<form class="profile page-wrap create-room edit-room" method="post" action="create_object">
 		<input type="hidden" name="action" value="create_object">
 		<input type="hidden" name="object_type" value="<?=$object_type;?>">
 		<input type="hidden" name="post_ID" value="<?=$postid;?>">
		<input type="hidden" name="_wp_page_template" value="single-apartment.php">

 		<div class="side-left">
			<?get_template_part('front/sidebar-room');?>
		</div>

		<div class="side-right">
			<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?get_template_part('front/profile-rooms');?>
  			<? endwhile;
  			endif; ?>

			<div class="message success update-fields"></div>
		</div>

	</form>
</div>