<?php
if (!is_user_logged_in() ) {
	wp_redirect( home_url() ); 
	exit;
}
get_header();
/* Template Name: Мои объекты */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

	<div class="profile page-wrap">

		<div class="left-side">
			<?get_template_part('front/profile-sidebar');?>
		</div>

		<div class="right-side">
 			<?get_template_part('front/profile-objects');?>
 			<?get_template_part('front/object-form');?>
	 	</div>

 	</div>
</div>

<?php
get_footer();