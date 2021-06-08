<?php

require_once('config.php');

$r1 = $link->query("select count(*) from discuss_log where 1")->fetch_row();

echo $r1[0];

$link->close();