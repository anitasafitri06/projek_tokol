<?php
date_default_timezone_set('Asia/Jakarta');
$db = mysqli_connect("localhost", "root","","u8823774_dmsncloth");
if(mysqli_connect_error()) {
    die ("error");
}

$cfg_baseurl = "http://localhost/tokol/";
