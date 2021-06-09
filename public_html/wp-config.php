<?php
// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'rsya_lightsshopru' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4_' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

define('WPCF7_AUTOP', false );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '$)#Tt&_wUD( 8TfT,Tk9Ztn csR_hFDDB> Z$e#A>pAjK}x9PEAV4RI/#a{QWY,3' );
define( 'SECURE_AUTH_KEY',  's#|AeQw1&$GhfpE@:1Wa(^vvW@xS%kV$c@7@<AwxSbsjPMxSULK2{j6]Qh@O[j[y' );
define( 'LOGGED_IN_KEY',    'G.S;t:xG6w,2ZY9^<yw*>@[6bKhon*=X=FTk<^;V|XPQ*;<5k5bD}w2# ;64-Ce/' );
define( 'NONCE_KEY',        'w@cCpc#Oo{U;+RtZ9)#vf2Z)e.Or,jKG~u7(z1!Z=gLdj?t12KJx7V#j,464.X9s' );
define( 'AUTH_SALT',        '/_B/>>|Hl[bw^dsBv*-OUon(kY/+p@h:F/86fuFKypn[DrgW&;TJy%<RImUml R(' );
define( 'SECURE_AUTH_SALT', '1(^Sbz*5VfjTWM]Lp&H^k 6$2vg_Fxv8ZmD~S|DX:cW6F4{]xYsxhjd%#qR ^(<Q' );
define( 'LOGGED_IN_SALT',   'xB)jn^w[mTb}s$8cZ/Mf<I9,m ytmQ7ScBW{-C+iZ?h1&SBP$XgCES6XGSDLz@NU' );
define( 'NONCE_SALT',       'CD=~,j0c$CGNo7J`X+zIl}1Jar+;9?(?j1 62>]hp@2zLt1>U}HtSx@`~I(v5^}}' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

define( 'SMTP_USER', 'info@krymking.ru' );  
define( 'SMTP_PASS', 'mtgljmmagbulkiqh' );
define( 'SMTP_HOST', 'smtp.yandex.ru' );
define( 'SMTP_FROM', 'info@krymking.ru' );
define( 'SMTP_NAME', 'Krymking' );
define( 'SMTP_PORT', '465' );
define( 'SMTP_SECURE', 'ssl' );
define( 'SMTP_AUTH', true );
define( 'SMTP_DEBUG', 0 );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
