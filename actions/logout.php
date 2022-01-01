<?php
  require_once('../requires/functions.php');
  
  if(!$isAuth) redirect();

  session_destroy();
  redirect();