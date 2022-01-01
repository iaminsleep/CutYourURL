<?php
  require_once('../requires/functions.php');

  if(!$isAuth) redirect();

  if(isset($_POST['link-id']) || !empty($_POST['link-id']) && isset($_POST['link']) && !empty($_POST['link'])) {
    $linkId = $_POST['link-id'];
    $modifiedLink = $_POST['link'];
    
    edit_link($linkId, $modifiedLink);
  }

  redirect('profile.php');