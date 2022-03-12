<?php

require_once('config.php');
require_once('lib.php');
session_start();

if (!isset($_GET['url'])) die('请输入url');

$parsed = parse_url($_GET['url']);

$url = $_GET['url'];

if ($parsed['host'] != 'www.luogu.com.cn') die('只能解析洛谷帖子QwQ');

$thread = intval(basename($parsed['path']));
parse_str($parsed['query'], $out);
$page = intval($out['page']);
if (!$page || $page == 0) $page = 1;

$q0 = $link->query("select thread from discuss_count where title != 'None' and title != '' order by thread desc limit 1")->fetch_assoc();
if (!isset($_SESSION['admin']))
    if ($thread < $st_thread || $q0['thread'] - $thread > 700) die('帖子超出时间范围');

if ($r = save($thread, $page, $cnt, $title, $creply)) {
    if ($r == 2) die('帖子标题包含屏蔽词');
    echo 'success';
} else
    echo '帖子已被删除';

$arr = $link->query("select * from discuss_log where thread=$thread and page=$page")->fetch_assoc();

if ($title != 'None') addClick($thread, $title, $creply);
else addClick($thread, $arr['title']);

if (!$r || $cnt < 11) die();

/* begin close the connection to the browser */
$size = ob_get_length();
header("Content-Length: $size");
header("Connection: Close");
ob_flush();
flush();
/* end */


// get more pages after disconnecting
for ($i = 1; $i <= 10; ++$i) {
    $npage = $page + $i;
    $q = $link->query("select title from discuss_log where thread=$thread page=$npage+1");
    // if ($q->num_rows) continue;
    $r = save($thread, $npage, $cnt, $title);
    if ($cnt < 11 || !$r) break; // stop
}

$link->close();