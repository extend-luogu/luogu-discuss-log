<?php

$admin_pass = 'your pass';
$st_thread = 0; // thread less than this wouldn't be recorded

$start = microtime(true); // to get the time of rendering
$link = new mysqli("localhost", "your username", "your password", "your database name"); // init db connection
mysqli_set_charset($link, "utf8"); // set charset
if (!$link) die('QwQ 数据库挂了');
