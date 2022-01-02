<?php
  require_once '../requires/functions.php';

  if(!$isAuth) redirect();

  //проверка аватара на вредоносность и прочее
  if(isset($_POST['set_avatar']) && !empty($_FILES['avatar']['name'])) {
    $currentAvatar = get_user_avatar($_SESSION['user']['id']);
    $avatar = $_FILES['avatar'];

    $name = $avatar['name'];
    $type = $avatar['type'];
    $size = $avatar['size'];

    $blacklist = array(".php", ".js", ".html");

    foreach($blacklist as $row) {
      if(preg_match("/$row\$/i", $name)) {
        return false;
      }
    }
    if(($type !== "image/png") && ($type !== "image/jpg") && ($type !== "image/jpeg")) {
      return false;
    }
    if($size > 5 * 1024 * 1024) {
      return false;
    }
    else {
      delete_avatar($currentAvatar);
      upload_avatar($_SESSION['user']['id'], $avatar);
    }
  }

  redirect('profile.php');