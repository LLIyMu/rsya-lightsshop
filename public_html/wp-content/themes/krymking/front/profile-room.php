<?
global $postid;
// Основные характеристики
$main_attr[] = get_field_object('field_60868176abfa4', $postid); // Площадь номера 
$main_attr[] = get_field_object('field_5fd719b126a08', $postid); // Количество принимаемых гостей
$main_attr[] = get_field_object('field_5fd719f332ddb', $postid); // Количество комнат
$main_attr[] = get_field_object('field_6001a7c1076ab', $postid); // Одноместных кроватей
$main_attr[] = get_field_object('field_6001a8017ca4b', $postid); // Двухместных кроватей
$main_attr[] = get_field_object('field_5fd71e630cd1f', $postid); // Всего спальных мест
$main_attr[] = get_field_object('field_608685b5152bd', $postid); // Количество возможных дополнительных мест
$main_attr[] = get_field_object('field_60019e3645d2e', $postid); // Количество санузлов всего
$main_attr[] = get_field_object('field_5fd7273e11a21', $postid); // Количество ванных комнат
$main_attr[] = get_field_object('field_600921bd474dc', $postid); // Питание
$main_attr[] = get_field_object('field_6086857195eab', $postid); // Количество номеров этого типа
 
// Ценообразование
foreach (acf_get_fields(357) as $field) {
	$prices[] = get_field_object($field['key'], $postid);
}
 
if (empty($_POST['choosed'])) {
	$title = get_the_title($postid);
	$name_apr = get_field('apartment_title', $postid);
} else {
	$title = '';
	$name_apr = $_POST['choosed'];
}
?>
 

<div class="form-section active" id="desc">
	<div class="heading">Описание и название</div>
	<div class="form-group section-gray">
		<div class="input-group full">
			<input type="text" name="apartment_title" placeholder="Название номера" value="<?=$name_apr;?>" maxlength="59" required class="form-control">
		</div>
		<div class="input-group full">
			<input type="text" name="apartment_name" placeholder="Собственное название номера" value="<?=$title;?>" maxlength="59" required class="form-control">
		</div>
		<div class="create-title">Не обязательная инфо, для удобства идентификации Владельцем</div>
		<div class="input-group textarea-group full">
			<div class="textarea-field">
			<textarea name="description" placeholder="Описание номера Владельцем" maxlength="500" rows="8" required class="form-control textarea"><?=get_post($postid)->post_content;?></textarea>
			<div class="count"><?=get_post($postid)->post_content ? 500 - mb_strlen(get_post($postid)->post_content, 'utf-8') : '500';?></div>
			</div>
		</div>
	</div>
</div>

<div class="form-section" id="rules">
<div class="heading">Основные характеристики</div>
	<div class="form-group section-gray">
		<?=main_fields($main_attr);?>
	</div>

	<div class="heading">Правила проживания</div>
	<div class="form-group section-gray">
		<?=main_fields( rulesRoom( $postid ) );?>
	</div>

	<div class="heading show-more">Общие удобства</div>
	<div class="form-group section-gray hide-param">
		<?=main_fields( generalRoom( $postid ) );?>
	</div>

	<div class="heading">Санузлы</div>
	<div class="form-group section-gray hide-param">
		<?=main_fields( sanuzelRoom( $postid ) );?>
	</div>

	<div class="heading">Кухня</div>
	<div class="form-group section-gray hide-param">
		<?=main_fields( kitchenRoom( $postid ) );?>
	</div>

	<div class="heading">Комнаты</div>
	<div class="form-group section-gray hide-param">
		<?=main_fields( roomsRoom( $postid ) );?>
	</div>

	<div class="heading">Детям</div>
	<div class="form-group section-gray hide-param">
		<?=main_fields( childrenRoom( $postid ) );?>
	</div>
</div>

