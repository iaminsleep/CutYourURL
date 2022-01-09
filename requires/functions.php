<?php

require_once('config.php');

require_once('default_functions.php');

/****************************************************
*****************************************************
************Получение основной информации************
*****************************************************
*****************************************************/

function get_user_count() {
  return db_query("SELECT COUNT(id) FROM `users`;")->fetchColumn();
}

function get_links_count() {
  return db_query("SELECT COUNT(id) FROM `links`;")->fetchColumn(); 
}

function get_links_views() {
  $viewsCount = db_query("SELECT SUM(`views`) FROM `links`;")->fetchColumn(); 
  if(empty($viewsCount)) {
    return 0;
  }
  else {
    return $viewsCount;
  }
}

/****************************************************
*****************************************************
*****************Работа с ссылками*******************
*****************************************************
*****************************************************/

function get_link_info($url) { //данные получают из метода GET
  if(empty($url)) return [];
  /* просто fetch, потому что мы всё равно получим только одну строку */
  return db_query("SELECT * FROM `links` WHERE `short_link` = '$url';")->fetch();
}

function upd_link_views($url) {
  if(empty($url)) return false;
  db_query("UPDATE `links` SET `views` = `views` + 1 WHERE `short_link` = '$url';", true);
}

/****************************************************
*****************************************************
******Вспомогательные функции для аутентификации*****
*****************************************************
*****************************************************/

function get_messages($type) {
  if($type === 'error') {
    $error = '';
    if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
      $error = $_SESSION['error'];
      $_SESSION['error'] = '';
      return $error;
    }
  }

  else if($type === 'success') {
    $success = '';
    if(isset($_SESSION['success']) && !empty($_SESSION['success'])) {
      $success = $_SESSION['success'];
      $_SESSION['success'] = '';
      return $success;
    }
  }
}

