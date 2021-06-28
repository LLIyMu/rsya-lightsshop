<?
/*
Template Name: Шаблон отели
Template Post Type: hotels
*/
get_header();
?>

<div class="headLine"></div>
<div class="wrapper">

	<? if(function_exists('bcn_display')) { ?>
		<div class="breadcrumbs">
			<?=bcn_display();?>
		</div>   
  	<? } ?>

	<div class="room-content">
	<div class="room-left">

		<h1 class="page-title"><?=the_title()?> <?=rating_stars();?></h1>

		<div class="hotel-address wrap-address"><?=hotel_address($post->ID);?> <a href="#popup-map" class="map-link">Показать на карте</a></div>

		<div class="flexbox">
			<div class="rating-wrap">
				<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
				<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
				<a href="#reviews" class="reviews"><?=comments_number('0 отзывов','1 отзыв','% отзывов');?></a>
			</div>
			<?=super_owner();?>
		</div>

		<div class="room-detail">

			<? if (get_field('gallery')) { ?>
			<div class="gallery-images">
				<? 
				$i = 1;
				$count = count(get_field('gallery')) - 5;

				foreach (get_field('gallery') as $image) { ?>
				<div class="gallery-item">
					<a href="<?=$image['url'];?>" data-fancybox="gallery">
						<img src="<?=$image['sizes']['large'];?>" alt="<?=the_title()?>"> 
						<span class="zoom"></span>
						<? if ($i > 5 || $i == 5) { ?>
							<div class="plus-photos">+ ещё <?=$count;?> фото</div>
						<? } ?>
					</a>
				</div>
				<? if ($i == 5) { ?>
					<?break;?>
				<? } ?>
				<? $i++; } ?>
			</div>
			<? } ?>

			<? if(get_field('video')) { ?>
 				<a href="<?=the_field('video');?>" data-fancybox="video" class="link-video">Видео объекта</a>
			<? } ?>
 			
 			<?if (properties_hotel()) {?>
			<ul class="properties properties-hotel">
				<?foreach (properties_hotel() as $prop) {?>
					<li><strong><?=$prop['title'];?>:</strong> <?=$prop['value'];?></li>
				<?}?>				
			</ul>
			<?}?>

			<? if (get_field('fast_booking') == 'Включить') { ?>
				<div class="fast-booking">Мгновенное бронирование</div>
			<? } ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="desc"><?php the_content(); ?></div>
			<?php
			endwhile;
			endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<? $variants = get_field('select_object', $post->ID);

		if( $variants ) { ?>
		<div class="variants" id="available-rooms">
		<h2 class="block-header">Доступные номера</h2>
		<div class="variants-rooms ajax">
		<? foreach( $variants as $post) { ?>
		    <? setup_postdata($post); ?>
			<div class="room-item">
				<div class="room-name"><?=the_title();?> <div class="room-collapse">Подробнее</div></div>
				<div class="room-wrap">
					<div class="room-content">
						<?if (get_field('gallery')) {?>
						<div class="room-gallery">
							<div class="room-slider">
								<?foreach (get_field('gallery') as $image) {?>
									<a href="<?=$image['url'];?>" data-fancybox="gallery">
										<img src="<?=$image['sizes']['large'];?>">
										<span class="zoom"></span>
									</a>
								<?}?>
							</div>
							<div class="counts-slides"><span class="current">1</span> / <span><?=count(get_field('gallery'));?></span></div>
						</div>
						<?}?>
						<div class="room-info">
							<?=properties_romms();?>
							<?=lightning();?>
							
							<div class="nights-guests">2 ночи, 2 взрослых, <?=the_price();?> за ночь</div>
							<div class="price-total">Всего <?=the_price();?> RUB</div>
							<div class="button-group">
								<div class="room-more">Подробнее о номере</div>
								<div class="btn btn-booking" data-id="<?=$post->ID;?>">Забронировать</div>
							</div>
							<div class="room-desc">
								<h4>Правила проживания</h4>
								<ul class="comfort">
									<li>животные запрещены</li>
									<li>курение на балконе</li>
								</ul>
								<h4>Общие удобства</h4>
								<ul class="comfort">
									<li>интернет: wifi</li>
									<li>телевизор: кабельное ТВ</li>
									<li>сейф: есть</li>
									<li>уборка: входит в стоимость</li>
								</ul>
								<ul class="comfort">
									<li>Санузлы: 2</li>
									<li>Кухня: есть</li>
									<li>Комнаты: 3</li>
									<li>Детская комната: есть</li>
								</ul>
							</div>
							<div class="room-calendar">Календарь и свободные даты этого номера</div>
						</div>
					</div>
				</div>
			</div>
		<? } ?>
		<? wp_reset_postdata(); ?>
		</div>
		</div>
		<? } ?>

		<h2 class="block-header">Местоположение</h2>
		<?=entity_map($post->ID);?>

		<h2 class="block-header m-b">Отзывы гостей</h2>
		<div class="rating-wrap">
			<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
			<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
			<div class="reviews"><?=comments_number('0 отзывов','1 отзыв','% отзывов');?></div>
		</div>

		<div class="reviews-hotel" id="reviews">
			<?
			$args = array(
				'post_id'   => $post->ID,
				'number'  => '3',
			);
			if( $comments = get_comments($args) ){ ?>
	 		<div class="reviews-list">
				<? foreach( $comments as $comment ){ ?>
			 		<div class="review-item">
			 			<div class="review-head">
			 				<div class="review-avatar avatar">
			 					<?=get_avatar( $comment, 44, '', '', array( 'class' => 'comment-avatar' ) );?>
			 				</div>
			 				<div class="review-content">
			 					<div class="reviewer"><?=$comment->comment_author;?></div>
			 					<div class="review-rating">
									<?php for ($i = 1; $i <= 5; $i++) { ?>
										<?php if (get_field('rating', $comment) < $i) { ?>
											<div class="star star-empty"></div>
										<?php } else { ?>
											<div class="star"></div>
										<?php } ?>
									<?php } ?>
			 					</div>
			 				</div>
			 				<div class="review-date"><?=comment_date( 'd.m.Y, H:i' );?></div>
			 			</div>
			 			<div class="review-text"><?=$comment->comment_content;?></div>
			 			<div class="review-period">проживал(а): <?=wp_date("F Y", strtotime(get_field('arrival_date', $comment)));?></div>
			 		</div>
				<? } ?>
	 		</div>
	 		<div class="all-reviews"><span>Показать все отзывы</span> <div class="plus">+</div></div>
	 		<? } else { ?>
	 			<p class="text-empty">В настоящее время пока никто не оставил отзыв на данный объект</p>
	 		<? } ?>
 		</div>


		<?include(TEMPLATEPATH . '/front/owner-profile.php');?>

		<?include(TEMPLATEPATH . '/front/object-similar.php');?>

	</div>
	<div class="room-right">	
		<?include(TEMPLATEPATH . '/front/sidebar-form.php');?>
	</div>
	</div>
