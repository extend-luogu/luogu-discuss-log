<?php
require_once('config.php');
header("Cache-control: max-age=3600");
?>

<!DOCTYPE html>

<head>
    <title>洛谷帖子保存站</title>
    <?php require_once 'header.php'; ?>
</head>

<body>
    <div class="container mainindex">
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
    <script>
    $('button').click(() => {
        if ($('input').val() == '') window.alert('请输入链接URL');
        else window.location.href = '/search.php?s=' + $('input').val();
    })
    </script>
    <style>
    .jumbotron {
        bottom: 0;
        position: fixed;
    }
    .mainindex {
        width: 800px;
        height: 400px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>
    <?php require_once('footer.php'); ?>
</body>