<?php
  require_once('../../requires/functions.php');
  
  if(!$isAdmin) redirect();

  session_destroy();
  redirect();