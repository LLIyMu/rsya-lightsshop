<?php
if (!is_user_logged_in() ) {
	wp_redirect( home_url() ); 
	exit;
}
get_header();
/* Template Name: Мои сообщения */
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
 			<ul class="profile-nav">
				<li><a href="#" class="active">Входящие</a></li>
				<li><a href="#">Отправленные</a></li>
				<li><a href="#">Черновики</a></li>
				<li><a href="#">Архив</a></li>
			</ul>
			<div class="messages-list">
				<div class="message-item">
					<div class="message-avatar"></div>
					<div class="message-name"><!--Евгений Кравченко--></div>
				</div>
			</div>
 			<?get_template_part('front/object-form');?>
	 	</div>

 	</div>
</div>
 

<?php
get_footer();