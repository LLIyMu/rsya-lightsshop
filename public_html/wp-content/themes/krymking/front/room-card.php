<div class="room-item" data-id="<?=get_the_ID();?>">
    <div class="room-name"><?=the_title();?> 
        <? if( get_the_ID() == $room_id ) { ?>
            <div class="room-collapse active">Свернуть</div>
        <? } else { ?>
            <div class="room-collapse">Подробнее</div>
        <? } ?>
    </div>
    <div class="room-wrap" <?=get_the_ID() == $room_id ? 'style="display: block;"' : ''; ?>> 
        <div class="room-content">
            <div class="room-gallery">
                <div class="room-slider">
                    <?foreach (get_field('gallery') as $image) {?>
                        <a href="<?=$image['url'];?>" data-fancybox="gallery">
                            <img src="<?=$image['sizes']['large'];?>">
                            <span class="zoom"></span>
                        </a>
                    <?}?>
                </div>
                
                <? if( get_field('gallery') ) { ?>
                    <div class="counts-slides"><span class="current">1</span> / <span><?=count(get_field('gallery'));?></span></div>
                <? } ?>
            </div>
 
            <div class="room-info">
                <?=properties_romm();?>
                <?=lightning();?>
                <? if( guests_nights() ) { ?>
                    <div class="nights-guests"><?=guests_nights();?>, <?=the_price();?> за ночь</div>
                <? } ?>
                <div class="price-total">Всего <?=price_total(the_price(), days($_SESSION['check_in'], $_SESSION['check_out']) );?> RUB</div>
                <div class="button-group">
                    <div class="room-more">Подробнее о номере</div>
                    <div class="btn btn-booking" data-id="<?=get_the_ID();?>">Забронировать</div>
                </div>
 
                <div class="room-calendar">Календарь и свободные даты этого номера</div>
            </div>
        </div>

        <div class="room-desc">
			<? if(fields( rulesRoom(get_the_ID()) )) { ?>
			<div class="room-parameters">
				<h3>Правила проживания</h3>
				<ul class="attributes-line attributes-flex">
					<? foreach (fields( rulesRoom(get_the_ID()) ) as $field) { ?>
						<li><strong><?=$field['label'];?>:</strong> <?=$field['value'];?></li>
					<? } ?>
				</ul>
			</div>
			<? } ?>
			<div class="room-parameters parameters-list">
				<? if(fields( generalRoom(get_the_ID()) )) { ?>
				<div class="parameters-item">
					<h3>Общие удобства</h3>
					<ul class="attributes">
					<? foreach (fields( generalRoom(get_the_ID()) ) as $field) { ?>
						<li><?=$field['label'];?>: <?=$field['value'];?></li>
					<? } ?>
					</ul>
				</div>
				<? } ?>
				<? if(fields( sanuzelRoom(get_the_ID()) )) { ?>
				<div class="parameters-item">
					<h3>Санузлы</h3>
					<ul class="attributes">
					<? foreach (fields( sanuzelRoom(get_the_ID()) ) as $field) { ?>
						<li><?=$field['label'];?>: <?=$field['value'];?></li>
					<? } ?>
					</ul>
				</div>
				<? } ?>
				<? if(fields( kitchenRoom(get_the_ID()) )) { ?>
				<div class="parameters-item">
					<h3>Кухня</h3>
					<ul class="attributes">
					<? foreach (fields( kitchenRoom(get_the_ID()) ) as $field) { ?>
						<li><?=$field['label'];?>: <?=$field['value'];?></li>
					<? } ?>
					</ul>
				</div>
				<? } ?>
				<? if(fields( roomsRoom(get_the_ID()) )) { ?>
				<div class="parameters-item">
					<h3>Комнаты</h3>
					<ul class="attributes">
					<? foreach (fields( roomsRoom(get_the_ID()) ) as $field) { ?>
						<li><?=$field['label'];?>: <?=$field['value'];?></li>
					<? } ?>
					</ul>
				</div>
				<? } ?>
				<? if(fields( childrenRoom(get_the_ID()) )) { ?>
				<div class="parameters-item">
					<h3>Детям</h3>
					<ul class="attributes">
					<? foreach (fields( childrenRoom(get_the_ID()) ) as $field) { ?>
						<li><?=$field['label'];?>: <?=$field['value'];?></li>
					<? } ?>
					</ul>
				</div>
				<? } ?>
			</div>
        </div>
    </div>
</div>