<div class="popup popup-register">
	<div class="popup-content">
		<div class="popup-title">Выберите удобный для Вас вариант регистрации <div class="popup-close"></div></div>
		<div class="popup-row">
			<div class="popup-item register-email active">
				<h4>Регистрация <br> с помощью  электронной почты</h4>
				<form action="new_user" method="POST">
					<input type="hidden" name="action" value="new_user">
					<div class="input-group">
						<label class="input-title">Ваше имя <span class="required">*</span></label>
						<input type="text" name="name" required class="form-control">
					</div>
					<div class="input-group">
						<label class="input-title">Ваша фамилия <span class="required">*</span></label>
						<input type="text" name="lastname" required class="form-control">
					</div>
					<div class="input-group">
						<label class="input-title">Ваша дата рождения</label>
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
					<div class="input-group">
						<label class="input-title">Введите свой e-mail <span class="required">*</span></label>
						<input type="email" name="email" required class="form-control">
					</div>
					<div class="input-group">
						<label class="input-title">Введите свой пароль <span class="required">*</span></label>
						<input type="password" name="password" required class="form-control">
						<div class="btn-visibility"></div>
					</div>
					<div class="message error"></div>
					<div class="text-agreement">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="agreement" class="custom-input" checked>
                            <div class="check"></div>
                        </label> 
                        <span class="text">Нажимая на кнопку Зарегистрироваться, Я соглашаюсь с <a href="/agreement/">Политикой обработки персональных данных</a> и <a href="/politics/">принимаю условия Пользовательского соглашения</a></span>
                    </div>
					<div class="input-group">
						<input type="submit" value="Зарегистрироваться" class="btn btn-submit">
					</div>
				</form>
			</div>
			<div class="popup-item register-phone">
				<h4>Регистрация <br> с помощью  телефона</h4>
				<form action="sms_register" method="POST">
					<input type="hidden" name="action" value="sms_register">
					<input type="hidden" name="submit" value="sendsms">

					<div class="input-group">
						<label class="input-title">ФИО <span class="required">*</span></label>
						<input type="text" name="name" class="form-control">
					</div>
					<div class="input-group">
						<label class="input-title">Страна</label>
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
					</div>
					<div class="input-group">
						<label class="input-title">Введите номер телефона <span class="required">*</span></label>
						<input type="tel" name="phone" required class="form-control">
					</div>
					
					<div class="input-group code-confirm">
						<label class="input-title">Код подтверждения:</label>
						<input type="text" name="code" maxlength="7" size="6" class="form-control">
						<input type="submit" name="ok" value="Подтвердить код" class="btn btn-code">
					</div>

					<div class="input-group">
						<label class="input-title">Введите свой e-mail <span class="required">*</span></label>
						<input type="email" name="email" required class="form-control">
					</div>

					<div class="message error"></div>
					<div class="message-confirm">Мы позвоним Вам или отправим SMS, чтобы подтвердить номер телефона. Применяются стандартные условия Вашего тарифа на прием сообщений и передачу данных</div>
					<div class="text-agreement">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="agreement" class="custom-input" checked>
                            <div class="check"></div>
                        </label> 
                        <span class="text">Нажимая на кнопку Зарегистрироваться, Я соглашаюсь с <a href="/agreement/">Политикой обработки персональных данных</a> и <a href="/politics/">принимаю условия Пользовательского соглашения</a></span>
                    </div>
					<div class="input-group">
						<input type="submit" name="sendsms" value="Зарегистрироваться" class="btn btn-submit">
					</div>
				</form>
			</div>
			<div class="popup-item register-social">
				<h4>Регистрация <br> с помощью соцсетей</h4>
				<div class="socials">
					<?php do_action( 'wordpress_social_login' ); ?> 
				</div>
				<div class="text-agreement">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="agreement" class="custom-input" checked>
                        <div class="check"></div>
                    </label> 
                    <span class="text">Нажимая на кнопку Соц. сети, Я соглашаюсь с <a href="/agreement/">Политикой обработки персональных данных</a> и <a href="/politics/">принимаю условия Пользовательского соглашения</a></span>
                </div>
			</div>
		</div>
		<div class="bottom-line"><div class="login-text">У Вас уже есть учётная запись? <span class="">Войти</span></div></div>
	</div>
</div>