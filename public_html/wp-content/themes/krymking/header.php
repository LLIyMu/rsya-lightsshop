<?php
if( !is_front_page() ) {
   $static = "static";
}
global $current_user;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- <meta name="viewport" content="width=1920"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<script src="//api-maps.yandex.ru/2.1/?apikey=d5b0c5c9-4525-425f-b488-0871669beee0&lang=ru_RU&csp=true" type="text/javascript"></script>
</head>

<body <?php body_class(); ?>>

<header class="<?=$static?>">
	<div class="wrapper">
		<?if ( is_user_logged_in() ) {?>
			<div class="header-left">
				<div class="logo">
					<a href="/">Krymking.ru</a>
					<div class="logo-text">Посуточная аренда жилья <br> в Крыму</div>
				</div>
				<a href="/hotels/" class="btn"><span class="text-btn">Найти жильё</span> <i class="icon-search"></i></a>
			</div>
			
			<div class="header-right">
				<a href="<?=home_url('/profile/add/');?>" class="btn"><span class="text-btn">Сдать жильё</span> <i class="icon-house"></i></a>
				<div class="btn btn-help"><span class="text-btn">Помощь</span> <i class="icon-help"></i></div>
				<a href="/favorites/" class="btn btn-wishlist"><span class="text-btn">Избранное</span> <i class="icon-wishlist"></i></a>
				<a href="/messages/" class="btn btn-message"><span class="text-btn">Сообщения</span> <i class="icon-message"></i></a>
				<div class="user-name"><div class="avatar"><?=user_photo($current_user);?></div><span class="text-btn"><?=$current_user->display_name;?></span></div>
			</div>
		<?} else {?>
			<div class="logo">
				<a href="/">Krymking.ru</a>
				<div class="logo-text">Посуточная аренда жилья <br> в Крыму</div>
			</div>
			<div class="btn btn-login">
				<span class="text-btn">Сдать жильё</span>
				<i class="icon-house"></i>
			</div>

			<div class="currency">
				<span class="btn btn-currency">rub</span>
				<div class="btn flag flag-russia"></div>
			</div>
			<div class="btn btn-register"><span class="text-btn">Зарегистрироваться</span> <i class="icon-register"></i></div>
			<div class="btn btn-login"><span class="text-btn">Войти</span> <i class="icon-login"></i></div>
			<div class="btn btn-help"><span class="text-btn">Помощь</span> <i class="icon-help"></i></div>
			<div class="phone">
				<a href="tel:<?=preg_replace('/[^0-9]/', '', get_field('phone', 'options'));?>" class="btn"><?=the_field('phone', 'options');?></a>
				<div class="phone-text">Подберём, бесплатно <br> забронируем</div>
				<div class="arrow"></div>
			</div>
		<?} ?>

	</div>
</header>

<div class="popup popup-guests">
	<div class="popup-content">
		<div class="guestsClose"><span></span></div>
		<div class="popup-head">Количество гостей</div>
		<ul class="guests-list">
			<li class="guest-item adults">
				<div class="guest-name">Взрослые <span>возраст от 13 лет</span></div>
				<div class="quantity"><div class="btn-controls btn-minus">-</div><input type="text" name="quantity" value="<?=guests_adults();?>" class="value" readonly="readonly"><div class="btn-controls btn-plus">+</div></div>
			</li>
			<li class="guest-item children">
				<div class="guest-name">Дети <span>возраст от 2 до 13 лет</span></div>
				<div class="quantity"><div class="btn-controls btn-minus">-</div><input type="text" name="quantity" value="<?=guests_childrens();?>" class="value" readonly="readonly"><div class="btn-controls btn-plus">+</div></div>
			</li>
			<li class="guest-item babies">
				<div class="guest-name">Младенцы <span>возраст до 2 лет</span></div>
				<div class="quantity"><div class="btn-controls btn-minus">-</div><input type="text" name="quantity" value="<?=guests_babies();?>" class="value" readonly="readonly"><div class="btn-controls btn-plus">+</div></div>
			</li>
		</ul>
	</div>
</div>

<script>
	$('.guestsClose').click(function(){
		$('.popup-guests').css('display', 'none');
	});
</script>

<div class="popup popup-help">
	<div class="popup-content">
		<ul class="menu">
			<li><a href="<?=home_url('/gostyam/');?>">Гостям</a></li>
			<li><a href="<?=home_url('/vladelczam/');?>">Владельцам</a></li>
			<li><a href="<?=home_url('/support/');?>">Служба поддержки</a></li>
		</ul>
	</div>
</div>

