<? 
global $current_user;
?>
<div class="profile-wrap">
	<div class="profile-info">
		<div class="avatar">
			<?=user_photo($current_user);?>
			<input name="my_file_upload" type="file" id="uploadimage"  accept=".png, .jpg, .jpeg, .gif, .jpe" />
			<div class="edit-photo" data-id="<?=$current_user->ID;?>"></div>
		</div>
		<div class="message error"></div>
		<div class="user-name"><?=$current_user->display_name;?></div>
		<div class="user-id">ID пользователя: <?=$current_user->ID;?></div>
		<ul class="user-data">
			<li>Имя: <span><?=$current_user->user_firstname;?></span></li>
			<li>Фамилия: <span><?=$current_user->user_lastname;?></span></li>
			<?if (get_field('company', 'user_' .$current_user->ID)) {?>
			<li>Компания: <span><?=the_field('company', 'user_' .$current_user->ID);?></span></li>
			<?}?>
		</ul>
		<a href="/settings/" class="edit-link">Редактировать информацию</a>
	</div>

	<div class="profile-right">
		<?if (get_field('phone', 'user_' .$current_user->ID)) {?>
		<div class="edit-field">
			<div class="edit-label label-tel">Номер телефона</div>
			<div class="edit-info">
				<span><input type="text" name="phone" value="<?=the_field('phone', 'user_' .$current_user->ID);?>"></span>
				<div class="edit-link">Сменить номер телефона</div>
				<div class="message error"></div>
			</div>
		</div>
		<?}?>
		<?if ($current_user->user_email) {?>
		<div class="edit-field">
			<div class="edit-label label-email">Электронная почта</div>
			<div class="edit-info">
				<span><input type="email" name="user_email" value="<?=$current_user->user_email;?>"></span>
				<div class="edit-link">Сменить электронную почту</div>
				<div class="message error"></div>
			</div>
		</div>
		<?}?>
	</div>
</div>