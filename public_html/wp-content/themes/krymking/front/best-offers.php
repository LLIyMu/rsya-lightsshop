<h2 class="title">Лучшие предложения</h2>

<? $post_objects = get_field('best_offers', 7);
if( $post_objects ) { ?>
    <div class="offers-list">
    <? foreach( $post_objects as $post) { ?>
        <? setup_postdata($post); ?>
		<div class="offer-item">
			<div class="offer-content">
				<div class="offer-image">
					<a href="<?=the_permalink();?>"><?=the_post_thumbnail(array(355, 330));?></a>
				</div>
				<div class="offer-info">
					<div class="offer-title"><a href="<?=the_permalink();?>"><?=the_title();?></a></div>
					<div class="offer-position"><?=place();?></div>
					<div class="offer-price"><?=the_price();?> RUB<span> за ночь</span></div>
					<div class="flexbox rating-wrap">
						<div class="rating"><?=rating(get_field('guest_rating'), 'number');?></div>
						<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
						<div class="reviews"><?=num_word( get_comments_number(), array("отзыв","отзыва","отзывов") ); ?></div>
					</div>
				</div>
			</div>
		</div>
    <? } ?>
    </div>
<? } ?>