<? if ( !is_user_logged_in() ) { ?>

	<?get_template_part('front/auth');?>
	<?get_template_part('front/register');?>

	<div class="popup popup-tel">
		<div class="popup-content">
			<ul class="menu">
				<li><a href="tel:<?=preg_replace('/[^0-9]/', '', get_field('phone2', 'options'));?>"><span class="phone1"><?=the_field('phone2', 'options');?></span></a></li>
				<li><a href="tel:<?=preg_replace('/[^0-9]/', '', get_field('phone', 'options'));?>"><span><?=the_field('phone', 'options');?></span></a></li>
			</ul>
		</div>
	</div>

<? } else { ?>

	<div class="popup popup-lk">
		<div class="popup-content">
			<ul class="menu">
				<li><a href="<?=home_url('/profile/');?>">Мой личный кабинет</a></li>
				<li><a href="<?=home_url('/settings/');?>">Настройки</a></li>
				<li><a href="<?=wp_logout_url(home_url());?>">Выйти</a></li>
			</ul>
		</div>
	</div>

<? } ?>

<div class="popup popup-objects popup-83">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=83"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=83"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

<div class="popup popup-objects popup-90">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=90"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=90"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

<div class="popup popup-objects popup-89">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=89"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=89"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

<div class="popup popup-objects popup-91">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=91"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=91"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

<div class="popup popup-objects popup-85">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=85"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=85"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

<div class="popup popup-objects popup-86">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=86"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=86"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

<div class="popup popup-objects popup-87">
	<div class="popup-content">
		<div class="popup-row">
		<?
		$taxonomies = get_terms( array(
			'taxonomy' => 'hotel',
			'hide_empty' => false,
		) );
		if (!empty($taxonomies)) { 
			foreach($taxonomies as $category){ 
				if($category->parent == 0){?>
					<div class="popup-item">
						<h3><?=$category->name;?></h3>
						<ul class="city-list">
							<?if($category->term_id !== 9) {?>
							<li><a href="<?=get_category_link($category->term_id);?>?type=87"><?=$category->name;?></a></li>
							<?}?>
						<?foreach($taxonomies as $subcategory){?>
							<?if($subcategory->parent == $category->term_id){?>
								<li><a href="<?=get_category_link($subcategory->term_id);?>?type=87"><?=$subcategory->name;?></a></li>
							<? } ?>
						<?} ?>
						</ul>
					</div>
				<?} 
			}
		} ?>
		</div>
	</div>
</div>

 
<div class="popup popup-currency">
	<div class="popup-content">
		<ul class="currency-list">
			<li class="active">rub - российский рубль</li>
			<li>usd - доллар США</li>
			<li>eur - евро</li>
			<li>uah - украинская гривна</li>
		</ul>
	</div>
</div>

<div class="popup popup-language">
	<div class="popup-content">
		<ul class="language-list">
			<li class="active"><div class="flag-russia"></div> <span>русский</span></li>
			<li><div class="flag-eng"></div> <span>английский</span></li>
		</ul>
	</div>
</div>


<div class="popup popup-forgot">
	<div class="popup-content">
		<div class="popup-title">Восстановление пароля <div class="popup-close"></div></div>
		<div class="forgot-content">
			<div class="forgot-title">Введите адрес электронной почты или телефон, <br> связанный с Вашей учётной записью</div>
			<div class="input-group">
				<label class="input-title">Введите свой e-mail или телефон</label>
				<input type="text" name="forgot" class="form-control">
			</div>
			<div class="btn btn-forgot">Восстановить пароль</div>
			<!-- <div class="forgot-text">Мы позвоним Вам на номер +7 (978) 123-45-67,<br> определите последние 5 цифр номера из входящего <br> вызова и используйте их как пароль</div>
			<div class="input-group">
				<label class="input-title">Введите пароль</label>
				<input type="password" name="password" class="form-control">
				<div class="btn-visibility"></div>
			</div>
			<div class="input-group">
				<input type="submit" value="Войти" class="btn btn-submit">
			</div> -->
			<div class="text-register">Нет учётной записи? <span>Зарегистрироваться</span></div>
		</div>
	</div>
</div>

<div class="modal-form" id="registration-message">
	<div class="modal-content">
		<div class="modal-title">Спасибо за регистрацию! На Ваш электронный адрес отправлен запрос о подтверждении Ваших действий. В своем электронном почтовом ящике откройте письмо от krymking.ru и подтвердите регистрацию. Всего наилучшего!</div>
	</div>
</div>

<div class="popup popup-phone">
	<div class="popup-content">
		 
	</div>
</div>


<div class="overlay"></div>
 