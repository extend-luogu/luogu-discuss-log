<?php

/*
  things need modifying:
  admin password (LINE 13)
  starting thread (LINE 14)
  cookie (LINE 16)
  database connection (LINE 21)
*/

ini_set("display_errors", "0");

$admin_pass = 'your pass';
$st_thread = 0; // thread less than this wouldn't be recorded

$cookie = '__client_id=<your cid>;_uid=<your uid>;';

$announce_ver = 1; // update this each time you update the announcement. this is used to control cache policy

$start = microtime(true); // to get the time of rendering
$link = new mysqli("localhost", "your username", "your password", "your database name"); // init db connection
mysqli_set_charset($link, "utf8"); // set charset
if (!$link) die('QwQ 数据库挂了');

function mix($u)
{
    return '1919810' . $u . '114514';
}
