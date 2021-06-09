<?
global $postid;
?>

<ul class="menu-left">
	<li data-step="location"><a href="#location" class="active">1. <span>Местоположение</span></a></li>
	<li data-step="options"><a href="#options">2. <span>Параметры</span></a></li>
	<li data-step="desc"><a href="#desc">3. <span>Описание и название</span></a></li>
	<li data-step="rules"><a href="#rules">4. <span>Правила проживания</span></a></li>
	<li data-step="pricing"><a href="#pricing">5. <span>Ценообразование</span></a></li>
	<li data-step="calendar"><a href="#calendar">6. <span>Календарь и свободные даты</span></a></li>
	<li data-step="lightning"><a href="#lightning">7. <span>Мгновенное бронирование</span></a></li>
	<li data-step="photo"><a href="#photo">8. <span>Фото и видео</span></a></li>
	<li data-step="verification"><a href="#verification">9. <span>Верификация Владельца</span></a></li>
</ul>

<div class="error hidden">Заполните обязательные поля</div>

<a href="/?post_type=hotels&p=<?=$postid;?>&preview=true" class="btn view-ad" target="_blank">Просмотр объявления</a>
<input type="submit" name="publish" value="Опубликовать" class="btn btn-add">