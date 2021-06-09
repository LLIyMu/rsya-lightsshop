<?php
/**
 * krymking functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package krymking
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'krymking_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function krymking_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be field in the /languages/ directory.
		 * If you're building a theme based on krymking, use a find and replace
		 * to change 'krymking' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'krymking', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'krymking' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'krymking_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'krymking_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function krymking_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'krymking_content_width', 640 );
}
add_action( 'after_setup_theme', 'krymking_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function krymking_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'krymking' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'krymking' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'krymking_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function krymking_scripts() {
    // wp_enqueue_script( 'jquery' );

	$theme_style = get_stylesheet_directory() . '/css/style.css';
	$style_ver = filemtime($theme_style);
	wp_enqueue_style( 'krymking-fonts', get_template_directory_uri() . '/fonts/fonts.css');
	wp_enqueue_style( 'krymking-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.min.css');
	wp_enqueue_style( 'krymking-slick', get_template_directory_uri() . '/css/slick.css');
	wp_enqueue_style( 'krymking-ui', get_template_directory_uri() . '/css/jquery-ui.min.css');
	wp_enqueue_style( 'krymking-slider', get_template_directory_uri() . '/css/jquery.slider.css');
	wp_enqueue_style( 'krymking-style', get_template_directory_uri() . '/css/style.css?' . $style_ver, false, null );
	wp_enqueue_style( 'krymking-responsive', get_template_directory_uri() . '/css/responsive.css');


	wp_enqueue_script( 'krymking-jquery', get_template_directory_uri() . '/js/jquery-3.3.1.min.js');
	wp_enqueue_script( 'krymking-mask', get_template_directory_uri() . '/js/jquery.mask.js');
	wp_enqueue_script( 'krymking-fancybox', get_template_directory_uri() . '/js/jquery.fancybox.min.js');
	wp_enqueue_script( 'krymking-slick', get_template_directory_uri() . '/js/slick.min.js');
	wp_enqueue_script( 'krymking-ui', get_template_directory_uri() . '/js/jquery-ui.min.js');
	wp_enqueue_script( 'krymking-datepicker', get_template_directory_uri() . '/js/datepicker.range.min.js');
	wp_enqueue_script( 'krymking-touch', get_template_directory_uri() . '/js/jquery.ui.touch-punch.min.js');
	wp_enqueue_script( 'krymking-touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js');
 

	wp_enqueue_script( 'fonts', get_template_directory_uri() . '/js/common.js');
}
add_action( 'wp_enqueue_scripts', 'krymking_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Общие удобства в номере
function generalRoom( $post_id = 0 ) {
	$field[] = get_field_object('field_600577ac4928d', $post_id); // Телевизор
	$field[] = get_field_object('field_602eb1bce5d78', $post_id); // Кондиционер
	$field[] = get_field_object('field_6008afb8ef784', $post_id); // Холодильник
	$field[] = get_field_object('field_6008b02bef787', $post_id); // Электрический чайник
	$field[] = get_field_object('field_6008aff6ef785', $post_id); // Микроволновая печь
	$field[] = get_field_object('field_6005ad4551be7', $post_id); // Фен
	$field[] = get_field_object('field_6005ada851beb', $post_id); // Туалетные принадлежности
	$field[] = get_field_object('field_6008af39ef781', $post_id); // Кухня
	$field[] = get_field_object('field_60057e562e1bf', $post_id); // Балкон/лоджия
	$field[] = get_field_object('field_60057f45e2ef1', $post_id); // Сейф
	$field[] = get_field_object('field_60057e268a6b6', $post_id); // Отопление
	$field[] = get_field_object('field_6005812c0da67', $post_id); // Пожарная сигнализация

	return $field;
}

// Санузлы в номере
function sanuzelRoom( $post_id = 0 ) {
	$field[] = get_field_object('field_6005842ba1203', $postid); // Количество санузлов
	$field[] = get_field_object('field_6064531334137', $postid); // Количество туалетов
	$field[] = get_field_object('field_600586fd05d50', $postid); // Ванна
	$field[] = get_field_object('field_600587ab94792', $postid); // Душевая кабина
	$field[] = get_field_object('field_600587c1504ef', $postid); // Биде
	$field[] = get_field_object('field_600587f6fc36d', $postid); // Гигиенический душ
	$field[] = get_field_object('field_600588127403a', $postid); // Джакузи
	$field[] = get_field_object('field_6005884d05013', $postid); // Водонагреватель электрический
	$field[] = get_field_object('field_600588b37407d', $postid); // Водонагреватель газовый
	$field[] = get_field_object('field_600588e17407e', $postid); // Стиральная машина
	$field[] = get_field_object('field_600588f97407f', $postid); // Сушильная машина
	$field[] = get_field_object('field_6005ad2151be6', $postid); // Сушка для белья
	$field[] = get_field_object('field_6005ad5a51be8', $postid); // Полотенца
	$field[] = get_field_object('field_6005ad6f51be9', $postid); // Халат
	$field[] = get_field_object('field_6005ad8651bea', $postid); // Тапочки

	return $field;
}

// Кухня в номере
function kitchenRoom( $post_id = 0 ) {
	$field[] = get_field_object('field_6008af7aef782', $postid); // Газовая плита
	$field[] = get_field_object('field_6008af9def783', $postid); // Электроплита
	$field[] = get_field_object('field_6008b009ef786', $postid); // Духовка
	$field[] = get_field_object('field_6008b045ef788', $postid); // Кофеварка
	$field[] = get_field_object('field_6008b058ef789', $postid); // Мультиварка
	$field[] = get_field_object('field_6008b069ef78a', $postid); // Блендер
	$field[] = get_field_object('field_6008b07def78b', $postid); // Посудомоечная машина
	$field[] = get_field_object('field_6008b097ef78c', $postid); // Фильтр для воды
	$field[] = get_field_object('field_6008b0a4ef78d', $postid); // Посуда и приборы

	return $field;
}

// Комнаты в номере
function roomsRoom( $post_id = 0 ) {
	$field[] = get_field_object('field_600693ee44d7e', $postid); // Вентилятор
	$field[] = get_field_object('field_6006946744d80', $postid); // Кабельное телевидение
	$field[] = get_field_object('field_6006947e44d81', $postid); // Интернет телевидение
	$field[] = get_field_object('field_6005816d0da69', $postid); // Постельное белье
	$field[] = get_field_object('field_6006949b44d82', $postid); // Утюг
	$field[] = get_field_object('field_600694bd44d83', $postid); // Гладильная доска
	$field[] = get_field_object('field_600694d244d84', $postid); // Пылесос
	$field[] = get_field_object('field_6006951344d85', $postid); // Стол/рабочее место
	$field[] = get_field_object('field_6006953444d86', $postid); // Диван
	$field[] = get_field_object('field_6006954a44d87', $postid); // Шкаф/комод
	$field[] = get_field_object('field_6006956744d88', $postid); // ПК или ноутбук
	$field[] = get_field_object('field_6006957744d89', $postid); // Москитная сетка
	$field[] = get_field_object('field_6006958f44d8a', $postid); // Камин
	$field[] = get_field_object('field_6006959c44d8b', $postid); // Электрический обогреватель

	return $field;
}

// Детям в номере
function childrenRoom( $post_id = 0 ) {
	foreach (acf_get_fields(385) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}

// Правила проживания в номере
function rulesRoom( $post_id = 0 ) {
	foreach (acf_get_fields(348) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}

// Общие удобства в квартирах
function generalApartment( $post_id = 0 ) {
	foreach (acf_get_fields(310) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}

// Санузлы в квартирах
function sanuzelApartment( $post_id = 0 ) {
	foreach (acf_get_fields(311) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}
// Кухня в квартирах
function kitchenApartment( $post_id = 0 ) {
	foreach (acf_get_fields(371) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}
// Комнаты в квартирах
function roomsApartment( $post_id = 0 ) {
	foreach (acf_get_fields(332) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}
// На территории в квартирах
function territoryApartment( $post_id = 0 ) {
	foreach (acf_get_fields(390) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}
// Доступная среда
function accessibleApartment( $post_id = 0 ) {
	foreach (acf_get_fields(579) as $value) {
		$field[] = get_field_object( $value['key'], $post_id ); 
	}

	return $field;
}


if( function_exists('acf_add_options_page') ) {
	if( current_user_can( 'manage_options' ) ) {
		$option_page = acf_add_options_page(array(
			'page_title' 	=> 'Дополнительно',
			'menu_title'	=> 'Дополнительно',
			'icon_url' 		=> 'dashicons-nametag'
		));
	}
}

add_filter( 'authenticate', 'chk_active_user', 100, 2 );
function chk_active_user ($user,$username) {
    $user_data = $user->data;
    $user_id = $user_data->ID;
    $user_sts = get_user_meta($user_id,"user_active_status",true);

    if ($user_sts==="no") {
        return new WP_Error( 'disabled_account','Ваша учетная запись отключена');
    } else {
       return $user;
    }

    return $user;
}


function wptp_create_post_type() {
    $labels = array(
    	'name' => __( 'Объекты' ),
    	'singular_name' => __( 'Объекты' ),
    	'add_new' => __( 'Новый объект' ),
    	'add_new_item' => __( 'Добавить новый объект' ),
    	'edit_item' => __( 'Редактировать объект' ),
    	'new_item' => __( 'Новый объект' ),
    	'view_item' => __( 'Посмотреть объект' ),
    	'search_items' => __( 'Поиск объектов' ),
    	'not_found' =>  __( 'Объект не найден' ),
    	'not_found_in_trash' => __( 'В корзине объект не найден' ),
    );
    $args = array(
    	'labels' => $labels,
    	'has_archive' => true,
    	'public' => true,
    	'hierarchical' => false,
    	'menu_position' => 5,
    	'menu_icon' => 'dashicons-building',
    	'supports' => array(
    		'title',
    		'editor',
    		'excerpt',
    		'comments',
    		'custom-fields',
    		'thumbnail',
    		'author'
    	),
    );
 
    register_post_type( 'hotels', $args );
}
add_action( 'init', 'wptp_create_post_type' );

add_action('init', 'orders');
function orders() {
	$labels = array(
		'name' => 'Бронирования',
		'singular_name' => 'Бронирования',
		'add_new' => 'Добавить новый',
		'add_new_item' => 'Добавить новый заказ',
		'edit_item' => 'Редактировать заказ',
		'new_item' => 'Новый заказ',
		'view_item' => 'Посмотреть заказ',
		'search_items' => 'Найти заказ',
		'not_found' =>  'Заказов не найдено',
		'not_found_in_trash' => 'В корзине заказов не найдено',
		'parent_item_colon' => '',
		'menu_name' => 'Бронирования'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-calendar-alt',
		'supports' => array('title','editor','thumbnail', 'comments', 'author'),
		'taxonomies' => array('orders')
	);
	register_post_type('orders', $args);
}
 
function wptp_register_taxonomy() {
    register_taxonomy( 'hotel', 'hotels',
      array(
        'labels' => array(
          'name'              => 'Категории',
          'singular_name'     => 'Категория',
          'search_items'      => 'Поиск Категории',
          'all_items'         => 'Все категории проектов',
          'edit_item'         => 'Редактировать категорию',
          'update_item'       => 'Обновить категорию',
          'add_new_item'      => 'Добавить новую категорию проектов',
          'new_item_name'     => 'Имя новой Категории',
          'menu_name'         => 'Категории',
        ),
        'rewrite' => array( 
			'slug' => 'hotel', 
			'with_front' => false
		),
        'hierarchical' => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'show_admin_column' => true
        )
   	);

	register_taxonomy('type', 'hotels', 
		array(
			'labels' => array(
			    'name'              => __('Тип размещения','wpestate'),
			    'add_new_item'      => __('Добавить новый Тип','wpestate'),
			    'new_item_name'     => __('New Requirement Tag','wpestate')
			),
			'hierarchical' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'type' ),
			'show_admin_column' => true
		)
	);
}
add_action( 'init', 'wptp_register_taxonomy', 0);


function num_word($value, $words, $show = true) {
	$num = $value % 100;
	if ($num > 19) { 
		$num = $num % 10; 
	}
	
	$out = ($show) ?  $value . ' ' : '';
	switch ($num) {
		case 1:  $out .= $words[0]; break;
		case 2: 
		case 3: 
		case 4:  $out .= $words[1]; break;
		default: $out .= $words[2]; break;
	}
	
	return $out;
}

function hotel_address( $id = 0 ) {
	$array = array();
	$cur_terms = get_the_terms( $id, 'hotel');
	
	foreach( $cur_terms as $cur_term ){
		$array[] = $cur_term->name;
	}
	$comma_separated = implode(", ", $array);
	
	return $comma_separated;
}

function object_location($post_id){
	$array = array();
	$terms = get_the_terms( $post_id, 'hotel' );
	
	foreach( $terms as $term ){
		$array[] = $term->name;
	}
	$location = implode(", ", $array);

	return $location;
}


function address($post_id) {
	$address = object_location($post_id). ', ' .get_field('street', $post_id). ', ' .get_field('house', $post_id);

	return $address;
}

function price_total($price, $day) {
	if (!empty($day)) {
		$total = $price * $day;
	} else {
		$total = $price;
	}

	return $total;
}

// Количество дней между двумя датами
function days($d1, $d2) {
	$datetime1 = date_create(date("Y-m-d", strtotime($d1)));
	$datetime2 = date_create(date("Y-m-d", strtotime($d2)));
	$interval = date_diff($datetime1, $datetime2);
 
	return $interval->days;
}

// Склонение слов
function guests_count($number) {
	return num_word($number, array("взрослый гость","взрослых гостя","взрослых гостей") );
}

// Тип объекта
function rooms_type( $number = 0 ){

	$terms = get_the_terms( $post->ID, 'type' );
	if ( $terms ) {
		$term = array_shift( $terms );
	}

	if( $term->term_id == 83 ) {
		if ( $number == 1 ) {
			$title = 'Однокомнатная квартира';
		} elseif ( $number == 2 ) {
			$title = 'Двухкомнатная квартира';
		} elseif ( $number == 3 ) {
			$title = 'Трёхкомнатная квартира';
		} elseif ( $number == 4 ) {
			$title = 'Четырехкомнатная квартира';
		} elseif ( $number == 5 ) {
			$title = 'Пятикомнатная квартира';
		}
	} elseif ( $term->term_id == 90 ) {
		if ( $number == 1 ) {
			$title = 'Однокомнатный дом';
		} elseif ( $number == 2 ) {
			$title = 'Двухкомнатный дом';
		} elseif ( $number == 3 ) {
			$title = 'Трёхкомнатный дом';
		} elseif ( $number == 4 ) {
			$title = 'Четырехкомный дом';
		} elseif ( $number == 5 ) {
			$title = 'Пятикомнатный дом';
		}
	} elseif ( $term->term_id == 89 ) {
		if ( $number == 1 ) {
			$title = 'Однокомнатный частный сектор';
		} elseif ( $number == 2 ) {
			$title = 'Двухкомнатный частный сектор';
		} elseif ( $number == 3 ) {
			$title = 'Трёхкомнатный частный сектор';
		} elseif ( $number == 4 ) {
			$title = 'Четырехкомный частный сектор';
		} elseif ( $number == 5 ) {
			$title = 'Пятикомнатный частный сектор';
		}
	} elseif ( $term->term_id == 91 ) {
		if ( $number == 1 ) {
			$title = 'Однокомнатная комната';
		} elseif ( $number == 2 ) {
			$title = 'Двухкомнатная комната';
		} elseif ( $number == 3 ) {
			$title = 'Трёхкомнатная комната';
		} elseif ( $number == 4 ) {
			$title = 'Четырехкомнатная комната';
		} elseif ( $number == 5 ) {
			$title = 'Пятикомнатная комната';
		}
	} 

	return $title;
}

function term_children($post_id = 0) {
	$terms = get_the_terms( $post_id, 'hotel' );

	$parent_id = 0;
	foreach( $terms as $term ) {
		if ($term->parent != 0) {
			$parent_id = $term->term_id;
		}
	}

	return $parent_id;
}

// Расчёт рейтинга
function rating($rating, $text) {
	// $rating = round($rating/100);

	if ($text == 'text') {
		if ($rating == 5) {
			$title = 'Отлично';
		} elseif ($rating == 4) {
			$title = 'Очень хорошо'; 
		} elseif ($rating == 3) {
			$title = 'Хорошо';
		} elseif ($rating == 2) {
			$title = 'Нормально';
		} elseif ($rating == 1) {
			$title = 'Ужасно';
		} else {
			$title = 'Нет оценки';
		}
	} else {
		$title = $rating;
	}

	return $title;
}

function get_totalpositive($id) {
 	$a = 0;
 	$b = 0;
	foreach ( get_comments(['user_id' => $id]) as $comment ) {
		if ( get_field('rating', $comment) > 3 ) {
			$a += get_field('rating', $comment);
		} else {
			$b += get_field('rating', $comment);
		}
	}

	return round((100/($a+$b)*$a)) . '%';
 
}
 

// function totalPositive( $author_id ) {
//     global $wpdb;

// 	$sql = "
// 		SELECT meta_value  
// 		FROM $wpdb->posts AS a LEFT JOIN $wpdb->comments AS b 
// 		ON b.comment_post_ID = a.ID LEFT JOIN $wpdb->commentmeta AS c 
// 		ON c.comment_id = b.comment_ID 
// 		WHERE a.post_author = $author_id
// 		AND a.post_status = 'publish' 
// 		AND b.comment_approved = 1
// 		AND b.comment_type = 'comment'
// 		OR b.comment_type = 'comment'
// 		AND c.meta_key = 'rating'
// 	";

//     $results = $wpdb->get_results($sql);
//     var_dump( $results);

//     return 'Отзывов всего: '. count($results) . ' - положительных:';
// }

function totalPositive( $author_id ) {
    global $wpdb;
    $args = array(
        'author_id' => $author_id,
        'approved' => 1
    );

    $sql = $wpdb->prepare("SELECT COUNT(comments.comment_ID) 
            FROM {$wpdb->comments} AS comments 
            LEFT JOIN {$wpdb->posts} AS posts
            ON comments.comment_post_ID = posts.ID
            WHERE posts.post_author = %d
            AND comment_approved = %d
            AND comment_type IN ('comment', '')",
        $args
    );

    return 'Отзывов всего: '. $wpdb->get_var( $sql ). ' - положительных:';
}

// Количество ночей
function nights($days, $guests) {
	$days = num_word($days, array("ночь","ночи", "ночей") );
	$guests = num_word($guests, array("взрослый","взрослых") );

	return $days.', '.$guests;
}

// Получение заголовка из произвольных полей
function label_name($name) {
	$title = get_field_object($name)['label'];

	return $title;
}

// Список регионов
function region($category_id = 0) {
	$args = array(
		'hide_empty' => 0,
		'parent'     => 0, 
		'order'      => 'ASC'
	);
	$categories  = get_terms('hotel', $args);		
	if($categories ){ ?>
		<select name="region" class="form-control form-select">
			<option value="" selected="">Выберите регион</option>
		<? foreach ($categories as $term){ ?>
			<option value="<?=$term->term_id;?>" <?if($term->term_id == $category_id) {echo 'selected';}?> ><?=$term->name;?></option>
		<? } ?>
		</select>
	<? }
}

// Список городов
function city($category_id = 0) {
	if (!empty($_POST['term_id'])) {
		$parent_id = $_POST['term_id'];
	} else {
		$parent_id = '';
	}
	$taxonomies = get_terms(array(
	    'taxonomy'   => 'hotel',
	    'parent'     => $parent_id,
	    'hide_empty' => false
	) );
	  
	if (!empty($taxonomies)) :
	    $output = '<select name="city" required class="form-control form-select">';
		$output.= '<option value=""  >Выберите город или курорт</option>';
	    if (!empty($_POST['term_id'])) {
	    	$output.= '<option value="'.get_term($parent_id)->term_id.'">'.get_term($parent_id)->name.'</option>';
	    }

	    foreach($taxonomies as $category){
	        if($category->parent == 0){
	            $output.= '<optgroup label="'.esc_attr($category->name).'">';

	           	if ($category->term_id == $category_id) {
	           		$selected = 'selected';
	           	} else {
	           		$selected = '';
	           	}
 
	            $output.= '<option value="'.esc_attr($category->term_id).'" '.$selected.'>'.esc_html( $category->name ) .'</option>';

	            foreach($taxonomies as $subcategory){
	                if($subcategory->parent == $category->term_id){
	                	if ($subcategory->term_id == $category_id) {
	                		$selected = 'selected';
	                	} else {
	                		$selected = '';
	                	}
	                	$output.= '<option value="'.esc_attr($subcategory->term_id).'" '.$selected.'>'.esc_html( $subcategory->name ) .'</option>';
	                }
	            }
	            $output.='</optgroup>';
	        } else {
	        	if (!empty($_POST['term_id'])) {
	        		$output.= '<option value="'.esc_attr($category->term_id).'">'.esc_html( $category->name ) .'</option>';
	        	}
	        }
	    }
	    $output.='</select>';
	    echo $output;
	endif;
	// exit;
}
add_action('wp_ajax_nopriv_city','city');
add_action('wp_ajax_city','city');


function month($month_text) {
	$month = array(
		"1" => "Январь", 
		"2" => "Февраль", 
		"3" => "Март", 
		"4" => "Апрель", 
		"5" => "Май", 
		"6" => "Июнь", 
		"7" => "Июль", 
		"8" => "Август", 
		"9" => "Сентябрь", 
		"10" => "Октябрь", 
		"11" => "Ноябрь", 
		"12" => "Декабрь",
	); ?>
	<select name="month" class="form-control form-select">
		<option>месяц</option>
		<?foreach ($month as $value) {?>
		<option value="<?=$value;?>" <?if ($value == $month_text) echo 'selected';?>><?=$value;?></option>
		<?}?>
	</select>
<? }

function failed_login () {
    return 'Неверное имя пользователя или пароль'; //Сообщение при неверном вводе логина или пароля
}
add_filter ( 'login_errors', 'failed_login' );


function auth() {
	$creds = array();
	$creds['user_login'] = $_POST['email'];
	$creds['user_password'] = $_POST['password'];
	$creds['remember'] = $_POST['remember'];
	
	$user = wp_signon($creds, false);

	if ( is_wp_error($user) ) {
		$result['status'] = 'error';
		$result['message'] = $user->get_error_message();
	} else {
		$result['status'] = 'success';
		$result['message'] = 'Вы успешно авторизовались!';
	}

	echo json_encode($result);

	exit;
}
add_action('wp_ajax_nopriv_auth','auth');
add_action('wp_ajax_auth','auth');

function auth_phone() {
	$creds = array();
	$creds['user_login'] = preg_replace("/[^0-9]/", '', $_POST['phone']);
	$creds['user_password'] = $_POST['password'];
	$creds['remember'] = $_POST['remember'];
	
	$user = wp_signon($creds, false);

	if ( is_wp_error($user) ) {
		$result['status'] = 'error';
		$result['message'] = $user->get_error_message();
	} else {
		$result['status'] = 'success';
		$result['message'] = 'Вы успешно авторизовались!';
	}

	echo json_encode($result);

	exit;
}
add_action('wp_ajax_nopriv_auth_phone','auth_phone');
add_action('wp_ajax_auth_phone','auth_phone');

function user_photo($user) {
	if (get_field('photo', 'user_' .$user->ID)) {
		$data = '<img src = "'.get_field('photo', 'user_' .$user->ID).'">';
	} else {
		$data = preg_replace('~(\pL)\S+|\s+~u', '$1', $user->display_name);
	}
	
	return $data;
}

show_admin_bar(false);
 
$new_role = add_role(
	'tenant', // название роли
	__( 'Арендатор' ), // отображаемое название роли (модератор комментариев)
	array( // массив возможностей, true - разрешено, false - запрещено
		'read'         => true,  // ну это понятно
		'edit_posts'   => true,  // true разрешает редактировать посты
		'upload_files' => true,  // может загружать файлы
		'publish_posts' => false,
		'edit_published_posts' => true,
	)
);

function upload_photo(){
	if ( !function_exists( 'wp_handle_upload' ) ) {
	    require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	
	$movefile = wp_handle_upload($_FILES['my_file_upload'], array('test_form' => FALSE));

	if ( $movefile && empty($movefile['error']) ) {
		$filename = $movefile['url'];

		$filetype = wp_check_filetype( basename( $filename ), null );

		$wp_upload_dir = wp_upload_dir();
		
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment( $attachment, $filename, 0 );

		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data);

		update_user_meta(get_current_user_id(), 'photo', $attach_id);

		$result['status'] = 'success';
		$result['message'] = 'Файл был успешно загружен.';
	} else {
		$result['status'] = 'error';
		$result['message'] = $movefile['error'];
	}

	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_upload_photo','upload_photo');
add_action('wp_ajax_upload_photo','upload_photo');

function delete_photo(){
	update_user_meta(get_current_user_id(), 'photo', '');

	$result['status'] = 'success';
	$result['message'] = 'Файл был успешно удален.';

	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_delete_photo','delete_photo');
add_action('wp_ajax_delete_photo','delete_photo');


// Исключаем отели из вывода
if ( !is_admin() ) {
    function posts_exclude($query) {
        if ( $query->query_vars['post_type'] == 'hotels' ) {

			$meta_query = array(
				array(
				   'key'   => '_wp_page_template',
				   'value' => 'single-hotel.php',
				   'compare'=>'!=',
				),
			);

			$query->set('meta_query', $meta_query);

        }
		
    	return $query;
	}

	add_filter( 'pre_get_posts','posts_exclude', 10 );
}

function get_terms_type($term_id) {
	$post_type  = 'hotels';
	$taxonomy_a = 'hotel';
	$taxonomy_b = 'type';
	$term_b_id  = $term_id;

	global $wpdb;
	$query = $wpdb->prepare(
		"SELECT DISTINCT
			terms.* 
		FROM
			`wp_terms` terms
		INNER JOIN
			`wp_term_taxonomy` tt1 ON
				tt1.term_id = terms.term_id
		INNER JOIN
			`wp_term_relationships` tr1 ON
				tr1.term_taxonomy_id = tt1.term_taxonomy_id
		INNER JOIN
			`wp_posts` p ON
				p.ID = tr1.object_id
		INNER JOIN 
			`wp_term_relationships` tr2 ON
				tr2.object_ID = p.ID
		INNER JOIN 
			`wp_term_taxonomy` tt2 ON
				tt2.term_taxonomy_id = tr2.term_taxonomy_id
		WHERE
			p.post_type = %s AND
			p.post_status = 'publish' AND
			tt1.taxonomy = %s AND
			tt2.taxonomy = %s AND
			tt2.term_id = %d",
		[
			$post_type,
			$taxonomy_a,
			$taxonomy_b,
			$term_b_id,
		]
	);
 
	$results = $wpdb->get_results( $query );
	
	if ( $results ) {
		$tax = array_map( 'get_terms', $results );
	}

	$taxonomy = array();

	foreach($tax as $terms ) {
		foreach($terms as $term) {
			$taxonomy[] = $term;
		}
	}
 
	return $taxonomy;
}

// filter
function my_posts_where( $where ) {

	$where = str_replace("meta_key = 'free_dates_$", "meta_key LIKE 'free_dates_%", $where);

	return $where;
}
add_filter('posts_where', 'my_posts_where');


// filter
function filters() {
	if (!empty($_REQUEST['order'])) {
		$order = $_REQUEST['order'];
	} else {
		$order = 'ASC';
	}
	
	if (!empty($_REQUEST['sort'])) {
		$sort = $_REQUEST['sort'];
	} else {
		$sort = 'price';
	}

	global $wpdb, $post;
	$sql = "
		SELECT wp_posts.*
		FROM wp_posts 
		INNER JOIN wp_postmeta ON (wp_posts.ID = wp_postmeta.post_id)
		WHERE 1=1
			AND wp_posts.post_type = 'hotels'
			AND (wp_posts.post_status = 'publish')
	";
	// Исключаем отели из вывода
	$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = '_wp_page_template' AND meta_value != 'single-hotel.php' )";
	// Количество гостей
	if( !empty($_POST['adults']) || !empty($_POST['children']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'guests_count' AND meta_value >= ".($_POST['adults'] + $_POST['children'])." )";
	}
	// Установить свой бюджет до
	if( !empty($_POST['budget']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'price' AND meta_value <= ".$_POST['budget']." )";
	}
	// Фильтр по цене [от и до]
	if( !empty($_POST['price']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'price' AND meta_value BETWEEN ".$_POST['price']." )";
	}
	// Расстояние до моря до
	if( !empty($_POST['distance']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'distance' AND meta_value <= ".$_POST['distance']." )";
	}
	// Количество комнат
	if( !empty($_POST['rooms_count']) ) {
		$operator = $_POST['rooms_count'] == 1 ? '=' : '>=';
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'rooms_count' AND meta_value ".$operator." ".$_POST['rooms_count']." )";
	}
	// Количество кроватей [Одноместных]
	if( !empty($_POST['single_beds']) ) {
		$operator = $_POST['single_beds'] == 1 ? '=' : '>=';
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'single_beds' AND meta_value ".$operator." ".$_POST['single_beds']." )";
	}
	// Количество кроватей [Двухместных]
	if( !empty($_POST['double_beds']) ) {
		$operator = $_POST['double_beds'] == 1 ? '=' : '>=';
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'double_beds' AND meta_value ".$operator." ".$_POST['double_beds']." )";
	}
	// Количество спальных мест
	if( !empty($_POST['bed_total']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'bed_total' AND meta_value >= ".$_POST['bed_total']." )";
	}
	// Количество санузлов
	if( !empty($_POST['bathroom_total']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'bathroom_total' AND meta_value >= ".$_POST['bathroom_total']." )";
	}
	// Минимальный срок бронирования от
	if( !empty($_POST['check_in']) && !empty($_POST['check_out']) ) {
		$date_from = days($_POST['check_in'], $_POST['check_out']);
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'minimum_booking' AND meta_value <= ".$date_from." )";
	}
	// Удобства в помещении
	if( !empty($_POST['tools_hotels']) ) {
		foreach ( $_REQUEST['tools_hotels'] as $val ) {
			if( $val == 'на море' || $val == 'на горы' || $val == 'на бассейн' || $val == 'на парк' || $val == 'на город' ) {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'species_characteristics' AND meta_value = '".$val."') ";
			} else {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = '".$val."' AND meta_value NOT IN('нет','') )";
			}
		}
	}
	// Удобства в здании или на территории
	if( !empty($_REQUEST['facilities']) ) {
		foreach ( $_REQUEST['facilities'] as $val ) {
			if( $val == 'открытая' || $val == 'охраняемая' || $val == 'подземная' ) {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'parking' AND meta_value = '".$val."') ";
			} else {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = '".$val."' AND meta_value NOT IN('нет','') )";
			}
		}
	}
	// Питание
	if( !empty($_REQUEST['food']) ) {
		foreach ($_REQUEST['food'] as $val) {
			if( $val == 'kitchen_main' || $val == 'kitchen_main2' ) {
				$value = $val == 'kitchen_main2' ? 'собственная' : 'общая';
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'kitchen' AND meta_value = '".$value."') ";
			} else {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'food_service_".$val."' AND meta_value IN('да') )";
			}
		}
	}
	// Услуги
	if( !empty($_POST['services_hotels']) ) {
		foreach ($_POST['services_hotels'] as $val) {
			$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = '".$val."' AND meta_value NOT IN('нет','') )";
		}
	}
	// Условия
	if( !empty($_POST['conditions']) ) {
		foreach ($_POST['conditions'] as $val) {
			if ( $val == 1 ) {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'fast_booking' AND meta_value = 'on' )";
			} elseif ( $val == 2 ) {
				$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'fast_responding' AND meta_value = 'on' )";
			}
		}
	}
	// Оценка по отзывам
	if( !empty($_POST['reviews']) && $_POST['reviews'][0] != 'all' ) {
		foreach ($_POST['reviews'] as $val) {
			$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'reviews' AND meta_value = '".$val."' )";
		}
	}
	// Количество звёзд
	if( !empty($_POST['stars']) && $_POST['stars'][0] != 'all' ) {
		foreach ($_POST['stars'] as $val) {
			$sql .= "AND wp_posts.ID IN (SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'rating' AND meta_value = '".$val."' )";
		}
	}
	// Регион или город
	if( !empty($_POST['term_id']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT object_id FROM wp_term_relationships WHERE term_taxonomy_id = ".$_POST['term_id'].")";
	}
	// Типы жилья
	if( !empty($_POST['type_hotels']) ) {
		$sql .= "AND wp_posts.ID IN (SELECT DISTINCT object_id FROM wp_term_relationships WHERE term_taxonomy_id IN(".implode(',',$_POST['type_hotels'])."))";
	}
	// Сортировка объектов
	$sql .= "GROUP BY wp_posts.ID ORDER BY wp_postmeta.meta_key ".$order." LIMIT 0, 10";

	//echo $sql;

	$result = $wpdb->get_results($sql);
	
	
	function dates_in_range() {
		$startDate = $_POST['check_in'];
		$endDate = $_POST['check_out'];

		//echo $startDate."<br>".$endDate;



		if( $startDate != 0 && $endDate != 0 ) {
			foreach( get_field('free_dates') as $date ) {

				//if ( ($date['date_from'] >= $startDate) && ($date['date_end'] <= $endDate) ) {
                $result1=(strtotime($date['date_from'])<=  strtotime($startDate)); //$result == true
                $result2=(strtotime($startDate) <= strtotime($date['date_to'])); //$result == true

                if ( $result1 == true and $result2 == true ) {

					return false;
				}
                $result1=(strtotime($date['date_from'])<=  strtotime($endDate)); //$result == true
                $result2=(strtotime($endDate) <= strtotime($date['date_to'])); //$result == true

                if ( $result1 == true and $result2 == true ) {

                    return false;
                }

			}

			// $var1 = days($startDate, $endDate);
			// $var2 = get_field('minimum_booking')['value'];			
		}

		// $sql2 = "SELECT DISTINCT post_id FROM wp_postmeta WHERE meta_key = 'apartment' AND meta_value = ".get_the_ID()." ";
		// var_dump($sql2);

		return true;
	}
?>
	<? if ( $result ) { ?>

<div id="search-map"></div>
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
	foreach( $result as $post ) {
	setup_postdata($post);
	$address = hotel_address($post->ID). ', ' .get_field('street'). ', ' .get_field('house');
	if (dates_in_range() === true) { ?>
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
			// empty();
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

			$('html, body').animate({ scrollTop: 0 }, 'slow');
		});

		},
		function(err) {
			alert('Ошибка');
		}
		);
	
	<?
	}
	$i++; }
	wp_reset_postdata();
	?>
	}
	</script>

	<div class="hotels-list">
		<?foreach( $result as $post ) {
			setup_postdata($post);
			if (dates_in_range() === true) {
				include(TEMPLATEPATH . '/front/object-card.php');
			}
		}
		wp_reset_postdata();
		?>
	</div>
	<? } else {
		echo 'Постов для вывода не найдено.';
	} ?>
	

	<?
	exit;
}
add_action('wp_ajax_nopriv_filters','filters');
add_action('wp_ajax_filters','filters');

function search_suggest(){
	$args = array(
	    'taxonomy'      => array( 'hotel' ),
	    'orderby'       => 'id', 
	    'order'         => 'ASC',
	    'hide_empty'    => false,
	    'fields'        => 'all',
	    'name__like'    => $_POST['suggest']
	); 
	$terms = get_terms( $args );
	if ($terms) {
		foreach ($terms as $term) { ?>
			<li data-link='<?=get_category_link($term->term_id);?>'><div class="suggest-point"></div><?=$term->name;?></li>
		<?php } ?>
	<? } else { ?>
		<li class="error">Ничего не найдено!</li>
	<? }

	exit;
}
add_action('wp_ajax_nopriv_search_suggest','search_suggest');
add_action('wp_ajax_search_suggest','search_suggest');

function data_param() {
	$_SESSION['check_in'] = $_POST['check_in'];
	$_SESSION['check_out'] = $_POST['check_out'];

	$_SESSION['adults'] = $_POST['adults'];
	$_SESSION['children'] = $_POST['children'];
	$_SESSION['babies'] = $_POST['babies'];

	$_SESSION['counts_guests'] = $_POST['counts_guests'];

	exit;
}
add_action('wp_ajax_nopriv_data_param','data_param');
add_action('wp_ajax_data_param','data_param');

//добавление использования сессий в нашем шаблоне
add_action( 'init', 'do_session_start' ); 
 
function do_session_start() { 
    if ( !session_id() ) session_start(); 
}


// Избранное для авторизованных пользователей
function favorite(){

	if ( is_user_logged_in() ) { 

		$unserialize = get_field('favorite', 'user_' .get_current_user_id() );
		$favorite['favorite'] = unserialize($unserialize);

		if (!isset($favorite['favorite'])) {
			$favorite['favorite'] = array();
		}

		if (isset($_REQUEST['post_id'])) {
			$post_id = $_REQUEST['post_id'];
		} else {
			$post_id = 0;
		}

		if (!in_array($post_id, $favorite['favorite'])) {
			if (count($favorite['favorite']) >= 4) {
				array_shift($favorite['favorite']);
			}

			$favorite['favorite'][] = $post_id;

			$serialize = serialize($favorite['favorite']);

			update_user_meta(get_current_user_id(), 'favorite', $serialize);

			$number = get_field('favorite_count', $post_id);
			$number++;

			update_field('favorite_count', $number, $post_id);

			$result['status'] = 'success';
			$result['message'] = 'Успешно добавлено в Избранное. Вы можете просматривать список избранных и управлять ими в личном кабинете.';
		} else {
			if (isset($post_id)) {
				$unserialize = get_field('favorite', 'user_' .get_current_user_id() );
				$favorite['favorite'] = unserialize($unserialize);

				$key = array_search($post_id, $favorite['favorite']);
				
				if ($key !== false) {
					unset($favorite['favorite'][$key]);

					$serialize = serialize($favorite['favorite']);
					update_user_meta(get_current_user_id(), 'favorite', $serialize);

					$result['status'] = 'remove';
					$result['message'] = 'Вы успешно удалили объект из избранных!';
				}
			}
		}

	} else {
		$text = '<div class="popup-title">Пожалуйста, для добавления объекта в избранное, зарегистрируйтесь</div>';
		$text .= '<div class="btn btn-register" onclick="$.fancybox.close();">Зарегистрироваться</div>';
		$text .= '<div class="login-text">У Вас уже есть учётная запись? <span class="">Войти</span></div>';

		$result['status'] = 'error';
		$result['message'] = $text;
	}
 
	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_favorite','favorite');
add_action('wp_ajax_favorite','favorite');

function button_favorite() {
	$unserialize = get_field('favorite', 'user_' .get_current_user_id() );
	$favorite['favorite'] = unserialize($unserialize);
	if (!empty($favorite['favorite']) && $favorite['favorite'][array_search(get_the_ID(), $favorite['favorite'])] == get_the_ID()) { ?>
		<div class="favorite favorite-add" data-id="<?=get_the_ID();?>"></div>
	<? } else { ?>
		<div class="favorite" data-id="<?=get_the_ID();?>"></div>
	<? } ?>
<?}

function edit_field(){
	$update_user = '';
	if ($_REQUEST['field'] == 'phone') {
		$update_user = update_user_meta(get_current_user_id(), 'phone', $_REQUEST['val']);
	} elseif ($_REQUEST['field'] == 'user_email') {
		$args = array(
		    'ID'         => get_current_user_id(),
		    'user_email' => esc_attr( $_REQUEST['val'] )
		);
		$update_user = wp_update_user( $args );
	}
 
	if( !$update_user){
		$result['status'] = 'error';
		$result['message'] = "Поле не обновлено";
	} else {
		$result['status'] = 'success';
		$result['message'] = "Данные успешно обновлены!";
	}

	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_edit_field','edit_field');
add_action('wp_ajax_edit_field','edit_field');

function edit_account(){
	$userdata = array(
	    'ID'         => get_current_user_id(),
	    'first_name' => esc_attr( $_REQUEST['firstname'] ),
	    'last_name' => esc_attr( $_REQUEST['lastname'] ),
	    'user_email' => esc_attr( $_REQUEST['user_email'] ),
	);
	wp_update_user( $userdata );
	update_user_meta(get_current_user_id(), 'company', $_REQUEST['company']);
	update_user_meta(get_current_user_id(), 'city', $_REQUEST['city']);
	update_user_meta(get_current_user_id(), 'country', $_REQUEST['country']);
	update_user_meta(get_current_user_id(), 'gender', $_REQUEST['gender']);
	update_user_meta(get_current_user_id(), 'day', $_REQUEST['day']);
	update_user_meta(get_current_user_id(), 'month', $_REQUEST['month']);
	update_user_meta(get_current_user_id(), 'year', $_REQUEST['year']);
	update_user_meta(get_current_user_id(), 'phone', $_REQUEST['phone']);
	update_user_meta(get_current_user_id(), 'phone2', $_REQUEST['phone2']);
	update_user_meta(get_current_user_id(), 'user_email2', $_REQUEST['user_email2']);

	if(!empty($_REQUEST['password'])){
		wp_set_password($_REQUEST['password'], get_current_user_id());
	}

	$result['status'] = 'success';
	$result['message'] = "Данные успешно обновлены!";

	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_edit_account','edit_account');
add_action('wp_ajax_edit_account','edit_account');

function getWeekday($date){
	$days = array(1 => "пн","вт","ср","чт","пт","сб","вс");
	return $days[date('N', strtotime($date))];
}


// function booking(){
// 	$number = (int)get_field('booking_number', 'options');

// 	$post_id = wp_insert_post(  wp_slash( array(
// 		'post_status'   => 'request',
// 		'post_type'     => 'orders',
//     	'post_title'    => 'Бронирование №'. get_field('booking_number', 'options'),
//     	'post_content'  => '',
// 		'post_author'   => get_post($_POST['post_id'])->post_author,
// 		'ping_status'   => get_option('default_ping_status'),
// 		'meta_input'    => [ 'meta_key'=>'meta_value' ],
// 	) ) );

// 	if( is_wp_error($post_id) ){
// 		$result['error'] = 'success';
// 		$result['message'] = $post_id->get_error_message();
// 	} else {
// 		$result['status'] = 'success';
// 		$result['message'] = 'Бронирование № '.get_field('booking_number', 'options');
		
// 		$number++;
// 		update_field('booking_number', $number, 'options');
		
// 		update_field('booking_number', get_field('booking_number', 'options'), $post_id);
// 		update_field('check_in', $_POST['check_in'], $post_id);
// 		update_field('check_out', $_POST['check_out'], $post_id);
// 		update_field('guests', $_POST['guests'], $post_id);
// 		update_field('comment', $_POST['comment'], $post_id);
// 		update_field('apartment', $_POST['post_id'], $post_id);
// 		update_field('time_arrival', $_POST['time_arrival'], $post_id);

// 		update_field('user_name', $_POST['name'], $post_id);
// 		update_field('user_lastname', $_POST['lastname'], $post_id);
// 		update_field('user_email', $_POST['email'], $post_id);
// 		update_field('user_phone', $_POST['phone'], $post_id);
// 		update_field('main_guest', $_POST['main_guest'], $post_id);
// 	}

// 	echo json_encode($result);
// 	exit;
// }
// add_action('wp_ajax_nopriv_booking','booking');
// add_action('wp_ajax_booking','booking');

function calc_percent($value) {
	return $value * (10 / 100); 
}

function payment_calc(){ 
	calc_amount($_POST['days'], $_POST['price']);

	exit; 
}
add_action('wp_ajax_nopriv_payment_calc','payment_calc');
add_action('wp_ajax_payment_calc','payment_calc');


function calc_amount($days, $price){ ?>
	<ul class="booking-details">
		<li><strong>Итого за <?=$days;?> суток:</strong> <strong><?=price_total($price, $days);?> RUB</strong></li>
		<li class="payment-calc"><span><?=$price;?> RUB * <?=$days;?> суток</span> <span><?=price_total($price, $days);?> RUB</span></li>
	</ul>
	<div class="btn-calc">Скрыть расчёт</div>
	<div class="prepayment">Внесите предоплату <span><?=calc_percent(price_total($price, $days));?> RUB</span> сейчас, остальное при заезде</div>
<? }


function trash_object(){ 
	wp_trash_post( $_POST['post_id'], false );
}
add_action('wp_ajax_nopriv_trash_object','trash_object');
add_action('wp_ajax_trash_object','trash_object');

function untrash_object(){ 
	wp_untrash_post( $_POST['post_id']);
}
add_action('wp_ajax_nopriv_untrash_object','untrash_object');
add_action('wp_ajax_untrash_object','untrash_object');


function seasonPrices() {

	$row = array(
		'date_begin' => $_POST['date_from'],
		'date_end'	 => $_POST['date_end'],
		'price'		 => $_POST['price'],
	);
	
	$i = add_row('field_600fe372730ca', $row, $_POST['post_id']);

	pricePeriod($_POST['post_id']);
 
	exit;
}
add_action('wp_ajax_nopriv_seasonPrices','seasonPrices');
add_action('wp_ajax_seasonPrices','seasonPrices');



function pricePeriod($postid) { ?>

	<div class="season-prices"></div>

	<? if (get_field('season_prices', $postid)) {

		$dates['season'] = array();

		foreach (get_field('season_prices', $postid) as $date) { 

			$interval_date = date_diff(date_create($date['date_begin']), date_create($date['date_end']))->days+1;

			for($i = 1; $i <= $interval_date ; $i++){

				$dates['season'][] = array(
					'date'  => date('Y-n-j',(strtotime($date['date_begin'])+86400*($i-1))),
					'price' => $date['price']
				);

			}

		}
			
		$date_arr = array();

		foreach ($dates['season'] as $value) {
			$date_arr[$value['date']] = $value['price'];
		}

		$date_prices = $date_arr;

	} else {
		$date_prices = '';
	} ?>

	<script type="text/javascript">
		var date = new Date();
			date.setDate(date.getDate());
		var	m, d, y, checkDate, specificPrice = '';    
		var	specificPrices = <?echo json_encode($date_prices);?>;
		
		$('.season-prices').datepicker({
			monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
			dayNamesMin: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
			range: 'period', // режим - выбор периода
			dateFormat: "dd.mm.yy",
			minDate: date,
			onSelect: function(dateText, inst, extensionRange) {
				$('input[name=date_from]').val(extensionRange.startDateText);
				$('input[name=date_end]').val(extensionRange.endDateText);
			},
		    beforeShowDay: function checkAvailable(date) {
			    m = date.getMonth();
			    d = date.getDate();
			    y = date.getFullYear();
			    checkDate = y + '-' + (m+1) + '-' + d;
			    if(specificPrices[checkDate]){
			        specificPrice = specificPrices[checkDate];

			        return [true, "day-price-season", specificPrice +' ₽'];
			    }else{
			        specificPrice = $('.field-price input[name=price]').val();
			        console.log($('.field-price input[name=price]').val());

			        return [true, "", specificPrice +' ₽'];
			    }
			}
		});
	</script>

<? }

function dates_free($postid) { ?>
<div class="booking-calendar free-dates"></div>
<?
 
if ( get_field('free_dates', $postid) ) {

	$dates = array();

	foreach (get_field('free_dates', $postid) as $date) {
		
		$interval_date = date_diff(date_create($date['date_from']), date_create($date['date_to']))->days+1;

		for($i = 1; $i <= $interval_date ; $i++){

			$dates[] = date('Y-n-j',(strtotime($date['date_from'])+86400*($i-1)));
 
		}

	}	
 
	$disabledDays = json_encode($dates);
} else {
	$disabledDays = "null";
}

?>
 
<script>
	var	date = new Date();
		date.setDate(date.getDate());
		
      	disabledDays = <?=$disabledDays;?>;
 
	$('.free-dates').datepicker({
		monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNamesMin: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
		range: 'period', // режим - выбор периода
		minDate: new Date(),
		dateFormat: "dd.mm.yy",
		onSelect: function(dateText, inst, extensionRange) {
 
			if (extensionRange.startDateText != extensionRange.endDateText) {
				$.ajax({
					url : '/wp-admin/admin-ajax.php',
					type: "POST",
					dataType: "html",
					data: {
						'action'    : 'freeDates',
						'post_ID'   : $('input[name="post_ID"]').val(),
						'date_from' : extensionRange.startDateText,
						'date_to'   : extensionRange.endDateText,
					},
            		beforeSend: function( xhr){
            		 	$('.ajax').html('');
 						$('.ajax').append('<div class="spinner"></div>');
            		},
					success:function(result){
						$('.ajax').html(result);

					}
				});
			}

		},
        beforeShowDay: function(date) {

            var m = date.getMonth(), 
				d = date.getDate(), 
				y = date.getFullYear();
 
			if(disabledDays) {
				for (i = 0; i < disabledDays.length; i++) {
					if($.inArray(y + '-' + (m+1) + '-' + d,disabledDays) != -1) {
						return [true, 'selected-day', 'День заблокирован'];
					} else {
						return [true, '', ''];
					}
				}
			} else {
				return [true, '', ''];
			}
        }
	});	

	$('.free-dates').datepicker('setDate', ['<?=$date['date_from'];?>', '<?=$date['date_to'];?>']);
</script>
<? }

function freeDates() {

	$date_from = $_POST['date_from'];
	$date_to   = $_POST['date_to'];
	$post_id   = $_POST['post_ID'];

	$field_key = "field_602f6aea7ce20";

	$row = array();
 
	if (get_field('free_dates', $post_id)) {

		$fields = get_field('free_dates', $post_id);

		$form = array_search($_POST['date_from'], array_column($fields, 'date_from'));
		$to = array_search($_POST['date_to'], array_column($fields, 'date_to'));

		if ( is_bool($form) == false && is_bool($to) == false ) {

			$result = array();

			$row = get_field('free_dates', $post_id);

			foreach ($row as $key => $value) {

				if($value['date_from'] == $_POST['date_from'] && $value['date_to'] == $_POST['date_to']) {
					unset($row[$key]);
				}

			}

		} else {

			$row = get_field('free_dates', $post_id);

			$row[] = array(
				'date_from' => $_POST['date_from'],
				'date_to'	=> $_POST['date_to'],
			);

		}
 
	} else {

		$row[] = array(
			'date_from' => $_POST['date_from'],
			'date_to'	=> $_POST['date_to'],
		);

	}

	// сохраняем значение для повторителя
	update_field( $field_key, $row, $post_id );

	echo dates_free($post_id);


	exit;
}
add_action('wp_ajax_nopriv_freeDates','freeDates');
add_action('wp_ajax_freeDates','freeDates');

function monthDisabled() {

	$myYearMonth = $_POST['month'];

	$start = new DateTime(date('Y-m-01', strtotime($myYearMonth)));
	$end = new DateTime(date('Y-m-t', strtotime($myYearMonth)));
	
	$diff = DateInterval::createFromDateString('1 day');
	$periodStart = new DatePeriod($start, $diff, $end);
	
	$data['dates'] = array();

	foreach ( $periodStart as $dayDate ){
		$data['dates'][] = array(
			'date' => $dayDate->format( "d-m-Y" ),
		);
	} 

	update_field('free_dates', $data['dates'], $_POST['post_id']);

}
add_action('wp_ajax_nopriv_monthDisabled','monthDisabled');
add_action('wp_ajax_monthDisabled','monthDisabled');



function SecondLastPostId() {
    global $wpdb;

	$result  = $wpdb->get_results( "SHOW TABLE STATUS LIKE 'wp_posts'", ARRAY_A );
 

    return $result[0]['Auto_increment'];
}

// На сайте был последний раз
function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'last_login', time() );
}
add_action( 'wp_login', 'user_last_login', 10, 2 );

function wpb_lastlogin() {
	$last_login = get_the_author_meta('last_login');
	$the_login_date = human_time_diff($last_login);
	return $the_login_date. ' назад';
}
add_shortcode('lastlogin','wpb_lastlogin');

function super_owner() {?>
 	<? if (get_field('owner_super', 'user_' .get_the_author_meta('ID')) == 1) { ?>
 		<div class="owner-super">Супервладелец</div>
 	<? } ?>
<? }

function owner_status() {
	$status = get_field('owner_status', 'user_' .get_the_author_meta('ID'));
	?>
 	<? if (!empty($status['value']) && $status['value'] !== 0) { ?>
 		<div class="owner-partner partner-<?=$status['value'];?>"><?=$status['label'];?></div>
 	<? } ?>
<? }


function period_days() {

}

// Цена в диапазоне
function the_price($post = 0) {
	
	if (!empty($post)) {
		$post_id = $post;
	} else {
		$post_id = '';
	}

	$price = get_field('price', $post_id);

	if(get_field('season_prices', $post_id)){

		$date = strtotime(date("d.m.Y"));
 
		foreach(get_field('season_prices', $post_id) as $value) {

			if ($date >= strtotime($value['date_begin']) && $date <= strtotime($value['date_end'])) {
				 
				$price = $value['price'];

				break;

			} else {

				$price;

			}

		}

	} else {

		$price;

	}

	return $price;
}

// function the_price() {
// 	return get_price() . ' RUB ';
// }

function place() {
	$array = array();
	$terms = get_the_terms($post->ID, 'hotel');
	
	foreach( $terms as $term ){
		$array[] = $term->name;
	}
	$category = implode(", ", $array);
	
	return $category;
}


function properties_hotel($post = 0) {
	$prop[] = get_field_object('field_6006a2f5f84ee', $post);
	$prop[] = get_field_object('field_6006a3e0f84ef', $post);
	$prop[] = get_field_object('field_601ac2188dba1', $post);
	$prop[] = get_field_object('field_601ac2a797a84', $post);
	$prop[] = get_field_object('field_60057524eebd4', $post);
	$prop[] = get_field_object('field_6009187c2a3a1', $post);
	$prop[] = get_field_object('field_5fd719b126a08', $post);
	$prop[] = get_field_object('field_602eb4cae6289', $post);
	$prop[] = get_field_object('field_6005818e0da6a', $post);
 
 	$data['prop'] = array();
 
	foreach ( $prop as $field ) {
		$data['prop'][] = array(
			'title' => $field['label'],
			'value' => !empty($field['value']['value']) ? $field['value']['label'] : $field['value'],
		);
	}

	return $data['prop'];
}

function properties_romms() { ?>

	<ul class="properties">
		<? if( get_field('area')['general_area'] ) { ?>
			<li>Площадь: <span><?=get_field('area')['general_area'];?> м.кв.</span></li>
		<? } ?>
		<? if( get_field('guests_count') ) { ?>
			<li>Количество гостей: <span><?=num_word(get_field('guests_count'), array("взрослый","взрослых") );?></span></li>
		<? } ?>
		<li>Количество комнат: <span><?=the_field('rooms_count');?></span></li>
		<li>Количество двухместных кроватей: <span><?=the_field('double_beds');?></span></li>
		<li>Количество одноместных кроватей: <span><?=the_field('single_beds');?></span></li>
		<li>Количество спальных мест: <span><?=the_field('bed_total');?></span></li>
		<li>Количество санузлов всего: <span><?=the_field('bathroom_total');?></span></li>
		<li>Количество ванных комнат: <span><?=the_field('bathroom_count');?></span></li>
		<li>Расстояние до моря: <span><?=get_field('distance')['label'];?></span></li>
	</ul>

<? }


function properties_romm() { ?>

	<ul class="properties">
		<? if( get_field('room_size') ) { ?>
			<li>Площадь номера: <span><?=the_field('room_size');?> м.кв.</span></li>
		<? } ?>
		<? if( get_field('guests_count') ) { ?>
			<li>Количество гостей: <span><?=num_word(get_field('guests_count'), array("взрослый","взрослых") );?></span></li>
		<? } ?>
		<li>Количество комнат: <span><?=the_field('rooms_count');?></span></li>
		<li>Количество двухместных кроватей: <span><?=the_field('double_beds');?></span></li>
		<li>Количество одноместных кроватей: <span><?=the_field('single_beds');?></span></li>
		<li>Количество спальных мест: <span><?=the_field('bed_total');?></span></li>
		<li>Количество санузлов всего: <span><?=the_field('bathroom_total');?></span></li>
		<li>Количество ванных комнат: <span><?=the_field('bathroom_count');?></span></li>
		<li>
		Питание: 
		<? if( get_field('food_service')['breakfast'] || get_field('food_service')['lunch'] == 'да' || get_field('food_service')['dinner'] == 'да' ) { ?>
			<? if( get_field('food_service')['breakfast'] == 'да' ) { ?>
				завтрак, 
			<? } ?>
			<? if( get_field('food_service')['lunch'] == 'да' ) { ?>
				обед, 
			<? } ?>
			<? if( get_field('food_service')['dinner'] == 'да' ) { ?>
				ужин
			<? } ?>
			
		<? } ?>
		</li>
	</ul>

<? }

function lightning() { ?>

	<? if (get_field('fast_booking') == 'Включить') { ?>
		<div class="fast-booking">Мгновенное бронирование</div>
	<? } ?>

<? }

function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }

function services() { 
	$icons = array();

	$icons[] = get_field_object('field_6005774f41bef', $post->ID);
	$icons[] = get_field_object('field_60057524eebd4', $post->ID);
	$icons[] = get_field_object('field_6008afb8ef784', $post->ID);
	$icons[] = get_field_object('field_6008b02bef787', $post->ID);
	$icons[] = get_field_object('field_602eb1bce5d78', $post->ID);
	$icons[] = get_field_object('field_6008aff6ef785', $post->ID);
	$icons[] = get_field_object('field_600588e17407e', $post->ID);

	?>

	<div class="services">
	<? 
	$i = 1;
	foreach( $icons as $icon ) { ?>
		<?if($icon['value'] != 'нет' && $i >= 4){?>
 
			<div class="service icon-info icon-<?=$icon['name'];?>" data-hint="<?=$icon['label'];?>"></div>
 
		<? } ?>
	<? $i++; } ?>
	</div>
	<!-- <div class="services">
		<div class="service icon-wifi" data-hint="Беспроводной интернет Wi-Fi"></div>
		<div class="service icon-parking" data-hint="Парковка"></div>
		<div class="service icon-cart" data-hint="Супермаркет"></div>
		<div class="service icon-info" data-hint="Холодильник"></div>
		<div class="service icon-info" data-hint="Электрический чайник"></div>
	</div> -->
<? }

function rating_stars($post_id = 0) {
	$rating = get_field('rating', $post_id);
	?>
	<div class="rating-stars">
    <?php for ($i = 1; $i <= 5; $i++) { ?>
		<?php if ($rating < $i) { ?>
		<?php } else { ?>
			<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M8.47553 3.84549L8 2.38197L7.52447 3.84549L6.51416 6.95492H3.24472H1.70588L2.95082 7.85942L5.59586 9.78115L4.58555 12.8906L4.11002 14.3541L5.35497 13.4496L8 11.5279L10.645 13.4496L11.89 14.3541L11.4145 12.8906L10.4041 9.78115L13.0492 7.85942L14.2941 6.95492H12.7553H9.48584L8.47553 3.84549Z" fill="#178DE0" stroke="#178DE0"/>
			</svg>
		<?php } ?>
    <?php } ?>
    </div>
<? }


function guests_nights() { 
	$days = days($_SESSION['check_in'], $_SESSION['check_out']);

	if($days && $_SESSION['adults']) {
		$period = nights($days, $_SESSION['adults'] + $_SESSION['children']);
	} else {
		$period = '';
	}

	return $period;
}

function guests_adults() {
	return $_SESSION['adults'] ? $_SESSION['adults'] : '1';
}

function guests_childrens() {
	return $_SESSION['children'] ? $_SESSION['children'] : '0';
}

function guests_babies() {
	return $_SESSION['babies'] ? $_SESSION['babies'] : '0';
}

function guests() {
	return $_SESSION['counts_guests'] ? $_SESSION['counts_guests'] : '';
}

function hideNumber($phone) {
	$result = substr_replace($phone, 'ХХ-ХХ', -5, 5);
	return $result;
}

// function update_status() {
// 	$update_post = array(
// 		'post_type' => 'orders',
// 		'ID' => $_POST['id'],
// 		'post_status' => $_POST['status']
// 	);
	
// 	wp_update_post($update_post);

// 	exit;
// }
// add_action('wp_ajax_nopriv_update_status','update_status');
// add_action('wp_ajax_update_status','update_status');

function filter_type() {
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'hotels',
		'post_status' => 'publish, draft, pending, rejected',
		'order' => 'ASC',
		'author' => get_current_user_id(),
		'meta_query' => array(
			array(
				'key'     => '_wp_page_template',
				'value'   => 'single-room.php',
				'compare' => '!='
			),
		),
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'fields' => 'term_id',
                'terms' => $_POST['term']
            ),
        ),
	);
	query_posts( $args );
	if(have_posts()) {
		while ( have_posts() ) {
			the_post(); ?>
			<?include(TEMPLATEPATH . '/front/object.php');?>
		<? }
	} else {
		echo 'Ничего не найдено!';
	}
	wp_reset_postdata();

	exit;
}
add_action('wp_ajax_nopriv_filter_type','filter_type');
add_action('wp_ajax_filter_type','filter_type');

// function ranging_posts( $query ) {
// 	if( !is_admin() && is_taxonomy('hotel') ) {

//         // $meta_query = array(
//         //     array(
//         //         'key' => 'guest_rating',
//         //         'value' => 5,
//         //     ),
//         // );
// 		// $query->set( 'meta_query', $meta_query );
// 		$query->set( 'meta_key', 'guest_rating' );
// 		$query->set( 'orderby', 'meta_value_num' );
// 		$query->set( 'order', 'DESC' );
// 		// $query->set( 'posts_per_page', 2 );
// 	}
	
// }
// add_action( 'pre_get_posts', 'ranging_posts' );

function robokassa() {


    $post_id = $_POST['post_id'];
    $days = days($_POST['check_in'], $_POST['check_out']);
    $price = the_price($_POST['post_id']);

    $prepay = calc_percent(price_total($price, $days));//стоимость с днями
    $prepay_kope = $prepay * 100;//стоимость в копейках

    $date_start = wp_date( 'j F Y', strtotime($_POST['check_in']) );
    $date_end = wp_date( 'j F Y', strtotime($_POST['check_out']) );

    $message = 'Оплата бронирования на сайте Krymking.ru: бронь №'.$post_id.', ';
    $message .= ''.address($_POST['post_id']).', ';
    $message .= 'заезд '.$date_start.' г., выезд '.$date_end.' г. Сумма к оплате '.$prepay.' рублей.';

    //https://www.tinkoff.ru/kassa/develop/api/payments/init-description/ - апи на тинькове
    $arr['TerminalKey'] = "TinkoffBankTest";
    $arr['Amount'] = $prepay_kope;
    $arr['OrderId'] = $_POST['post_id'];
    $arr['Description'] = $message;
    //$arr['DATA']['Phone'] = '+71234567890';
    $arr['DATA']['Email'] = $_POST['user_email'];

    $arr['Receipt']['Email'] = $_POST['user_email'];//емейл клиента
    //$arr['Receipt']['Phone'] = "+79031234567";
    $arr['Receipt']['EmailCompany'] = "contact@krymking.ru";//емейл фирмы
    $arr['Receipt']['Taxation'] = "usn_income_outcome";//система налог ображения
    $arr['Receipt']['Items']['Name'] = $_POST['post_id'];//Должно быть название товара
    $arr['Receipt']['Items']['Price'] = $prepay_kope;//цена за еденицу товара в копейках
    $arr['Receipt']['Items']['Quantity'] = '1.00';//Количество или вес товара
    $arr['Receipt']['Items']['Amount'] = $prepay_kope;//стоимость товра в копейках
    $arr['Receipt']['Items']['PaymentMethod'] = 'advance';//оплата аванса
    $arr['Receipt']['Items']['PaymentObject'] = 'service';//передаю за что деньги в данном случае услуга
    $arr['Receipt']['Items']['Tax'] = 'none';//передаю данны о ндс


    $link = 'https://securepay.tinkoff.ru/v2/Init';

    echo "11111111111";

    echo "<br><br><br><br><br><br>";
    echo "<pre>";
    print_r($arr);
    echo "</pre>";

    exit();
   // echo json_encode($arr);

    /*
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $link);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
            $output = curl_exec($ch);
            curl_close($ch);
    */





    /*
    $mrh_pass1 = "zV395RuabF6HbqbmWRJ3";
			
	$days = days(get_field('check_in'), get_field('check_out'));
	$price = get_field('price', get_field('apartment'));
	$prepay = calc_percent(price_total($price, $days));
 
	$date_start = wp_date( 'j F Y', strtotime(get_field('check_in')) );
	$date_end = wp_date( 'j F Y', strtotime(get_field('check_out')) );

	$message = 'Оплата бронирования на сайте Krymking.ru: бронь №'.get_the_ID().', ';
	$message .= ''.address(get_field('apartment')).', ';
	$message .= 'заезд '.$date_start.' г., выезд '.$date_end.' г. Сумма к оплате '.$prepay.' рублей.';

	$user = get_userdata(get_field('customer'));

	$params = array(
		'MerchantLogin' => 'krymking.ru', // Идентификатор магазина
		'InvId'         => get_the_ID(), // ID заказа
		'Description'   => $message, // Описание заказа (мах 100 символов)
		'OutSum'        => $prepay, // Сумма заказа
		'Culture'       => 'ru',
		'Email'			=> $user->user_email,
		'Encoding'      => 'utf-8',   
		'IsTest'        => 1, // Тестовый режим
	);

	// Формирование подписи
	$params['SignatureValue'] = md5("{$params['MerchantLogin']}:{$params['OutSum']}:{$params['InvId']}:{$mrh_pass1}"); 

	echo '<a href="https://auth.robokassa.ru/Merchant/Index.aspx?' . urldecode(http_build_query($params)) . '" class="btn-travel">Оплатить бронирование</a>';
    */
}