<div class="form-section" id="pricing">
	<div class="heading">Ценообразование</div>
	<div class="form-group section-gray">
		<?=main_fields($prices);?>
	</div>
	<div class="heading">Цены по датам</div>
	
	<div class="section-gray calendar-wrap">
		<div class="calendar-left">
			<div class="load-prices">

				<?=pricePeriod($postid);?>

			</div>
		</div>
		<div class="calendar-right">
			<div class="input-group group-vertical">
				<div class="input-title">С</div>
				<input type="text" name="date_from" value="<?=date("d.m.Y");?>" class="calendar-season form-control">
			</div>
			<div class="input-group group-vertical">
				<div class="input-title">До</div>
				<input type="text" name="date_end" value="<?=date("d.m.Y");?>" class="calendar-season form-control">
			</div>
			<div class="input-group group-vertical">
				<div class="input-title">Цена за сутки</div>
				<input type="number" name="price_day" placeholder="<?=the_field('price', $postid);?>" value="<?=the_field('price', $postid);?>" class="form-control">
			</div>
			<div class="btn btn-save">Сохранить</div>
		</div>
	</div>
</div>

<div class="form-section" id="calendar">
	<div class="heading">Календарь и свободные даты</div>
	<div class="section-gray section-border">
		<div class="create-title">Настройте свободные даты в Календаре</div>
		<div class="create-info">Гости могут бронировать свободные даты до 12 месяцев вперед</div>
		<div class="marker-info">
			<div class="marker"><span class="circle circle-busy"></span> занято</div>
			<div class="marker"><span class="circle circle-free"></span> свободно</div>
		</div>
		<div class="create-text">Чтобы не получать заявки о бронировании на занятые даты, перечеркните в календаре дни, когда заселение невозможно</div>
		<div class="calendar-flex">
			<div class="calendar-left">
				<div class="calendar-header">Для блокировки периода выберите первую и последнюю дату периода</div>

				<div class="ajax ajax-date"><?=dates_free($postid);?></div>
			</div>
			<!-- <div class="calendar-right">
				<div class="calendar-item calendar-text">Свяжите календарь своего объекта для синхронизации с календарями этого объекта на других сайтах</div>
				<div class="calendar-item calendar-title">Связать календари</div>
				<div class="calendar-item calendar-text">Чтобы бронирование с Krymking попадали на другие сайты, вставьте у них ссылку на этот календарь объекта</div>
				<div class="calendar-item flexbox">
					<div class="input-group">
						<input type="text" name="calendar_link " placeholder="Ссылка Krymking" class="form-control">
					</div>
					<div class="btn">Копировать</div>
				</div>
				<div class="calendar-item calendar-text">Чтобы бронирование с других сайтов попадали сюда, вставьте ссылку c их календарем у нас здесь</div>
				<div class="calendar-item flexbox">
					<div class="input-group">
						<input type="text" name="calendar_site " placeholder="Ссылка других" class="form-control">
					</div>
					<div class="btn add-calendar">Добавить еще сайт</div>
				</div>
			</div> -->
		</div>
	</div>
</div>
 
