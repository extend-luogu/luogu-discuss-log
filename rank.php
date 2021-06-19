<?php

require_once('config.php');

$q = $link->query("select * from discuss_count where click > 0 and title != 'None' and title != '' order by click desc limit 20");

$arr = [];
while ($assoc = $q->fetch_assoc()) array_push($arr, $assoc);

$cnt = 0;

?>

<!DOCTYPE html>

<head>
    <title>神帖排行</title>
    <link rel="shortcut icon" type="image/x-icon" href="//www.luogu.com.cn/favicon.ico" media="screen" />
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/dist/main.css" />
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-light fixed-top" style="box-shadow: 0px 1px 3px 0px black;">
        <a class="navbar-brand" href="/">洛谷帖子</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/list.php">列表</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/rank.php">排行</a>
            </li>
        </ul>
    </nav>
    <div class="container" style="margin-top:80px">
        <div class="row">
            <div class="col-sm-12">
                <div class="lg-content-table-left">
                    <?php foreach ($arr as $va) { ?>
                    <div class="am-g lg-table-bg0 lg-table-row">
                        <div class="am-u-md-6">
                            <?php echo ++$cnt; ?>
                            <a
                                href="/show.php?url=https://www.luogu.com.cn/discuss/show/<?php echo $va['thread']; ?>"><?php echo $va['title']; ?></a>
                            <br />
                            <span class="lg-small">访问次数: <?php echo $va['click']; ?>
                            </span>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('footer.php'); ?>
</body>