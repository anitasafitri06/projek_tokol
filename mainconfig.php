<?php
date_default_timezone_set('Asia/Jakarta');
$db = mysqli_connect("localhost", "root","","cv_db");
if(mysqli_connect_error()) {
    die ("error");
}

$cfg_baseurl = "http://localhost/tokol/";
