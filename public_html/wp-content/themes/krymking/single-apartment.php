<?
/*
Template Name: Шаблон квартиры
Template Post Type: hotels
*/
get_header();
$url = get_template_directory_uri();

$postid = $post->ID;
 
?>
<div class="headLine"></div>
<div class="wrapper">
 <? if(function_exists('bcn_display')) {?>
  <div class="breadcrumbs">
    <?=bcn_display();?>
  </div>   
  <? } ?>
	<div class="room-content">
	<div class="room-left">
		<h1 class="page-title"><?=the_title()?></h1>
		<div class="room-name"><?=rooms_type(get_field('rooms_count'));?></div>
		<div class="hotel-address wrap-address"><?=hotel_address($post->ID);?> <a href="#popup-map">Показать на карте</a></div>
		<div class="flexbox">
			<div class="rating-wrap">
				<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
				<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
				<a href="#reviews" class="reviews"><?=num_word( get_comments_number(), array("отзыв","отзыва","отзывов") ); ?></a>
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
			<div class="room-title"><?=rooms_type(get_field('rooms_count'));?> <span><?=the_title()?></span></div>

			<?=properties_romms();?>
			<?=lightning();?>
			<?=services();?>
		</div>
		
		
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<? if (get_the_content()) { ?>
				<div class="room-parameters">
					<h3>Описание объекта</h3>
					<?php the_content(); ?>
				</div>
			<? } ?>
		<?php
		endwhile;
		endif; 
		wp_reset_query();
		?>

		<? if(fields( rulesRoom($post->ID) )) { ?>
		<div class="room-parameters">
			<h3>Правила проживания</h3>
			<ul class="attributes-line attributes-flex">
				<? foreach (fields( rulesRoom($post->ID) ) as $field) { ?>
					<li><strong><?=$field['label'];?>:</strong> <?=$field['value'];?></li>
				<? } ?>
			</ul>
		</div>
		<? } ?>

		<div class="room-parameters parameters-list">
			<? if(fields( generalApartment($post->ID) )) { ?>
			<div class="parameters-item">
				<h3>Общие удобства</h3>
				<ul class="attributes">
				<? foreach (fields( generalApartment($post->ID) ) as $field) { ?>
					<li><span><?=$field['label'];?>:</span> <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			<? if(fields( sanuzelApartment($post->ID) )) { ?>
			<div class="parameters-item">
				<h3>Санузлы</h3>
				<ul class="attributes">
				<? foreach (fields( sanuzelApartment($post->ID) ) as $field) { ?>
					<li><span><?=$field['label'];?>:</span> <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			<? if(fields( kitchenApartment($post->ID) )) { ?>
			<div class="parameters-item">
				<h3>Кухня</h3>
				<ul class="attributes">
				<? foreach (fields( kitchenApartment($post->ID) ) as $field) { ?>
					<li><span><?=$field['label'];?>:</span> <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			<? if(fields( roomsApartment($post->ID) )) { ?>
			<div class="parameters-item">
				<h3>Комнаты</h3>
				<ul class="attributes">
				<? foreach (fields( roomsApartment($post->ID) ) as $field) { ?>
					<li><span><?=$field['label'];?>:</span> <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			<? if(fields( childrenRoom($post->ID) )) { ?>
			<div class="parameters-item">
				<h3>Детям</h3>
				<ul class="attributes">
				<? foreach (fields( childrenRoom($post->ID) ) as $field) { ?>
					<li><?=$field['label'];?>: <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			<? if(fields( territoryApartment($post->ID) )) { ?>
			<div class="parameters-item">
				<h3>На территории</h3>
				<ul class="attributes">
				<? foreach (fields( territoryApartment($post->ID) ) as $field) { ?>
					<li><?=$field['label'];?>: <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			<? if(fields( accessibleApartment($post->ID) )) { ?>
			<div class="parameters-item full">
				<h3>Доступная среда</h3>
				<ul class="attributes">
				<? foreach (fields( accessibleApartment($post->ID) ) as $field) { ?>
					<li><?=$field['label'];?>: <?=$field['value'];?></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
		</div>

		<?if (get_field('field_601ac5ffd10b7') || get_field('field_60091b7a9ad97')) { ?>
		<div class="room-parameters">
			<h3>Инфраструктура</h3>
			<?if (get_field('field_601ac5ffd10b7')) { ?>
				<div class="attr-title">Расстояние до важных объектов</div>
				<ul class="attributes-line">
				<? foreach (get_field('field_601ac5ffd10b7') as $field) { ?>
					<li><span><?=$field['objects']['label'];?>:</span> <?=$field['distance']['label'];?></li>
				<? } ?>
				</ul>
			<? } ?>
			<?if (get_field('field_60091b7a9ad97')) { ?>
				<div class="attr-title">Варианты досуга в городе</div>
				<ul class="attributes horizontally">
				<? foreach (get_field('field_60091b7a9ad97') as $field) { ?>
					<li><?=$field;?></li>
				<? } ?>
				</ul>
			<? } ?>
		</div>
		<? } ?>

		<div class="room-parameters">
			<h3>Услуги</h3>
			<ul class="attributes-line">
			<? foreach (acf_get_fields(412) as $param) { ?>
				<?if (get_field_object($param['key'])['type'] == 'radio') {?>
					<li><strong><?=get_field_object($param['key'])['label'];?>:</strong> <?=get_field_object($param['key'])['value'];?></li>
				<? } elseif(get_field_object($param['key'])['type'] == 'group') { ?>
					<?foreach (get_field_object($param['key'])['sub_fields'] as $field) { ?>
						<li><strong><?=$field['label'];?>:</strong> <?=get_field_object($param['key'])['value'][$field['name']];?></li>
					<?}?>
				<? } else { ?>
					<li><strong><?=get_field_object($param['key'])['label'];?>:</strong> <?=get_field_object($param['key'])['value'];?></li>
				<? } ?>
			<? } ?>
			</ul>
		</div>

		<div class="room-parameters">
			<?=free_calendar($post->ID);?>
		</div>

		<h2 class="block-header">Местоположение</h2>
		<?=entity_map($post->ID);?>

		<h2 class="block-header m-b">Отзывы гостей</h2>
		<div class="rating-wrap">
			<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
			<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
			<div class="reviews"><?=num_word( get_comments_number(), array("отзыв","отзыва","отзывов") ); ?></div>
		</div>

		<div class="reviews-hotel" id="reviews">
			<?
			$args = array(
				'post_id'   => $postid,
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

 		<?get_template_part('front/object-similar');?>

	</div>
	<div class="room-right">
		<?include(TEMPLATEPATH . '/front/sidebar-form.php');?>
	</div>
	</div>
</div>

<script type="text/javascript">

</script>

<?php
get_footer();
