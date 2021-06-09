<?php
if (!is_user_logged_in() ) {
	wp_redirect( home_url() ); 
	exit;
}
get_header();
/* Template Name: Настройки */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

	<div class="profile page-wrap">

		<div class="left-side">
			<ul class="menu-left">
				<li><a href="#user" class="active">1. <span>О пользователе</span></a></li>
				<li><a href="#contacts">2. <span>Контактная информация</span></a></li>
				<li><a href="#notifications">3. <span>Уведомления</span></a></li>
				<li><a href="#socials">4. <span>Социальные сети</span></a></li>
				<li><a href="#password">5. <span>Ваш пароль</span></a></li>
			</ul>
		</div>

		<div class="right-side">
			<?get_template_part('front/profile-settings');?>
		</div>

	</div>
</div>

<?php
get_footer();