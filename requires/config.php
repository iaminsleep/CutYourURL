<?php
  //первый способ обявления переменных
  define ('SITE_NAME', "Cut Your URL");
  define ('HOST', $_ENV['APP_URL']);
  define ('URL_CHARS', "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-");

  //второй способ
  const DB_HOST = $_ENV['DB_HOST'];
  const DB_NAME = $_ENV['DB_NAME'];

  const DB_USER = $_ENV['DB_USER'];
  const DB_PASS = $_ENV['DB_PASS'];

  const ADMIN_LOGIN = $_ENV['ADMIN_LOGIN'];
  const ADMIN_PASSW = $_ENV['ADMIN_PASSW'];

  /* важная команда, благодаря ней стартует сессия и туда можно записывать данные */
  session_start();