<?
global $postid;
?>

<ul class="menu-left">
    <li data-step="desc"><a href="#desc" class="active">1. <span>Описание и название</span></a></li>
    <li data-step="rules"><a href="#rules">2. <span>Параметры и правила проживания</span></a></li>
    <li data-step="pricing"><a href="#pricing">3. <span>Ценообразование</span></a></li>
    <li data-step="calendar"><a href="#calendar">4. <span>Календарь и свободные даты</span></a></li>
    <li data-step="lightning"><a href="#lightning">5. <span>Мгновенное бронирование</span></a></li>
    <li data-step="photo"><a href="#photo">6. <span>Фото и видео</span></a></li>
    <li data-step="verification"><a href="#verification">9. <span>Верификация Владельца</span></a></li>
</ul>

<div class="error hidden">Заполните обязательные поля</div>

<a href="/?post_type=hotels&p=<?=$postid;?>&preview=true" class="btn view-ad" target="_blank">Просмотр объявления</a>
<input type="submit" name="publish" value="Опубликовать" class="btn btn-add">