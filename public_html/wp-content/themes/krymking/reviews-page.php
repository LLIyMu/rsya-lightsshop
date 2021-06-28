<?php
get_header();
/* Template Name: Отзывы */
$url = get_template_directory_uri();
?>
<div class="headLine"></div>

<div class="wrapper">
	<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
 	<h1 class="page-title">Отзывы о нас</h1>
 	<div class="reviews">
 		<div class="review-header">
 			<h4>Данные отзывы оставляют Клиенты, <br> которые воспользовались услугами нашего сервиса</h4>
 		</div>
 		<div class="page-wrap">
 		<div class="side-left full">
	 		<div class="reviews-list">
			<? $args = array(
			   'number' => 10,
			   'orderby' => 'comment_date',
			   'order' => 'DESC',
			   'type' => '', 
			);
			if( $comments = get_comments( $args ) ){ ?>
				<? foreach( $comments as $comment ){ ?>
				<? $rating = get_field('rating', $comment);?>
				<? if($rating > 4.5){?>
			 		<div class="review-item">
			 			<div class="review-head">
			 				<div class="review-avatar avatar">
			 					<?=get_avatar( $comment, 44, '', '', array( 'class' => 'comment-avatar' ) );?>
			 				</div>
			 				<div class="review-content">
			 					<div class="reviewer"><?=$comment->comment_author;?></div>
			 					<div class="review-object"><a href="<?=get_permalink($comment->comment_post_ID);?>"><?=get_the_title($comment->comment_post_ID);?></a> <span class="date">(период проживания
: <?=the_field('arrival_date', $comment); ?> - <?=the_field('departure_date', $comment); ?>)</span></div>
			 				</div>
			 				<div class="review-date"><?=comment_date( 'd.m.Y, H:i' );?></div>
			 			</div>
			 			<div class="review-text"><?=$comment->comment_content;?></div>	
			 		</div>
					 <? } ?>
				<? } ?>
			<? } ?>
	 		</div>
	 	</div>
	 	<?if ( is_user_logged_in() ) {?>
	 	<!-- <div class="side-right">
	 		<div class="sidebar">
	 			<div class="sidebar-title">Поделитесь своими <br> впечатлениями о сервисе</div>
	 		</div>
	 		<form class="review-form sidebar-form-content" action="#" method="post">
				<div class="input-group">
					<label class="input-title">Ваше имя</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-title">Ваша фамилия</label>
					<input type="text" name="lastname" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-title">Введите номер телефона</label>
					<input type="text" name="phone" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-title">Введите свой e-mail</label>
					<input type="email" name="email" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-title">Период проживания</label>
					<div class="flexbox">
						<div class="title-left">Заезд</div>
						<select name="day" class="form-control form-select">
							<option selected>день</option>
							<?for($i=1; $i<32; $i++){?>
								<option value="<?=$i;?>"><?=$i;?></option>
							<?}?>
						</select>
						<?=month('month');?>
						<select name="year" class="form-control form-select">
							<option selected>год</option>
							<?php foreach (range(1945, 2020) as $val) { ?>
							    <option value="<?= $val ?>"><?= $val ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="flexbox">
						<div class="title-left">Выезд</div>
						<select name="day" class="form-control form-select">
							<option selected>день</option>
							<?for($i=1; $i<32; $i++){?>
								<option value="<?=$i;?>"><?=$i;?></option>
							<?}?>
						</select>
						<?=month('month');?>
						<select name="year" class="form-control form-select">
							<option selected>год</option>
							<?php foreach (range(1945, 2020) as $val) { ?>
							    <option value="<?= $val ?>"><?= $val ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="input-group">
					<label class="input-title">Ваш отзыв</label>
					<textarea name="review" class="form-control"></textarea>
				</div>
				<div class="input-group">
					<input type="submit" value="Отправить отзыв" class="btn btn-submit">
				</div>
	 		</form>
	 	</div> -->
		<? } ?>
	 	</div>
 	</div>
</div>

<?php
get_footer();