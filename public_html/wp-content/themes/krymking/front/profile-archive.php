<?
$posts1 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'trash',
		'post_type' => 'hotels',
		'author' => get_current_user_id()
	)
);

$posts2 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'trash',
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

$posts3 = new WP_Query(
	array(
		'posts_per_page' => -1,
		'post_status' => 'trash',
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
?>

<ul class="filters-nav">
	<li data-type="all" class="active">Все объекты (<?=$posts1->post_count;?>)</li>
	<li data-type="88">Частное жилье (<?=$posts2->post_count;?>)</li>
	<li data-type="84">Отели (<?=$posts3->post_count;?>)</li>
</ul>

<?
$args = array(
	'posts_per_page' => -1,
	'post_type' => 'hotels',
	'post_status' => 'trash',
	'order' => 'ASC',
	'author' => get_current_user_id(),
);
query_posts( $args );
?>
<? if ( have_posts() ) { ?>
<div class="objects-list ajax">
	<? while ( have_posts() ) {
	the_post(); ?>
		<?include(TEMPLATEPATH . '/front/object.php');?>
	<? } ?>
</div>
<? } else { ?>
	<div class="empty-text">В этом разделе нет объектов.</div>
<? } ?>