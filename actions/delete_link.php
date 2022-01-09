<?php
  require_once('../requires/functions.php');

  if(!$isAuth) redirect(); /* данное действие могут выполнять только авторизированные пользователи */
  
  $userId = $_GET['id'];
  /* если идентификатор не установлен, или ссылка пустая, перекидывает на страницу профиля */
  if(!isset($userId) || empty($userId)) {
    redirect('profile.php');
  }

  else {
    delete_link($userId);
  }

  redirect('profile.php');
  