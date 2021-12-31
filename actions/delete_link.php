<?php
  require_once('../requires/functions.php');

  if(!$isAuth) redirect(); /* данное действие могут выполнять только авторизированные пользователи */
  
  /* если идентификатор не установлен, или ссылка пустая, перекидывает на страницу профиля */
  if(!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('profile.php');
  }

  else {
    delete_link($_GET['id']);
  }

  redirect('profile.php');
  