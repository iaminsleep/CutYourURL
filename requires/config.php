<?php

//первый способ обявления переменных
define ('SITE_NAME', "Cut Your URL");
define ('HOST', "http://" . $_SERVER['HTTP_HOST']);

//второй способ
const DB_HOST = '127.0.0.1';
const DB_NAME = 'cut_url';

const DB_USER = 'root';
const DB_PASS = 'phpuser420';