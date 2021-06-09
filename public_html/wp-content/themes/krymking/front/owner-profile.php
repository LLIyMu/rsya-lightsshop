<?
$udata = get_userdata(get_the_author_meta('ID'));
$registered = wp_date("d.m.Y", strtotime($udata->user_registered));
 
?> 

<h2 class="block-header">Профайл владельца</h2>
<div class="owner-hotel">
	<div class="owner-col">
		<div class="owner-photo avatar">
			<?if (get_field('photo', 'user_' .get_the_author_meta('ID'))) {?>
				<img src="<?=get_field('photo', 'user_' .get_the_author_meta('ID'));?>">
			<? } else { ?>
				<?=preg_replace('~(\pL)\S+|\s+~u', '$1', get_the_author());?>
			<? } ?>
		</div>
	</div>
	<div class="owner-col">
		<div class="owner-name"><?=get_the_author();?> <div class="owner-status"></div></div>
		<ul class="owner-info">
			<li><span>Количество объектов на ресурсе: <?=get_the_author_posts();?></span></li>
			<li><span><?=totalPositive(get_the_author_meta('ID'));?></span></li>
			<li>Представлен на ресурсе с: <span><?=$registered;?></span></li>
			<li>На сайте был последний раз: <span><?=do_shortcode('[lastlogin]');?></span></li>
			<li>Частота ответов: <span>100%</span></li>
			<li>Время ответа: <span>в течение часа</span></li>
			<? if( get_field('languages', 'user_' .get_the_author_meta('ID')) ) { ?>
				<li>Язык общения: 
					<span>
					<?foreach (get_field('languages', 'user_' .get_the_author_meta('ID')) as $value) { ?>
						<?=$value['label'];?>
					<? } ?>
					</span>
				</li>
			<? } ?>
		</ul>
	</div>
	<div class="owner-col owner-right">
		<div class="owner-labels">
			<?=super_owner();?>
			<?=owner_status();?>
		</div>
		<div class="owner-message">
			<?if(get_field('phone', 'user_' .get_the_author_meta('ID'))){?>
			<div class="owner-phone"><?=hideNumber(get_field('phone', 'user_' .get_the_author_meta('ID')));?></div>
			<?}?>
			<div class="btn-owner">Написать владельцу</div>
		</div>
	</div>
</div>

<div class="popup popup-owner">
	<div class="popup-content">
		<p class="owner-text">Владелец бронирует свой объект и общается исключительно при помощи нашего ресурса. Для бронирования используйте кнопку <span>Забронировать</span></p>
	</div>
</div>