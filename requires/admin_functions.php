<?php
  require_once 'functions.php';
  require_once 'default_functions.php';

  $isAdmin = isset($_SESSION['isAdmin']);

  if(!$isAdmin) {
    session_destroy();
    redirect();
  }

  