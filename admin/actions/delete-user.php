<?php
  require_once('../../requires/admin_functions.php');
  require_once('../../requires/default_functions.php');

  if(!$isAdmin) redirect(); /* данное действие могут выполнять только админы */

  $userId = $_GET['id'];
  
  if(!isset($userId) || empty($userId)) {
    $_SESSION['error'] = 'Произошла ошибка';
  }

  else {
    deleteUser($userId);
  }

  redirect('admin/manage_users.php');