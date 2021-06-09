<?
global $wpdb;
global $current_user;

include 'TinkoffMerchantAPI.php';

//spl_autoload('TinkoffMerchantAPI');
$api = new TinkoffMerchantAPI(
    '1618915637197DEMO',  //Ваш Terminal_Key
    'ptlarl9mfnwe9kh9'   //Ваш Secret_Key
);


$enabledTaxation = true;
//$amount = 1000 * 100;


function balanceAmount($isShipping, $items, $amount)
{
    $itemsWithoutShipping = $items;

    if ($isShipping) {
        $shipping = array_pop($itemsWithoutShipping);
    }

    $sum = 0;

    foreach ($itemsWithoutShipping as $item) {
        $sum += $item['Amount'];
    }

    if (isset($shipping)) {
        $sum += $shipping['Amount'];
    }

    if ($sum != $amount) {
        $sumAmountNew = 0;
        $difference = $amount - $sum;
        $amountNews = [];

        foreach ($itemsWithoutShipping as $key => $item) {
            $itemsAmountNew = $item['Amount'] + floor($difference * $item['Amount'] / $sum);
            $amountNews[$key] = $itemsAmountNew;
            $sumAmountNew += $itemsAmountNew;
        }

        if (isset($shipping)) {
            $sumAmountNew += $shipping['Amount'];
        }

        if ($sumAmountNew != $amount) {
            $max_key = array_keys($amountNews, max($amountNews))[0];    // ключ макс значения
            $amountNews[$max_key] = max($amountNews) + ($amount - $sumAmountNew);
        }

        foreach ($amountNews as $key => $item) {
            $items[$key]['Amount'] = $amountNews[$key];
        }
    }

    return $items;
}






if($_GET['booking-id']) {
	$booking_id = get_field('apartment', $_GET['booking-id']);
	$check_in   = get_field('check_in', $_GET['booking-id']);
	$check_out  = get_field('check_out', $_GET['booking-id']);
	$post_id = $_GET['booking-id'];
} else {
	$booking_id = $_POST['hotel_id'];
	$check_in   = $_POST['check_in'];
	$check_out  = $_POST['check_out'];
}

$url   = get_template_directory_uri();
$days  = days($check_in, $check_out);
$price = the_price($booking_id);
$total = price_total($price, $days);
 