// Хлебные крошки
include_once( get_template_directory() . '/back/breadcrumbs.php' );
// Уведомления
include_once( get_template_directory() . '/back/notifications.php' );
// Создание номера
include_once( get_template_directory() . '/back/create-rooms.php' );
// Местоположение объекта
include_once( get_template_directory() . '/back/object-map.php' );
// Статусы объектов
include_once( get_template_directory() . '/back/status.php' );
// Регистрация на сайте
include_once( get_template_directory() . '/back/register.php' );
// Отправка сообщений
include_once( get_template_directory() . '/back/sending-mail.php' );
// Произвольные поля
include_once( get_template_directory() . '/front/custom-fields.php' );

function wsl_use_fontawesome_icons( $provider_id, $provider_name, $authenticate_url )
{
    ?>
        <a
           rel           = "nofollow"
           href          = "<?php echo $authenticate_url; ?>"
           data-provider = "<?php echo $provider_id ?>"
           class         = "wp-social-login-provider wp-social-login-provider-odnoklassniki social-item"
           role="button"
         >
			<div class="social-logo social-<?php echo strtolower( $provider_id ); ?>"></div>
			<div class="social-name"><?php echo $provider_name; ?></div>
        </a>
    <?php
}
 
add_filter( 'wsl_render_auth_widget_alter_provider_icon_markup', 'wsl_use_fontawesome_icons', 10, 3 );
 


