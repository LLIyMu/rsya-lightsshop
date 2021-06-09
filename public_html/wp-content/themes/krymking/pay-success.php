<?php
// Пароль #1 (для тестовых платежей)
$mrh_pass1 = 'zV395RuabF6HbqbmWRJ3';
 
// Чтение параметров
$inv_id  = intval(@$_POST['InvId']);
$out_sum = @$_POST['OutSum'];
$crc     = strtoupper(@$_POST['SignatureValue']); 

update_field('booking_status', '2', $inv_id);
update_field('prepayment', $out_sum, $inv_id);

get_header();
/* Template Name: Обработка платежа */
?>
<div class="headLine"></div>
<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title"><?=the_title()?></h1>
    <?if (empty($inv_id)) { ?>
    	Произошла ошибка
    <? } else { ?>
    	<div class="success-text">Благодарим за бронирование на Крымкинг.ру! После подтверждения оплаты на Ваш электронный адрес будет отправлен Ваучер на заселение с контактной информацией о Владельце и забронированном жилье.  Откройте электронное письмо от Krymking.ru с Ваучером и сохраните или распечатайте его.</div>
    <? } ?>
</div>

<?php
get_footer();