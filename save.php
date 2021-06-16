<?php

require_once('config.php');
require_once('get.php');

if (!isset($_GET['url'])) die('请输入url');

$parsed = parse_url($_GET['url']);

$url = $_GET['url'];

if ($parsed['host'] != 'www.luogu.com.cn') die('只能解析洛谷帖子QwQ');

$thread = intval(basename($parsed['path']));
parse_str($parsed['query'], $out);
$page = intval($out['page']);
if ($page == 0) $page = 1;

if ($r = save($thread, $page, $cnt))
    echo 'success';
else
    echo 'failed';

$arr = $link->query("select * from discuss_log where thread=$thread and page=$page")->fetch_assoc();

$r0 = $link->query("select title from discuss_count where thread=$thread");
if ($r0->num_rows) {
    $as = $r0->fetch_assoc();
    if ($as['title'] == '' && $arr['title'] != '')
        $link->query("update discuss_count set title = \"" . $arr['title'] . "\" where thread=$thread");
    $link->query("update discuss_count set click = click + 1 where thread = $thread");
} else {
    $link->query("insert into discuss_count values  ($thread, 1, \"" . $arr["title"] . "\")");
}

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