// if ( !is_admin() ) {
//     function posts_include($query) {
//         if ( $query->is_main_query() ) {

// 			$meta_query = array(
// 				array(
// 				   'key'   => '_wp_page_template',
// 				   'value' => 'single-hotel.php',
// 				   'compare'=>'!=',
// 				),
// 			);

// 			$query->set('meta_query', $meta_query);

//         }
		
//     	return $query;
// 	}

// 	add_filter( 'pre_get_posts','posts_include' );
// }

function hotel_room(){ 

	$variants = get_field('select_object', $_POST['post_id']);
	$room_id = $_POST['room_id'];
 
	$args = array(
		'post_type' => 'hotels',
		'post__in' => $variants
	);
	query_posts( $args );
	
	while ( have_posts() ) {
		the_post(); ?>
		<?include(TEMPLATEPATH . '/front/room-card.php');?>
	<? }
	wp_reset_postdata();

	exit; 
}
add_action('wp_ajax_nopriv_hotel_room','hotel_room');
add_action('wp_ajax_hotel_room','hotel_room');

function booking_form() { 
	$post_id = $_POST['post_id'];
	$hotel_id = $_POST['room_id'];
 
	?>
	<?include(TEMPLATEPATH . '/front/booking-form.php');?>
<?
exit; 
}
add_action('wp_ajax_nopriv_booking_form','booking_form');
add_action('wp_ajax_booking_form','booking_form');

