<? if( $_GET['action'] == 'edit-rooms'){ ?>
	<? get_template_part('room'); ?>
<? } else { ?>
	<div class="headLine"></div>
	<div class="wrapper">
		<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

	 	<form class="profile page-wrap create-room" method="post" action="https://krymking.ru/profile/add/hotels/room/">
	 		<input type="hidden" name="action" value="create_object">
	 		<input type="hidden" name="object_type" value="<?=$object_type;?>">
	 		<input type="hidden" name="post_ID" value="<?=$postid;?>">
			<input type="hidden" name="_wp_page_template" value="single-hotel.php">

	 		<div class="side-left">
				<?get_template_part('front/sidebar-hotel');?>
			</div>
			<div class="side-right">
			<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<? get_template_part('front/profile-hotels'); ?>
	  		<? endwhile;
	  		endif; ?>
			</div>
		</form>
	</div>
<? } ?>