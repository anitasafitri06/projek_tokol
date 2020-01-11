<?php
session_start();
require("../mainconfig.php");
$page_type = "admin";
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else {
	include("../lib/header.php");
	$msg_type = "nothing";

?>
				<!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-info-circle"></i> Data</h4>
                Selamat Datang di Sistem Kontrol Administrator DMSNCLOTH
                </div>
            </div>
        
      <!-- /.row (main row) -->
<?php
	include("../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl."login.php");
}
?>