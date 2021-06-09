<?php
get_header();
/* Template Name: Запрос */
$url = get_template_directory_uri();
?>
<div class="headLine"></div>

<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
 	<h1 class="page-title"><?=the_title();?></h1>
    <div class="success-text">Вы запросили бронирование №<?=$_GET['order-id'];?>. Информация отправлена Владельцу. Вы будете уведомлены о его ответе при помощи электронной почты. При подтверждении дат бронирования Владельцем Вам останется только внести предоплату на сайте, получить ваучер и планировать свое путешествие. <a href="<?=home_url("/profile/travel/");?>" class="btn">Мои бронирования</a></div>
</div>

<?php
get_footer();