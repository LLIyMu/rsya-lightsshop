<?
function new_user() {
	if( email_exists($_POST['email']) ){
		$result['status'] = 'error';
		$result['message'] = 'Этот E-mail уже зарегистрирован!';
	} else {
		if (!empty($_POST['email'])) {
			$token = sha1(uniqid());
			$oldData = get_option('email-confirmation-data') ?: array();
			$data = array();
			$data[$token] = $_POST;
			update_option('email-confirmation-data', array_merge($oldData, $data));

			register_confirm($_POST['email'], $token);

			$result['status'] = 'success';
			$result['message'] = 'Спасибо за регистрацию! На Ваш электронный адрес отправлен запрос о подтверждении Ваших действий. В своем электронном почтовом ящике откройте письмо от krymking.ru и подтвердите регистрацию. Всего наилучшего!';
		}
	}

	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_new_user','new_user');
add_action('wp_ajax_new_user','new_user');

function sms_register() {

	$sms_tel = preg_replace("/[^0-9]/", '', $_POST["phone"]);

	if( email_exists($_POST['email']) ){

		$result['status'] = 'error';
		$result['message'] = 'Этот E-mail уже зарегистрирован!';

	} else {

		$api_id = "C4594B2C-15E6-A1B5-B5E9-8A821C59A03E";
		
		if ($_POST["submit"] == 'sendsms') {
			function generate_pass($number) {
				$arr = array('1','2','3','4','5','6', '7','8','9','0');
			
				// Генерируем пароль для смс
				$pass = "";
				for($i = 0; $i < $number; $i++) {
					// Вычисляем произвольный индекс из массива
					$index = rand(0, count($arr) - 1);
					$pass .= $arr[$index];
				}
				return $pass;
			}
		
			$newpass = generate_pass(6);
	
			$_SESSION['code'] = $newpass;

			// Отсылаем код
			$ch = curl_init("https://sms.ru/sms/send");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
				"api_id" => $api_id,
				"from" => 'krymking.ru',
				"to" => $sms_tel, // До 100 штук до раз
				"msg" => iconv("windows-1251", "utf-8", $newpass), // Если приходят крякозябры, то уберите iconv и оставьте только "Привет!",
				"json" => 1 // Для получения более развернутого ответа от сервера
			)));
			$body = curl_exec($ch);
			curl_close($ch);

			$json = json_decode($body);
			if ($json) { // Получен ответ от сервера
				if ($json->status == "OK") {
					foreach ($json->sms as $phone => $data) {
						if ($data->status == "OK") {
							$result['status'] = 'success';
							$result['message'] = "Код на номер $phone успешно отправлен. ";
						} else { // Ошибка в отправке
							$result['status'] = 'error';
							$result['message'] = "Код на номер $phone не отправлен. $data->status_text. ";
						}
					}
				} else {
					$result['status'] = 'error';
					$result['message'] = "Запрос не выполнился: $json->status_code. ";
				}
			} else {
				$result['status'] = 'error';
				$result['message'] = "Запрос не выполнился. Не удалось установить связь с сервером. ";
			}
			
		}

		if ($_POST["submit"] == 'ok') {
			
			if ($_POST["code"] == $_SESSION['code']) {

				$userData = array(
					'user_pass'  => $_POST["code"],
					'user_login' => $sms_tel,
					'user_email' => $_POST["email"],
					'first_name' => $_POST["name"],
					'role' => 'tenant'
				);
			
				$new_user = wp_insert_user($userData);

				if (!is_wp_error( $new_user ) ) {
					update_user_meta($new_user, 'phone', $_POST["phone"]);
				}

				$result['status'] = 'success';
				$result['message'] = "Спасибо за регистрацию! Используйте код подтверждения для авторизации на сайте.";

				$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
				$subject = 'Регистрация через СМС';
			
				$message = 'Пароль: '.$_SESSION['code'].'';
			
				wp_mail($_POST['email'], $subject, $message, $headers);
			} else {
				$result['status'] = 'error';
				$result['message'] = "Неверный код подтверждения";
			}
			
		}

	}
 
	echo json_encode($result);
	exit;	
}
add_action('wp_ajax_nopriv_sms_register','sms_register');
add_action('wp_ajax_sms_register','sms_register');