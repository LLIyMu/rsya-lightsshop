<?php
get_header();
/* Template Name: Контакты */
$url = get_template_directory_uri();
?>
<div class="headLine"></div>

<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
	<h1 class="page-title">Контакты для официальных обращений</h1>
 	<div class="contacts-wrap">
 		<div class="contacts-left">
 			<div class="contacts-list">
 				<div class="contact-item contact-address"><span>Наш офис:</span> <?=the_field('address', 'options');?></div>
 				<div class="contact-item contact-email"><span>Для писем:</span> <?=the_field('letters', 'options');?></div>
 				<div class="contact-item contact-email"><span>Электронный адрес:</span> <a href="mailto:<?=the_field('email', 'options');?>" class="email"><?=the_field('email', 'options');?></a></div>
 				<div class="contact-item contact-doc"><span>Реквизиты:</span> <?=the_field('requisites', 'options');?></div>
 			</div>
 		</div>
 		<div class="contacts-right">
 			<div id="contact-map"></div>
 		</div>
 	</div>
</div>


<script src="//api-maps.yandex.ru/2.1/?apikey=<API-ключ>&lang=ru_RU&csp=true" type="text/javascript"></script>
<script>
ymaps.ready(function () {
	var myMap = new ymaps.Map('contact-map', {
	center: [<?=the_field('geocode', 'options');?>],
	zoom: 16,
	controls: ['zoomControl']
	}, {
	searchControlProvider: 'yandex#search'
	}),
	myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
	hintContent: 'Krymking.ru',
	balloonContent: '<?=the_field('address', 'options');?>'
	}, {
		// Опции.
		// Необходимо указать данный тип макета.
		iconLayout: 'default#image',
		// Своё изображение иконки метки.
		iconImageHref: '<?=get_template_directory_uri();?>/images/icons/point.svg',
		// Размеры метки.
		iconImageSize: [19, 31],
		// Смещение левого верхнего угла иконки относительно
		// её "ножки" (точки привязки).
		iconImageOffset: [-9, -63],
	});
	// Сдвинем карту на 300 пикселей влево
	// var position = myMap.getGlobalPixelCenter();
	// myMap.setGlobalPixelCenter([ position[0] - 300, position[1] - 100 ]);
	myMap.geoObjects.add(myPlacemark);
	myMap.behaviors.disable('scrollZoom');
});
</script>

<?php
get_footer();