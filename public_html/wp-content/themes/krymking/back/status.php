<?
function true_status_custom(){
	register_post_status( 'rejected', array(
		'label'                     => 'Отклонено',
		'label_count'               => _n_noop( 'Отклонено <span class="count">(%s)</span>', 'Отклонено <span class="count">(%s)</span>' ),
		'public'                    => false,
		'show_in_admin_status_list' => true
	) );

	register_post_status( 'request', array(
		'label'                     => 'Запрос',
		'label_count'               => _n_noop( 'Запрос <span class="count">(%s)</span>', 'Запрос <span class="count">(%s)</span>' ),
		'post_type'                 => array( 'orders' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true
	) );
	
	register_post_status( 'confirmed', array(
		'label'                     => 'Подтверждено',
		'label_count'               => _n_noop( 'Подтверждено <span class="count">(%s)</span>', 'Подтверждено <span class="count">(%s)</span>' ),
		'post_type'                 => array( 'orders' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true
	) );

	register_post_status( 'canceled', array(
		'label'                     => 'Отменено',
		'label_count'               => _n_noop( 'Отменено <span class="count">(%s)</span>', 'Отменено <span class="count">(%s)</span>' ),
		'post_type'                 => array( 'orders' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true
	) );
}
add_action( 'init', 'true_status_custom' );

function true_append_post_status_list(){
	global $post;
	$optionselected = '';
 	$statusname = '';

	if( $post->post_type == 'hotels' ){
		if($post->post_status == 'rejected'){
			$optionselected = ' selected="selected"';
			$statusname = "$('#post-status-display').text('Отклонено');";
		}
		echo "<script>
		jQuery(function($){
			$('select#post_status').append('<option value=\"rejected\"$optionselected>Отклонено</option>');
			$statusname
		});
		</script>";
	}

	if( $post->post_type == 'orders' ){
		if($post->post_status == 'request'){
			$optionselected = ' selected="selected"';
			$statusname = "$('#post-status-display').text('Запрос');";
		}
		echo "<script>
		jQuery(function($){
			$('select#post_status').append('<option value=\"request\"$optionselected>Запрос</option>');
			$statusname
		});
		</script>";
	}

	if( $post->post_type == 'orders' ){
		if($post->post_status == 'confirmed'){
			$optionselected = ' selected="selected"';
			$statusname = "$('#post-status-display').text('Подтверждено');";
		}
		echo "<script>
		jQuery(function($){
			$('select#post_status').append('<option value=\"confirmed\"$optionselected>Подтверждено</option>');
			$statusname
		});
		</script>";
	}

	if( $post->post_type == 'orders' ){
		if($post->post_status == 'canceled'){
			$optionselected = ' selected="selected"';
			$statusname = "$('#post-status-display').text('Отменено');";
		}
		echo "<script>
		jQuery(function($){
			$('select#post_status').append('<option value=\"canceled\"$optionselected>Отменено</option>');
			$statusname
		});
		</script>";
	}
}
add_action('admin_footer-post-new.php', 'true_append_post_status_list');
add_action('admin_footer-post.php', 'true_append_post_status_list');

function true_status_display( $statuses ) {
	global $post;
	if( get_query_var( 'post_status' ) != 'rejected' ){
		if($post->post_status == 'rejected'){
			return array('отклонено');
		} elseif ($post->post_status == 'draft'){
			return array('не опубликовано');
		} elseif ($post->post_status == 'pending'){
			return array('на модерации');
		} elseif ($post->post_status == 'request'){
			return array('запрос');
		} elseif ($post->post_status == 'canceled'){
			return array('отменено');
		} elseif ($post->post_status == 'confirmed'){
			return array('подтверждено');
		}
	}
	return $statuses;
}
add_filter( 'display_post_states', 'true_status_display' );

function tb_change_text( $translated_text, $untranslated_text, $domain ) {
	if ( $untranslated_text == 'Черновик' ) {
		$translated_text = 'Не опубликовано';
	}elseif ( $untranslated_text == 'На утверждении' ) {
		$translated_text = 'На модерации';
	}
	return $translated_text;
}
add_filter( 'gettext', 'tb_change_text', 20, 3 );
