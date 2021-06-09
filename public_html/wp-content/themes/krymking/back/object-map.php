<?
function entity_map($postid){
	$address = hotel_address($postid). ', ' .get_field('street', $postid). ', ' .get_field('house', $postid);

  $post_id = get_the_ID();
?>

<div class="entity-location">
	<div id="popup-map" class="entity-map"></div>
	<div class="location-bottom">
		<div class="entity-address"><?=hotel_address($postid);?>, ул. <?=the_field('street', $postid);?>, <?=the_field('house', $postid);?></div>
		<div class="show-offers"><label class="custom-checkbox"><input type="checkbox" name="show_offers" class="custom-input" checked=""><div class="check"></div></label> Показывать предложения рядом</div>
	</div>
</div>

<script type="text/javascript">

ymaps.ready(init);

function init() {

    myMap = new ymaps.Map('popup-map', {
    	center: [44.945890, 34.099599],
    	zoom: 9,
    	controls: []
    }, {
    	searchControlProvider: 'yandex#search'
    });

	<?

    $meta_query[] = array(
      'key'     => '_wp_page_template',
      'value'   => 'single-hotel.php',
      'compare' => '!='
    );

    $args = array(
    'posts_per_page' => -1,
    'post_type' => 'hotels',
    'order' => 'ASC',
    'post_status' => 'publish',
    'meta_query'     => $meta_query
    );

 

	  $query = new WP_Query($args); ?>
    <?
    $i = 1;
    if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); 

    if(get_field('select_hotel')) {
      $address = hotel_address(get_field('select_hotel', $post_id)->ID). ', ' .get_field('street', get_field('select_hotel', $post_id)->ID). ', ' .get_field('house', get_field('select_hotel', $post_id)->ID);
    } else {
      $address = hotel_address($post->ID). ', ' .get_field('street'). ', ' .get_field('house');
    }

    ?>

    // получение координат по адресу - асинхронная функция
    var myGeocoder = ymaps.geocode('<?=$address;?>');
    myGeocoder.then(
      function(res) {

        var coords = res.geoObjects.get(0).geometry.getCoordinates();
          var polygonLayout = ymaps.templateLayoutFactory.createClass('<div class="placemark placemark-<?php the_ID(); ?>"><?=the_field('price');?> RUB</div>');

      var polygonPlacemark<?php the_ID(); ?> = new ymaps.Placemark(
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
             <?if(!empty($_SESSION['check_in']) && !empty($_SESSION['check_out'])){?>
              '<form action="/booking/" method="post">',
              '<input type="hidden" name="hotel_id" value="<?=the_ID();?>">',
              '<input type="hidden" name="check_in" value="<?=$_SESSION['check_in'];?>">',
              '<input type="hidden" name="check_out" value="<?=$_SESSION['check_out'];?>">',
              '<input type="submit" class="btn btn-booking" value="Забронировать">',
              '</form>',
             <? } ?>
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
      // myMap.events.add('actiontick', function() {
      //   empty();
      // });

        polygonPlacemark<?php the_ID(); ?>.events
        .add('click', function(e) {
          var clustererPlacemark = e.get('target');
          var overlay = clustererPlacemark.getOverlaySync();
          var layout = overlay.getLayoutSync();
          var element = layout.getParentElement();
          var placemark = element.querySelector('.placemark');
          placemark.classList.toggle('active')
        });

      myMap.geoObjects.add(polygonPlacemark<?php the_ID(); ?>);
 
      jQuery(document).on("click", ".hotel-address [data-id='<?php the_ID(); ?>']", function(){
        $('.placemark').removeClass('active');

        polygonPlacemark<?php the_ID(); ?>.balloon.open();
        $('.placemark-<?php the_ID(); ?>').addClass('active');

        $('html, body').animate({ scrollTop: 0 }, 'slow');
      });

		<?
 
    if(get_field('select_hotel', $post_id)) {
      $post_id = $post_id;
    } else {
      $post_id = $postid;
    }
      
    if(get_the_ID() == $post_id){?>

			setTimeout(function(){
				$('.placemark').removeClass('active');
			
				polygonPlacemark<?=the_ID();?>.balloon.open();
				$('.placemark-<?=the_ID();?>').addClass('active');
			}, 1000);

		<?} ?>

      },
      function(err) {
        alert('Ошибка');
      }
    );
 
	<?
	$i++;
	endwhile;
	endif;
  wp_reset_postdata(); 
  ?>
}
 

</script>
<? }


function entity_location(){
	$postid = $_POST['post_id'];
?>
	<div class="popup-map">
		<?=entity_map($postid);?>
	</div>
<? }
add_action('wp_ajax_nopriv_entity_location','entity_location');
add_action('wp_ajax_entity_location','entity_location');