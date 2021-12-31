<?php
  require_once('requires/config.php');
  if(!$isAuth) redirect(); /* данное действие могут выполнять только авторизированные пользователи */
  session_destroy();
  header('Location: index.php');