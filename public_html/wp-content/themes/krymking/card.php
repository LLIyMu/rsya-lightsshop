<div class="side-right">
	<div class="sort-menu">
		<div class="sort-label">Сортировать по: </div>
		<div class="sort-option active">Рекомендованные</div>
		<div class="sort-option">Сначала дешевые </div>
		<div class="sort-option">Сначала дорогие</div>
		<div class="sort-option">Оценка гостей</div>
		<div class="sort-option">Близость к морю</div>
	</div>
	<div id="search-map"></div>
	<div class="hotels-list">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	
		<div class="hotel-item">
			<div class="hotel-image">
				<a href="<?=get_permalink();?>"><?=the_post_thumbnail(array(355, 330));?></a>
				<div class="favorite"></div>
				<div class="super">Супервладелец</div>
				<div class="partner">Золотой партнёр</div>
			</div>
			<div class="hotel-content">
				<div class="hotel-head">
					<div class="room"><?=rooms_type(get_field('rooms_count'));?></div>

					<div class="right">
						<div class="rating rating-orange"><?=rating(500, 'number');?></div>
						<div class="rating-text"><?=rating(500, 'text');?></div>
						<div class="reviews">99 отзывов</div>
					</div>
				</div>
				<div class="hotel-title"><a href="<?=get_permalink();?>"><?=the_title();?></a></div>

				<div class="hotel-address"><?=hotel_address($post->ID);?> <a href="https://yandex.ru/maps/?text=<?=hotel_address($post->ID);?>" rel="nofollow" target="_blank" class="map-link">Показать на карте</a></div>
				<ul class="properties">
					<li><?=label_name('area');?>: <span><?=the_field('area');?> м.кв.</span></li>
					<li><?=label_name('guests_count');?>: <span><?=num_word(get_field('guests_count'), array("взрослый","взрослых") );?></span></li>
					<li><?=label_name('rooms_count');?>: <span><?=the_field('rooms_count');?></span></li>
					<li><?=label_name('bed_count');?>: <span><?=the_field('bed_count');?></span></li>
					<li><?=label_name('bed_total');?>: <span><?=the_field('bed_total');?></span></li>
					<li><?=label_name('bathroom');?>: <span><?=the_field('bathroom');?></span></li>
					<li><?=label_name('distance');?>: <span><?=the_field('distance');?> м</span></li>
				</ul>
				<div class="hotel-bottom flexbox">
					<? if (get_field('fast_booking') == 'Включить') { ?>
					<div class="fast-booking">Мгновенное бронирование</div>
					<? } ?>
					<div class="hotel-price">
						<div class="period"><?=nights($_GET['days'], $_GET['guests']);?></div>
						<div class="price"><span><?=the_field('price');?> RUB</span> за ночь</div>
					</div>
					<div class="hotel-total">Всего: <span><?=price_total(get_field('price'), $_GET['days']);?> RUB</span></div>
				</div>
				<div class="services">
					<div class="service icon-wifi"></div>
					<div class="service icon-parking"></div>
					<div class="service icon-cart"></div>
					<div class="service icon-info"></div>
					<div class="service icon-info"></div>
				</div>
			</div>
		</div>
		<?php
	endwhile;
	endif; ?>
	</div>
</div>