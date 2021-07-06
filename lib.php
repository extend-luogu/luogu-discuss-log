<?php
require_once('config.php');

function compress($content)
{
    preg_replace('/<article class="am-comment am-comment-danger" data-reply-count="\d+">\n<div class="lg-left">/', '\x021', $content);
    return $content;
}

function decompress($content)
{
    str_replace('\x021', '<article class="am-comment am-comment-danger">\n<div class="lg-left">', $content);
    return $content;
}

function save($thread, $page, &$cnt)
// param thread int: the thread id;
// param page int: the page number;
// param cnt int: the number of replies in this page;
// return int: whether the page is dead(0) or alive(1)
{
    global $link;
    $url = "https://www.luogu.com.cn/discuss/show/$thread?page=$page";

    $cont = file_get_contents($url);

    $cnt = 0;

    preg_match_all('/<article [\d\D]+?<\/article>/', $cont, $res);
    $cnt = count($res[0]);
    $res = implode('', $res[0]);

    preg_match('/<h1>([\d\D]+?)<\/h1>/', $cont, $title);
    $title = $title[1];

    $res = compress($link->real_escape_string($res));
    $title = $link->real_escape_string($title);

    $r1 = $link->query("select time from discuss_log where page=$page and thread=$thread");

    $sql = ' ';
    $ret = 0;
    if ($res == '') {
        if ($r1->num_rows == 0)
            $sql = "insert into discuss_log values ($thread, $page, \"None\", \"None\", NOW())";
        $ret = 0;
    } else {
        $sql = "replace into discuss_log values ($thread, $page, \"$title\", \"$res\", NOW())";
        $ret = 1;
    }

    $link->query($sql);

    return $ret;
}

function addClick($thread, $curtitle)
{
    global $link;
    $r0 = $link->query("select title from discuss_count where thread=$thread");
    if ($r0->num_rows) {
        $as = $r0->fetch_assoc();
        if ($as['title'] == '' && $curtitle != '')
            $link->query("update discuss_count set title = \"" . $curtitle . "\" where thread=$thread");
        $link->query("update discuss_count set click = click + 1 where thread = $thread");
    } else {
        $link->query("insert into discuss_count values  ($thread, 1, \"" . $curtitle . "\")");
    }
    $aclick = $link->query("select click from discuss_count where thread=$thread")->fetch_assoc();
    if (!$aclick['click']) $aclick['click'] = 0;
    return $aclick['click'];
}