if (!empty($_POST['send'])) {

	if(empty($_GET['booking-id'])) {

        $start1 = microtime(true);




		if(get_field('fast_booking',  $_POST['post_id']) == 'Включить') {
			$status = 'confirmed';
		} else {
			$status = 'request';
		}

		$post_id = wp_insert_post(  wp_slash( array(
			'post_status'   => $status,
			'post_type'     => 'orders',
			'post_title'    => 'Бронирование №'. SecondLastPostId(),
			'post_content'  => '',
			'post_author'   => get_post($_POST['post_id'])->post_author,
			'ping_status'   => get_option('default_ping_status'),
			'meta_input'    => [ 'meta_key'=>'meta_value' ],
		) ) );

		if( is_wp_error($post_id) ){

			$result['error'] = 'success';
			$result['message'] = $post_id->get_error_message();
		} else {


		    $result['status'] = 'success';
			$result['message'] = 'Бронирование № '.SecondLastPostId();

			update_field('check_in', $_POST['check_in'], $post_id);
			update_field('check_out', $_POST['check_out'], $post_id);
			update_field('guests', $_POST['guests'], $post_id);
			update_field('comment', $_POST['comment'], $post_id);
			update_field('apartment', $_POST['post_id'], $post_id);
			update_field('time_arrival', $_POST['time_arrival'], $post_id);

			$user = get_user_by('email', $_POST['user_email']);
			$user_id = $user->ID;

			update_field('customer', $user_id, $post_id);
			update_field('booking_status', '1', $post_id);

			update_field('user_name', $_POST['user_name'], $post_id);
			update_field('user_lastname', $_POST['user_lastname'], $post_id);
			update_field('user_email', $_POST['user_email'], $post_id);
			update_field('user_phone', $_POST['phone'], $post_id);
			update_field('main_guest', $_POST['main_guest'], $post_id);

		}

		$post = get_post($_POST['post_id']);
		$author = get_userdata($post->post_author);

		// Письмо владельцу
		if ( get_field('fast_booking', $post->ID ) == 'Включить') {

			// Мгновенное бронирование
			$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
			$subject = 'Бронирования объекта на сайте Krymking.ru';
	
			$message = 'Здравствуйте, '.$author->first_name.' '.$author->last_name.'! ';
			$message .= 'Поздравляем, Ваш объект жилья id-номер '.$post->ID.' забронирован Гостем. ';
			$message .= 'Для получения детальной информации перейдите в <a href="'.home_url("/profile/").'">Личный кабинет</a>. ';
			$message .= 'Напоминаем, что Вы можете обмениваться сообщениями со своими гостями на сайте Krymking.ru.';
			$message .='<br>';
			$message .='<br>';
			$message .='С уважением, <br> Команда Krymking.ru';

	
		} else {

			// Без мгновенного бронирования
			$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
			$subject = 'Бронирования объекта на сайте Krymking.ru';
	
			$message = 'Здравствуйте, '.$author->first_name.' '.$author->last_name.'! ';
			$message .= 'По Вашему объекту жилья id-номер '.$post->ID.' пришел запрос на бронирование. ';
			$message .= 'Для получения детальной информации перейдите в <a href="'.home_url("/profile/orders/").'">Личный кабинет</a>. ';
			$message .='<br>';
			$message .='<br>';
			$message .='С уважением, <br> Команда Krymking.ru';

		}



		//wp_mail($author->user_email, $subject, $message, $headers);
        mail($author->user_email, $subject, $message, $headers);

	}


	if($_POST['send'] == 'payment') {

        $days = days($_POST['check_in'], $_POST['check_out']);
        $price = the_price($_POST['post_id']);

        $prepay = calc_percent(price_total($price, $days));//стоимость с днями
        $prepay_kope = $prepay * 100;//стоимость в копейках

        $date_start = wp_date( 'j F Y', strtotime($_POST['check_in']) );
        $date_end = wp_date( 'j F Y', strtotime($_POST['check_out']) );

        $message = 'Оплата бронирования на сайте Krymking.ru: бронь №'.$post_id.', ';
        $message .= ''.address($_POST['post_id']).', ';
        $message .= 'заезд '.$date_start.' г., выезд '.$date_end.' г. Сумма к оплате '.$prepay.' рублей.';

        //https://www.tinkoff.ru/kassa/develop/api/payments/init-description/ - апи на тинькове
	    $arr['TerminalKey'] = "TinkoffBankTest";
        $arr['Amount'] = $prepay_kope;
        $arr['OrderId'] = $post_id;
        $arr['Description'] = $message;
        //$arr['DATA']['Phone'] = '+71234567890';
        $arr['DATA']['Email'] = $_POST['user_email'];

        $arr['Receipt']['Email'] = $_POST['user_email'];//емейл клиента
        //$arr['Receipt']['Phone'] = "+79031234567";
        $arr['Receipt']['EmailCompany'] = "contact@krymking.ru";//емейл фирмы
        $arr['Receipt']['Taxation'] = "usn_income_outcome";//система налог ображения
        $arr['Receipt']['Items']['Name'] = $_POST['post_id'];//Должно быть название товара
        $arr['Receipt']['Items']['Price'] = $prepay_kope;//цена за еденицу товара в копейках
        $arr['Receipt']['Items']['Quantity'] = '1.00';//Количество или вес товара
        $arr['Receipt']['Items']['Amount'] = $prepay_kope;//стоимость товра в копейках
        $arr['Receipt']['Items']['PaymentMethod'] = 'advance';//оплата аванса
        $arr['Receipt']['Items']['PaymentObject'] = 'service';//передаю за что деньги в данном случае услуга
        $arr['Receipt']['Items']['Tax'] = 'none';//передаю данны о ндс


        $link = 'https://securepay.tinkoff.ru/v2/Init';






        $email = 'test@test.com';
        $emailCompany = 'testCompany@test.com';
        $phone = '89179990000';


        $receiptItem = [[
            'Name'          => 'product1',
            'Price'         => $prepay_kope,
            'Quantity'      => 1,
            'Amount'        => $prepay_kope,
            'PaymentMethod' => 'advance',
            'PaymentObject' => 'service',
            'Tax'           => 'none'
        ]];

        $isShipping = false;

        if (!empty($isShipping[2]['Name'] === 'shipping')) {
            $isShipping = true;
        }

        $enabledTaxation = true;

        $receipt = [
            'EmailCompany' => "contact@krymking.ru",
            'Email'        => $_POST['user_email'],
            'Taxation'     => "usn_income_outcome",
            'Items'        => balanceAmount($isShipping, $receiptItem, $prepay_kope),
        ];


        $params = [
            'OrderId' => $post_id,
            'Amount'  => $prepay_kope,
            'DATA'    => [
                'Email'           => $_POST['user_email'],
                'Connection_type' => 'example'
            ],
        ];

        if ($enabledTaxation) {
            $params['Receipt'] = $receipt;
        }

        $api->init($params);



        header('Location:' . $api->paymentUrl);




/*
		$mrh_pass1 = "zV395RuabF6HbqbmWRJ3";

		$days = days($_POST['check_in'], $_POST['check_out']);
		$price = the_price($_POST['post_id']);
		$prepay = calc_percent(price_total($price, $days));

		$date_start = wp_date( 'j F Y', strtotime($_POST['check_in']) );
		$date_end = wp_date( 'j F Y', strtotime($_POST['check_out']) );

		$message = 'Оплата бронирования на сайте Krymking.ru: бронь №'.$post_id.', ';
		$message .= ''.address($_POST['post_id']).', ';
		$message .= 'заезд '.$date_start.' г., выезд '.$date_end.' г. Сумма к оплате '.$prepay.' рублей.';

		$params = array(
			'MerchantLogin' => 'krymking.ru', // Идентификатор магазина
			'InvId'         => $post_id, // ID заказа
			'Description'   => $message, // Описание заказа (мах 100 символов)
			'OutSum'        => $prepay, // Сумма заказа
			'Culture'       => 'ru',
			'Email'			=> $_POST['user_email'],
			'Encoding'      => 'utf-8',
			'IsTest'        => 1, // Тестовый режим
		);

		// Формирование подписи
		$params['SignatureValue'] = md5("{$params['MerchantLogin']}:{$params['OutSum']}:{$params['InvId']}:{$mrh_pass1}");

		// Перенаправляем пользователя на страницу оплаты
		header('Location: https://auth.robokassa.ru/Merchant/Index.aspx?' . urldecode(http_build_query($params)));
*/
	} elseif ($_POST['send'] == 'request') {
		// Перенаправляем пользователя на страницу запроса

		// Письмо гостю
		$user = get_userdata(get_field('customer', $post_id));
		$post2 = get_field('apartment', $post_id);
	
		$headers2 = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
		$subject2 = 'Запрос на бронирование объекта';
	
		$message2 = 'Здравствуйте, '.$user->first_name.' '.$user->last_name.'! ';
		$message2 .= 'Вы запросили бронирование №'.$post_id.' объекта жилья <a href="'.get_permalink($post2).'">'.get_permalink($post2).'</a>. ';
		$message2 .= 'Информация отправлена Владельцу. Вы будете уведомлены о его ответе при помощи электронной почты. ';
		$message2 .= 'При подтверждении дат бронирования Владельцем Вам останется только внести предоплату на сайте, получить ваучер и планировать свое путешествие.';
		$message2 .='<br>';
		$message2 .='<br>';
		$message2 .='С уважением, <br> Команда Krymking.ru';	
	

		global $current_user;
		$email_to = $current_user->user_email;
		wp_mail($user->user_email, $subject2, $message2, $headers2);	


		wp_redirect( home_url('/request/?order-id='.$post_id.'') ); 
	}



}

