<?
global $postid;
// Местоположение
$location[] = get_field_object('field_600714f654d78', $postid); // Выберите тип улицы
$location[] = get_field_object('field_5fe2e279d947c', $postid); // Улица
$location[] = get_field_object('field_5fe2e299d947d', $postid); // Дом
$location[] = get_field_object('field_5fe2e2ebd947e', $postid); // Корпус

// Доступная среда
$disabilities[] = get_field_object('field_600919d84971f', $postid); // Удобства для гостей с ограниченными физическими возможностями

// Общие характеристики отеля
$attr[] = get_field_object('field_601ac0b50c5f4', $postid); // Звездность отеля
$attr[] = get_field_object('field_601ac17b49eb5', $postid); // Общее количество номеров
// $attr[] = get_field_object('field_6006a2f5f84ee', $postid); // Стандартное время заселения
// $attr[] = get_field_object('field_6006a3e0f84ef', $postid); // Стандартное время выселения
$attr[] = get_field_object('field_601ac2188dba1', $postid); // Оплата при заселении
$attr[] = get_field_object('field_601ac2a797a84', $postid); // Ресепшн
$attr[] = get_field_object('field_60057524eebd4', $postid); // Парковка
$attr[] = get_field_object('field_6009187c2a3a1', $postid); // Охраняемая территория
$attr[] = get_field_object('field_5fd71f7ce412a', $postid); // Расстояние до моря
$attr[] = get_field_object('field_602eb4cae6289', $postid); // Уборка
$attr[] = get_field_object('field_6005818e0da6a', $postid); // Отчетные документы

// Внутри или на территории отеля
$territory[] = get_field_object('field_6005774f41bef', $postid); // Интернет
$territory[] = get_field_object('field_600918902a3a2', $postid); // Ресторан
$territory[] = get_field_object('field_606461f2b4fbc', $postid); // Кафе
$territory[] = get_field_object('field_606461f0b4fbb', $postid); // Столовая
$territory[] = get_field_object('field_606461d8b4fba', $postid); // Общая кухня
$territory[] = get_field_object('field_606461d6b4fb9', $postid); // Бар
$territory[] = get_field_object('field_600915a8f72b2', $postid); // Беседка
// $territory[] = get_field_object('field_60057e7c2e1c0', $postid); // Терраса
$territory[] = get_field_object('field_60091626f72b5', $postid); // Веранда
$territory[] = get_field_object('field_6064635c674b9', $postid); // Собственный пляж
$territory[] = get_field_object('field_60091642f72b6', $postid); // Бассейн
$territory[] = get_field_object('field_6009167df72b7', $postid); // Сауна/баня
$territory[] = get_field_object('field_60646359674b8', $postid); // Спа зона
$territory[] = get_field_object('field_6009157c469c8', $postid); // Мангальная/барбекю зона
$territory[] = get_field_object('field_6009185c2a3a0', $postid); // Бильярд
$territory[] = get_field_object('field_6079414d3022b', $postid); // Детская комната
$territory[] = get_field_object('field_600916aef72b8', $postid); // Детская площадка
$territory[] = get_field_object('field_60091724f72b9', $postid); // Батут
$territory[] = get_field_object('field_600917e12a39b', $postid); // Спортивная площадка
$territory[] = get_field_object('field_600918012a39c', $postid); // Настольный теннис
$territory[] = get_field_object('field_6009181a2a39d', $postid); // Зал для фитнеса
$territory[] = get_field_object('field_6009182d2a39e', $postid); // Волейбол
$territory[] = get_field_object('field_6009183c2a39f', $postid); // Футбол
$territory[] = get_field_object('field_606464f5f5461', $postid); // Баскетбол
$territory[] = get_field_object('field_606464f3f5460', $postid); // Большой теннис
$territory[] = get_field_object('field_600919092a3a3', $postid); // Курение в специально отведенных местах
$territory[] = get_field_object('field_60792c963e8bd', $postid); // Лифт
$territory[] = get_field_object('field_600919d84971f', $postid); // Для гостей с ограниченными физическими возможностями
$territory[] = get_field_object('field_608677aa54e39', $postid); // Конференц-зал

// Инфраструктура
$infra[] = get_field_object('field_601ac5ffd10b7', $postid); // Расстояние до важных объектов
$infra[] = get_field_object('field_60091b7a9ad97', $postid); // Варианты досуга в городе

// Услуги
$service[] = get_field_object('field_60092146474da', $postid); // Трансфер
$service[] = get_field_object('field_60092180474db', $postid); // Парковка
$service[] = get_field_object('field_600921bd474dc', $postid); // Питание

