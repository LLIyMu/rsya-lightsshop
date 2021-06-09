<div class="block-header">Похожие объявления</div>
<div class="hotels-list similar-hotels">
<?php $args = array(
'posts_per_page' => 3,
'post_type' => 'hotels',
'order' => 'ASC',
'post_status' => 'publish'
);
query_posts( $args ); ?>
<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	
	<div class="hotel-item">
		<div class="hotel-image">
			<a href="<?=get_permalink();?>"><?=the_post_thumbnail(array(355, 330));?></a>
			<?=button_favorite();?>
	 		<?=super_owner();?>
	 		<?=owner_status();?>
		</div>
		<div class="hotel-content">
			<div class="hotel-head">
				<? if( get_field('rooms_count') ){ ?>
				<div class="room-name"><?=rooms_type(get_field('rooms_count'));?></div>
				<? } ?>
				<div class="rating-wrap">
					<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
					<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
					<div class="reviews"><?=num_word( get_comments_number(), array("отзыв","отзыва","отзывов") ); ?></div>
				</div>
			</div>
			<div class="hotel-title"><a href="<?=get_permalink();?>"><?=the_title();?></a></div>
	
			<div class="hotel-address"><?=hotel_address($post->ID);?> <div data-id="<?=$post->ID;?>" class="map-link">Показать на карте</div></div>
	 
			<?=services();?>
	
			<div class="hotel-bottom flexbox">
				<div class="hotel-price">
					<div class="price"><span><?=the_price();?> RUB</span> за ночь</div>
				</div>
				<a href="<?=get_permalink();?>" class="btn-more">Подробнее</a>
			</div>
			
		</div>
	</div>
<? 
endwhile;
endif; 
wp_reset_query();
?>
</div>
 