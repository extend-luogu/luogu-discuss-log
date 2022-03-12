<?php

$pgsiz = 20;

require_once('config.php');
session_start();

$pg = intval($_GET['page']);
if ($pg == 0) $pg = 1;

$jmp = ($pg - 1) * $pgsiz;

$q = $link->query("select * from discuss_count where click > 0 and title != 'None' and title != '' order by thread desc limit $jmp,$pgsiz");

$tot = $link->query("select count(*) from discuss_count where click > 0 and title != 'None' and title != ''")->fetch_row()[0];
$totpg = intval(($tot - 1) / $pgsiz) + 1;

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
                    <a class="nav-link active" href="/list.php">列表</a>
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
                    <?php 
                        $trd = $va['thread'];
                        if ($va['reply_count'] == -1) {
                            $va['reply_count'] = 'N/A';
                            $pgs = $link->query("select count(*) from discuss_log where thread = $trd")->fetch_row()[0];
                        } else {
                            $pgs = intval(($va['reply_count'] - 1) / 10) + 1; 
                        }
                    ?>
                    <div class="am-g lg-table-bg0 lg-table-row">
                        <div class="am-u-md-12 list-item">
                            <a class="list-item-title" href="/show.php?url=https://www.luogu.com.cn/discuss/<?php echo $va['thread']; ?>"><?php echo $va['title']; ?></a>
                            <div class="list-item-info-group">
                                <?php if (isset($_SESSION['admin'])) { ?>
                                <div class="list-item-info">
                                    <a class="badge badge-primary" href="javascript: del(<?php echo $va['thread'] ?>)">删除</a>
                                </div>
                                <?php } ?>
                                <div class="list-item-info">
                                    <span class="lg-small">回复</span>
                                    <span class="lg-small"><?php echo $va['reply_count']; ?></span>
                                </div>
                                <div class="list-item-info">
                                    <span class="lg-small">访问</span>
                                    <span class="lg-small"><?php echo $va['click']; ?></span>
                                </div>
                                <div class="list-item-info">
                                    <span class="lg-small">页数</span>
                                    <span class="lg-small"><?php echo $pgs; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <ul class="pagination justify-content-center">
                        <?php if ($pg > 1) { ?>
                        <li class="page-item"><a class="page-link" href="/list.php?page=1">«</a></li>
                        <?php } ?>
                        <?php 
                            for ($x = 1; $pg - $x > 1; $x *= 2) ;
                            for ($x /= 2; $x >= 1; $x /= 2) { 
                        ?>
                        <li class="page-item"><a class="page-link" href="/list.php?page=<?php echo $pg - $x; ?>"><?php echo $pg - $x; ?></a></li>
                        <?php } ?>
                        <li class="page-item active"><a class="page-link" href="#"><?php echo $pg; ?></a></li>
                        <?php for ($x = 1; $pg + $x < $totpg; $x *= 2) { ?>
                        <li class="page-item"><a class="page-link" href="/list.php?page=<?php echo $pg + $x; ?>"><?php echo $pg + $x; ?></a></li>
                        <?php } ?>
                        <?php if ($pg < $totpg) { ?>
                        <li class="page-item"><a class="page-link" href="/list.php?page=<?php echo $totpg; ?>">»</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php if (isset($_SESSION['admin'])) { ?>
    <script>
    function del(thread) {
        $.get(`/delete.php?thread=${thread}`).then((u) => {
            Toast.fire({
                icon: "success",
                title: u,
            }).then(() => location.reload());
        })
    }
    </script>
    <?php } ?>
    <?php require_once('footer.php'); ?>
</body>