function free_calendar($post_id = 0) { ?>
	<h3>Календарь и свободные даты</h3>
	<div class="booking-calendar free-calendar"></div>
	<div class="marker-info">
		<div class="marker"><span class="circle circle-busy"></span> занято</div>
		<div class="marker"><span class="circle circle-free"></span> свободно</div>
	</div>
	<?
	if ( get_field('free_dates', $post_id) ) {

		$dates = array();

		foreach (get_field('free_dates', $post_id) as $date) {
			
			$interval_date = date_diff(date_create($date['date_from']), date_create($date['date_to']))->days+1;

			for($i = 1; $i <= $interval_date ; $i++){

				$dates[] = date('Y-n-j',(strtotime($date['date_from'])+86400*($i-1)));
	
			}

		}	
	
		$disabled_dates = json_encode($dates);
	} else {
		$disabled_dates = "null";
	} ?>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			var disabledDays = <?=$disabled_dates;?>;
				date = new Date();
				date.setDate(date.getDate());

			$('.free-calendar').datepicker({
				monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
				monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'],
				dayNamesMin: ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'],
				range: 'multiple',
				dateFormat: "d-m-yy",
				numberOfMonths: 2,
				minDate: date,
				beforeShowDay: function(date) {

					var m = date.getMonth(), 
						d = date.getDate(), 
						y = date.getFullYear();

					if(disabledDays) {
						for (i = 0; i < disabledDays.length; i++) {
							if($.inArray(y + '-' + (m+1) + '-' + d,disabledDays) != -1) {
								return [true, 'selected-day', 'День заблокирован'];
							} else {
								return [true, '', ''];
							}
						}
					} else {
						return [true, '', ''];
					}
				},
				onSelect: function(dateText, inst, extensionRange) {

				}
			});
		});
	</script>
