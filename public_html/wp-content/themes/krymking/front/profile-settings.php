<?global $current_user;?>
<form action="edit" method="post" class="profile-settings">
	<input type="hidden" name="action" value="edit_account">
	<!-- О пользователе -->

	<div class="form-section active" id="user">
		<div class="title-info">Информация о Вас защищена и её не передают третьим лицам.<br> Она будет использована только для автозаполнения Ваших данных и поможет ускорить Ваше бронирование.</div>

		<div class="main-photo">
<!-- 			<div class="main-photo-title">Главная фотография</div> -->
			<div class="photo">
				<div class="avatar">
					<? if (get_field('photo', 'user_' .$current_user->ID)) { ?>
						<img src="<?=get_field('photo', 'user_' .$current_user->ID);?>" alt="Нет фото">
					<? } else { ?>
						<img src="<?=get_template_directory_uri();?>/images/icons/no-image.svg" alt="Нет фото">
					<? } ?>
				</div>
				<span>Ваше фото</span>
			</div>
			<div class="button-wrap">
				<div class="btn btn-download">Загрузить фото <input name="my_file_upload" type="file" id="uploadimage" accept=".png, .jpg, .jpeg, .gif, .jpe"></div>
				<div class="btn btn-delete">Удалить фото</div>
			</div>
			<div class="download-info"><strong>Разрешённые типы файлов:</strong> gif, jpeg, jpe, jpg, png <br> <strong>Размер аватарки:</strong> 110x110 <br> <strong>Максимальный размер файла</strong> 0.05MB </div>
		</div>

		

		<div  class="section-gray d-flex">
			<div class="column-group">
				<div class="input-group">
					<label class="input-title">Ваше имя</label>
					<input type="text" name="firstname" value="<?=$current_user->user_firstname;?>" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-title">Название компании</label>
					<input type="text" name="company" value="<?=the_field('company', 'user_' .$current_user->ID);?>" class="form-control">
				</div>
				<div class="input-group">
					<label class="input-title">Страна</label>
					<select name="countries" class="form-control form-select">
						<option value="Россия" selected>Россия</option>
						<option value="Россия">Украина</option>
					</select>
				</div>
				<div class="input-group">
					<label class="input-title">Дата рождения</label>
					<select name="day" class="form-control form-select">
						<option>день</option>
						<?for($i=1; $i<32; $i++){?>
							<option value="<?=$i;?>" <?if ($i == get_field('day', 'user_' .$current_user->ID)) echo 'selected';?>><?=$i;?></option>
						<?}?>
					</select>
					<?=month(get_field('month', 'user_' .$current_user->ID));?>
					<select name="year" class="form-control form-select">
						<option>год</option>
						<?php foreach (range(1945, 2020) as $val) { ?>
						    <option value="<?= $val ?>" <?if ($val == get_field('year', 'user_' .$current_user->ID)) echo 'selected';?>><?= $val ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="column-group">
				<div class="input-group flex-end">
					<label class="input-title">Фамилия</label>
					<input type="text" name="lastname" value="<?=$current_user->user_lastname;?>" class="form-control">
				</div>
				<div class="input-group flex-end">
					<label class="input-title">Город</label>
					<input type="text" name="city" value="<?=the_field('city', 'user_' .$current_user->ID);?>" class="form-control">
				</div>
				<div class="input-group flex-end">
					<label class="input-title">Пол</label>
					<div class="flexbox custom-wrap">
						<?foreach (get_field_object('field_5fe62dcd7cdb3')['choices'] as $value) { ?>
						<div class="custom-item">
							<label class="custom-radio form-control">
								<input type="radio" name="gender" value="<?=$value;?>" <?if ($value == get_field('gender', 'user_' .$current_user->ID)['label']) echo 'checked';?>>
								<div class="label-name"><?=$value;?></div>
							</label>
						</div>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Контактная информация -->

	<div class="form-section" id="contacts">
		<div class="heading">Контактная информация</div>
		<div class="section-gray">
			<div class="input-group flexbox">
				<label class="input-title">Электронный адрес</label>
				<input type="email" name="user_email" value="<?=$current_user->user_email;?>" class="form-control">
				<div class="confirmation-status yes-confirmed">Подтвержден</div>
				<div class="btn btn-confirm">Подтвердить</div>
			</div>
			<div class="input-group flexbox">
				<label class="input-title"> Добавить электрон. адрес</label>
				<input type="email" name="user_email2" placeholder="Введите адрес электронной почты" value="<?=the_field('user_email2', 'user_' .$current_user->ID);?>" class="form-control">
				<div class="confirmation-status not-confirmed">Не подтвержден</div>
				<div class="btn btn-confirm">Подтвердить</div>
			</div>
			<div class="input-group flexbox">
				<label class="input-title">Контактный телефон</label>
				<div class="field-phone">
					<select name="country" class="form-control">
						<option value="ru" selected>Россия</option>
						<option value="ua">Украина</option>
						<option value="kz">Казахстан</option>
						<option value="by">Беларусь</option>
						<option value="tj">Таджикистан</option>
						<option value="uz">Узбекистан</option>
						<option value="am">Армения</option>
						<option value="az">Азербайджан</option>
						<option value="kg">Кыргызстан</option>
						<option value="md">Молдова</option>
						<option value="tm">Туркменистан</option>
					</select>
					<input type="tel" name="phone" value="<?=the_field('phone', 'user_' .$current_user->ID);?>" class="form-control">
				</div>
				<div class="confirmation-status yes-confirmed">Подтвержден</div>
				<div class="btn btn-confirm">Подтвердить</div>
			</div>
			<div class="input-group flexbox">
				<label class="input-title">Добавить телефон</label>
				<div class="field-phone">
					<select name="country" class="form-control">
						<option value="ru" selected>Россия</option>
						<option value="ua">Украина</option>
						<option value="kz">Казахстан</option>
						<option value="by">Беларусь</option>
						<option value="tj">Таджикистан</option>
						<option value="uz">Узбекистан</option>
						<option value="am">Армения</option>
						<option value="az">Азербайджан</option>
						<option value="kg">Кыргызстан</option>
						<option value="md">Молдова</option>
						<option value="tm">Туркменистан</option>
					</select>
					<input type="tel" name="phone2" placeholder="Введите номер телефона" value="<?=the_field('phone2', 'user_' .$current_user->ID);?>" class="form-control">
				</div>
				<div class="confirmation-status not-confirmed">Не подтвержден</div>
				<div class="btn btn-confirm">Подтвердить</div>
			</div>
		</div>
	</div>

	<!-- Уведомления -->

	<div class="form-section" id="notifications">
		<div class="heading">Уважаемый Пользователь, отметьте, какие сообщения Вы хотели бы получать</div>
		<div class="section-gray">

			<?=get_notifications(get_field_object('field_600d2941e3309'));?>
			<?=get_notifications(get_field_object('field_600d2b1dba94f'));?>
			<?=get_notifications(get_field_object('field_600d2d3013fea'));?>

		</div>
	</div>

	<!-- Социальные сети -->

	<div class="form-section" id="socials">
		<div class="heading">Соедините учетную запись в Krymking со своими аккаунтами в социальных сетях для более быстрого входа</div>
		<div class="section-gray">
			<div class="socials">
				<?php do_action( 'wordpress_social_login' ); ?>
			</div>
			<!-- <div class="socials">
				<div class="social-item">
					<div class="social-logo vk"></div>
					<div class="social-name">Вконтакте</div>
				</div>
				<div class="social-item">
					<div class="social-logo fb"></div>
					<div class="social-name">Facebook</div>
				</div>
				<div class="social-item">
					<div class="social-logo inst"></div>
					<div class="social-name">Instagram</div>
				</div>
				<div class="social-item">
					<div class="social-logo ok"></div>
					<div class="social-name">Одноклассники</div>
				</div>
				<div class="social-item">
					<div class="social-logo icon-ya"></div>
					<div class="social-name">Яндекс</div>
				</div>
				<div class="social-item">
					<div class="social-logo icon-goo"></div>
					<div class="social-name">Гугл</div>
				</div>
				<div class="social-item">
					<div class="social-logo icon-mail"></div>
					<div class="social-name">Mail.ru</div>
				</div>
			</div> -->
		</div>
	</div>

	<!-- Ваш пароль -->

	<div class="form-section" id="password">
		<div class="heading">Изменить пароль</div>
		<div class="section-gray">
			<div class="input-group">
				<label class="input-title">Текущий пароль</label>
				<input type="password" name="password1" class="form-control">
			</div>
			<div class="input-group">
				<label class="input-title">Новый пароль</label>
				<input type="password" name="password2" class="form-control">
			</div>
			<div class="input-group">
				<label class="input-title">Новый пароль еще раз</label>
				<input type="password" name="password3" class="form-control">
			</div>
			<div class="btn btn-form change-password">Изменить пароль</div>

			<div class="form-section-title text-center">Забыли пароль? Не беда, мы вышлем Вам ссылку для смены пароля!</div>
			<div class="btn btn-form restore-password">Восстановить пароль</div>
		</div>
	</div>

	<div class="message error"></div>
</form>