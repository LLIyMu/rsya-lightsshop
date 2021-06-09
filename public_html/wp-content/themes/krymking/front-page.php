<?php
get_header();

$url = get_template_directory_uri();
?>
 
<section class="main-screen">
	<div class="slider">
		<div class="slide">
			<img src="<?=$url;?>/images/slide-1.jpg" alt="Слайд">
		</div>
		<div class="slide">
			<img src="<?=$url;?>/images/slide-2.jpg" alt="Слайд">
		</div>
		<div class="slide">
			<img src="<?=$url;?>/images/slide-3.jpg" alt="Слайд">
		</div>
		<div class="slide">
			<img src="<?=$url;?>/images/slide-4.jpg" alt="Слайд">
		</div>
		<div class="slide">
			<img src="<?=$url;?>/images/slide-5.jpg" alt="Слайд">
		</div>
	</div>
	<div class="wrapper">
		<h1>Крымкинг - забронируй лето!</h1>
		<div class="subtitle">Посуточная аренда жилья в Крыму</div>

		<?get_template_part('front/main-search');?>

		<?get_template_part('front/housing-type');?>
	</div>
</section>

<section class="section">
	<div class="wrapper">
		<div class="urgent-booking">
			<div class="phone-info">
				<h4>Срочное бесплатное бронирование по телефону</h4>
				<div class="phone">
					<a href="tel:<?=get_field('phone', 'options');?>"><?=get_field('phone', 'options');?></a>
					<span>бесплатно по россии</span>
				</div>
				<div class="phone phone2">
					<a href="tel:<?=get_field('phone2', 'options');?>"><?=get_field('phone2', 'options');?></a>
					<span>для звонков по тарифам <br> вашего мобильного оператора</span>
				</div>
			</div>
			<div class="messenger">
				<a href="https://wa.me/<?=get_field('messenger', 'options');?>" class="messenger-text" rel="nofollow">Whatsapp <img src="<?=$url;?>/images/icons/whatsapp.svg" alt="Whatsapp"></a>
				<a href="viber://chat?number=<?=get_field('messenger', 'options');?>" class="messenger-text" rel="nofollow">Viber <img src="<?=$url;?>/images/icons/viber.svg" alt="Viber"></a>
				<a href="tg://resolve?domain=<?=get_field('messenger', 'options');?>" class="messenger-text" rel="nofollow">Telegram <img src="<?=$url;?>/images/icons/telegram.svg" alt="Telegram"></a>
			</div>
		</div>

		<?get_template_part('front/popular-destinations');?>

		<?/* if( !wp_is_mobile() ) { */?>
		<?get_template_part('front/objects-map');?>
		<?/* } */?>

		<?if(get_field('advantages', 'options')){?>
		<h2 class="title">Преимущества бронирования с Krymking.ru</h2>
		<div class="advantages">
			<div class="advantage-image">
				<img src="<?=$url;?>/images/advantage.png" alt="Преимущества">
			</div>
			<div class="advantage-info">
				<h3>Мы - крымчане и Крым - наш дом!</h3>
				<ul>
					<?foreach (get_field('advantages', 'options') as $value) {?>
					<li><?=$value['title'];?></li>
					<?}?>
				</ul>
			</div>
		</div>
		<?}?>
		<?/* if( !wp_is_mobile() ) { */?>
		<?get_template_part('front/best-offers');?>
		<?/* } */?>

	</div>
</section>

<?
// $filter[] = get_field_object('field_6005774f41bef');
// $filter[] = get_field_object('field_600577ac4928d');
// $filter[] = get_field_object('field_602eb1bce5d78');
// $filter[] = get_field_object('field_602eb2642c2b4');
// $filter[] = get_field_object('field_6008afb8ef784');
// $filter[] = get_field_object('field_6008aff6ef785');

// $options = array(); 
// foreach( $filter as $option ) {
// 	$options[] = array(
// 		'label' => $option['label'],
// 		'name'  => $option['name'],
// 	);
// }



?>
 
<?php
get_footer();
