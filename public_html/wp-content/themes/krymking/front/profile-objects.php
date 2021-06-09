<?
$posts1 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'publish, draft, pending, rejected',
		'post_type' => 'hotels',
		'author' => get_current_user_id()
	)
);
wp_reset_query();
$posts2 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'publish, draft, pending, rejected',
		'post_type' => 'hotels',
		'author' => get_current_user_id(),
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => 'private',
            ),
        ),
	)
);
wp_reset_query();
$posts3 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'publish, draft, pending, rejected',
		'post_type' => 'hotels',
		'author' => get_current_user_id(),
        'tax_query' => array(
            array(
                'taxonomy' => 'type',
                'field' => 'slug',
                'terms' => 'hotel',
            ),
        ),
	)
);
wp_reset_query();

$args = array(
	'posts_per_page' => -1,
	'post_type' => 'hotels',
	'post_status' => 'publish, draft, pending, rejected',
	'order' => 'ASC',
	'author' => get_current_user_id()
);
 
$query = new WP_Query($args); ?>

<ul class="filters-nav">
	<li data-type="all" class="active">Все объекты (<?=$posts1->post_count;?>)</li>
	<li data-type="88">Частное жилье (<?=$posts2->post_count;?>)</li>
	<li data-type="84">Отели (<?=$posts3->post_count;?>)</li>
</ul>
 
<? if ( $query->have_posts() ) { ?>
<div class="objects-list ajax">
	<? while ( $query->have_posts() ) {
	$query->the_post(); ?>
		<?include(TEMPLATEPATH . '/front/object.php');?>
	<? } ?>
</div>
<? wp_reset_query(); } else { ?>
	<div class="empty-text">Ничего не найдено!</div>
<? } ?>