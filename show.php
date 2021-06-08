<?php

require_once('config.php');

if (!isset($_GET['url']) && (!isset($_GET['thread']) || !isset($_GET['page']))) {
    header('HTTP/1.1 404 Not Found');
    die();
}

$thread = intval($_GET['thread']);
$page = intval($_GET['page']);

if (isset($_GET['url'])) {
    $parsed = parse_url($_GET['url']);
    $thread = intval(basename($parsed['path']));
    parse_str($parsed['query'], $out);
    $page = intval($out['page']);
    if ($page == 0) $page = 1;
}

$arr = $link->query("select * from discuss_log where thread=$thread and page=$page")->fetch_assoc();

$url = "https://www.luogu.com.cn/discuss/show/$thread?page=$page";

$r0 = $link->query("select title from discuss_count where thread=$thread");
if ($r0->num_rows) {
    $as = $r0->fetch_assoc();
    if ($as['title'] == '' && $arr['title'] != '')
        $link->query("update discuss_count set title = \"" . $arr['title'] . "\" where thread=$thread");
    $link->query("update discuss_count set click = click + 1 where thread = $thread");
} else {
    $link->query("insert into discuss_count values  ($thread, 1, \"" . $arr["title"] . "\")");
}


$aclick = $link->query("select click from discuss_count where thread=$thread")->fetch_assoc();
$link->close();

if (!$aclick['click']) $aclick['click'] = 0;
$arr['click'] = $aclick['click'];

date_default_timezone_set("Asia/Shanghai");
$tim = strtotime($arr['time']);
$timstr = date('Y-m-d H:i:s', strtotime("+0 hours", $tim)); // time adjust

if (!$arr['title']) {
    $arr['title'] = '还未保存过QwQ, 请点击下方更新以保存';
    $timstr = '将来某时';
}

if ($arr['content'] == 'None') {
    $arr['title'] = '这个帖子在被保存之前就被删除了QwQ';
    $arr['content'] = '';
}


?>

<!DOCTYPE html>

