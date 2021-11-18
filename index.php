<?php
require_once('config.php');
?>

<!DOCTYPE html>

<head>
    <title>洛谷帖子保存站</title>
    <link rel="shortcut icon" type="image/x-icon" href="//www.luogu.com.cn/favicon.ico" media="screen" />
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/dist/main.css" />
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top vluogu-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">洛谷帖子</a>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" href="/">首页</a>
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
    <div class="container" style="margin-top: 10%; margin-bottom: 15%;">
        <div class="row">
            <div class="col-sm-12 text-center">
                <br />
                <h2><img src="/dist/logo.png" style="width: 120px; margin-bottom: 9px;" />一下</h2>
                <br />
                <br />
                <div data-v-c68c4f54="" data-v-796309f8="" class="search-input" align="center">
                    <div data-v-72107c51="" data-v-c68c4f54="" class="input-group search-filter" data-v-796309f8="">
                        <div data-v-a7f7c968="" data-v-c68c4f54="" class="refined-input input-wrap frame"
                            placeholder="请输入帖子链接URL" data-v-72107c51="">
                            <input data-v-a7f7c968="" type="text" placeholder="请输入帖子链接URL"
                                value="https://www.luogu.com.cn/discuss/317505" class="lfe-form-sz-middle">
                        </div>
                        <button data-v-370e72e2="" data-v-c68c4f54="" type="button" class="lfe-form-sz-middle"
                            data-v-72107c51=""
                            style="border-color: rgb(52, 152, 219); background-color: rgb(52, 152, 219);">
                            洛谷一下
                        </button>
                    </div>
                </div>
                <br />
                <small>这是一个洛谷帖子保存站, 在上方输入URL开始查找以及保存帖子吧</small>
            </div>
        </div>
    </div>
    <script>
    $('button').click(() => {
        if ($('input').val() == '') window.alert('请输入链接URL');
        else window.location.href = '/search.php?s=' + $('input').val();
    })
    </script>
    <?php require_once('footer.php'); ?>
</body>
