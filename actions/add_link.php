<?php
  require_once('../requires/functions.php');

  if(!$isAuth) redirect(); /* данное действие могут выполнять только авторизированные пользователи */
  
  /* если идентификатор не установлен, или ссылка пустая, перекидывает на страницу профиля */
  if(isset($_POST['link']) || !empty($_POST['link']) && isset($_POST['user-id']) && !empty($_POST['user-id'])) {
    add_link($_POST['user-id'], $_POST['link']);
  }

  redirect('profile.php');