// Регион и город
if( term_children($postid) == 0 ) {
	$terms = get_the_terms( $post_id, 'hotel' );
	if( $terms ){
		$term = array_shift( $terms );
	
		$region = $term->term_id;
		$city = $term->term_id;
	}
} else {
	$city = term_children($postid);
	$region = wp_get_term_taxonomy_parent_id( $city, 'hotel' );
}

// Название отеля
if ($postid) {
	$title = get_the_title($postid);
} else {
	$title = '';
}
?>

<div class="form-section active" id="location">
	<div class="section-gray">
		<div class="form-group">
			<div class="input-group">
				<label class="input-title">Регион</label>
				<?=region($region);?>
			</div>
			<div class="input-group">
				<label class="input-title">Город</label>
				<?=city($city);?>
			</div>
			<?=main_fields($location);?>
		</div>
		<div class="message"></div>
		<div class="object-text">Объект на карте</div>
		<div class="map">
			<div id="object-map"></div>
			<div class="btn btn-verify">Да, правильно</div>
		</div>
		<div class="object-message">Если адрес на карте определился неправильно, поставьте отметку вручную</div>
	</div>
	<div class="navigation">
		<div class="btn btn-prev">Назад</div>
		<div class="btn btn-next">Далее</div>
	</div>
</div>

<script type="text/javascript">
//Дождёмся загрузки API и готовности DOM.
ymaps.ready(init);

function init() {
    myMap = new ymaps.Map('object-map', {
      center: [44.948237, 34.100318], // Москва
      zoom: 16,
      controls: []
    });
 
	function clickGoto(address) {

	    // город
	    var city = address;

	    // получение координат по адресу - асинхронная функция
	    var myGeocoder = ymaps.geocode(city);
	    myGeocoder.then(
	    	function(res) {
	    	 	var coords = res.geoObjects.get(0).geometry.getCoordinates();
            	var obj = res.geoObjects.get(0);
              	var error, hint;
            if (obj) {
                // Об оценке точности ответа геокодера можно прочитать тут: https://tech.yandex.ru/maps/doc/geocoder/desc/reference/precision-docpage/
                switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                    case 'exact':
                        break;
                    case 'number':
                    case 'near':
                    case 'range':
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'street':
                        error = 'Неполный адрес, требуется уточнение';
                        hint = 'Уточните номер дома';
                        break;
                    case 'other':
                    default:
                        error = 'Неточный адрес, требуется уточнение';
                        hint = 'Уточните адрес';
                }
            } else {
                error = 'Адрес не найден';
                hint = 'Уточните адрес';
            }
 
            if (error) {
            	$('#location .message').removeClass('success');
            	$('#location .message').text(error +': '+ hint).addClass('error');

            	$('.btn-verify').fadeOut();
            } else {
            	$('#location .message').removeClass('error');
            	$('#location .message').text('Точное местоположение объекта найдено').addClass('success');

            	$('.btn-verify').fadeIn();

	    		// переходим по координатам
	    		myMap.panTo(coords, {
	    			flying: 1
	    		});

	    		// добавляем маркер
				var myPlacemark = new ymaps.Placemark(coords, null, {
					preset: 'islands#blueDotIcon',
					draggable: true
				});

				/* Событие dragend - получение нового адреса */
				myPlacemark.events.add('dragend', function(e){
					var cord = e.get('target').geometry.getCoordinates();
 
					ymaps.geocode(cord).then(function(res) {
						var location = res.geoObjects.get(0);
						console.log(location);

						$('input[name="house"]').val(location.getPremiseNumber());
						$('input[name="street"]').val(location.getThoroughfare());
								
					});
				});


	    		myMap.geoObjects.add(myPlacemark);
            }


	    	},
	    	function(err) {
	    		alert('Ошибка');
	    	}
	    );
	    return false;
	}
 

	$('#location *').on('change', function() {
		myMap.geoObjects.removeAll();
		clickGoto($('select[name="region"]').find(':selected').text() + ', ' + $('select[name="city"]').find(':selected').text() + ', ' + $('input[name="street"]').val() + ', ' + $('input[name="house"]').val());
	});

	clickGoto($('select[name="region"]').find(':selected').text() + ', ' + $('select[name="city"]').find(':selected').text() + ', ' + $('input[name="street"]').val() + ', ' + $('input[name="house"]').val()); 

	$('.btn-verify').on('click', function() {
		myMap.geoObjects.removeAll();
		clickGoto($('select[name="region"]').find(':selected').text() + ', ' + $('select[name="city"]').find(':selected').text() + ', ' + $('input[name="street"]').val() + ', ' + $('input[name="house"]').val());
	});
}
</script>

