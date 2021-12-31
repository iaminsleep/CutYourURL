<?php
  require_once('../requires/config.php');
  session_destroy();
  header('Location: ../index.php');