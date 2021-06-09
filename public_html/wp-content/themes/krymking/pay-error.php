<?php
// Пароль #1 (для тестовых платежей)
$mrh_pass1 = 'zV395RuabF6HbqbmWRJ3';
 
// Чтение параметров
/*
 * робокасса
$inv_id  = intval(@$_POST['InvId']);
$out_sum = @$_POST['OutSum'];
$crc     = strtoupper(@$_POST['SignatureValue']);
*/
$inv_id  = intval(@$_GET['OrderId']);
$out_sum = @$_POST['Amount']/100;


update_field('booking_status', '3', $inv_id);

get_header();
/* Template Name: Оплата не удалась */
?>
<div class="headLine"></div>
<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title"><?=the_title()?></h1>
    <?if (!empty($inv_id)) { ?>
    	<div class="success-text">Платеж отменен</div>
    <? } else { ?>
    	<div class="success-text">Произошла ошибка</div>
    <? } ?>
</div>

<?php
get_footer();