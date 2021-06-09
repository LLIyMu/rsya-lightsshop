<?
$posts1 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_type' => 'orders',
		'post_status' => 'confirmed',
		'meta_query' => array(
			array(
				'key'     => 'customer',
				'value'   => get_current_user_id(),
			)
		)
	)
);
$posts2 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'confirmed',
		'post_type' => 'orders',
		'meta_query' => array(
			array(
				'key'     => 'customer',
				'value'   => get_current_user_id(),
			)
		)
	)
);
$posts3 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'canceled',
		'post_type' => 'orders',
		'meta_query' => array(
			array(
				'key'     => 'customer',
				'value'   => get_current_user_id(),
			)
		)
	)
);

if(is_page(101)) {
	$page_status = 'request';
}
if(is_page(845)) {
	$page_status = 'confirmed';
}
if(is_page(847)) {
	$page_status = 'canceled';
}
?>

<ul class="profile-nav">
	<li><a href="/profile/travel/" class="<?=$page_status == 'request' ? 'active' : '';?>">Предстоящие поездки (<?=$posts1->post_count;?>)</a></li>
	<li><a href="/profile/travel/completed/" class="<?=$page_status == 'confirmed' ? 'active' : '';?>">Завершенные поездки (<?=$posts2->post_count;?>)</a></li>
	<li><a href="/profile/travel/canceled/" class="<?=$page_status == 'canceled' ? 'active' : '';?>">Отмененные поездки (<?=$posts3->post_count;?>)</a></li>
</ul>
 
<div class="travels-list">
	<?php 
	
	if(is_page(845)) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'orders',
			'post_status' => 'confirmed',
			'meta_query' => array(
				array(
					'key'     => 'customer',
					'value'   => get_current_user_id(),
				),
				array(
					'key'     => 'booking_status',
					'value'   => 2,
				)
			),
		);
 
	} elseif( is_page(847) ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'orders',
			'post_status' => 'canceled',
			'meta_query' => array(
				array(
					'key'     => 'customer',
					'value'   => get_current_user_id(),
				)
			),
		);
	} else {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'orders',
			'post_status' => 'confirmed',
			'meta_query' => array(
				array(
					'key'     => 'customer',
					'value'   => get_current_user_id(),
				)
			)
		);
	}

	query_posts( $args ); ?>
	<?php
	if ( have_posts() ) {
	while ( have_posts() ) {
	the_post(); 

	$price = get_field('price', get_field('apartment'));
	$days = days(get_field('check_in'), get_field('check_out'));

	if(get_field('select_hotel', get_field('apartment'))) {
		$post_id = get_field('select_hotel', get_field('apartment'));
	} else {
		$post_id = get_field('apartment');
	}
	?>
	<div class="travel-item">
		<div class="travel-content">
			<a href="<?=get_permalink(get_field('apartment'));?>" class="travel-title"><?=get_the_title(get_field('apartment'));?></a>
			<div class="travel-address"><a href="<?=get_permalink(get_field('apartment'));?>"><?=address($post_id);?></a></div>
			<ul class="travel-info">
				<li><span>Номер бронирования:</span> <?=$post->ID;?></li>
				<li><span>Даты поездки:</span> <?=the_field('check_in');?> - <?=the_field('check_out');?></li>
				<li><span>Количество гостей:</span> <?=the_field('guests');?></li>
				<li><span>Цена:</span> <?=price_total($price, $days);?> RUB</li>
				<li><span>Уже оплачено:</span> <?=the_field('prepayment');?> RUB</li>
				<li><span>Статус объекта:</span> <?=get_field('booking_status')["label"];?></li>
			</ul>
			<?if($page_status != 'canceled' && $page_status != 'confirmed') {?>
			<div class="travel-button">
				<!-- <a href="/messages/" class="btn-travel btn-message">Сообщение Владельцу</a> -->
				<div class="travel-agreement">Напоминаем, Вы можете отменить бронирование согласно <a href="/gostyam/pravila-otmeny-bronirovaniya/" target="_blank">"Правилам отмены бронирования"</a></div>
				<div class="travel-cancel" data-id="<?=$post->ID;?>">Отменить бронирование</div>
			</div>
			<? } ?>

			<?if($page_status == 'confirmed') {?>
				<div class="travel-button">
					<a href="<?=get_permalink();?>" class="btn-travel">Оставить отзыв</a>
				</div>
			<? } ?>

		</div>
		<div class="travel-image">
			<a href="<?=get_permalink(get_field('apartment'));?>"><?=get_the_post_thumbnail(get_field('apartment'));?></a>
		</div>
	</div>
	<?php
	}
	} else { 
		echo "Ничего не найдено!";
	} 
	?>
</div>
 