<head>
    <title><?php echo $arr['title']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="//www.luogu.com.cn/favicon.ico" media="screen" />
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="/dist/sweetalert2@10.js"></script>
    <link rel="stylesheet" href="/dist/katex.min.css" />
    <script defer src="/dist/katex.min.js"></script>
    <script defer src="/dist/auto-render.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        renderMathInElement(document.body, {
            delimiters: [{
                    left: '$$',
                    right: '$$',
                    display: true
                },
                {
                    left: '$',
                    right: '$',
                    display: false
                }
            ],
            throwOnError: false
        });
    });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top" style="box-shadow: 0px 1px 3px 0px black;">
        <a class="navbar-brand" href="/">洛谷帖子</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/list.php">列表</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/rank.php">排行</a>
            </li>
        </ul>
    </nav>
    <div class="container" style="margin-top:80px">
        <div class="row">
            <div class="col-sm-8">
                <h1><?php echo $arr['title']; ?></h1>
                <hr />
                <div class="lfe-body">
                    <strong>
                        <a href="<?php echo $url; ?>">原帖</a>
                        &nbsp;&nbsp;
                        <a href="javascript: update('<?php echo $url; ?>')" id="update">点此更新</a>
                        &nbsp;&nbsp;
                        总访问数:<?php echo $arr['click'] + 1; ?>
                        &nbsp;&nbsp;
                        上次更新:<?php echo $timstr; ?>
                    </strong>
                    <br /><br />
                    <?php echo $arr['content']; ?>
                    <?php if ($arr['content'] == '') { ?>
                    <div align="center">
                        <script src="https://down.52pojie.cn/.fancyindex/js/phaser.min.js"></script>
                        <script src="https://down.52pojie.cn/.fancyindex/js/catch-the-cat.js"></script>
                        <div id="catch-the-cat"></div>
                        <script>
                        window.game = new CatchTheCatGame({
                            w: 12,
                            h: 11,
                            r: 20,
                            backgroundColor: 16777215,
                            parent: "catch-the-cat",
                            statusBarAlign: "center",
                            credit: "luogulo.gq",
                        });
                        </script>
                        <style type="text/css">
                        .style9 {
                            font-size: 24px;
                            font-family: "楷体_GB2312";
                        }
                        </style>
                    </div>
                    <?php } ?>
                    <div class="pagination-centered">
                        <ul class="am-pagination am-pagination-centered">
                            <?php if ($page > 1) { ?>
                            <li><a
                                    href="/show.php?url=https://www.luogu.com.cn/discuss/show/<?php echo $thread; ?>?page=<?php echo $page - 1; ?>">&lt;</a>
                            </li>
                            <?php } ?>
                            <li><a
                                    href="/show.php?url=https://www.luogu.com.cn/discuss/show/<?php echo $thread; ?>?page=<?php echo $page + 1; ?>">&gt;</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $("img").each((v, u) => {
        let url = new URL(u.src);
        if (url.hostname == "cdn.luogu.com.cn")
            u.src = '/img.php?url=' + u.src;
    });
    $('article a').each((v, u) => {
        if (u.href.includes('https://luogulo.gq/')) u.href = u.href.replace('https://luogulo.gq/',
            'https://www.luogu.com.cn/');
    })
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    function update(url) {
        let h = $('#update').text("正在更新").attr('href');
        $('#update').removeAttr('href');
        $.get(`/save.php?url=${url}`).then((u) => {
            if (u == 'success')
                Toast.fire({
                    icon: "success",
                    title: "更新成功",
                }).then(() => location.reload());
            else Toast.fire({
                icon: "error",
                title: "更新失败, 帖子已被删除",
            })
            $('#update').text("点此更新").attr('href', h);
        });
    }
    </script>

    <style>
    .lg-fg-brown {
        color: #996600 !important;
    }

    .lg-bg-brown {
        background-color: #996600;
    }

    code {
        font-family: monospace, "Courier New";
        font-family: monospace, monospace;
        font-size: 1em;
        padding: 2px 4px;
        color: #c7254e;
        white-space: nowrap;
        border-radius: 0;
    }

    code,
    pre {
        background-color: #f8f8f8;
    }

    .am-pagination>li>a,
    .am-pagination>li>span {
        position: relative;
        display: block;
        padding: .5em 1em;
        text-decoration: none;
        line-height: 1.2;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 0;
        margin-bottom: 5px;
        margin-right: 5px;
    }

    .am-pagination>li {
        display: inline-block;
    }

    .am-pagination {
        position: relative;
        padding-left: 0;
        margin: 1.5rem 0;
        list-style: none;
        color: #999;
    }

    .am-pagination-centered {
        text-align: center;
    }


    .am-badge.am-radius {
        border-radius: 2px;
    }

    .lg-bg-orange {
        background-color: #e67e22;
    }

    .lg-bg-purple {
        background-color: #8e44ad;
    }

    .lg-bg-red {
        background-color: #e74c3c;
    }

    .am-badge {
        display: inline-block;
        min-width: 10px;
        padding: 0.25em 0.625em;
        font-size: 0.8rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        vertical-align: baseline;
        white-space: nowrap;
    }

    .am-badge,
    .am-close,
    .am-icon-btn,
    .am-icon-fw,
    .am-icon-li,
    .am-progress-bar {
        text-align: center;
    }

    .lg-fg-purple {
        color: #8e44ad !important;
    }

    .am-comment-bd> :last-child {
        margin-bottom: 0;
    }

    address,
    blockquote,
    dl,
    fieldset,
    figure,
    hr,
    ol,
    p,
    pre,
    ul {
        margin: 0 0 1.6rem;
    }

    .am-comment-bd img {
        max-width: 100%;
    }

    img {
        border-style: none;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .lg-fg-gray {
        color: #bbb !important;
    }

    .lg-fg-green {
        color: #5eb95e !important;
    }

    .lg-fg-red {
        color: #e74c3c !important;
    }

    .lg-bold {
        font-weight: bold;
    }

    .lg-fg-orange {
        color: #e67e22 !important;
    }

    .am-comment-primary .am-comment-avatar,
    .am-comment-primary .am-comment-main {
        border-color: #0e90d2;
    }

    .am-comment-primary .am-comment-main:before {
        border-right-color: #0e90d2;
    }

    .am-comment-danger .am-comment-main:before {
        border-right-color: #dd514c;
    }

    .am-comment-main:before {
        z-index: 1;
    }

    .am-comment-main:after,
    .am-comment-main:before {
        position: absolute;
        top: 10px;
        left: -8px;
        right: 100%;
        width: 0;
        height: 0;
        display: block;
        content: " ";
        border-color: transparent;
        border-style: solid solid outset;
        border-width: 8px 8px 8px 0;
        pointer-events: none;
    }

    .am-comment-main:after {
        border-right-color: #f8f8f8;
        margin-left: 1px;
        z-index: 2;
    }

    .am-comment-bd {
        word-break: break-all;
        background: #ffffff;
        font-size: 14px;
        padding: 15px;
        overflow: hidden;
    }

    .am-comment-avatar {
        background-image: url(/images/icon.png);
        background-size: 48px, 48px;
        width: 48px;
        height: 48px;
        float: left;
        border-radius: 50%;
        border: 1px solid transparent;
    }


    .am-btn,
    img,
    select {
        vertical-align: middle;
    }

    .am-comment-meta a:not([class]) {
        float: right;
        font-weight: bold;
        margin-left: 1em;
    }

    .am-comment-meta a {
        color: #999;
    }

    .am-comment-meta {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
        padding: 10px 15px;
        line-height: 1.2;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .lg-fg-bluelight {
        color: #0e90d2 !important;
    }

    .am-comment-actions,
    .am-comment-meta {
        color: #999;
        font-size: 13px;
    }

    .am-comment-hd {
        background: #f8f8f8;
        border-bottom: 1px solid #eee;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        border-bottom: none;
    }

    .am-comment-danger .am-comment-avatar,
    .am-comment-danger .am-comment-main {
        border-color: #dd514c;
    }

    .am-comment-main {
        position: relative;
        margin-left: 63px;
        border: 1px solid #dedede;
        border-radius: 0;
    }

    a {
        color: #3498db;
        text-decoration: none;
        background-color: transparent;
    }

    .lg-left {
        float: left !important;
    }

    .am-comment {
        margin-bottom: 25px;
    }

    article,
    aside,
    details,
    footer,
    header,
    summary {
        display: block;
    }

    *,
    :after,
    :before {
        box-sizing: border-box;
    }

    article {
        display: block;
    }

    .lfe-body {
        font-family: -apple-system, BlinkMacSystemFont, "San Francisco",
            "Helvetica Neue", "Noto Sans", "Noto Sans CJK SC", "Noto Sans CJK",
            "Source Han Sans", "PingFang SC", "Segoe UI", "Microsoft YaHei",
            sans-serif;
        font-size: 16px;
        line-height: 1.5;
        color: rgba(0, 0, 0, 0.75);
    }

    body {
        background: aliceblue;
    }
    </style>
    <?php require_once('footer.php'); ?>
</body>