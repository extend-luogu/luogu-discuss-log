<?php
$imgurl = $_GET['url'];
$parsed = parse_url($imgurl);
if ($parsed['host'] != 'cdn.luogu.com.cn') die('我不是图像代理工具QwQ'); // avoid other use
header('Cache-Control: max-age=31536000'); // cache control
header('Content-type: image/png'); // set content type
echo file_get_contents($imgurl);