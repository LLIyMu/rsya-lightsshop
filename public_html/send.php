<?if (mail("kravchenko.e@siteup.ru", "заголовок", "текст")) {
    echo 'Отправлено';
}
else {
    echo 'Не отправлено';
}