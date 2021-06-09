<?
$posts1 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'request',
		'post_type' => 'orders',
		'author' => get_current_user_id()
	)
);
$posts2 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'confirmed',
		'post_type' => 'orders',
		'author' => get_current_user_id()
	)
);
$posts3 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'canceled',
		'post_type' => 'orders',
		'author' => get_current_user_id()
	)
);

if( is_page(106) ) {
	$page_status = 'request';
}
if( is_page(713) ) {
	$page_status = 'confirmed';
}
if( is_page(716) ) {
	$page_status = 'canceled';
}
 
?>

<ul class="profile-nav">
	<li><a href="/profile/orders/" class="<?=$page_status == 'request' ? 'active' : '';?>">Запросы на бронирование (<?=$posts1->post_count;?>)</a></li>
	<li><a href="/profile/confirmed/" class="<?=$page_status == 'confirmed' ? 'active' : '';?>">Подтвержденные бронирования (<?=$posts2->post_count;?>)</a></li>
	<li><a href="/profile/canceled/" class="<?=$page_status == 'canceled' ? 'active' : '';?>">Отмененные бронирования (<?=$posts3->post_count;?>)</a></li>
</ul>

<div class="bookings-list">
<?
$args = array(
	'posts_per_page' => -1,
	'author' => get_current_user_id(),
	'post_type' => 'orders',
	'post_status' => $page_status,
	'order' => 'DESC',
);
$query = new WP_Query($args); ?>
<? if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
	<? 
	$post_object = get_field('apartment');
	setup_postdata( $post_object );
	$days = days(get_field('check_in'), get_field('check_out'));
	?>
	<div class="booking-item" data-id="<?=$post->ID;?>">
		<div class="booking-image">
			<?$status = get_post_status( $post->ID ); ?>
			<div class="booking-status <?=$status;?>"><?=get_post_status_object( $status )->label;?></div>
			<?=get_the_post_thumbnail(get_field('apartment'), array(355, 330));?>
		</div>
		<div class="booking-content">
			<ul class="booking-info">
				<li>Объект № <?=$post_object;?>, <?=get_the_title($post_object);?></li>
				<li><?=address(get_field('apartment'));?></li>
				<li>Заезд: <?=the_field('check_in');?></li>
				<li>Выезд: <?=the_field('check_out');?></li>
				<li>Общая длительность проживания: <?=num_word($days, array("сутки","суток","суток") );?></li>
				<li>Количество гостей: <?=the_field('guests');?></li>
				<li>Итого за <?=num_word($days, array("сутки","суток","суток") );?>: <strong><?=price_total(get_field('price', get_field('apartment')), $days);?> RUB</strong></li>
			</ul>
			<?if($page_status == 'request') {?>
			<div class="booking-button">
				<div class="booking-confirm" data-action="confirmed">Подтвердить бронирование</div>
				<div class="booking-cancel" data-action="canceled">Отменить бронирование</div>
			</div>
			<?}?>
		</div>
	</div>
<? endwhile;
else: echo "Список бронирований пуст";
endif; ?>
</div>
<!-- Список бронирований пуст -->