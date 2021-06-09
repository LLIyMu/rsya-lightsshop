<? 
global $current_user;

if( is_page(71) ) {
	$active1 = 'active';
} else {
	$active1 = '';
}

if( is_page(101) || is_page(81) || is_page(83) || is_page(845) || is_page(847) ) {
	$active2 = 'active';
} else {
	$active2 = '';
}

if( is_page(92) || is_page(104) || is_page(106) || is_page(108) || is_page(110) ) {
	$active3 = 'active';
} else {
	$active3= '';
}
?>
<div class="profile-card">
	<div class="profile-content">
		<div class="profile-head">
			<div class="avatar">
				<?=user_photo($current_user);?>
			</div>
			<div class="user-info">
				<div class="user-name"><?=$current_user->display_name;?></div>
				<div class="user-id">ID: <?=$current_user->ID;?></div>
			</div>
		</div>
		<div class="profile-title <?=$active1;?> title-data"><a href="<?=home_url("/profile/");?>"><span>Личные данные</span></a></div>
		<div class="profile-title <?=$active2;?> title-info"><a href="<?=home_url("/profile/travel/");?>"><span>Общая информация</span></a></div>
		<?php wp_nav_menu([ 
		'menu_class' => 'profile-menu',
		'menu' => 'Общая информация'
		]); ?>
		<div class="profile-title <?=$active3;?> title-info"><a href="<?=home_url("/profile/objects/");?>"><span>Информация только для Владельцев</span></a></div>
		<?php wp_nav_menu([ 
		'menu_class' => 'profile-menu',
		'menu' => 'Информация Владельцам'
		]); ?>
	</div>
</div>