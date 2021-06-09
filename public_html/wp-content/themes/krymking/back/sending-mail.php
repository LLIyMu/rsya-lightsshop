<?
add_action( 'phpmailer_init', 'send_smtp_email' );
function send_smtp_email( $phpmailer ) {
   $phpmailer->isSMTP();
   $phpmailer->Host = SMTP_HOST;
   $phpmailer->SMTPAuth = SMTP_AUTH;
   $phpmailer->Port = SMTP_PORT;
   $phpmailer->Username = SMTP_USER;
   $phpmailer->Password = SMTP_PASS;
   $phpmailer->SMTPSecure = SMTP_SECURE;
   $phpmailer->From = SMTP_FROM;
   $phpmailer->FromName = SMTP_NAME;
}

function sending_mail($title, $text) {
	global $current_user;
	$email_to = $current_user->user_email;
	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';

	wp_mail( $email_to, $title, $text, $headers, $attachments);
}

function objectPending($post_id) {
	global $wpdb;
	$post = get_post($post_id);
	$author = get_userdata($post->post_author);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Ваш объект жилья проходит модерацию';

	$message = 'Здравствуйте, '.$author->first_name.' '.$author->last_name.'! ';
	$message .= 'Поздравляем, Вы проделали большую работу и теперь Ваш объект жилья проходит модерацию. ';
	$message .= 'Крымкинг.ру максимально быстро проверит Ваше объявление.';

	wp_mail($author->user_email, $subject, $message, $headers);

	$post_title = get_the_title( $post_id );
	$subject2 = 'Запрос на размещение объекта на сайте Krymking.ru';

	$message2 = "Проверьте объект: \n\n";
	$message2 .= '<a href="'.home_url("/wp-admin/post.php?post=".$post_id."&action=edit").'">'.$post_title . ": № " . $post_id .'</a>';
	wp_mail( get_option('admin_email'), $subject2, $message2, $headers);
}
add_action( 'pending_hotels', 'objectPending', 10);

// Объявление успешно прошло модерацию
function objectPublish($post_id) {
	global $wpdb;
	$post = get_post($post_id);
	$author = get_userdata($post->post_author);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Ваше объявление успешно прошло модерацию';

	$message = 'Здравствуйте, '.$author->first_name.' '.$author->last_name.'! ';
	$message .= 'Поздравляем, Ваше объявление успешно прошло модерацию и теперь Ваш объект жилья опубликован на Krymking.ru и ему присвоен ID-номер '.$post->ID.' ';
	$message .= 'Редактировать информацию по своим объектам жилья Вы можете в <a href="'.home_url('/profile/objects/').'">Личном кабинете</a>.';

	wp_mail($author->user_email, $subject, $message, $headers);
}
add_action( 'pending_to_publish', 'objectPublish', 10);

function objectRejected($post_id) {
	global $wpdb;
	$post = get_post($post_id);
	$author = get_userdata($post->post_author);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Ваше объявление не прошло модерацию';

	$message = 'Здравствуйте, '.$author->first_name.' '.$author->last_name.'! ';
	$message .= 'К сожалению, Ваше объявление не прошло модерацию и Ваш объект жилья не опубликован на Krymking.ru. ';
	$message .= 'Узнать подробности Вы сможете, связавшись с нашей <a href="'.home_url("/about-us/support/").'">Службой поддержки</a>.';

	wp_mail($author->user_email, $subject, $message, $headers);
}
add_action( 'rejected_hotels', 'objectRejected', 10);
 
function register_user($email) {
	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Вы успешно зарегистрировались на Krymking.ru';

	$message = "Уважаемый Пользователь! Добро пожаловать на сайт Krymking.ru. <br>";
	$message .= "Всегда готовы помочьвам в краткосрочной аренде жилья для отдыха в Крыму. <br>";
	$message .= "По всем вопросам работы нашего сайта Вы сможете найти ответы в разделе <a href='".home_url("/guests-owners")."'>Помощь</a>. <br>";
	$message .= "С уважением, <br>";
	$message .= "команда Krymking.ru <br>";
	$message .= "Преимущества бронирования с Krymking.ru <br>";
	$message .= "1.Мы крымчане и Крым наш дом! <br>";
	$message .= "2.Вы наш приоритет! <br>";
	$message .= "3.Порядочность и качество – наше кредо! <br>";
	$message .= "4.Простота и доступность – наши принципы! <br>";
	$message .= "5.Эффективная служба поддержки! <br>";
	$message .= "6.Гарантия успешного заселения! <br>";
	$message .= "7.Высокая скорость обслуживания! <br>";
	$message .= "8.Бесплатные услуги бронирования! <br>";

 
	wp_mail($email, $subject, $message, $headers);
}
 
