<?php
get_header();
?>
<div class="headLine"></div>
<img src="<?=get_template_directory_uri();?>/images/404.jpg" alt="Страница не найдена">
<div class="wrapper">
	<div class="error-title">Ошибка!</div>
	<div class="error-text">Запрашиваемая Вами страница, к сожалению, не найдена...</div>
	<a href="/" class="btn btn-error">На главную страницу</a>
</div>
<?php
get_footer();
