<?php 
  require_once('../requires/functions.php');

  if(!$isAuth) redirect();

  if(isset($_POST['delete_avatar'])) {
    $currentAvatar = get_user_avatar($_SESSION['user']['id']);
    delete_avatar($currentAvatar);
    $_SESSION['success'] = "Аватарка успешно удалена";
  }
  
  redirect('profile.php');