<? }

function room_calendar() { ?>
	<div class="modal-calendar">
		<?=free_calendar($_POST['post_id']);?>
	</div>
	<? 
}
add_action('wp_ajax_nopriv_room_calendar','room_calendar');
add_action('wp_ajax_room_calendar','room_calendar');

function is_subcategory ($catid) {
    $currentcat = get_category($catid);
    if ($currentcat->parent) {
        return true;
    } else {
        return false;
    }
}



// function update_status() {
// 	$update_post = array(
// 		'post_type' => 'orders',
// 		'ID' => $_POST['id'],
// 		'post_status' => $_POST['status']
// 	);
	
// 	wp_update_post($update_post);

// 	exit;
// }
// add_action('wp_ajax_nopriv_update_status','update_status');
// add_action('wp_ajax_update_status','update_status');



function booking_confirmed() {
	$post_id = $_POST['post_id'];

	$update_post = array(
		'post_type'   => 'orders',
		'ID'          => $post_id,
		'post_status' => 'confirmed'
	);
	
	wp_update_post($update_post);

	global $wpdb;
	$user = get_userdata(get_field('customer', $post_id));
	$post = get_field('apartment', $post_id);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';

		// Если объект подключен к мгновенному бронированию
	if(get_field('fast_booking', $post) == 'Включить') {
		$subject = 'Благодарим за бронирование №'.$post_id.'';

		$message = 'Здравствуйте, '.$user->first_name.' '.$user->last_name.'! ';
		$message .= 'Благодарим за бронирование №'.$post_id.' на Крымкинг.ру! ';
		$message .= 'После подтверждения оплаты на Ваш электронный адрес будет отправлен Ваучер на заселение с контактной информацией о Владельце и забронированном жилье. ';
		$message .= 'Откройте электронное письмо от Krymking.ru с Ваучером и сохраните или распечатайте его.';
		$message .='<br>';
		$message .='<br>';
		$message .='С уважением, <br> Команда Krymking.ru';

	} else {
		
		$subject = 'Владелец подтвердил бронирование №'.$post_id.'';

		$message = 'Уважаемый, '.$user->first_name.' '.$user->last_name.'! ';
		$message .= 'Владелец подтвердил бронирование №'.$post_id.' объекта жилья <a href="'.get_permalink($post).'">'.get_permalink($post).'</a> согласно Вашему запросу. ';
		$message .= 'Предлагаем Вам финализировать свое бронирование, перейдя на страницу завершения бронирования жилья и внести предоплату.<br>';
		$message .= '<a href="'.home_url("/booking/").'?booking-id='.$post_id.'">Внести предоплату</a>';
		$message .='<br>';
		$message .='<br>';
		$message .='С уважением, <br> Команда Krymking.ru';	
	}

	wp_mail($user->user_email, $subject, $message, $headers);
}
add_action('wp_ajax_nopriv_booking_confirmed','booking_confirmed');
add_action('wp_ajax_booking_confirmed','booking_confirmed');

