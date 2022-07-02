<?php
  //первый способ обявления переменных
  define ('SITE_NAME', "Cut Your URL");
  define ('URL_CHARS', "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-");

  require_once(realpath($_SERVER["DOCUMENT_ROOT"]) . '/vendor/autoload.php');

  // Looing for .env at the root directory
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();

  /* важная команда, благодаря ней стартует сессия и туда можно записывать данные */
  session_start();