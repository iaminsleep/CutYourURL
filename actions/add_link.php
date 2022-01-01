<?php
  require_once('../requires/functions.php');

  if(!$isAuth) redirect(); /* данное действие могут выполнять только авторизированные пользователи */
  
  if(isset($_POST['link']) || !empty($_POST['link']) && isset($_POST['user-id']) && !empty($_POST['user-id'])) {
    $userId = $_POST['user-id'];
    $newLink = $_POST['link'];
    
    add_link($userId, $newLink);
  }

  redirect('profile.php');