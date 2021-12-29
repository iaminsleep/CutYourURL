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
function db_query($sql = '') {
  if(empty($sql)) return false;

  $statement = db()->query($sql);
  return $statement;
}

/* exec же, в свою очередь, выполняет операции с базой данных,
такие как удаление, обновление, вставку данных. */
function db_exec($sql = '') {
  if(empty($sql)) return false;

  $statement = db()->exec($sql);
  return $statement;
}