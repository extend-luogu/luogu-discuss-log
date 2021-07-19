<?php
require_once('config.php');

function compress($content)
{
    $content = preg_replace('/<article class="am-comment am-comment-danger" data-reply-count="\d+">\n<div class="lg-left">/', '\x021', $content);
    $content = preg_replace('/class="am-comment-avatar"\/>\n<\/a><\/div>\n<div class="am-comment-main">\n<header class="am-comment-hd">\n<div class="am-comment-meta"> <span style="margin-right: 3px">@<\/span><a class=/', '\x022', $content);
    $content = preg_replace('/<a data-fd-username=".*?" href="javascript: scrollToId\(\'replyarea\'\)">\u56de\u590d<\/a>/', '', $content);
    $content = preg_replace('/<a style="cursor:pointer" name="report" data-report-type="post_reply" data-report-id="\d+">\n\u4e3e\u62a5\n<\/a>/', '', $content);
    $content = str_replace('https://www.luogu.com.cn', '\x023', $content);
    $content = str_replace('https://cdn.luogu.com.cn', '\x024', $content);
    $content = preg_replace('/<a class="sb_amazeui" target="_blank" href="\/discuss\/show\/142324"><svg xmlns="http:\/\/www.w3.org\/2000\/svg" width="16" height="16" viewBox="0 0 16 16" fill="#5eb95e" style="margin-bottom: -3px;"><path d="M16 8C16 6.84375 15.25 5.84375 14.1875 5.4375C14.6562 4.4375 14.4688 3.1875 13.6562 2.34375C12.8125 1.53125 11.5625 1.34375 10.5625 1.8125C10.1562 0.75 9.15625 0 8 0C6.8125 0 5.8125 0.75 5.40625 1.8125C4.40625 1.34375 3.15625 1.53125 2.34375 2.34375C1.5 3.1875 1.3125 4.4375 1.78125 5.4375C0.71875 5.84375 0 6.84375 0 8C0 9.1875 0.71875 10.1875 1.78125 10.5938C1.3125 11.5938 1.5 12.8438 2.34375 13.6562C3.15625 14.5 4.40625 14.6875 5.40625 14.2188C5.8125 15.2812 6.8125 16 8 16C9.15625 16 10.1562 15.2812 10.5625 14.2188C11.5938 14.6875 12.8125 14.5 13.6562 13.6562C14.4688 12.8438 14.6562 11.5938 14.1875 10.5938C15.25 10.1875 16 9.1875 16 8ZM11.4688 6.625L7.375 10.6875C7.21875 10.8438 7 10.8125 6.875 10.6875L4.5 8.3125C4.375 8.1875 4.375 7.96875 4.5 7.8125L5.3125 7C5.46875 6.875 5.6875 6.875 5.8125 7.03125L7.125 8.34375L10.1562 5.34375C10.3125 5.1875 10.5312 5.1875 10.6562 5.34375L11.4688 6.15625C11.5938 6.28125 11.5938 6.5 11.4688 6.625Z"><\/path><\/svg><\/a>/', '\x025', $content);
    return $content;
}

function decompress($content)
{
    $content = str_replace('\x021', '<article class="am-comment am-comment-danger"><div class="lg-left">', $content);
    $content = str_replace('\x022', 'class="am-comment-avatar"/></a></div><div class="am-comment-main"><header class="am-comment-hd"><div class="am-comment-meta"> <span style="margin-right: 3px">@</span><a class=', $content);
    $content = str_replace('\x023', 'https://www.luogu.com.cn', $content);
    $content = str_replace('\x024', 'https://cdn.luogu.com.cn', $content);
    $content = str_replace('\x025', '<a class="sb_amazeui" target="_blank" href="/discuss/show/142324"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="#5eb95e" style="margin-bottom: -3px;"><path d="M16 8C16 6.84375 15.25 5.84375 14.1875 5.4375C14.6562 4.4375 14.4688 3.1875 13.6562 2.34375C12.8125 1.53125 11.5625 1.34375 10.5625 1.8125C10.1562 0.75 9.15625 0 8 0C6.8125 0 5.8125 0.75 5.40625 1.8125C4.40625 1.34375 3.15625 1.53125 2.34375 2.34375C1.5 3.1875 1.3125 4.4375 1.78125 5.4375C0.71875 5.84375 0 6.84375 0 8C0 9.1875 0.71875 10.1875 1.78125 10.5938C1.3125 11.5938 1.5 12.8438 2.34375 13.6562C3.15625 14.5 4.40625 14.6875 5.40625 14.2188C5.8125 15.2812 6.8125 16 8 16C9.15625 16 10.1562 15.2812 10.5625 14.2188C11.5938 14.6875 12.8125 14.5 13.6562 13.6562C14.4688 12.8438 14.6562 11.5938 14.1875 10.5938C15.25 10.1875 16 9.1875 16 8ZM11.4688 6.625L7.375 10.6875C7.21875 10.8438 7 10.8125 6.875 10.6875L4.5 8.3125C4.375 8.1875 4.375 7.96875 4.5 7.8125L5.3125 7C5.46875 6.875 5.6875 6.875 5.8125 7.03125L7.125 8.34375L10.1562 5.34375C10.3125 5.1875 10.5312 5.1875 10.6562 5.34375L11.4688 6.15625C11.5938 6.28125 11.5938 6.5 11.4688 6.625Z"></path></svg></a>', $content);

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

    $res = $link->real_escape_string(compress($res));
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
