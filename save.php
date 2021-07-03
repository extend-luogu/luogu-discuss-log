<?php

require_once('config.php');
require_once('lib.php');

if (!isset($_GET['url'])) die('请输入url');

$parsed = parse_url($_GET['url']);

$url = $_GET['url'];

if ($parsed['host'] != 'www.luogu.com.cn') die('只能解析洛谷帖子QwQ');

$thread = intval(basename($parsed['path']));
parse_str($parsed['query'], $out);
$page = intval($out['page']);
if ($page == 0) $page = 1;

if ($thread < $st_thread) die('帖子超出时间范围');

if ($r = save($thread, $page, $cnt))
    echo 'success';
else
    echo 'failed';

addClick($thread, $arr['title']);

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
    if ($q->num_rows) continue;
    $r = save($thread, $npage, $cnt);
    if ($cnt < 11 || !$r) break; // stop
}

$link->close();
