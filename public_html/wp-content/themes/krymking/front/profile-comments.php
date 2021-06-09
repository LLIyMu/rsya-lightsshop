<? $args = array(
   'number' => 10,
   'post_author' => get_current_user_id(),
   'orderby' => 'comment_date',
   'order' => 'DESC',
   'type' => '', 
);
if( $comments = get_comments( $args ) ){ ?>
<div class="reviews-list">
	<? foreach( $comments as $comment ){ ?>
 		<div class="review-item">
 			<div class="review-head">
 				<div class="review-avatar avatar">
 					<?=get_avatar( $comment, 44, '', '', array( 'class' => 'comment-avatar' ) );?>
 				</div>
 				<div class="review-content">
 					<div class="reviewer"><?=$comment->comment_author;?></div>
 					<div class="review-object"><a href="<?=get_permalink($comment->comment_post_ID);?>"><?=get_the_title($comment->comment_post_ID);?></a> <span class="date">(дата проживания: <?=the_field('arrival_date', $comment); ?> - <?=the_field('departure_date', $comment); ?>)</span></div>
 				</div>
 				<div class="review-date"><?=comment_date( 'd.m.Y, H:i' );?></div>
 			</div>
 			<div class="review-text"><?=$comment->comment_content;?></div>	
 		</div>
	<? } ?>
</div>
<? } else { ?>
	<div class="empty-text">Раздел с отзывами пуст</div>
<? } ?>