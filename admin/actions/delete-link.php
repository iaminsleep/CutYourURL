<?php
  require_once('../../requires/admin_functions.php');
  require_once('../../requires/default_functions.php');

  if(!$isAdmin) redirect(); /* данное действие могут выполнять только админы */
  
  /* если идентификатор не установлен, или ссылка пустая, перекидывает на страницу профиля */
  if(!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('admin/manage_links.php');
  }

  else {
    deleteLink($_GET['id']);
  }

  redirect('admin/manage_links.php');