<?
get_header();
/* Template Name: Создания объектов */

global $postid;

// Создание новго объекта
if ( isset( $_GET['post'] ) && isset( $_POST['post_ID'] ) && (int) $_GET['post'] !== (int) $_POST['post_ID'] ) {
	wp_die( __( 'A post ID mismatch has been detected.' ), __( 'Sorry, you are not allowed to edit this item.' ), 400 );
} elseif ( isset( $_GET['post'] ) ) {
	$post_id = (int) $_GET['post'];
} elseif ( isset( $_POST['post_ID'] ) ) {
	$post_id = (int) $_POST['post_ID'];
} else {
    require_once ABSPATH . 'wp-admin/includes/post.php';

    $post = get_default_post_to_edit( 'hotels', true );
    $post_id = $post->ID;

    $my_post = array();
    $my_post['ID'] = $post_id;
    $my_post['post_title'] = 'Без названия';
    
    // Обновляем данные в БД
    wp_update_post( wp_slash($my_post) );

    // Taxonomy
    $term_type = $_POST['object_type'];
    wp_set_post_terms( $post_id, $term_type, 'type' );

    $term_hotel[] = $_POST['city'];
    $term_hotel[] = wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' );
    
    wp_set_post_terms( $post_id, $term_hotel, 'hotel' );

    // Подключаем шаблон
    if ( $term_type == 83 || $term_type == 90 || $term_type == 89 || $term_type == 91 ) {
        update_field('_wp_page_template', 'single-apartment.php', $post_id);
    } elseif ( $term_type == 85 || $term_type == 86 || $term_type == 87 ) {
        update_field('_wp_page_template', 'single-hotel.php', $post_id);
    } else {
        update_field('_wp_page_template', 'single-room.php', $post_id);
    } ?>

    <script>
    jQuery(document).ready(function ($) {
        history.pushState('', "", '?post='+ <?=$post_id;?>);
    });
    </script>

<? }

$postid = $post_id;
$post = get_post( $postid );

// Тип размещения
$terms = get_the_terms( $postid, 'type' );
if ( $terms ) {
    // Получим только первый термин
	$term = array_shift( $terms );
}

// Проверка на автора поста
if (!is_user_logged_in() || $post->post_author != get_current_user_id()) {
	wp_redirect( home_url() ); 
	exit;
}

if ( $term->term_id == 83 || $term->term_id == 90 || $term->term_id == 89 || $term->term_id == 91 ) {
    $action = 'create_object';
    $class = 'object-update';
} elseif ( $term->term_id == 85 || $term->term_id == 86 || $term->term_id == 87 ) {

    if ( get_field('_wp_page_template', $post->ID) != 'single-room.php' ) {
        $action = 'https://krymking.ru/profile/add/hotels/room/';
        $class = 'object-hotel';
    } else {
        $action = 'create_object';
        $class = 'object-update';
    }
    
} else {
    $action = 'create_object';
    $class = 'object-update';
}

?>
 
<div class="headLine"></div>
<div class="wrapper">
    <div class="breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList">
    <span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
    <a class="breadcrumbs__link" href="https://krymking.ru/" itemprop="item">
        <span itemprop="name">Главная</span>
    </a><meta itemprop="position" content="1"></span>
    <span class="breadcrumbs__separator"></span>
    <span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
    <a class="breadcrumbs__link" href="https://krymking.ru/profile/" itemprop="item">
        <span itemprop="name">Личный кабинет</span>
    </a><meta itemprop="position" content="2"></span><span class="breadcrumbs__separator"></span><span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a class="breadcrumbs__link" href="https://krymking.ru/profile/add/" itemprop="item"><span itemprop="name">Сдать жильё</span></a><meta itemprop="position" content="3"></span><span class="breadcrumbs__separator"></span><span class="breadcrumbs__current">Размещение объекта</span></div>
	<?//if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>  

 	<form class="profile page-wrap create-room <?=$class;?>" method="post" action="<?=$action;?>">
 		<input type="hidden" name="action" value="create_object">
 		<input type="hidden" name="object_type" value="<?=$term->term_id;?>">
 		<input type="hidden" name="post_ID" value="<?=$postid;?>">

 		<div class="side-left">
            <? if ( get_field('_wp_page_template', $postid) == 'single-apartment.php' ) { ?>
                <?get_template_part('front/sidebar-apartment');?>
            <? } elseif ( get_field('_wp_page_template', $postid) == 'single-hotel.php' ) { ?>
                <?get_template_part('front/sidebar-hotel');?>
            <? } elseif ( get_field('_wp_page_template', $postid) == 'single-room.php' ) { ?>
                <?get_template_part('front/sidebar-room');?>
            <? } ?>
		</div>

		<div class="side-right">
            <? if ( get_field('_wp_page_template', $postid) == 'single-apartment.php' ) { ?>
                <?get_template_part('front/profile-apartment');?>
            <? } elseif ( get_field('_wp_page_template', $postid) == 'single-hotel.php' ) { ?>
                <?get_template_part('front/profile-hotels');?>
            <? } elseif ( get_field('_wp_page_template', $postid) == 'single-room.php' ) { ?>
                <?get_template_part('front/profile-room');?>
            <? } ?>
		</div>

	</form>
</div>

<?php
get_footer();