<?php

require_once('requires/config.php');

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

function get_user_count() {
  return db_query("SELECT COUNT(id) FROM `users`;")->fetchColumn();
}

function get_links_count() {
  return db_query("SELECT COUNT(id) FROM `links`;")->fetchColumn(); 
}

function get_links_views() {
  return db_query("SELECT SUM(`views`) FROM `links`;")->fetchColumn(); 
}

function get_link_info($url) {
  if(empty($url)) return [];
  /* просто fetch, потому что мы всё равно получим только одну строку */
  return db_query("SELECT * FROM `links` WHERE `short_link` = '$url';")->fetch();
}

function upd_link_views($url) {
  if(empty($url)) return false;
  db_query("UPDATE `links` SET `views` = `views` + 1 WHERE `short_link` = '$url';", true);
}
