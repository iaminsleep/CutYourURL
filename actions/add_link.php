<?php
  require_once('../requires/functions.php');

  if(!$isAuth) redirect(); /* данное действие могут выполнять только авторизированные пользователи */
  
  if(isset($_POST['link']) || !empty($_POST['link']) && isset($_POST['user-id']) && !empty($_POST['user-id'])) {
    if(strlen($_POST['link']) > 40) {
      $_SESSION['error'] = 'Указанный URL-адрес превышает максимальную длину';
    }
    else if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $_POST['link'])) {
      $userId = $_POST['user-id'];
      $newLink = $_POST['link'];
      
      add_link($userId, $newLink);
    }
    else {
      $_SESSION['error'] = 'Указанный URL-адрес недействителен';
    }
  }

  redirect('profile.php');