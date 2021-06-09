<div class="popup popup-auth">
	<div class="popup-content">
		<div class="popup-title">Вход в личный кабинет <div class="popup-close"></div></div>
		<div class="popup-row">
			<div class="popup-item active auth-email">
				<h4>С помощью  электронной почты</h4>
				<form action="auth" method="POST">
					<input type="hidden" name="action" value="auth">
					<div class="input-group">
						<label class="input-title">Введите свой e-mail</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="input-group">
						<label class="input-title">Введите свой пароль</label>
						<input type="password" name="password" class="form-control" required>
						<div class="btn-visibility"></div>
					</div>
					<div class="message error"></div>
					<div class="remember">
						<label class="custom-checkbox">
							<input type="checkbox" name="remember" class="custom-input" value="forever" checked>
							<div class="check"></div>
						</label>
						<span>Запомнить меня</span>
						<div class="forgot-password">Забыли пароль?</div>
					</div>
					<div class="input-group">
						<input type="submit" value="Войти" class="btn btn-submit">
					</div>
					<div class="text-register">Нет учётной записи? <span>Зарегистрироваться</span></div>
				</form>
			</div>
			<div class="popup-item auth-phone">
				<h4>С помощью  телефона</h4>
				<form action="#" method="POST">
					<input type="hidden" name="action" value="auth_phone">
					<div class="flexbox">
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
						<div class="input-group tel">
							<label class="input-title">Номер телефона </label>
							<input type="tel" name="phone" class="form-control">
						</div>
					</div>
					<div class="input-group">
						<label class="input-title">Введите свой пароль</label>
						<input type="password" name="password" class="form-control">
						<div class="btn-visibility"></div>
					</div>
					<div class="message error"></div>
					<div class="remember">
						<label class="custom-checkbox">
							<input type="checkbox" name="remember" class="custom-input" value="forever" checked>
							<div class="check"></div>
						</label>
						<span>Запомнить меня</span>
						<div class="forgot-password">Забыли пароль?</div>
					</div>
					<div class="input-group">
						<input type="submit" value="Войти" class="btn btn-submit">
					</div>
					<div class="text-register">Нет учётной записи? <span>Зарегистрироваться</span></div>
				</form>
			</div>
			<div class="popup-item auth-social">
				<h4>С помощью соцсетей</h4>
				<div class="socials">
					<?php do_action( 'wordpress_social_login' ); ?>
				</div>
			</div>
		</div>
	</div>
</div>