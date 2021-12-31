<?php
  //первый способ обявления переменных
  define ('SITE_NAME', "Cut Your URL");
  define ('HOST', "http://" . $_SERVER['HTTP_HOST']);
  define ('URL_CHARS', "abcdefghijklmnopqrstuvwxyz0123456789-");

  //второй способ
  const DB_HOST = '127.0.0.1';
  const DB_NAME = 'cut_url';

  const DB_USER = 'root';
  const DB_PASS = 'phpuser420';

  /* важная команда, благодаря ней стартует сессия и туда можно записывать данные */
  session_start();