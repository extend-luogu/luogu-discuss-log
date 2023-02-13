<?php

ini_set("display_errors", "0");

$admin_pass = $_ENV["ADMIN_PASSWORD"];
$st_thread  = 0; // thread less than this wouldn't be recorded

$cookie = '__client_id=' . $_ENV["CLIENT_ID"] . ';_uid=' . $_ENV["UID"] . ';';

$announce_ver = 1; // update this each time you update the announcement. this is used to control cache policy

$start = microtime(true); // to get the time of rendering
$link  = new mysqli("mysql", "root", "", $_ENV["MYSQL_DATABASE"]); // init db connection
mysqli_set_charset($link, "utf8"); // set charset
if (!$link)
    die('QwQ 数据库挂了');

function mix($u)
{
    return '1919810' . $u . '114514';
}
