<?php
require_once('config.php');
session_start();
if (isset($_GET['pass']) && $_GET['pass'] == $admin_pass) {
    $_SESSION['admin'] = 1;
    echo 'success';
} else echo 'failed';