function booking_canceled() {
	$post_id = $_POST['post_id'];

	global $wpdb;
	$user = get_userdata(get_field('customer', $post_id));
	$post = get_field('apartment', $post_id);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Владелец не подтвердил бронирование';

	$message = 'Уважаемый, '.$user->first_name.' '.$user->last_name.'! ';
	$message .= 'К сожалению, Владелец не подтвердил бронирование №'.$post_id.' объекта жилья <a href="'.get_permalink($post).'">'.get_permalink($post).'</a> согласно Вашему запросу. ';
	$message .='Предлагаем Вам забронировать новый вариант, воспользовавшись <a href="'.home_url("/").'">Krymking.ru</a>';
	$message .='<br>';
	$message .='<br>';
	$message .='С уважением, <br> Команда Krymking.ru';	

	wp_mail($user->user_email, $subject, $message, $headers);
}
add_action('wp_ajax_nopriv_booking_canceled','booking_canceled');
add_action('wp_ajax_booking_canceled','booking_canceled');

function travel_cancel() { 
	$booking_id = $_POST['post_id'];

	$update_post = array(
		'post_type'   => 'orders',
		'ID'          => $booking_id,
		'post_status' => 'canceled'
	);
	
	wp_update_post($update_post);
	
	// Письмо владельцу
	$post = get_post($booking_id);
	$author = get_userdata($post->post_author);

	$headers = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject = 'Гость отменил бронирование №'.$booking_id.'';

	$message = 'Уважаемый, '.$author->first_name.' '.$author->last_name.'! ';
	$message .= 'К сожалению, Гость отменил бронирование №'.$booking_id.' Вашего объекта жилья id-номер '.get_field('apartment', $booking_id).'. ';
	$message .= 'Для внесения изменений по своему объекту перейдите в <a href="'.home_url('/profile/').'">Личном кабинете</a>.';
	$message .='<br>';
	$message .='<br>';
	$message .='С уважением, <br> Команда Krymking.ru';

	wp_mail($author->user_email, $subject, $message, $headers);

	// Письмо гостю
	$user = get_userdata( get_field('customer', $booking_id) );

	$headers_user = 'Content-type: text/html; charset=utf-8'."\r\n".'From: Krymking <info@krymking.ru>';
	$subject_user = 'Ваше бронирование №'.$booking_id.' отменено.';

	$message_user = 'Уважаемый, '.$user->first_name.' '.$user->last_name.'! ';
	$message_user .= 'Нам очень жаль, что <a href="'.home_url('/profile/travel/canceled/').'">Ваше бронирование №'.$booking_id.'</a> отменено. ';
	$message_user .= 'Вы можете подобрать любой другой вариант на любые даты на нашем сайте <a href="'.home_url('/').'">Krymking.ru</a>.';
	$message_user .='<br>';
	$message_user .='<br>';
	$message_user .='С уважением, <br> Команда Krymking.ru';

	wp_mail($user->user_email, $subject_user, $message_user, $headers_user);

	exit;	
}
add_action('wp_ajax_nopriv_travel_cancel','travel_cancel');
add_action('wp_ajax_travel_cancel','travel_cancel');

