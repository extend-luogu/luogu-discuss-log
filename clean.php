<?php

require_once('config.php');

if (!isset($_GET['pass']) || $_GET['pass'] != $admin_pass) die('require pass');

$min_clk = $_GET['click'];
if (!isset($_GET['click'])) $min_clk = 10;

$link->query("delete from discuss_log where exists (select thread from discuss_count where click < $min_clk and discuss_log.thread = discuss_count.thread)");
$link->query("delete from discuss_count where thread < $st_thread; delete from discuss_log where thread < $st_thread");