get_header();
/* Template Name: Бронирование */
?>
<div class="headLine"></div>

<div class="booking">
	<div class="wrapper">
 
	<? if (!is_user_logged_in() ) { ?>
		<div class="booking-auth-title">
			<span class="link-auth">Войдите в свою учетную запись</span>, чтобы продолжить бронирование.
		</div>
	<? } else { ?>

		<h1 class="page-title">Завершение бронирования и оплата</h1>
		<div class="booking-number">Бронь № 
			<?if ($_GET['booking-id']) {?>
				<?=$_GET['booking-id'];?>
			<? } else { ?>
				<?=SecondLastPostId();?>
			<? } ?>
		</div>
		<div class="page-wrap">
			<div class="booking-hotel">
				<div class="booking-title"><a href="<?=get_permalink($booking_id);?>"><?=get_the_title($booking_id);?></a></div>
				<div class="booking-thumbnail">
					<div class="booking-gallery">
					<?foreach (get_field('gallery', $booking_id) as $image) {?>
						<a href="<?=$image['url'];?>" data-fancybox="gallery">
							<img src="<?=$image['sizes']['large'];?>">
						</a>
					<?}?>
					</div>
					<div class="counts-slides"><span class="current">1</span> / <span><?=count(get_field('gallery', $booking_id));?></span></div>
				</div>
				<div class="booking-type">
					<div class="hotel-name"><a href="<?=get_permalink($booking_id);?>"><?=rooms_type(get_field('rooms_count', $booking_id));?></a></div>
					<div class="hotel-address"><?=hotel_address($booking_id);?>, ул. <?=get_field('street', $booking_id);?>, <?=get_field('house', $booking_id);?></div>
				</div>
				<div class="flexbox">
					<div class="booking-date">
						<div class="dates-title">Заезд</div>
						<div class="date"><?=getWeekday($check_in);?>, <?=$check_in;?>, с 12:00</div>
					</div>
					<div class="booking-date">
						<div class="dates-title">Выезд</div>
						<div class="date"><?=getWeekday($check_out);?>, <?=$check_out;?>, с 12:00</div>
					</div>
				</div>
				<div class="booking-guests flexbox">Общая длительность проживания <span><?=num_word($days, array("сутки","суток","суток") );?></span></div>
				<div class="booking-guests flexbox">Количество гостей <span><?=guests();?></span></div>
				<ul class="booking-details">
					<li><strong>Итого за <?=$days;?> суток:</strong> <strong><?=price_total($price, $days);?> RUB</strong></li>
					<li class="payment-calc"><span><?=$price;?> RUB * <?=$days;?> суток</span> <span><?=price_total($price, $days);?> RUB</span></li>
				</ul>
				<div class="btn-calc">Скрыть расчёт</div>
		 		<ul class="booking-details">
					<li><span>Предоплата</span> <strong><?=calc_percent(price_total($price, $days));?> RUB</strong></li>
					<li><span>Оплата при заселении</span> <strong><?=price_total($price, $days)-calc_percent(price_total($price, $days));?> RUB</strong></li>
				</ul>
				<div class="booking-commissions">Без комиссий и сборов</div>
<!-- 				<div class="btn btn-close">Отменить бронирование</div> -->
			</div>


            <form method="POST" enctype="multipart/form-data" class="bookingForm">

				<input type="hidden" name="post_id" value="<?=$booking_id;?>">
				<input type="hidden" name="check_in" value="<?=$check_in;?>">
				<input type="hidden" name="check_out" value="<?=$check_out;?>">
				<input type="hidden" name="guests" value="<?=guests();?>">

				<?if (!is_user_logged_in() ) {?>
					<div class="booking-title">Введите свои данные</div>
				<? } else { ?>
					<div class="booking-title">Ваши данные</div>
				<? } ?>
				<?if (!is_user_logged_in() ) {?>
				<div class="booking-auth"><span class="link-auth">Войдите в свою учетную запись</span>, чтобы использовать сохранённые данные, или <br> <span class="link-registr">зарегистрируйтесь</span>, чтобы управлять бронированием</div>
				<div class="booking-info">Если у Вас нет учётной записи и Вы не хотите зарегистрироваться <br> сейчас, просто заполните обязательные поля для бронирования</div>
				<?}?>
				<div class="flexbox">
					<div class="input-group">
						<label class="input-title">Имя<span class="required">*</span> <span class="required-text">(обязательно к  заполнению)</span></label>
						<input type="text" name="user_name" value="<?=$current_user->user_firstname;?>" class="form-control" required>
					</div>
					<div class="input-group">
						<label class="input-title">Фамилия<span class="required">*</span> <span class="required-text">(обязательно к  заполнению)</span></label>
						<input type="text" name="user_lastname" value="<?=$current_user->user_lastname;?>" class="form-control" required>
					</div>
				</div>
				<div class="input-group">
					<label class="input-title">Электронная почта<span class="required">*</span> <span class="required-text">(обязательно к  заполнению)</span></label>
					<input type="email" name="user_email" class="form-control" value="<?=$current_user->user_email;?>" placeholder="Убедитесь, что вводите без опечаток" required>
				</div>
				<div class="input-group">
					<label class="input-title">Подтвердите адрес электронной почты<span class="required">*</span> <span class="required-text">(обязательно к  заполнению)</span></label>
					<input type="email" name="confirm_email" value="<?=$current_user->user_email;?>" class="form-control" required>
					<span class="text-hint">На этот адрес будет отправлено подтверждение бронирования</span>
				</div>
				<div class="input-group">
					<label class="input-title">Ваш номер телефона <span class="required-text">(необязательно к заполнению)</span></label>
					<select name="country" class="form-control">
						<option value="ru" selected>Россия</option>
						<option value="ua">Украина</option>
						<option value="kz">Казахстан</option>
						<option value="by">Беларусь</option>
						<option value="tj">Таджикистан</option>
						<option value="uz">Узбекистан</option>
						<option value="am">Армения</option>
						<option value="az">Азербайджан</option>
						<option value="kg">Кыргызстан</option>
						<option value="md">Молдова</option>
						<option value="tm">Туркменистан</option>
					</select>
					<input type="tel" name="phone" value="<?=the_field('phone', 'user_' .get_current_user_id());?>" class="form-control" autocomplete="off" required>
				</div>

				<div class="booking-info title-commnet">Ответьте на несколько простых вопросов, которые помогут <br> Вам получить лучший сервис</div>

				<div class="input-group flex-radio">
					<label class="input-title">Кто основной гость?</label>
					<label class="custom-radio form-control">
						<input type="radio" name="main_guest" value="Я" checked="">
						<div class="label-name">Я</div>
					</label>
					<label class="custom-radio form-control">
						<input type="radio" name="main_guest" value="Другой человек">
						<div class="label-name">Другой человек</div>
					</label>
				</div>

				<div class="main-guest">
					<div class="input-group">
						<label class="input-title">Имя<span class="required">*</span></label>
						<input type="text" name="other_name" class="form-control">
					</div>
					<div class="input-group">
						<label class="input-title">Фамилия<span class="required">*</span></label>
						<input type="text" name="other_lastname" class="form-control">
					</div>
					<div class="input-group">
						<label class="input-title">Электронная почта</label>
						<input type="email" name="other_email" class="form-control" placeholder="Убедитесь, что вводите без опечаток">
					</div>
					<p class="text-hint">Мы отправляем на электронную почту только информацию о бронировании</p>
				</div>
				
				<div class="input-group">
					<label class="input-title">Расскажите владельцу о себе, какая цель поездки, с кем Вы путешествуете?</label>
					<textarea name="comment" class="form-control"></textarea>
				</div>
				<div class="booking-info">Сообщите Владельцу предполагаемое время Заезда</div>

				<div class="input-title title-main">Ваш номер будет готов в дату заезда с <?=get_field('check_in_time', $booking_id)['label'];?></div>

				<div class="input-group flexbox align-items">
					<label class="input-title">Время прибытия</label>
					<input type="datetime-local" name="time_arrival" class="form-control">
				</div>
				<div class="input-title title-main">Правила проживания</div>
				<div class="booking-attributes">
					<ul>
					<? foreach (acf_get_fields(348) as $param) { ?>
						<?if (get_field_object($param['key'], $booking_id)['type'] == 'select') {?>
							<li><strong><?=get_field_object($param['key'], $booking_id)['label'];?>:</strong> <?=get_field_object($param['key'], $booking_id)['value']['value'];?></li>
						<? } else { ?>
							<li><strong><?=get_field_object($param['key'], $booking_id)['label'];?>:</strong> <?=get_field_object($param['key'], $booking_id)['value'];?></li>
						<? } ?>
					<? } ?>
					</ul>
				</div>

				<div class="text-agreement">
					<label class="custom-checkbox"><input type="checkbox" name="agreement" class="custom-input" checked=""><div class="check"></div></label>
					<span class="text">Нажимая на кнопку 
						
				<? if(get_field('fast_booking', $booking_id) == 'Включить' || get_post_status( $_GET['booking-id'] ) == 'confirmed') { ?>
					«Внести предоплату»
				<? } else { ?>
					«Запросить бронирование»
				<? } ?>
					
					, Вы соглашаетесь с <span>Правилами проживания</span> и <a href="/gostyam/pravila-otmeny-bronirovaniya/" target="_blank">Правилами отмены бронирования</a></span>
				</div>
				<div class="input-group">
				
				<? if(get_field('fast_booking', $booking_id) == 'Включить' || get_post_status( $_GET['booking-id'] ) == 'confirmed') { ?>
					<button type="submit" class="btn btn-submit">Внести предоплату</button>
					<input type="hidden" name="send" value="payment">
				<? } else { ?>
					<button type="submit" class="btn btn-submit">Запросить бронирование</button>
					<input type="hidden" name="send" value="request">
				<? } ?>
				</div>
			</form>
		</div>
		<? } ?>
	</div>
</div>


<?php
get_footer();