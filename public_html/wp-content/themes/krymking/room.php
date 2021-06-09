<?
get_header();
/* Template Name: Номер */

global $postid;

// Создание новго объекта
if ( isset( $_GET['post'] ) ) {
	$post_id = (int) $_GET['post'];
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

	if(wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' ) == 0) {
		$term_hotel = $_POST['city'];
	} else {
		$term_hotel[] = $_POST['city'];
		$term_hotel[] = wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' );
	}
    
    wp_set_post_terms( $post_id, $term_hotel, 'hotel' );

    update_field('_wp_page_template', 'single-room.php', $post_id);
	
	?>

    <script>
    jQuery(document).ready(function ($) {
        history.pushState('', "", '?post='+ <?=$post_id;?>);
    });
    </script>
	<?
} 

$postid = $post_id;
$post = get_post( $postid );
 
?>

<div class="headLine"></div>
<div class="wrapper">
	<?if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>

 	<form class="profile page-wrap create-room edit-room" method="post" action="create_object">
 		<input type="hidden" name="action" value="create_object">
 		<input type="hidden" name="post_ID" value="<?=$postid;?>">
 		<input type="hidden" name="select_hotel" value="<?=$_POST['post_ID'];?>">
		<input type="hidden" name="_wp_page_template" value="single-room.php">

 		<div class="side-left">
			<?get_template_part('front/sidebar-room');?>
		</div>

		<div class="side-right">
			<? if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?get_template_part('front/profile-room');?>
  			<? endwhile;
  			endif; ?>

			<div class="message success update-fields"></div>
		</div>

	</form>
</div>
 

<?
get_footer();
 