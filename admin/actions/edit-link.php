<?php
  require_once('../../requires/admin_functions.php');
  require_once('../../requires/default_functions.php');

  if(!$isAdmin) redirect();

  if(isset($_POST['link-id']) || !empty($_POST['link-id']) && isset($_POST['link']) && !empty($_POST['link'])) {
    if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i', $_POST['link'])) {
      $linkId = $_POST['link-id'];
      $modifiedLink = $_POST['link'];

      editLink($linkId, $modifiedLink);
    }
    else {
      $_SESSION['error'] = 'Указанный URL-адрес недействителен';
    }
  }

  redirect('admin/manage_links.php');