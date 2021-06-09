<?php
get_header();
/* Template Name: Подтверждение аккаунта */
$url = get_template_directory_uri();

$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
$subject = 'Полное Подтверждение аккаунта';
$message = "Уважаемый Пользователь! Добро пожаловать на сайт <a style='text-decoration: none; color: blue;' href='http://www.krymking.ru'>Krymking.ru</a>. Всегда готовы помочь вам в краткосрочной аренде жилья для отдыха в Крыму. По всем вопросам работы нашего сайта Вы сможете найти ответы в разделе <a style='text-decoration: none; color: blue;' href='#'>Помощь.</a>";
$message .= '<br>С уважением,<br>';
$message .= "<br>команда <a style='text-decoration: none; color: blue;' href='http://www.krymking.ru'>Krymking.ru</a><br>";
$message .= "<br>Преимущества бронирования с <a style='text-decoration: none; color: blue;' href='http://www.krymking.ru'>Krymking.ru</a><br>";
$message .= "<br>1.	Мы крымчане и Крым наш дом!<br>";
$message .= "2.	Вы наш приоритет!<br>";
$message .= "3.	Порядочность и качество – наше кредо!<br>";
$message .= "4.	Простота и доступность – наши принципы!<br>";
$message .= "5.	Эффективная служба поддержки!<br>";
$message .= "6.	Гарантия успешного заселения!<br>";
$message .= "7.	Высокая скорость обслуживания!<br>";
$message .= "8.	Бесплатные услуги бронирования!<br>";
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

?>
<div class="headLine"></div>

<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title">Подтверждение электронного адреса</h1>

	<? $data = EmailConfirmation::check($_GET['token']);?>
	<? if (!empty($data) && !empty($_GET['email'])) { 
		mail(base64_decode(urldecode($_GET['email'])), $subject, $message, $headers);
	?>
		<h3>Вы успешно подтвердили свой аккаунт!</h3>
	<?} else { ?>
		<h3>Произошла ошибка!</h3>
	<?} ?>
</div>
<?php
get_footer();