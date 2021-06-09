<div class="hotel-item">
	<div class="hotel-image">
		<a href="<?=get_permalink();?>" target="_blank">
			<?=the_post_thumbnail(array(355, 330));?>
		</a>
		<?=button_favorite();?>
		<?=super_owner();?>
	 	<?=owner_status();?>
	</div>
	<div class="hotel-content">
		<div class="hotel-head">
		
			<? if ( get_field('select_hotel') ) { ?>
				<div class="room-name">
					<? 
					$terms = get_the_terms(get_field('select_hotel')->ID, 'type' );
					if ( $terms ) {
						$term = array_shift( $terms );
					}
					if ( $term->term_id == 85 ) {
						$title = 'Отель «'.get_field('select_hotel')->post_title.'»';
					} elseif ( $term->term_id == 86 ) {
						$title = 'Мини-отель «'.get_field('select_hotel')->post_title.'»';
					} elseif ( $term->term_id == 87 ) {
						$title = 'Пансионат «'.get_field('select_hotel')->post_title.'»';
					} 
					echo $title;
					?>
				</div>
			<? } else { ?>
				<div class="room-name"><?=rooms_type(get_field('rooms_count'));?></div>
			<? } ?>

			<div class="rating-wrap">
				<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
				<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
				<div class="reviews"><?=num_word( get_comments_number(), array("отзыв","отзыва","отзывов") ); ?></div>
			</div>

		</div>

		<div class="hotel-title"><a href="<?=get_permalink();?>" target="_blank"><?=the_title();?></a></div>

		<div class="hotel-address"><?=hotel_address($post->ID);?> <div data-id="<?=$post->ID;?>" class="map-link">Показать на карте</div></div>
		<?=properties_romms();?>

		<div class="hotel-bottom flexbox">
			<?=lightning();?>
			<div class="hotel-price">
				<div class="period"><?=guests_nights();?></div>
				<div class="price"><span><?=the_price();?> RUB</span> за ночь</div>
			</div>
			<div class="hotel-total">Всего: <span><?=price_total(the_price(), days($_SESSION['check_in'], $_SESSION['check_out']) );?> RUB</span></div>
		</div>
		<?=services();?>
		<a href="<?=get_permalink();?>" class="btn-more" target="_blank">Подробнее</a>
	</div>
</div>