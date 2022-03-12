<?php

require_once('config.php');
session_start();

if (!isset($_SESSION['admin'])) die('require pass');

if (isset($_GET['thread'])) {
    $thread = intval($_GET['thread']);
    $link->query("delete from discuss_count where thread = $thread");
    $link->query("delete from discuss_log where thread = $thread");
} else {
    $min_td = $_GET['td'];
    if (!isset($_GET['td'])) $min_td = 1000000;
    $min_clk = $_GET['click'];
    if (!isset($_GET['click'])) $min_clk = 10;

    $link->query("delete from discuss_log where exists (select thread from discuss_count where thread < $min_td and click < $min_clk and discuss_log.thread = discuss_count.thread)");
    $link->query("delete from discuss_count where thread < $st_thread; delete from discuss_log where thread < $st_thread");
    $link->query("delete from discuss_count where thread < $min_td and click < $min_clk");
    // $link->query("delete from discuss_count where not exists (select * from discuss_log where discuss_log.thread = discuss_count.thread)");
}

echo 'success';