function show_alert_messages($errorMessage, $successMessage) {
  if (!empty($errorMessage)) {
		echo '<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">'.$errorMessage.
         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
  else if (!empty($successMessage)) {
		echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">'.$successMessage.
         '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }
}

function get_user_info($login) { //данные получают из метода GET
  if(empty($login)) return [];
  /* просто fetch, потому что мы всё равно получим только одну строку */
  return db_query("SELECT * FROM `users` WHERE `login` = '$login';")->fetch();
}

/****************************************************
*****************************************************
***************Регистрация пользователя**************
*****************************************************
*****************************************************/

function add_user($login, $password) {
  $securedPassword = password_hash($password, PASSWORD_DEFAULT);
  //напоминание, true нужен т.к это exec функция
  return db_query("INSERT INTO `users` (`id`, `login`, `password`) VALUES (NULL, '$login', '$securedPassword');", true); 
}

function register_user($authData) {
  if(empty($authData) || !isset($authData['login']) || empty($authData['login'])
    || !isset($authData['password']) || empty($authData['password'])
    || !isset($authData['password-confirm']) || empty($authData['password-confirm']))
  return false; 

  $user = get_user_info($authData['login']);
  if(!empty($user)) {
    $_SESSION['error'] = 'Пользователь '.$authData['login'].' уже существует!';
    redirect('register.php');
  }

  if($authData['password'] !== $authData['password-confirm']) {
    $_SESSION['error'] = 'Пароли не совпадают!';
    redirect('register.php');
  }

  if(add_user($authData['login'], $authData['password'])) {
    $_SESSION['success'] = 'Регистрация прошла успешно.';
    redirect('login.php');
  }
}

/****************************************************
*****************************************************
**************Вход пользователя в систему************
*****************************************************
*****************************************************/

$isAuth = isset($_SESSION['user']['id']) && get_user_info($_SESSION['user']['login']);
$isAdmin = isset($_SESSION['isAdmin']);

$userName = $_SESSION['user']['login'];

function login($authData) {
  if(empty($authData) || !isset($authData['login']) || empty($authData['login'])
    || !isset($authData['password']) || empty($authData['password']))
  $_SESSION['error'] = 'Логин или пароль не может быть пустым!';

  $user = get_user_info($authData['login']);

  if($authData['login'] === ADMIN_LOGIN && $authData['password'] === ADMIN_PASSW) {
    $_SESSION['isAdmin'] = true;
    $_SESSION['success'] = 'Добро пожаловать в админку.';
    redirect('admin.php');
  }

  else if(empty($user)) {
    $_SESSION['error'] = 'Пользователь '.$authData['login'].' не был найден в системе!';
    redirect('login.php');
  }

  else if(password_verify($authData['password'], $user['password'])) {
    $_SESSION['user'] = $user;
    $_SESSION['success'] = 'Вы успешно вошли в систему.';
    redirect('profile.php');
  } else {
    $_SESSION['error'] = 'Пароль введён неправильно!';
    redirect('login.php');
  }
}

/****************************************************
*****************************************************
*************Работа с ссылками в профиле*************
*****************************************************
*****************************************************/

function get_user_links($userId) {
  if(filter_var($userId, FILTER_VALIDATE_INT) === false || empty($userId)) return [];
  
  return db_query("SELECT * FROM `links` WHERE `user_id` = '$userId';")->fetchAll();
}

function delete_link($linkId) {
  if(filter_var($linkId, FILTER_VALIDATE_INT) === false || empty($linkId)) return $_SESSION['error'] = 'Произошла ошибка';

  return db_query("DELETE FROM `links` WHERE `links`.`id` = $linkId AND `user_id` = ".$_SESSION['user']['id'], true)
   ? $_SESSION['success'] = 'Ссылка успешно удалена.' 
   : $_SESSION['error'] = 'Произошла ошибка';
}

/* Два вида генерации ссылок, первый вариант генерирует без повторения букв, что делает ссылку менее уникальной */
function generate_link($size = 10) {
  $new_string = str_shuffle(URL_CHARS);
  $cut_string = substr($new_string, 0, $size);
  return $cut_string;
}

/* Усложнённый вариант, ссылки будут более уникальными из-за возможности повторения букв */
function generate_link_complex($size = 10) {
  $new_string = '';
  
  for($i = 0; $i < $size; $i++) {
    $char = substr(URL_CHARS, rand(0, strlen(URL_CHARS)) , 1);
    $new_string .= $char;
  }

  return $new_string;
}

function add_link($userId, $link) {
  if(filter_var($userId, FILTER_VALIDATE_INT) && $userId == $_SESSION['user']['id']) {
    $shortLink = generate_link_complex();

    $_SESSION['success'] = 'Ссылка успешно добавлена.';
    return db_query("INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) 
    VALUES (NULL, '$userId', '$link', '$shortLink', '0');", true);
  } 
  else {
    $_SESSION['error'] = 'Произошла ошибка';
  }
}

function edit_link($linkId, $modifiedLink) {
  if(filter_var($linkId, FILTER_VALIDATE_INT) === false || empty($linkId) || empty($modifiedLink)) return $_SESSION['error'] = 'Произошла ошибка';
  return db_query("UPDATE `links` SET `long_link` = '$modifiedLink' WHERE `links`.`id` = '$linkId' AND `links`.`user_id` = ".$_SESSION['user']['id'], true) 
    ? $_SESSION['success'] = 'Ссылка успешно отредактирована.'
    : $_SESSION['error'] = 'Произошла ошибка';
}

/****************************************************
*****************************************************
******************Топ пользователей******************
*****************************************************
*****************************************************/

function get_users() {
  $topUsers = db_query("SELECT `users`.`id`, `users`.`login`, SUM(`links`.`views`) FROM `users` JOIN `links` ON `links`.`user_id` = `users`.`id` GROUP BY `users`.`id`, `users`.`login` ORDER BY SUM(`links`.`views`) DESC")->fetchAll();
  if(empty($topUsers)) {
    return db_query("SELECT * FROM `users`")->fetchAll();
  }
  else {
    return $topUsers;
  }
}

function get_users_links_count($userId) {
  return db_query("SELECT COUNT(id) FROM `links` WHERE `user_id` = '$userId';")->fetchColumn(); 
}

function get_users_views_count($userId) {
  $viewsCount = db_query("SELECT SUM(`views`) FROM `links` WHERE `user_id` = '$userId';")->fetchColumn(); 
  if(empty($viewsCount)) {
    return 0;
  }
  else {
    return $viewsCount;
  }
}

/****************************************************
*****************************************************
*************Работа с аватаром пользователя**********
*****************************************************
*****************************************************/

function get_user_avatar($userId) {
  return db_query("SELECT `avatar` FROM `users` WHERE `id` = '$userId';")->fetchColumn();
}

function delete_avatar($currentAvatar) {
  if($currentAvatar !== 'noavatar.png' && file_exists("../img/avatars/".$currentAvatar)) {
    unlink("../img/avatars/".$currentAvatar);
  }
  return db_query("UPDATE `users` SET `avatar` = 'noavatar.png' WHERE `users`.`id` = ".$_SESSION['user']['id'], true);
}

function upload_avatar($userId, $file) {
  $type = $file['type'];
  $name = md5(microtime()).'.'.substr($type, strlen("image/"));
  $dir = '../img/avatars/';
  $fullPath = $dir.$name;

  if(move_uploaded_file($file['tmp_name'], $fullPath) && db_query("UPDATE `users` SET `avatar` = '$name' WHERE `users`.`id` = '$userId';", true)) {
    $_SESSION['success'] = "Аватар успешно загружен";
  }
  else {
    $_SESSION['error'] = "Ошибка при загрузке аватара";
  }
}