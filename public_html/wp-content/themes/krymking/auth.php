<?php
get_header();
/* Template Name: auth */
global $current_user;
?>
<div class="headLine"></div>
<div class="wrapper">
<?

require_once 'lib/SocialAuther/autoload.php';

$adapterConfigs = array(
    'vk' => array(
        'client_id'     => '7774716',
        'client_secret' => 'O2bKEtMeNva2U8rlRKta',
        'redirect_uri'  => 'https://krymking.ru/auth?provider=vk',
        'response_type' => 'code'
    ),
    'odnoklassniki' => array(
        'client_id'     => '658606315',
        'client_secret' => 'C35045020A8C7C066F25C4C7',
        'redirect_uri'  => 'http://localhost/auth?provider=odnoklassniki',
        'public_key'    => 'BAMKABABACADCBBAB'
    ),
    'mailru' => array(
        'client_id'     => '670707',
        'client_secret' => 'a619062972f2073ded61405b8f8eccd2',
        'redirect_uri'  => 'http://localhost/auth/?provider=mailru'
    ),
    'yandex' => array(
        'client_id'     => 'bff0bfcaef054ab66c0538b39e0a86cf',
        'client_secret' => '219ba88d386b114b9c6abef7eab4e8e4',
        'redirect_uri'  => 'http://localhost/auth/?provider=yandex'
    ),
    'google' => array(
        'client_id'     => '393337311853.apps.googleusercontent.com',
        'client_secret' => 'B38WaUlZG8gDI6jIEWVct5id',
        'redirect_uri'  => 'http://localhost/auth?provider=google'
    ),
    'facebook' => array(
        'client_id'     => '346158195993388',
        'client_secret' => '2de1ab376d1c17cd47250920c05ab386',
        'redirect_uri'  => 'http://localhost/auth?provider=facebook'
    )
);

// создание адаптеров
$adapters = array();
foreach ($adapterConfigs as $adapter => $settings) {
    $class = 'SocialAuther\Adapter\\' . ucfirst($adapter);
    $adapters[$adapter] = new $class($settings);
}

if (!isset($_GET['code'])) {
    foreach ($adapters as $title => $adapter) {
        echo '<p><a href="' . $adapter->getAuthUrl() . '">Аутентификация через ' . ucfirst($title) . '</a></p>';
    }
} else {
    if (isset($_GET['provider']) && array_key_exists($_GET['provider'], $adapters)) {
        $auther = new SocialAuther\SocialAuther($adapters[$_GET['provider']]);
    }

    if ($auther->authenticate()) {
        if (!is_null($auther->getSocialId()))
            echo "Социальный ID пользователя: " . $auther->getSocialId() . '<br />';

        if (!is_null($auther->getName()))
            echo "Имя пользователя: " . $auther->getName() . '<br />';

        if (!is_null($auther->getEmail()))
            echo "Email пользователя: " . $auther->getEmail() . '<br />';

        if (!is_null($auther->getSocialPage()))
            echo "Ссылка на профиль пользователя: " . $auther->getSocialPage() . '<br />';

        if (!is_null($auther->getSex()))
            echo "Пол пользователя: " . $auther->getSex() . '<br />';

        if (!is_null($auther->getBirthday()))
            echo "День Рождения: " . $auther->getBirthday() . '<br />';

        // аватар пользователя
        if (!is_null($auther->getAvatar()))
            echo '<img src="' . $auther->getAvatar() . '" />'; echo "<br />";
    }
}
?>
</div>
<?php
get_footer();