function password_reset() {

	if (preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $_POST['field'])) {
		$user = get_user_by('login', $_POST['field']);
	} else {
		$user = get_user_by('email', $_POST['field']);
	}

	if( isset($user) && !empty($user) ) {
		$user_id = $user->ID;
		$userData = get_userdata($user_id);             

		$user_login = $userData->user_login;
		$user_email = $userData->user_email;
		$key = get_password_reset_key( $userData );

		$subject = "Новый пароль";
		$message = __('Кто-то запросил сброс пароля для следующей учётной записи:') . "\r\n\r\n";
		$message .= network_home_url( '/' ) . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('Если произошла ошибка, просто проигнорируйте это письмо, и ничего не произойдёт.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login');

		wp_mail( $user_email, $subject, $message );

		$return = array(
			'status'    => 'success',
			'message'   => 'Вам отправлено письмо со ссылкой для подтверждения.'
		);
	} else {
		$return = array(
			'status'    => 'error',
			'message'   => 'Учетной записи с данным номером или email не существует.'
		);
	}

	wp_send_json($return);
}
add_action('wp_ajax_nopriv_password_reset','password_reset');
add_action('wp_ajax_password_reset','password_reset');

function fields( $fields = array() ) {
	$data = array();
	foreach( $fields as $field ) {
		if($field['value']) {
			$data[] = array(
				'label' => $field['label'],
				'value' => isset($field['value']['value']) ? $field['value']['label'] : $field['value'],
			);
		}
	}

	return $data;
}