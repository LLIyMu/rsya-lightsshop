<?php
get_header();
/* Template Name: Личный кабинет */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

	<? if (!is_user_logged_in() ) { ?>
		<?get_template_part('front/auth');?>
	<? } else { ?>
		<div class="profile page-wrap">

			<div class="left-side">
				<?get_template_part('front/profile-sidebar');?>
			</div>

			<div class="right-side">
				<?get_template_part('front/profile-common');?>
				<?get_template_part('front/object-form');?>
			</div>

		</div>
	<? } ?>
</div>

<?php
get_footer();