<?php
require_once('../config.php');
session_start();
if (isset($_GET['verify'])) {
    $rs = $_SESSION['rndstr'];
    $uid = intval($_GET['uid']);
    $cont = file_get_contents("https://www.luogu.com.cn/user/$uid?_contentOnly");
    $nc = json_decode($cont);
    $intro = $nc->currentData->user->introduction;
    $code = substr($intro, 0, 32);
    if ($rs == $code) {
        $hs = password_hash(mix($uid), PASSWORD_DEFAULT);
        $un = substr($hs, 7);
        die($un);
    } else die('failed');
}
$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$len = strlen($str) - 1;
$randstr = '';
for ($i = 0; $i < 32; $i++) {
    $num = mt_rand(0, $len);
    $randstr .= $str[$num];
}
$_SESSION['rndstr'] = $randstr;
?>

<!DOCTYPE html>

<head>
    <title>洛谷帖子保存站 - 验证洛谷账户</title>
    <?php require_once('../header.php'); ?>
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
        <div class=" row">
            <div class="col-sm-12 text-center">
                <br />
                <h2>验证洛谷账号</h2>
                <p>请将<?php echo $randstr; ?>复制到您个人介绍的开头, 验证结束可以删除</p>
                <div data-v-c68c4f54="" data-v-796309f8="" class="search-input" align="center">
                    <div data-v-72107c51="" data-v-c68c4f54="" class="input-group search-filter" data-v-796309f8="">
                        <div data-v-a7f7c968="" data-v-c68c4f54="" class="refined-input input-wrap frame"
                            data-v-72107c51="">
                            <input data-v-a7f7c968="" type="text" placeholder="请输入您的uid" class="lfe-form-sz-middle">
                        </div>
                        <button data-v-370e72e2="" data-v-c68c4f54="" type="button" class="lfe-form-sz-middle"
                            data-v-72107c51=""
                            style="border-color: rgb(52, 152, 219); background-color: rgb(52, 152, 219);">
                            提交
                        </button>
                    </div>
                </div>
                <div id="show-token"></div>
                <br /> <br /> <br />
            </div>
        </div>
    </div>
    <script>
    const toast = Swal.mixin({
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
    $('button').click(() => {
        if ($('input').val() == '') window.alert('请输入您的uid');
        else {
            $.get('/user/verify.php?verify&uid=' + $('input').val())
                .then((u) => {
                    if (u === 'failed')
                        toast.fire({
                            icon: "error",
                            title: "验证失败",
                        });
                    else {
                        toast.fire({
                            icon: "success",
                            title: "验证成功",
                        });
                        $("#show-token").html(`<p>您的token是${u}</p>`)
                    }
                });
        }
    })
    </script>
    <?php require_once('../footer.php'); ?>
</body>