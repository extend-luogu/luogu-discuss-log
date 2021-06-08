<?php
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

    $res = $link->real_escape_string($res);
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