<?php
if (!is_user_logged_in() ) {
	wp_redirect( home_url() ); 
	exit;
}
get_header();
/* Template Name: Статистика */
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
			<div class="heading">Статистика</div>
			<?
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'hotels',
				'post_status' => 'publish, draft, pending, rejected',
				'order' => 'ASC',
				'author' => get_current_user_id(),
			);
			query_posts( $args ); ?>
			<div class="objects-list statistics-list">
			<? while ( have_posts() ) {
			the_post(); ?>
				<div class="object-item">
					<div class="object-image"><a href="<?=get_permalink();?>"><?=the_post_thumbnail(array(200, 200));?></a></div>
					<div class="object-content">
						<a href="<?=get_permalink();?>" class="object-title"><?=the_title();?></a>
						<ul class="statistics">
							<li>Количество добавлений в избранное: <span><?=the_field('favorite_count');?></span></li>
							<li>Количество сообщений по объекту: <span>10</span></li>
							<li>Количество запросов на бронирование: <span>10</span></li>
							<li>Количество совершенных бронирований: <span>15</span></li>
							<li>Количество отказов на бронирование: <span>25</span></li>
						</ul>
					</div>
				</div>
			<? } ?>
			</div>
 			<?get_template_part('front/object-form');?>
	 	</div>

 	</div>
</div>

<?php
get_footer();