<?php
if ( is_page(array(260, 268)) ) {
	wp_redirect( '/preimushhestva-dlya-vladelczev/' );
}

get_header();
/* Template Name: Справочник Владельца */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>
	<div class="handbook-header">
		<h4>Мы готовы ответить на все Ваши вопросы</h4>
		<div class="handbook-switch">
			<a href="/gostyam/">Справочник Гостя</a>
			<a href="/vladelczam/" class="active">Справочник Владельца</a>
		</div>
	</div>
	<div class="handbook-wrap">
		<div class="handbook-left">
			<?php wp_nav_menu( array(
			'menu'        => 'Справочник Владельца', 
			'container'  => false,
			'items_wrap' => '<ul class="menu-left">%3$s</ul>'
			));
			?>
		</div>
		<div class="handbook-right">
			<div class="handbook-item active">
				<div class="handbook-title"><?=the_title();?></div>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?if (get_the_content()) {?>
				<div class="handbook-text">
					<?php the_content(); ?>
				</div>
				<?}?>
				<?php
				endwhile;
				endif; 
				wp_reset_query();
				?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer();