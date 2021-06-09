<?php
if (empty($_GET['city'])) {
	// header('Location: http://king.siteup.pro/');
}
get_header();
?>
<div class="headLine"></div>
<div class="wrapper">
 

 <? if(function_exists('bcn_display')) {?>
  <div class="breadcrumbs">
    <?=bcn_display();?>
  </div>   
  <? } ?>
 
	<div class="page-wrap flex-content">
		<?get_template_part('front/filters-sidebar');?>

		<div class="side-right">
			<div class="sort-menu">
				<div class="sort-label">Сортировать по:</div>
				<div class="sort-option active" data-sort="price" data-order="ASC">Рекомендованные</div>
				<div class="sort-option" data-sort="price" data-order="ASC">Сначала дешевые</div>
				<div class="sort-option" data-sort="price" data-order="DESC">Сначала дорогие</div>
				<div class="sort-option" data-sort="guest_rating" data-order="DESC">Оценка гостей</div>
				<div class="sort-option" data-sort="distance" data-order="ASC">Близость к морю</div>
			</div>

		    <div class="ajax">
				<div id="search-map"></div>
				<div class="hotels-list">
				<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>	
					<?get_template_part('front/object-card');?>
				<? endwhile;
				endif; ?>
		    	</div>
			</div>
		</div>

	</div>
</div>

 
<script type="text/javascript">

ymaps.ready(init);

function init() {

    myMap = new ymaps.Map('search-map', {
      center: [44.945890, 34.099599],
      zoom: 9,
      controls: []
    }, {
      searchControlProvider: 'yandex#search'
    });
 
    <?
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $address = hotel_address($post->ID). ', ' .get_field('street'). ', ' .get_field('house');
    ?>
 
    // получение координат по адресу - асинхронная функция
    var myGeocoder = ymaps.geocode('<?=$address;?>');
    myGeocoder.then(
      function(res) {

        var coords = res.geoObjects.get(0).geometry.getCoordinates();
          var polygonLayout = ymaps.templateLayoutFactory.createClass('<div class="placemark placemark-<?=$post->ID;?>"><?=the_field('price');?> RUB</div>');

      var polygonPlacemark<?=$post->ID;?> = new ymaps.Placemark(
          coords, {
          balloonContentBody: [
             '<div class="balloon-post">',
             '<div class="post-thumbnail"><a href="<?=get_permalink();?>"><?=the_post_thumbnail(array(355, 330));?></a></div>',
             '<div class="balloon-content">',
             // '<div class="category-name">Апартаменты / квартиры</div>',
             '<div class="post-name"><a href="<?=get_permalink();?>"><?=the_title()?></a></div>',
             '<div class="post-rating">',
             '<div class="rating rating-orange"><?=rating(get_field('guest_rating'), 'number');?></div>',
             '<div class="rating-content">',
             '<div class="rating-text"><?=rating(get_field('guest_rating'), 'text');?></div>',
             '<div class="reviews"><?=comments_number('0 отзывов','1 отзыв','% отзывов');?></div>',
             '</div>',
             '</div>',
             '<div class="post-price"><?=the_field('price');?> RUB / за сутки</div>',
             '<a href="<?=get_permalink();?>" class="btn btn-booking">Забронировать</a>',
             '</div>',
             '</div>'
          ].join('')
          }, {
              iconLayout: polygonLayout,
              // Описываем фигуру активной области "Полигон".
              iconShape: {   
                  type: 'Rectangle',
                  // Полигон описывается в виде трехмерного массива. Массив верхнего уровня содержит контуры полигона. 
                  // Первый элемента массива - это внешний контур, а остальные - внутренние.
                  coordinates: [
                      // Описание внешнего контура полигона в виде массива координат.
                      [-25, -25], [25, 25]
                      // , ... Описание внутренних контуров - пустых областей внутри внешнего.
                  ]
              },
              hideIconOnBalloonOpen: false
          }
      );

      function empty() {
        myMap.balloon.close();

            var elems = document.querySelectorAll('.placemark');
            
        [].forEach.call(elems, function(el) {
            el.classList.remove("active");
        });
      }

      myMap.events.add('click', function() {
        empty();
      });
      myMap.events.add('actiontick', function() {
        empty();
      });

        polygonPlacemark<?=$post->ID;?>.events
        .add('click', function(e) {
          var clustererPlacemark = e.get('target');
          var overlay = clustererPlacemark.getOverlaySync();
          var layout = overlay.getLayoutSync();
          var element = layout.getParentElement();
          var placemark = element.querySelector('.placemark');
          placemark.classList.toggle('active')
        });

      myMap.geoObjects.add(polygonPlacemark<?=$post->ID;?>);
 
      jQuery(document).on("click", ".hotel-address [data-id='<?=$post->ID;?>']", function(){
        $('.placemark').removeClass('active');

        polygonPlacemark<?=$post->ID;?>.balloon.open();
        $('.placemark-<?=$post->ID;?>').addClass('active');

        $('html, body').animate({ scrollTop: 0 }, 'slow');
      });

      },
      function(err) {
        alert('Ошибка');
      }
    );
 
  <?
  endwhile;
  endif; ?>
}



</script>


<?php
get_footer();
