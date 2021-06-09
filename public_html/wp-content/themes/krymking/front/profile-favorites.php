<div class="favorite-wrap">
	<div class="header-heading">
		<div class="heading">Избранное (<?=count(unserialize(get_field('favorite', 'user_' .get_current_user_id() )));?>)</div>
	</div>
	<?
	if (!empty(unserialize(get_field('favorite', 'user_' .get_current_user_id() )))) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'hotels',
			'order' => 'ASC',
			'post__in' => unserialize(get_field('favorite', 'user_' .get_current_user_id() ))
		);
		query_posts( $args ); ?>
	
		<? if ( have_posts() ) { ?>
	
		<div class="objects-list favorites">
			<? while ( have_posts() ) {
			the_post(); ?>
				<div class="object-item">
					<div class="object-content">
						<a href="<?=get_permalink();?>" class="object-title"><?=the_title();?></a>
						<? if(get_field('select_hotel')) {
							$post_id = get_field('select_hotel');
						} else {
							$post_id = $post->ID;
						} ?>
						<div class="object-address"><?=hotel_address($post->ID);?>, ул. <?=the_field('street', $post_id);?>, <?=the_field('house', $post_id);?></div>
					</div>
					<div class="object-image">
						<a href="<?=get_permalink();?>"><?=the_post_thumbnail(array(200, 200));?></a>
						<div class="remove-favorites" data-id="<?=$post->ID;?>" title="Удалить из избранного">×</div>
					</div>
				</div>
			<? } ?>
		</div>
		<? } ?>
	<? } else { ?>
		<div class="empty-text">Как жаль! У Вас нет выбранных объектов! Нажмите <a href="https://krymking.ru/hotels/">«Найти жилье»</a> и сделайте свой выбор!</div>
	<? } ?>
</div>