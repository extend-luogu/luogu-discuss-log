<?php

require_once('config.php');

if (isset($_GET['totalpage'])) {
    header("Cache-control: max-age=120");
    header('Content-type: text/plain');  
    $r1 = $link->query("select count(*) from discuss_log where 1")->fetch_row();

    die($r1[0]);
}

if (isset($_GET['announcement'])) {
    header("Cache-control: max-age=3600");
    header('Content-type: text/plain'); 
    die("$announce_ver");
}

if (isset($_GET['ban'])) {
    session_start();
    if (!isset($_SESSION['admin'])) die('require pass');
    $id = intval($_GET['id']);
    $link->query("insert into banlist values ($id)");
    die('success');
}
if (isset($_GET['deban'])) {
    session_start();
    if (!isset($_SESSION['admin'])) die('require pass');
    $id = intval($_GET['id']);
    $link->query("delete from banlist where banid = $id");
    die('success');
}

$link->close();