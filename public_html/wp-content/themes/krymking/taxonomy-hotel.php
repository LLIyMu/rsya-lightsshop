<?
get_header();

if (!empty($_POST['city'])) {
	$category_title = $_POST['city'];
} elseif(single_term_title('', false)) {
	$category_title = single_term_title('', false);
}
$category = get_queried_object();

$category_total = $category->count;

$parent_id = wp_get_term_taxonomy_parent_id( $category->term_id, 'hotel' );

$args = array(
    'post_type' => 'hotels',
    'hotel'=> $category->slug,
    'numposts' => 0
);

$query = new WP_Query;

$Aposts = $query->query($args);

?>
<div class="headLine"></div>
<div class="wrapper">
 

 <? if(function_exists('bcn_display')) {?>
  <div class="breadcrumbs">
    <?=bcn_display();?>
  </div>   
<? } ?>

<div class="variants-info">Посуточная аренда жилья в <?//=$parent_id != 0 ? '' : 'регионе'; ?> <?=$category_title;?> <span>Найдено <?=num_word( count($Aposts), array("вариант","варианта","вариантов") ); ?></span></div>
<div class="sub-category">
<? $taxonomy = 'hotel';
  $term = get_queried_object();

  $children = get_terms( 
    $term->taxonomy, array(
      'parent' => $term->term_id,
      'hide_empty' => false
    )
  );
  foreach ($children as $subcat) { 
?>
  <div class="category-item">
    <a href="<?=get_term_link($subcat->term_id, $taxonomy);?>" class="category-name"><?=$subcat->name;?></a>
  </div>
<? } ?>
</div>
  <div class="overlay-filter"></div>
	<div class="page-wrap flex-content">
		<?get_template_part('front/filters-sidebar');?>

		<div class="side-right show-maps">

      <div class="btn-filter">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="#3470A7"><path d="M7.17 19H4a1 1 0 0 1 0-2h3.17a3.001 3.001 0 1 1 0 2zm10.66-8H20a1 1 0 0 1 0 2h-2.17a3.001 3.001 0 1 1 0-2zM15 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-3-6a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2h-8zm-8 6a1 1 0 0 1 0-2h5a1 1 0 0 1 0 2H4zm6 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2zM6 9a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0-2a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm10 12a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2h-4z" fill-rule="nonzero"></path></svg>
		<span class="btnName">Фильтр</span>
	  </div>
			<div class="sort-menu">
				<div class="sort-label">Сортировать по: 
        <svg width="20" height="20" fill="#252525" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 24 24">
          <g>
            <path d="M9,0C8.7,0,8.5,0.1,8.3,0.3l-8,8C0.1,8.5,0,8.7,0,9c0,0.3,0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3   c0.3,0,0.5-0.1,0.7-0.3l0,0l2-2C5.4,8.8,6,9,6,9.5V23c0,0.5,0.5,1,1,1h2c0.5,0,1-0.5,1-1V1c0-0.3-0.1-0.5-0.3-0.7   C9.5,0.1,9.3,0,9,0z"/>
            <path d="m23.7,14.3l-1.4-1.4c-0.2-0.2-0.5-0.3-0.7-0.3-0.3,0-0.5,0.1-0.7,0.3l-2,2c-0.3,0.3-0.9,0.1-0.9-0.4v-13.5c0-0.5-0.5-1-1-1h-2c-0.5,0-1,0.5-1,1v22c0,0.3 0.1,0.5 0.3,0.7s0.5,0.3 0.7,0.3c0.3,0 0.5-0.1 0.7-0.3l8-8c0.2-0.2 0.3-0.4 0.3-0.7 0-0.3-0.1-0.5-0.3-0.7z"/>
          </g>
        </svg>
        </div>
        <div class="sort-content">
          <div class="sort-option active" data-sort="price" data-order="ASC">Рекомендованные</div>
          <div class="sort-option" data-sort="price" data-order="ASC">Сначала дешевые</div>
          <div class="sort-option" data-sort="price" data-order="DESC">Сначала дорогие</div>
          <div class="sort-option" data-sort="guest_rating" data-order="DESC">Оценка гостей</div>
          <div class="sort-option" data-sort="distance" data-order="ASC">Близость к морю</div>
        </div>
			</div>

		  <div class="ajax">
				<div id="search-map"></div>
				<div class="hotels-list">
                    <?php foreach ($Aposts as $post){

                        setup_postdata($post);

                        get_template_part('front/object-card');

                    }

                    wp_reset_postdata();

                    ?>
				<?/* if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?get_template_part('front/object-card'); */?>
				<?/* endwhile;
        else: echo "По вашему запросу ничего не найдено";
				endif; */?>
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
    $i = 1;
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    if(get_field('select_hotel')) {
      $address = hotel_address(get_field('select_hotel', $post->ID)->ID). ', ' .get_field('street', get_field('select_hotel', $post->ID)->ID). ', ' .get_field('house', get_field('select_hotel', $post->ID)->ID);
    } else {
      $address = hotel_address($post->ID). ', ' .get_field('street'). ', ' .get_field('house');
    }
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
             '<div class="post-price"><?=the_price();?> RUB / за сутки</div>',
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
      // myMap.events.add('actiontick', function() {
      //   empty();
      // });

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

        if(!$('.side-right').hasClass('show-maps') ) {
          $('.show-map').click();
        }

          $('html, body').animate({ scrollTop: document.querySelector('.side-right.show-maps').getBoundingClientRect().top + pageYOffset }, 'slow', function(){
              console.log(document.querySelector('.side-right.show-maps').getBoundingClientRect().top + pageYOffset)
          });
      });

      },
      function(err) {
        alert('Ошибка');
      }
    );
 
  <?
  $i++;
  endwhile;
  endif; ?>
}

</script>
			</div>

		</div>

	</div>
</div>

<?php
get_footer();
