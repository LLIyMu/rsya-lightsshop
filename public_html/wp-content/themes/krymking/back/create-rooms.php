<?
function create_object(){ 

	if ( get_post_status($_POST['post_ID']) ) {
		if ( isset($_POST['publish']) ) {
		 	$status = 'pending';

			$btn = '<a href="/profile/add/" class="btn btn-add-room">Добавить ещё один объект</a>';

			$result['status'] = 'success';
			$result['message'] = 'Поздравляем, Вы проделали большую работу и теперь Ваш объект жилья проходит модерацию. '.$btn.' ';
		} else {
			$status = 'draft';

			$result['status'] = 'success';
			$result['message'] = 'Изменения успешно сохранены!';
		}

        $update_post = array(
            'ID'            => $_POST['post_ID'],
            'post_status'   => $status,
            'post_title'    => $_POST['apartment_name'],
            'post_content'  => $_POST['description'],
        );

    	$post_id = wp_update_post( $update_post );

		// Добавляем новый номер в отель
		if ( get_field('select_hotel', $_POST['post_ID']) ) {
			
			// Создаем массив с POST_ID
			$hotel_id = get_field('select_object', $_POST['select_hotel']);
			$hotel_id[] = $_POST['post_ID'];

			$hotel_ids = array_unique($hotel_id);

			update_field('select_object', $hotel_ids, $_POST['select_hotel']);
		}

		// Обновляем данные в номерах
		if ( get_field('_wp_page_template', $_POST['post_ID']) == 'single-hotel.php' && get_field('select_object', $_POST['post_ID']) ) {
			foreach( get_field('select_object', $_POST['post_ID']) as $post ) {
				foreach (acf_get_fields(390) as $field) {
					update_field($field['name'], $_POST[$field['name']], $post);
				}

				$infrastructure[] = get_field_object('field_601ac5ffd10b7');
				$infrastructure[] = get_field_object('field_60091b7a9ad97');
				foreach ($infrastructure as $field) {
					update_field($field['name'], $_POST[$field['name']], $post);
				}

				// Обновляем город в номерах
				if( wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' ) == 0 ) {
					$term_hotel = $_POST['city'];
				} else {
					$term_hotel[] = $_POST['city'];
					$term_hotel[] = wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' );
				}
				if($term_hotel) {
					wp_set_post_terms( $post, $term_hotel, 'hotel' );
				}

				// foreach( generalRoom() as $field ) {
				// 	wp_set_post_terms( $post, $term_hotel, 'hotel' );
				// }
			}
		}

	} else {

		$post_data = array(
			'post_status'   => 'draft',
			'post_type'     => 'hotels',
	    	'post_title'    => $_POST['apartment_name'],
	    	'post_content'  => $_POST['description'],
			'post_author'   => get_current_user_id(),
		);

		$post_id = wp_insert_post( wp_slash($post_data));

		if( !empty($_POST['select_object']) ) {
			update_field('select_object', $post_id, $_POST['select_object']);
		}
	}

	if ( is_wp_error($post_id) ) {

		$result['status'] = 'error';
		$result['message'] = $post_id->get_error_message();

	} else {
		if ( !empty($_FILES['files']) ) {
			if ( ! function_exists( 'wp_handle_upload' ) ) {
			    require_once( ABSPATH . 'wp-admin/includes/file.php' );
			}
			// for multiple file upload.
			$upload_overrides = array( 'test_form' => false );

			$photos = array();
			$files = $_FILES['files'];
			foreach ( $files['name'] as $key => $value ) {
			    if ( $files['name'][ $key ] ) {
			        $file = array(
			            'name' => $files['name'][ $key ],
			            'type' => $files['type'][ $key ],
			            'tmp_name' => $files['tmp_name'][ $key ],
			            'error' => $files['error'][ $key ],
			            'size' => $files['size'][ $key ]
			        );
			 
			        $movefile = wp_handle_upload( $file, $upload_overrides );

		    		if ( $movefile && !isset( $movefile['error'] ) ) {
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

						// Получаем id медиафайла
						$attach_id = wp_insert_attachment( $attachment, $filename, 0 );
						require_once( ABSPATH . 'wp-admin/includes/image.php' );

						// Создадим метаданные для вложения и обновим запись в базе данных.
						$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
						wp_update_attachment_metadata( $attach_id, $attach_data);

						$photos[] = $attach_id;
		    		}
			    }
			}

		 	set_post_thumbnail( $post_id, $photos[0]);
 			update_field('gallery', $photos, $post_id);
		}
 
		if(wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' ) == 0) {
			$term_hotel = $_POST['city'];
		} else {
			$term_hotel[] = $_POST['city'];
			$term_hotel[] = wp_get_term_taxonomy_parent_id( $_POST['city'], 'hotel' );
		}
		if($term_hotel) {
			wp_set_post_terms( $post_id, $term_hotel, 'hotel' );
		}
		if(!empty($_POST['object_type'])) {
			wp_set_post_terms( $post_id, $_POST['object_type'], 'type' );
		}

		$arr = $_POST;
		$delete_keys = array('action', 'term_id', 'region', 'city', 'apartment_name', 'description', 'object_name', 'post_ID', 'files');
		$arr = array_diff_key($arr, array_flip($delete_keys));
		foreach ($arr as $key => $val) {
			update_field($key, $_POST[$key], $post_id);	 
		}

	}

	echo json_encode($result);
	exit;
}
add_action('wp_ajax_nopriv_create_object','create_object');
add_action('wp_ajax_create_object','create_object');
