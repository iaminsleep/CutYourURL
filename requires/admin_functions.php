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
    if(filter_var($linkId, FILTER_VALIDATE_INT) === false || empty($linkId)) return $_SESSION['error'] = 'Произошла ошибка';

    return db_query("DELETE FROM `links` WHERE `links`.`id` = '$linkId';", true) 
      ? $_SESSION['success'] = 'Ссылка успешно удалена.'
      : $_SESSION['error'] = 'Произошла ошибка';
  }

  function editLink($linkId, $modifiedLink) {
  if(filter_var($linkId, FILTER_VALIDATE_INT) === false || empty($linkId) || empty($modifiedLink)) return $_SESSION['error'] = 'Произошла ошибка';
  
  return db_query("UPDATE `links` SET `long_link` = '$modifiedLink' WHERE `links`.`id` = '$linkId';", true)
    ? $_SESSION['success'] = 'Ссылка успешно отредактирована.'
    : $_SESSION['error'] = 'Произошла ошибка';
}
  
function getLinkInfo($linkId) { //данные получают из метода GET
  if(empty($linkId)) return false;
  /* просто fetch, потому что мы всё равно получим только одну строку */
  return db_query("SELECT * FROM `links` WHERE `id` = '$linkId';")->fetch();
}

function deleteAvatar($uid) {
  if(filter_var($uid, FILTER_VALIDATE_INT) === false || empty($uid)) return $_SESSION['error'] = 'Произошла ошибка';

  $currentAvatar = get_user_avatar($uid);
  
  if($currentAvatar !== 'noavatar.png' && file_exists("../../img/avatars/".$currentAvatar)) {
    unlink("../../img/avatars/".$currentAvatar);
    return db_query("UPDATE `users` SET `avatar` = 'noavatar.png' WHERE `users`.`id` = '$uid';", true) 
      ? $_SESSION['success'] = 'Аватар пользователя удалён.'
      : $_SESSION['error'] = 'Возникла ошибка при попытке удалить аватар!';
  }
}

function deleteUser($uid) {
  if(filter_var($uid, FILTER_VALIDATE_INT) === false || empty($uid)) return $_SESSION['error'] = 'Произошла ошибка';

  deleteAvatar($uid);
  $userLinks = db_query("SELECT * FROM `links` WHERE `user_id` = '$uid';")->fetchAll(); /* не забываем про fetchAll */

  if(empty($userLinks)) {
    return db_query("DELETE FROM `users` WHERE `users`.`id` = '$uid';", true);
  } 
  else {
    return db_query("DELETE `users`,`links` FROM `users` JOIN `links` ON `links`.`user_id` = `users`.`id` WHERE `users`.`id` = '$uid'", true);
  }
}