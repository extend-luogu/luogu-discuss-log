<?php

require_once('config.php');
header("Cache-control: max-age=60");

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
    <?php require_once 'header.php'; ?>
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
                            <a
                                href="/show.php?url=https://www.luogu.com.cn/discuss/show/<?php echo $va['thread']; ?>"><?php echo $va['title']; ?></a>
                            <br />
                            <span class="lg-small">id: <?php echo $va['thread']; ?>
                            </span>
                        </div>
                    </div>
                    <?php } ?>

                    <div class="pagination-centered">
                        <ul class="am-pagination am-pagination-centered">
                            <?php if ($pg > 1) { ?>
                            <li><a href="/list.php?page=<?php echo $pg - 1; ?>"><</a>
                            </li>
                            <?php }
                            if ($cnt == $pgsiz) { ?>
                            <li><a href="/list.php?page=<?php echo $pg + 1; ?>">></a>
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