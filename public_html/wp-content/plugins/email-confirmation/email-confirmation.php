<?php
/**
 * Plugin Name: Email Confirmation
 * Description: Подтверждение пользователя по электронной почте.
 * Author: SiteUP
 */
class EmailConfirmation
{
  const PREFIX = 'email-confirmation-';

  public static function send($to, $subject, $message, $headers) {
    $token = sha1(uniqid());

    $oldData = get_option(self::PREFIX .'data') ?: array();
    $data = array();
    $data[$token] = $_POST;
    update_option(self::PREFIX .'data', array_merge($oldData, $data));

    wp_mail($to, $subject, sprintf($message, $token), $headers);
  }

  public static function check($token) {
    $data = get_option(self::PREFIX .'data');
    $userData = $data[$token];

    if (isset($userData)) {
      $userdata = array(
        'user_pass' => $userData['password'],
        'user_login' => $userData['email'],
        'user_email' =>  $userData['email'],
        'first_name' => $userData['name'],
        'last_name' => $userData['lastname'],
        'role' => 'tenant'
      );

      $new_user = wp_insert_user($userdata);

      if (!is_wp_error( $new_user ) ) {
        update_user_meta($new_user, 'day', $userData['day']);
        update_user_meta($new_user, 'month', $userData['month']);
        update_user_meta($new_user, 'year', $userData['year']);

        register_user($userData['email']);
      }

      unset($data[$token]);
      update_option(self::PREFIX .'data', $data);
    }

    return $userData;
  }
}