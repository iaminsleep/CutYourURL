<?php

require_once('requires/config.php');

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
***************Регистрация пользователя**************
*****************************************************
*****************************************************/

function get_user_info($login) { //данные получают из метода GET
  if(empty($login)) return [];
  /* просто fetch, потому что мы всё равно получим только одну строку */
  return db_query("SELECT * FROM `users` WHERE `login` = '$login';")->fetch();
}

function add_user($login, $password) {
  //напоминание, true нужен т.к это exec функция
  return db_query("INSERT INTO `users` (`id`, `login`, `password`) VALUES (NULL, '$login', '$password');", true); 
}

function register_user($authData) {
  if(empty($authData) || !isset($authData['login']) || empty($authData['login'])
    || !isset($authData['password']) || empty($authData['password'])
    || !isset($authData['password-confirm']) || empty($authData['password-confirm']))
  return false; 

  $user = get_user_info($authData['login']);
  if(!empty($user)) {
    $_SESSION['error'] = 'Пользователь '.$authData['login'].' уже существует!';
    header('Location: register.php');
    die;
  }

  if($authData['password'] !== $authData['password-confirm']) {
    $_SESSION['error'] = 'Пароли не совпадают';
    header('Location: register.php');
    die;
  }

  add_user($authData['login'], $authData['password']);
}