function register_confirm($email, $token){
	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Подтверждение аккаунта';

	$message = 'Уважаемый Пользователь! Спасибо Вам  за регистрацию на сайте krymking.ru. ';
	$message .= 'Ваш личный кабинет создан. Нажмите кнопку <a style="color:red; text-decoration: none; padding: 0 5px;" href="'.home_url("/confirm").'?token='.$token.'&email=' . urlencode(base64_encode($email )). '">«подтвердить»</a> для активации учетной записи или пройдите по ссылке <a style="text-decoration: none; color: blue;" href="'.home_url("/confirm").'?token='.$token.'">'.home_url("/confirm").'?token='.$token.'</a>';
	$message .= '<br>С уважением,<br>';
	$message .= '<br>команда Krymking.ru<br>';
	$message .= '<br>';
	$message .= <<<HEREDOC
<br>
<div style="float: left;"><a href="http://www.krymking.ru" style="display: inline-block; margin-top: 20px; text-decoration: none; color: blue;">Krymking.ru</a><br>
    <span style="display: inline-block; margin-top: 20px;">
        <a style="text-decoration: none; color: blue;" href="#">VK</a>
        <a style="text-decoration: none; color: blue;" href="#">FB</a>
        <a style="text-decoration: none; color: blue;" href="#">INSTA</a>
        <a style="text-decoration: none; color: blue;" href="#">OK</a>
        <a style="text-decoration: none; color: blue;" href="#">TM</a>
    </span>
</div>
<div style="float: right; margin-left: 20px;">
    <span style="display: inline-block; margin-top: 20px;">Пишите нам <a style="text-decoration: none; color: blue;" href="mailto:info@krymking.ru">info@krymking.ru</a></span><br>
    <span style="display: inline-block; margin-top: 20px;">Звоните нам: <a style="text-decoration: none; color: blue;" href="tel:7978ХХХХХХХ">+7978ХХХХХХХ</a></span>
</div>
HEREDOC;
	
	
	mail($email, $subject, $message, $headers);
	//wp_mail($email, $subject, $message, $headers);
}

// Запрос на бронирование объекта
function request_booking($post_id) {
	global $wpdb;
	$user = get_userdata(get_field('customer', $post_id));
	$post = get_field('apartment', $post_id);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Запрос на бронирование объекта';

	$message = 'Здравствуйте, '.$user->first_name.' '.$user->last_name.'! ';
	$message .= 'Вы запросили бронирование №'.$post_id.' объекта жилья <a href="'.get_permalink($post).'">'.get_permalink($post).'</a>. ';
	$message .= 'Информация отправлена Владельцу. Вы будете уведомлены о его ответе при помощи электронной почты. ';
	$message .= 'При подтверждении дат бронирования Владельцем Вам останется только внести предоплату на сайте, получить ваучер и планировать свое путешествие.';
	$message .='<br>';
	$message .='<br>';
	$message .='С уважением, <br> Команда Krymking.ru';	

	wp_mail($user->user_email, $subject, $message, $headers);	
}
add_action( 'request_orders', 'request_booking', 10);

// Владелец подтвердил бронирование
// function confirmed_booking($post_id) {
// 	global $wpdb;
// 	$user = get_userdata(get_field('customer', $post_id));
// 	$post = get_field('apartment', $post_id);

// 	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';

// 		// Если объект подключен к мгновенному бронированию
// 	if(get_field('fast_booking', $post) == 'Включить') {
// 		$subject = 'Благодарим за бронирование №'.$post_id.'';

// 		$message = 'Здравствуйте, '.$user->first_name.' '.$user->last_name.'! ';
// 		$message .= 'Благодарим за бронирование №'.$post_id.' на Крымкинг.ру! ';
// 		$message .= 'После подтверждения оплаты на Ваш электронный адрес будет отправлен Ваучер на заселение с контактной информацией о Владельце и забронированном жилье. ';
// 		$message .= 'Откройте электронное письмо от Krymking.ru с Ваучером и сохраните или распечатайте его.';
// 		$message .='<br>';
// 		$message .='<br>';
// 		$message .='С уважением, <br> Команда Krymking.ru';

// 	} else {
		
// 		$subject = 'Владелец подтвердил бронирование №'.$post_id.'';

// 		$message = 'Уважаемый, '.$user->first_name.' '.$user->last_name.'! ';
// 		$message .= 'Владелец подтвердил бронирование №'.$post_id.' объекта жилья <a href="'.get_permalink($post).'">'.get_permalink($post).'</a> согласно Вашему запросу. ';
// 		$message .= 'Предлагаем Вам финализировать свое бронирование, перейдя на страницу завершения бронирования жилья и внести предоплату.<br>';
// 		$message .= '<a href="'.home_url("/booking/").'?booking-id='.$post_id.'">Внести предоплату</a>';
// 		$message .='<br>';
// 		$message .='<br>';
// 		$message .='С уважением, <br> Команда Krymking.ru';	
// 	}

// 	wp_mail($user->user_email, $subject, $message, $headers);	
// }
// add_action( 'confirmed_orders', 'confirmed_booking', 10);

// Владелец не подтвердил бронирование
// function canceled_booking($post_id) {
// 	global $wpdb;
// 	$user = get_userdata(get_field('customer', $post_id));
// 	$post = get_field('apartment', $post_id);

// 	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
// 	$subject = 'Владелец не подтвердил бронирование';

// 	$message = 'Уважаемый, '.$user->first_name.' '.$user->last_name.'! ';
// 	$message .= 'К сожалению, Владелец не подтвердил бронирование №'.$post_id.' объекта жилья <a href="'.get_permalink($post).'">'.get_permalink($post).'</a> согласно Вашему запросу. ';
// 	$message .='Предлагаем Вам забронировать новый вариант, воспользовавшись <a href="'.home_url("/").'">Krymking.ru</a>';
// 	$message .='<br>';
// 	$message .='<br>';
// 	$message .='С уважением, <br> Команда Krymking.ru';	

// 	wp_mail($user->user_email, $subject, $message, $headers);
// }
// add_action( 'canceled_orders', 'canceled_booking', 10);

function forgot(){
	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Восстановление пароля';

	wp_mail($email, $subject, $message, $headers);	
}