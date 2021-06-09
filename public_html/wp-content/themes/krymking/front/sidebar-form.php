<div class="booking-fixed">

	<? 
   	$hotel_id = $post->ID;
	   
	$favorite['favorite'] = unserialize(get_field('favorite', 'user_' .get_current_user_id() ));
	if (!empty($favorite['favorite']) && $favorite['favorite'][array_search($post->ID, $favorite['favorite'])] == $post->ID) {?>
		<div class="btn-favorite favorite-add" data-id="<?=$post->ID?>">В избранных</div>
	<? } else { ?>
		<div class="btn-favorite" data-id="<?=$post->ID?>">В избранное</div>
	<? } ?>
	
	<div class="share"><span>Поделиться:</span> 
		<div class="social">
			<a href="https://vk.com/share.php?url=<?=get_permalink( $post->ID );?>" class="vk" target="_blank" rel="nofollow"></a>
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?=get_permalink( $post->ID );?>" class="fb" target="_blank" rel="nofollow"></a>
			<a href="https://connect.ok.ru/offer?url=<?=get_permalink( $post->ID );?>" class="ok" target="_blank" rel="nofollow"></a>
			<a href="https://telegram.me/share/url?url=<?=get_permalink( $post->ID );?>" class="telegram" target="_blank" rel="nofollow"></a>
			<a href="whatsapp://send?text=<?=get_permalink( $post->ID );?>" class="whatsapp" target="_blank" rel="nofollow"></a>
			<a href="viber://forward?text=<?=get_permalink( $post->ID );?>" class="viber" target="_blank" rel="nofollow"></a>
			<a href="<?=get_permalink();?>" class="share-link" id="share-link"></a>
		</div>
	</div>
	<div class="booking-form ajax">

		<?include(TEMPLATEPATH . '/front/booking-form.php');?>
 
	</div>
</div>