<?
global $postid;

if (isset ($_GET['post']) ) {
	$postid = $_GET['post'];
} elseif (isset($_POST['post_id'])) {
	$postid = $_POST['post_id'];
} else {
	$postid = '';
}

$post = get_post( $postid );

if (!is_user_logged_in() || $post->post_author != get_current_user_id()) {
	wp_redirect( home_url() ); 
	exit;
}
/*
Template Name: Edit post
*/
get_header();

if (!empty($_POST['object_type'])) {
	$object_type = wp_get_term_taxonomy_parent_id( $_POST['object_type'], 'type' );
} else {
	$terms = get_the_terms( $postid, 'type' );
	if( $terms ){
		$term = array_shift( $terms );

		$object_type = $term->term_id;
	}
}

if( has_term(array(84, 85, 86, 87), 'type', $postid ) ){
    include( TEMPLATEPATH.'/edit-hotels.php' );
} else {
    include( TEMPLATEPATH.'/edit-rooms.php' );
}
?>

<?
get_footer();
?>