<div class="form-section" id="lightning">
	<div class="heading">Подключение функции «Мгновенное бронирование» по Вашему объекту</div>
	<div class="section-gray">
		<div class="heading-info">Подключенная функция «Мгновенное бронирование» дает удобную возможность Гостю забронировать жилье на определенные даты без согласования в переписке с Владельцем. Владелец получает быстрое бронирование своего объекта на свободные даты согласно календарю объекта, увеличивает число броней и повышает свой рейтинг на Крымкинг.ру.</div>
		
		<? if (get_field('fast_booking', $postid) == 'Включить') {?>
			<label class="custom-checkbox instant-booking">
				<input type="checkbox" name="fast_booking" value="off" class="custom-input" checked="checked">
				<div class="check"></div>
				<span class="label-name">Отключить Мгновенное бронирование</span>
			</label>
		<?}else{?>
			<label class="custom-checkbox instant-booking">
				<input type="checkbox" name="fast_booking" value="on" class="custom-input">
				<div class="check"></div>
				<span class="label-name">Подключить Мгновенное бронирование</span>
			</label>
		<?}?>

		<ul class="lightning-info">
			<li>Если Вы, как Владелец, не уверены в соблюдении главного правила Мгновенного бронирования: своевременная актуализация календаря бронирования объекта (Вам нужно ответственно отмечать свободные и занятые даты), Крымкинг.ру рекомендует Вам не подключать эту функцию. В таком случае, Гостю придется отправить Вам Запрос на бронирование, а Владельцу в переписке с Гостем, проверив календарь, дополнительно подтвердить актуальность запрашиваемых дат по объекту.</li>
			<li>В случае, если объект с подключенной функцией Мгновенное бронирование окажется занят на необходимые даты и это выяснится до заезда Гостя, Владелец будет оштрафован. Если объект окажется занят непосредственно при заселении Гостя, Владелец и его объекты будут удалены с Крымкинг.ру</li>
		</ul>
	</div>
	<?if(get_field('fast_booking', $postid) == 'Включить'){?>
		<div class="instant-text green">Внимание! У Вас ПОДКЛЮЧЕНО Мгновенное бронирование!</div>
	<?}else{?>
		<div class="instant-text">Внимание! У Вас НЕ ПОДКЛЮЧЕНО Мгновенное бронирование!</div>
	<?}?>
</div>

<div class="form-section" id="photo">
	<div class="heading">Фото и видео</div>
	<div class="form-group section-gray">
		<div class="create-title">Добавьте лучшие фотографии своего объекта и ваше объявление станет идеальным</div>

			<fieldset class="form-group">
			    <div class="fieldset-title">Нажмите для добавления фото</div>
			    <input type="file" id="pro-image" name="files[]" style="display: none;" class="form-control" multiple>
			</fieldset>
			<div class="preview-images-zone">
				<?foreach (get_field('gallery', $postid) as $image) { ?>
				<div class="preview-image preview-show-4">
					<div class="image-cancel" data-no="4">x</div>
					<div class="image-zone">
						<img id="pro-img-4" src="<?=$image['url'];?>">
					</div>
					<div class="tools-edit-image">
						<a href="javascript:void(0)" data-no="4" class="btn-edit-image">Редактировать</a>
					</div>
				</div>
				<? } ?>
			</div>
 
		<div class="create-note"><span>Не более 25 фотографий.</span> Размер файла <span>– не более 10 МБ</span>. Требования к фотографиям: <span>не должно быть адресов, телефонов, логотипов, других отметок.</span> Форматы фото: <span>jpg., gif., png.</span></div>
		<div class="input-group full">
			<label class="input-title">Видео с YouTube</label>
			<input type="text" name="video" placeholder="Например: https://www.youtube.com/watch?v=qPeVoi6OmR1" value="<?=the_field('video', $postid);?>" class="form-control">
		</div>
	</div>
</div>

<div class="form-section " id="verification">
	<div class="heading">Верификация Владельца</div>
	<div class="section-gray">
		<div class="text-agreement"><label class="custom-checkbox"><input type="checkbox" name="agreement" class="custom-input" checked=""><div class="check"></div></label> <span class="text">Нажимая на кнопку Подтвердить, Я подтверждаю свое право на размещение данного объекта в краткосрочную аренду и соглашаюсь с <a href="#">Правилами размещения объекта</a></div>
		<div class="btn btn-confirm">Подтвердить</div>
	</div>
</div>

<a href="/add-object/" class="btn new-add hidden">Добавить еще объект</a>

<div class="navigation">
	<div class="btn btn-prev">Назад</div>
	<div class="btn btn-next">Далее</div>
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
		    } else {
		        console.log('Browser not support');
		    }
		}
 });

</script>
 