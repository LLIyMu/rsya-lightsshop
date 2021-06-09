<div class="form-section section-gray active" id="location">
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
		clickGoto('Россия, Крым, ' + $('select[name="region"]').find(':selected').text() + ', ' + $('select[name="city"]').find(':selected').text() + ', ' + $('select[name="street_type"]').find(':selected').text() + ', ' + $('input[name="street"]').val() + ', дом ' + $('input[name="house"]').val());
	});

	clickGoto('Россия, Крым, ' + $('select[name="region"]').find(':selected').text() + ', ' + $('select[name="city"]').find(':selected').text() + ', ' + $('select[name="street_type"]').find(':selected').text() + ' ' + $('input[name="street"]').val() + ', ' + $('input[name="house"]').val()); 

	$('.btn-verify').on('click', function() {
		myMap.geoObjects.removeAll();
		clickGoto($('select[name="region"]').find(':selected').text() + ', ' + $('select[name="city"]').find(':selected').text() + ', ' + $('input[name="street"]').val() + ', ' + $('input[name="house"]').val());
	});
}
</script>