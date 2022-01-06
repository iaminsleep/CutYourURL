<?php
  require_once 'functions.php';
  require_once 'default_functions.php';

  $isAdmin = isset($_SESSION['isAdmin']);

  if(!$isAdmin) {
    session_destroy();
    redirect();
  }

  function getAllLinks() {
    return db_query("SELECT * FROM `links`")->fetchAll();
  }

  function getAllUsers() {
    return db_query("SELECT * FROM `users`")->fetchAll();
  }
  
  function deleteLink($linkId) {
    if(empty($linkId)) return false;

    if (db_query("DELETE FROM `links` WHERE `links`.`id` = $linkId;", true)) {
      $_SESSION['success'] = 'Ссылка успешно удалена.';
    } else {
      $_SESSION['error'] = 'Произошла ошибка';
    }
  }

  function editLink($linkId, $modifiedLink) {
  if(empty($linkId) || empty($modifiedLink)) return false;

  $_SESSION['success'] = 'Ссылка успешно отредактирована.';
  return db_query("UPDATE `links` SET `long_link` = '$modifiedLink' WHERE `links`.`id` = $linkId;", true);
}
  
function getLinkInfo($url) { //данные получают из метода GET
  if(empty($url)) return [];
  /* просто fetch, потому что мы всё равно получим только одну строку */
  return db_query("SELECT * FROM `links` WHERE `long_link` = '$url';")->fetch();
}

function deleteAvatar($uid) {
  if(empty($uid)) return false;

  return db_query("UPDATE `users` SET `avatar` = 'noavatar.png' WHERE `users`.`id` = $uid", true);
}

function deleteUser($uid) {
  if(empty($uid)) return false;

  return db_query("DELETE FROM `users` WHERE `users`.`id` = $uid", true);
}