<?php
// Пароль #1 (для тестовых платежей)
$mrh_pass1 = 'zV395RuabF6HbqbmWRJ3';
 
// Чтение параметров
/*
 * для  робокассы было
$inv_id  = intval(@$_POST['InvId']);
$out_sum = @$_POST['OutSum'];
$crc     = strtoupper(@$_POST['SignatureValue']);
*/
$inv_id  = intval(@$_GET['OrderId']);
$out_sum = @$_POST['Amount']/100;



//mount


get_header();
/* Template Name: Результат оплаты */
?>
<div class="headLine"></div>
<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title"><?=the_title()?></h1>

<? if ( !empty($inv_id) ) {

	// $my_crc = strtoupper(md5("$out_sum:$inv_id:$mrh_pass1"));

	// if ($my_crc == $crc) {
		// Письмо гостю предоплата
		$customer = get_userdata(get_field('customer', $inv_id));

		$headers1 = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
		$subject1 = 'Благодарим за бронирование';

		$message1 = 'Здравствуйте, '.$customer->first_name.' '.$customer->last_name.'! ';
		$message1 .= 'Благодарим за бронирование №'.$inv_id.' на Крымкинг.ру! ';
		$message1 .= 'После подтверждения оплаты на Ваш электронный адрес будет отправлен Ваучер на заселение с контактной информацией о Владельце и забронированном жилье. ';
		$message1 .= 'Откройте электронное письмо от Krymking.ru с Ваучером и сохраните или распечатайте его.';
		$message1 .='<br>';
		$message1 .='<br>';
		$message1 .='С уважением, <br> Команда Krymking.ru';

		//wp_mail($customer->user_email, $subject1, $message1, $headers1);
        mail($customer->user_email, $subject1, $message1, $headers1);

		// Обновляем статус на оплачен
		update_field('booking_status', '2', $inv_id);
		update_field('prepayment', $out_sum, $inv_id);

		// Письмо с успешной оплатой
		$object = get_post(get_field('apartment', $inv_id));

		$post = get_post($inv_id);
		$author = get_userdata($post->post_author);
		$user = get_userdata(get_field('customer', $inv_id));

		$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
		$subject = 'Благодарим за бронирование №'.$inv_id.'';

		$message = 'Уважаемый, '.$user->first_name.' '.$user->last_name.'! ';
		$message .= 'Поздравляем с успешным бронированием № '.$inv_id.' объекта жилья <a href="'.get_permalink($object).'">'.$object->post_title.'</a>, ';
		$message .= 'при помощи Krymking.ru. ';
		$message .= 'Во вложении находится Ваучер на заселение по данному объекту. ';
		$message .= 'Пожалуйста, сохраните его или распечатайте и предъявите при заезде Владельцу жилья. ';
		$message .='<br>';
		$message .='<br>';
		$message .='С уважением, <br> Команда Krymking.ru';

		//wp_mail($user->user_email, $subject, $message, $headers);
        mail($user->user_email, $subject, $message, $headers);

		echo '<div class="success-text">Благодарим за бронирование на Крымкинг.ру! После подтверждения оплаты на Ваш электронный адрес будет отправлен Ваучер на заселение с контактной информацией о Владельце и забронированном жилье.  Откройте электронное письмо от Krymking.ru с Ваучером и сохраните или распечатайте его.</div>';
		
		// exit();	
	// } else {
	// 	echo '<div class="success-text">Произошла ошибка</div>';
	// }
} else { 
	echo '<div class="success-text">Произошла ошибка</div>';
} ?>
 
</div>

<?php
get_footer();