<div class="form-section" id="desc">
	<div class="form-group section-gray">
		<div class="create-title">Название отеля</div>
		<div class="input-group full">
			<input type="text" name="apartment_name" placeholder="Введите название отеля" value="<?=$title;?>" maxlength="59" required class="form-control">
			<div class="count"><?=$title ? 59 - mb_strlen($title, 'utf-8') : '59';?></div>
		</div>

		<div class="create-title">Описание отеля</div>
		<div class="input-group textarea-group full">
			<div class="textarea-field">
			<textarea name="description" placeholder="Опишите отель и его территорию" maxlength="500" rows="8" required class="form-control textarea"><?=get_post($postid)->post_content;?></textarea>
			<div class="count"><?=get_post($postid)->post_content ? 500 - mb_strlen(get_post($postid)->post_content, 'utf-8') : '500';?></div>
			</div>
		</div>
	</div>

	<div class="heading">Общие характеристики отеля</div>
	<div class="form-group section-gray">
		<?=main_fields($attr);?>
	</div>

	<div class="heading">Внутри или на территории отеля</div>
	<div class="form-group section-gray">
		<?=main_fields($territory);?>
	</div>
 
	<div class="heading">Инфраструктура</div>
	<div class="form-group section-gray">
		<?=main_fields($infra);?>
	</div>

	<div class="heading">Услуги</div>
	<div class="form-group section-gray">
		<?=main_fields($service);?>
	</div>

	<div class="navigation">
		<div class="btn btn-prev">Назад</div>
		<div class="btn btn-next">Далее</div>
	</div>

</div>


<div class="form-section" id="photo">
	<div class="heading">Фото отеля и его территории</div>
	<div class="form-group section-gray">
		<fieldset class="form-group">
		    <div class="fieldset-title">Нажмите для добавления фото</div>
		    <input type="file" id="pro-image" name="files[]" style="display: none;" class="form-control" multiple>
		</fieldset>
		<div class="preview-images-zone">
			<?foreach (get_field_object('field_5fe06e7c53d4b', $postid)['value'] as $image) { ?>
			<div class="preview-image preview-show-<?=$image['ID'];?>">
				<div class="image-cancel" data-no="<?=$image['ID'];?>">x</div>
				<div class="image-zone">
					<img id="pro-img-<?=$image['ID'];?>" src="<?=$image['url'];?>">
					<input name="gallery[]" value="<?=$image['ID'];?>" type="hidden">
				</div>
				<div class="tools-edit-image">
					<a href="javascript:void(0)" data-no="<?=$image['ID'];?>" class="btn-edit-image">Редактировать</a>
				</div>
			</div>
			<? } ?>
		</div>
		<div class="create-note"><span>Не более 25 фотографий.</span> Размер файла <span>– не более 10 МБ</span>. Требования к фотографиям: <span>не должно быть адресов, телефонов, логотипов, других отметок.</span> Форматы фото: <span>jpg., gif., png.</span></div>
	</div>
	<div class="navigation">
		<div class="btn btn-prev">Назад</div>
		<div class="btn btn-next">Далее</div>
	</div>
</div>

<? 
$field1 = get_field_object('field_604afb8d2b9bf');
$field2 = get_field_object('field_604afcb24a64b');
$field3 = get_field_object('field_604afd438ab87');
?>

