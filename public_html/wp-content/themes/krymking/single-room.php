<?
/*
Template Name: Шаблон номера
Template Post Type: hotels
*/
get_header();
 
if ( get_field('select_hotel') ) { 
	$post_id = get_field('select_hotel')->ID;
} else {
	$post_id = $post->ID;
}


$attr = array();

$attr[] = get_field_object('field_601ac0b50c5f4', $post_id);
$attr[] = get_field_object('field_601ac17b49eb5', $post_id);
$attr[] = get_field_object('field_6006a2f5f84ee', $post_id);
$attr[] = get_field_object('field_6006a3e0f84ef', $post_id);
$attr[] = get_field_object('field_601ac2188dba1', $post_id);
$attr[] = get_field_object('field_601ac2a797a84', $post_id);
$attr[] = get_field_object('field_60057524eebd4', $post_id);
$attr[] = get_field_object('field_6009187c2a3a1', $post_id);
$attr[] = get_field_object('field_5fd71f7ce412a', $post_id);
$attr[] = get_field_object('field_602eb4cae6289', $post_id);
$attr[] = get_field_object('field_6005818e0da6a', $post_id);
 
// Внутри или на территории отеля
$territory[] = get_field_object('field_6005774f41bef', $post_id); // Интернет
$territory[] = get_field_object('field_600918902a3a2', $post_id); // Ресторан
$territory[] = get_field_object('field_606461f2b4fbc', $post_id); // Кафе
$territory[] = get_field_object('field_606461f0b4fbb', $post_id); // Столовая
$territory[] = get_field_object('field_606461d8b4fba', $post_id); // Общая кухня
$territory[] = get_field_object('field_606461d6b4fb9', $post_id); // Бар
$territory[] = get_field_object('field_600915a8f72b2', $post_id); // Беседка
$territory[] = get_field_object('field_60057e7c2e1c0', $post_id); // Терраса
$territory[] = get_field_object('field_60091626f72b5', $post_id); // Веранда
$territory[] = get_field_object('field_6064635c674b9', $post_id); // Собственный пляж
$territory[] = get_field_object('field_60091642f72b6', $post_id); // Бассейн
$territory[] = get_field_object('field_6009167df72b7', $post_id); // Сауна/баня
$territory[] = get_field_object('field_60646359674b8', $post_id); // Спа зона
$territory[] = get_field_object('field_6009157c469c8', $post_id); // Мангальная/барбекю зона
$territory[] = get_field_object('field_6009185c2a3a0', $post_id); // Бильярд
$territory[] = get_field_object('field_6079414d3022b', $post_id); // Детская комната
$territory[] = get_field_object('field_600916aef72b8', $post_id); // Детская площадка
$territory[] = get_field_object('field_60091724f72b9', $post_id); // Батут
$territory[] = get_field_object('field_600917e12a39b', $post_id); // Спортивная площадка
$territory[] = get_field_object('field_6009181a2a39d', $post_id); // Зал для фитнеса
$territory[] = get_field_object('field_6009182d2a39e', $post_id); // Волейбол
$territory[] = get_field_object('field_6009183c2a39f', $post_id); // Футбол
$territory[] = get_field_object('field_606464f5f5461', $post_id); // Баскетбол
$territory[] = get_field_object('field_606464f3f5460', $post_id); // Большой теннис
$territory[] = get_field_object('field_600919092a3a3', $post_id); // Курение в специально отведенных местах
$territory[] = get_field_object('field_60792c963e8bd', $post_id); // Лифт
$territory[] = get_field_object('field_600919d84971f', $post_id); // Для гостей с ограниченными физическими возможностями
$territory[] = get_field_object('field_608677aa54e39', $post_id); // Конференц-зал

