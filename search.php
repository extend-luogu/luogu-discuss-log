<?php

require_once('config.php');

$s = $_GET['s'];

// when entering thread id
if (intval($s) != 0) {
    header("Location: /show.php?thread=$s&page=1");
    die();
}


// when entering thread link
if ($ps = parse_url($s)) {
    parse_str($ps['query'], $out);
    if (intval(basename($ps['path'])) != 0 && $ps['host'] == 'www.luogu.com.cn') {
        header("Location: /show.php?url=$s");
        die();
    }
}

// when entering patterns to match

$cnt = 0;

$link->real_escape_string($s);
$q = $link->query("select * from discuss_count where title != 'None' and title != '' and title like '%$s%' limit 10");

$arr = [];
while ($assoc = $q->fetch_assoc()) array_push($arr, $assoc);

?>

<!DOCTYPE html>

<head>
    <title>讨论列表</title>
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
            <div class="col-sm-12">
                <div class="lg-content-table-left">
                    <?php foreach ($arr as $va) { ?>
                        <div class="am-g lg-table-bg0 lg-table-row">
                            <div class="am-u-md-6">
                                <?php echo $jmp + (++$cnt); /* count */ ?>
                                <a href="/show.php?url=https://www.luogu.com.cn/discuss/<?php echo $va['thread']; ?>"><?php echo $va['title']; ?></a>
                                <br />
                                <span class="lg-small">id: <?php echo $va['thread']; ?>
                                </span>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="pagination-centered">
                        <ul class="am-pagination am-pagination-centered">
                            <?php if ($pg > 1) { ?>
                                <li><a href="/list.php?page=<?php echo $pg - 1; ?>">&lt;</a>
                                </li>
                            <?php }
                            if ($cnt == $pgsiz) { ?>
                                <li><a href="/list.php?page=<?php echo $pg + 1; ?>">&gt;</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once('footer.php'); ?>
</body>