<div class="form-section" id="rooms">
				
	<? if( get_field('select_object', $postid) ) { ?>
	<div class="heading">Доступные номера в отеле</div>

	<div class="objects-list edit-objects">
		<? foreach( get_field('select_object', $postid ) as $post ) { ?>
			<? setup_postdata($post); ?>

			<? 
			$statuses = array(
				array(
					'label' => 'опубликовано',
					'value' => 'publish',
				),
				array(
					'label' => 'не опубликовано',
					'value' => 'draft',
				),
				array(
					'label' => 'на модерации',
					'value' => 'pending',
				),
				array(
					'label' => 'отклонено',
					'value' => 'rejected',
				)
			); ?>

			<div class="object-item">
				<div class="object-image">
					<a href="<?=get_permalink();?>"><?=the_post_thumbnail(array(200, 200));?></a>
				</div>
				<div class="object-content">
					<div class="rating-wrap">
						<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>
						<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>
						<div class="reviews"><?=num_word( get_comments_number(), array("отзыв","отзыва","отзывов") ); ?></div>
					</div>
					<a href="<?=get_permalink();?>" class="object-title"><?=the_title();?></a>
					<div class="object-id">ID: <?=get_the_ID();?></div>

					<div class="df">
						<a href="<?=home_url('/objects/edit/');?>?post=<?=get_the_ID();?>&action=edit-rooms" class="edit-link">Редактировать</a>
					</div>

					<div class="status">
						<div class="status-title">Статус</div>
						<?foreach ($statuses as $status) {?>
						<label class="custom-checkbox">
							<input type="checkbox" name="<?=$status['value'];?>" class="custom-input" 

							<?if (get_post_status( get_the_ID() ) == $status['value']) echo 'checked';?>

							<? if( get_post_status( get_the_ID() ) == 'pending' ) { ?>
								<?=$status['value'] == 'draft' ? 'checked' : ''; ?>
							<? } ?>
							
							disabled>
							<div class="check"></div>
							<span class="status-text"><?=$status['label'];?></span>
						</label>
						<? } ?>
					</div>
					<? if (get_post_status( get_the_ID() ) == 'trash') { ?>
						<div class="remove-link" data-id="<?=get_the_ID();?>" data-action="untrash_object">Восстановить</div>
					<? } else { ?>
						<div class="remove-link" data-id="<?=get_the_ID();?>" data-action="trash_object">Перенести в Архив</div>
					<? } ?>
				</div>
			</div>
		<?wp_reset_query();?>
		<? } ?>
	</div>
	<? } ?>

	<div class="heading">Добавление номера в отеле</div>
	<div class="form-group section-gray">

		<div class="input-group group-vertical <?=$field1['name'];?>">

			<label class="input-title title-radio"><strong><?=$field1['label'];?></strong></label>

			<?foreach ($field1['choices'] as $field_key => $field_value) { ?>

				<label class="custom-radio form-control">
					<input type="radio" name="<?=$field1['name'];?>" value="<?=$field_key;?>">
					<div class="label-name"><?=$field_value;?></div>
				</label>

			<? } ?>

		</div>

		<div class="input-group group-vertical <?=$field2['name'];?>">

			<label class="input-title title-radio"><strong><?=$field2['label'];?></strong></label>

			<?foreach ($field2['choices'] as $field_key => $field_value) { ?>

				<label class="custom-radio form-control">
					<input type="radio" name="<?=$field2['name'];?>" value="<?=$field_key;?>">
					<div class="label-name"><?=$field_value;?></div>
				</label>

			<? } ?>

		</div>

		<div class="input-group group-vertical <?=$field3['name'];?>">

			<label class="input-title title-radio"><strong><?=$field3['label'];?></strong></label>

			<?foreach ($field3['choices'] as $field_key => $field_value) { ?>

				<label class="custom-radio form-control">
					<input type="radio" name="<?=$field3['name'];?>" value="<?=$field_key;?>">
					<div class="label-name"><?=$field_value;?></div>
				</label>

			<? } ?>

		</div>

		<div class="input-group group-vertical full">
			<div class="input-title">Вы выбрали</div>
			<input type="text" name="choosed" value="" class="form-control" readonly>
		</div>

 	</div>

	<div class="navigation">
		<div class="btn btn-prev">Назад</div>
		<input type="submit" name="room" value="Далее" class="btn btn-next">
	</div>
</div>


<script>
$(document).ready(function() {
    $('.fieldset-title').click(function() {
    	$('#pro-image').click();
    });

	document.getElementById('pro-image').addEventListener('change', readImage, false);

	$( ".preview-images-zone" ).sortable();

	$(document).on('click', '.image-cancel', function() {
		let no = $(this).data('no');
		$(".preview-image.preview-show-"+no).remove();
	});

	var num = 4;
	function readImage() {
		if (window.File && window.FileList && window.FileReader) {
			var files = event.target.files; //FileList object
			var output = $(".preview-images-zone");
	
			for (let i = 0; i < files.length; i++) {
				var file = files[i];
				if (!file.type.match('image')) continue;
				
				var picReader = new FileReader();
				
				picReader.addEventListener('load', function (event) {
					var picFile = event.target;
					var html =  '<div class="preview-image preview-show-' + num + '">' +
								'<div class="image-cancel" data-no="' + num + '">x</div>' +
								'<div class="image-zone"><img id="pro-img-' + num + '" src="' + picFile.result + '"></div>' +
								'<div class="tools-edit-image"><a href="javascript:void(0)" data-no="' + num + '" class="btn-edit-image">Редактировать</a></div>' +
								'</div>';
	
					output.append(html);
					num = num + 1;
				});
	
				picReader.readAsDataURL(file);
			}
			// $("#pro-image").val('');
		} else {
			console.log('Browser not support');
		}
	}
 });	
 
</script>