// Услуги
$service[] = get_field_object('field_60092146474da', $post_id); // Трансфер
$service[] = get_field_object('field_60092180474db', $post_id); // Парковка

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

		<h1 class="page-title"><?=get_the_title($post_id)?> <?=rating_stars($post_id);?></h1>

		<div class="hotel-address wrap-address"><?=hotel_address($post_id);?> <a href="#popup-map" class="map-link">Показать на карте</a></div>

		<div class="flexbox">
			<div class="rating-wrap">
				<div class="rating rating-orange"><?=rating(get_field('guest_rating', $post_id), 'number');?></div>
				<div class="rating-text"><?=rating(get_field('guest_rating', $post_id), 'text');?></div>
				<a href="#reviews" class="reviews"><?=comments_number('0 отзывов','1 отзыв','% отзывов');?></a>
			</div>
			<?=super_owner();?>
		</div>

		<div class="room-detail">

			<? if ( get_field('gallery', $post_id) ) { ?>
			<div class="gallery-images">
				<? 
				$i = 1;
				$count = count(get_field('gallery', $post_id)) - 5;

				foreach ( get_field('gallery', $post_id) as $image ) { ?>
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

			<? if(get_field('video', $post_id)) { ?>
 				<a href="<?=the_field('video', $post_id);?>" data-fancybox="video" class="link-video">Видео объекта</a>
			<? } ?>
 			
 			<!-- <?if (properties_hotel($post_id)) {?>
			<ul class="properties properties-hotel">
				<?foreach (properties_hotel($post_id) as $prop) {?>
					<li><strong><?=$prop['title'];?>:</strong> <?=$prop['value'];?></li>
				<?}?>				
			</ul>
			<?}?> -->

			<? if (get_field('fast_booking') == 'Включить') { ?>
				<div class="fast-booking">Мгновенное бронирование</div>
			<? } ?>

			<? $posts = get_post( $post_id ); ?>
			<? if( $posts->post_content ) { ?>


                <div class="room-parameters room-param">
                    
                    <div class="hidden" style="display: block;">
                        <ul class="attributes-line attributes-flex">
                            <? foreach (fields($attr) as $field) { ?>
                                <li><strong><?=$field['label'];?>: </strong> <?=$field['value'];?></li>
                            <? } ?>
                        </ul>
                    </div>
                </div>





				<div class="desc">
					<div class="block-header">Описание отеля</div>
					<?=$posts->post_content;?>
				</div>
			<? } ?>
			

		</div>
 


		<div class="room-parameters room-param">
			<h3>Внутри или на территории отеля <div class="param-collapse">Подробнее</div></h3>
			<div class="hidden">
				<ul class="attributes-line attributes-flex">
					<? foreach (fields($territory) as $field) { ?>
						<li><strong><?=$field['label'];?>: </strong> <?=$field['value'];?></li>
					<? } ?>
				</ul>
			</div>
		</div>
 
		<?if (get_field('field_601ac5ffd10b7') || get_field('field_60091b7a9ad97')) { ?>
		<div class="room-parameters room-param">
			<h3>Инфраструктура <div class="param-collapse">Подробнее</div></h3>
			<div class="hidden">
				<div class="attr-title">Расстояние до важных объектов</div>
				<ul class="attributes-line">
				<? foreach (get_field('field_601ac5ffd10b7') as $field) { ?>
					<li><span><?=$field['objects']['label'];?>:</span> <?=$field['distance']['label'];?></li>
				<? } ?>
				</ul>

				<div class="attr-title">Варианты досуга в городе</div>
				<ul class="attributes horizontally">
				<? foreach (get_field('field_60091b7a9ad97') as $field) { ?>
					<li><?=$field;?></li>
				<? } ?>
				</ul>
			</div>
		</div>
		<? } ?>

		<div class="room-parameters room-param">
			<h3>Услуги <div class="param-collapse">Подробнее</div></h3>
			<div class="hidden">
				<ul class="attributes-line">
					<? foreach (fields($service) as $field) { ?>
						<li><strong><?=$field['label'];?>: </strong> <?=$field['value'];?></li>
					<? } ?>
				</ul>
			</div>
		</div>

		<?
		$variants = get_field('select_object', $post_id);
		$room_id = get_the_ID();
 
		if( $variants ) { ?>

		<div class="variants" id="available-rooms">
			<h2 class="block-header">Доступные номера</h2>
			<div class="variants-rooms ajax">
				<? 
				$args = array(
					'post_type' => 'hotels',
					'post__in' => $variants
				);
				query_posts( $args );
				
				while ( have_posts() ) {
					the_post(); ?>
					<?include(TEMPLATEPATH . '/front/room-card.php');?>
				<? }
				wp_reset_postdata();
				?>
			</div>
		</div>
		<? } ?>

		<h2 class="block-header">Местоположение</h2>
		<?=entity_map($post_id);?>

		<h2 class="block-header m-b">Отзывы гостей</h2>
		<div class="rating-wrap">
			<div class="rating rating-orange"><?=rating(get_field('guest_rating', $post_id), 'number');?></div>
			<div class="rating-text"><?=rating(get_field('guest_rating', $post_id), 'text');?></div>
			<div class="reviews"><?=comments_number('0 отзывов','1 отзыв','% отзывов');?></div>
		</div>

		<div class="reviews-hotel" id="reviews">
			<?
			$args = array(
				'post_id'   => $post_id,
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

<?php
get_footer();