</div>


<script type="text/javascript">
ymaps.ready(init);

function init() {
    var myMap = new ymaps.Map('entity-map', {
        zoom: 9,
        center: [<?=the_field('geocode', $post->ID);?>],
        controls: []
    }, {
        searchControlProvider: 'yandex#search'
    });
 
    var placemark = new ymaps.Placemark(myMap.getCenter(), {
        // Зададим содержимое заголовка балуна.
        balloonContentHeader: '',
        // Зададим содержимое основной части балуна.
        balloonContentBody: [
           '<div class="balloon-post">',
           '<div class="post-thumbnail"><a href="<?=get_permalink($post->ID);?>"><?=get_the_post_thumbnail($post->ID, array(355, 330));?></a></div>',
           '<div class="balloon-content">',
           // '<div class="category-name">Апартаменты / квартиры</div>',
           '<div class="post-name"><a href="<?=get_permalink($post->ID);?>"><?=get_the_title($post->ID)?></a></div>',
           '<div class="post-rating">',
           '<div class="rating rating-orange"><?=rating(get_field('guest_rating', $post->ID), 'number');?></div>',
           '<div class="rating-content">',
           '<div class="rating-text"><?=rating(get_field('guest_rating', $post->ID), 'text');?></div>',
           '<div class="reviews"><?=comments_number('0 отзывов','1 отзыв','% отзывов');?></div>',
           '</div>',
           '</div>',
           '<div class="post-price"><?=the_field('price', $post->ID);?> RUB / за сутки</div>',
           '<a href="<?=get_permalink($post->ID);?>" class="btn btn-booking">Забронировать</a>',
           '</div>',
           '</div>'
        ].join(''),

        // Зададим содержимое нижней части балуна.
        balloonContentFooter: '',
        // Зададим содержимое всплывающей подсказки.
        hintContent: '',
        iconContent: '<?=the_field('price', $post->ID);?> RUB'
    }, {
        preset: 'islands#redStretchyIcon'
    });

    // Добавим метку на карту.
    myMap.geoObjects
   .add(placemark)

   placemark.balloon.open();
}
</script>

<?php
get_footer();
