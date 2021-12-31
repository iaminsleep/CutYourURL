<?php

require_once('config.php');

/****************************************************
*****************************************************
*Дефолтные функции, которые используются повсеместно*
*****************************************************
*****************************************************/

function get_url($page = '') {
  return HOST . "/$page";
}

function db() {
  try {
    /* подключение к базе данных */
    $db = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME.";charset=utf8", DB_USER, DB_PASS, [
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $db;
  }

  catch(PDOException $e) {
    die($e->getMessage()); /* завершает выполнение текущего скрипта */
  }
}

/* query возвращает данные из базы данных */
function db_query($sql = '', $exec = false) {
  if(empty($sql)) return false;

  if($exec) {
    /* exec же, в свою очередь, выполняет операции с базой данных,
    такие как удаление, обновление, вставку данных. */
    $statement = db()->exec($sql);
  } else {
    $statement = db()->query($sql);
  }
  return $statement;
}

//функция редиректа, которая значительно облегчает верстку
function redirect($location = '') {
    header("Location: ".get_url($location)); //если значение пустое, перекидывает на главную страницу
    die;
}

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
  return db_query("SELECT SUM(`views`) FROM `links`;")->fetchColumn(); 
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

function get_error_message() {
  $error = '';

	if(isset($_SESSION['error']) && !empty($_SESSION['error'])) {
		$error = $_SESSION['error'];
		$_SESSION['error'] = '';
    return $error;
	}
}

function get_success_message() {
	$success = '';

	if(isset($_SESSION['success']) && !empty($_SESSION['success'])) {
		$success = $_SESSION['success'];
		$_SESSION['success'] = '';
    return $success;
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

$isAuth = isset($_SESSION['user']['id']);
$userName = $_SESSION['user']['login'];

function login_user($authData) {
  if(empty($authData) || !isset($authData['login']) || empty($authData['login'])
    || !isset($authData['password']) || empty($authData['password']))
  $_SESSION['error'] = 'Логин или пароль не может быть пустым!';

  $user = get_user_info($authData['login']);
  if(empty($user)) {
    $_SESSION['error'] = 'Пользователь '.$authData['login'].' не найден в системе!';
    redirect('login.php');
  }

  if(password_verify($authData['password'], $user['password'])) {
    $_SESSION['user'] = $user;
    redirect('profile.php');
  } else {
    $_SESSION['error'] = 'Пароль введён неправильно!';
    redirect('login.php');
  }
}

/****************************************************
*****************************************************
******************Работа с ссылками******************
*****************************************************
*****************************************************/

function get_user_links($userId) {
  if(empty($userId)) return [];
  
  return db_query("SELECT * FROM `links` WHERE `user_id` = $userId;")->fetchAll();
}

function delete_link($linkId) {
  if(empty($linkId)) return false;

  else if (db_query("DELETE FROM `links` WHERE `links`.`id` = $linkId AND `user_id` = '".$_SESSION['user']['id']."'", true)) {
    $_SESSION['success'] = 'Ссылка успешно удалена.';
  } else {
    $_SESSION['error'] = 'Произошла ошибка при удалении ссылки!';
  }
}

function generate_link($size = 6) {
  $new_string = str_shuffle(URL_CHARS);
  $cut_string = substr($new_string, 0, $size);
  return $cut_string;
}

function add_link($userId, $link) {
  if($userId == $_SESSION['user']['id']) {
    $shortLink = generate_link();
    $_SESSION['success'] = 'Ссылка успешно добавлена.';
    return db_query("INSERT INTO `links` (`id`, `user_id`, `long_link`, `short_link`, `views`) 
    VALUES (NULL, '$userId', '$link', '$shortLink', '0');", true);
  } 
  else {
    $_SESSION['error'] = 'Произошла ошибка при добавлении ссылки!';
  }
}