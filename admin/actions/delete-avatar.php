<?php
  require_once('../../requires/admin_functions.php');
  require_once('../../requires/default_functions.php');

  if(!$isAdmin) redirect(); /* данное действие могут выполнять только админы */
  
  $previousPage = str_replace("http://cut-your-url/", "", $_SERVER['HTTP_REFERER']);

  /* если идентификатор не установлен, или ссылка пустая, перекидывает на страницу профиля */
  if(!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'Произошла ошибка';
  }

  else {
    deleteAvatar($_GET['id']);
  }

  redirect($previousPage);