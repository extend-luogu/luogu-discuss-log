<?php

require_once('config.php');
require_once('lib.php');
session_cache_limiter('private');
session_start();

header("Cache-control: max-age=60");

if (!isset($_GET['url']) && (!isset($_GET['thread']) || !isset($_GET['page']))) {
    header('HTTP/1.1 404 Not Found');
    die();
}

$thread = intval($_GET['thread']);
$pg = intval($_GET['page']);

if (isset($_GET['url'])) {
    $parsed = parse_url($_GET['url']);
    $thread = intval(basename($parsed['path']));
    parse_str($parsed['query'], $out);
    $pg = intval($out['page']);
    if ($pg == 0) $pg = 1;
}

$arr = $link->query("select * from discuss_log where thread=$thread and page=$pg")->fetch_assoc();

$url = "https://www.luogu.com.cn/discuss/$thread?page=$pg";

$arr['click'] = addClick($thread);
$tq = $link->query("select reply_count, title from discuss_count where thread=$thread");


date_default_timezone_set("Asia/Shanghai");
$tim = strtotime($arr['time']);
$timstr = date('Y-m-d H:i:s', strtotime("+0 hours", $tim)); // time adjust


if (!$tq->num_rows) {
    $arr['title'] = '还未保存过QwQ, 请点击下方更新以保存';
    $timstr = '将来某时';
} else {
    $rs = $tq->fetch_assoc();
    $arr['title'] = $rs['title'];
    $arr['reply_count'] = $rs['reply_count'];
}

if ($arr['content'] == 'None') {
    $arr['title'] = '这个帖子在被保存之前就被删除了QwQ';
    $arr['content'] = '';
}

$pgs = 1;

if ($arr['reply_count'] == -1) {
    $pgs = $link->query("select count(*) from discuss_log where thread = $thread")->fetch_row()[0];
    $arr['reply_count'] = 'N/A';
} else {
    $pgs = intval(($arr['reply_count'] - 1) / 10) + 1; 
}

$link->close();

$arr['content'] = decompress($arr['content']);

if (isset($_GET['_contentOnly'])) {
    $rs = array(
        'content' => $arr['content'],
        'title' => $arr['title'],
    );
    die(json_encode($rs));
}

function pageLink($p) {
    global $thread;
    echo "/show.php?url=https://www.luogu.com.cn/discuss/$thread?page=$p";
}

?>

<!DOCTYPE html>

<head>
    <title><?php echo $arr['title']; ?></title>
    <?php require_once 'header.php'; ?>
    <script>
    hljs.initHighlightingOnLoad();
    document.addEventListener("DOMContentLoaded", function() {
        renderMathInElement(document.body, {
            delimiters: [{
                left: '$$',
                right: '$$',
                display: true
            }, {
                left: '$',
                right: '$',
                display: false
            }],
            throwOnError: false
        });
    });
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top vluogu-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">洛谷帖子</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">首页</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/list.php">列表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/rank.php">排行</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container" style="margin-top:80px">
        <div class="row">
            <div class="col-sm-8">
                <h2><?php echo $arr['title']; ?></h2>
                <hr />
                <div class="lfe-body">
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
                    <ul class="pagination justify-content-center">
                        <?php if ($pg > 1) { ?>
                        <li class="page-item"><a class="page-link" href="<?php pageLink(1); ?>">«</a></li>
                        <?php } ?>
                        <?php 
                            for ($x = 1; $pg - $x > 1; $x *= 2) ;
                            for ($x /= 2; $x >= 1; $x /= 2) { 
                        ?>
                        <li class="page-item"><a class="page-link" href="<?php pageLink($pg - $x); ?>"><?php echo $pg - $x; ?></a></li>
                        <?php } ?>
                        <li class="page-item active"><a class="page-link" href="#"><?php echo $pg; ?></a></li>
                        <?php for ($x = 1; $pg + $x < $pgs; $x *= 2) { ?>
                        <li class="page-item"><a class="page-link" href="<?php pageLink($pg + $x); ?>"><?php echo $pg + $x; ?></a></li>
                        <?php } ?>
                        <?php if ($pg < $pgs) { ?>
                        <li class="page-item"><a class="page-link" href="<?php pageLink($pgs); ?>">»</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4">
                <section style="background-color: #ffffff;padding: 10px 10px;box-shadow: 0 3px 5px rgb(50 50 93 / 10%), 0 2px 3px rgb(0 0 0 / 8%);">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>访问</th>
                                <td><?php echo $arr['click']; ?></td>
                            </tr>
                            <tr>
                                <th>页数</th>
                                <td><?php echo $pgs; ?></td>
                            </tr>
                            <tr>
                                <th>回复</th>
                                <td><?php echo $arr['reply_count']; ?></td>
                            </tr>
                            <tr>
                                <th>更新</th>
                                <td><?php echo $timstr; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?php echo $url; ?>" class="btn btn-primary" target="_blank">原帖</a>
                    <button type="button" onclick="update('<?php echo $url; ?>')" id="update"
                        class="btn btn-success">点此更新</button>
                    <?php if (isset($_SESSION['admin'])) { ?>
                    <button type="button" class="btn btn-danger" onclick="del(<?php echo $thread; ?>)">
                        删除
                    </button>
                    <?php } ?>
                    <!-- 按钮：用于打开模态框 -->
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"
                        id="openUserGuide">
                        用户指南
                    </button>

                    <!-- 模态框 -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- 模态框头部 -->
                                <div class="modal-header">
                                    <h4 class="modal-title">用户指南</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- 模态框主体 -->
                                <div class="modal-body" id="userguide">
                                </div>

                                <!-- 模态框底部 -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <script>
    let isUpdating = 0;

    function update(url) {
        if (isUpdating)
            return;
        isUpdating = 1
        let h = $('#update').text("正在更新").attr('href');
        $('#update').addClass('disabled');
        $('#update').removeAttr('href');
        $.get(`/save.php?url=${url}`).then((u) => {
            if (u == 'success')
                Toast.fire({
                    icon: "success",
                    title: "更新成功",
                }).then(() => location.reload());
            else Toast.fire({
                icon: "error",
                title: u,
            })
            $('#update').text("点此更新").attr('href', h);
            isUpdating = 0
            $('#update').removeClass('disabled');
        });
    }
    </script>
    <script>
    $("#openUserGuide").on('click', (e) => {
        $.get('/userguide.html').then((u) => $("#userguide").html(u));
    })
    </script>
    <?php if (isset($_SESSION['admin'])) { ?>
    <script>
    function del(thread) {
        $.get(`/delete.php?thread=${thread}`).then((u) => {
            Toast.fire({
                icon: "success",
                title: u,
            }).then(() => history.back());
        })
    }
    </script>
    <?php } ?>
    <?php require_once('footer.php'); ?>
</body>