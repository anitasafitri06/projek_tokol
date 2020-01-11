<?php
session_start();
require("../../mainconfig.php");
$page_type = "admin";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM admin WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} 

	include("../../lib/header.php");
	$msg_type = "nothing";

	if (isset($_POST['submit'])) {
	    $post_name = mysqli_real_escape_string($db, trim($_POST['name']));

		if (empty($post_name)) {
			$msg_type = "error";
			$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
		} else {
			$update_web = mysqli_query($db, "UPDATE set_countdown SET time = '$post_name' WHERE id = '2'");
			if ($update_web == TRUE) {
				$msg_type = "success";
				$msg_content = "<b>Berhasil:</b> Data Countdown untuk besok telah diubah.";
			} else {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Error system.";
			}
		}
	}
?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-gear"></i> Kelola Data Website</h4>
                                        <?php 
                						if ($msg_type == "success") {
                						?>
                						<div class="alert alert-success">
                						<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                						<i class="fa fa-check-circle"></i>
                						<?php echo $msg_content; ?>
                						</div>
                						<?php
                						} else if ($msg_type == "error") {
                						?>
                						<div class="alert alert-danger">
                						<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                						<i class="fa fa-times-circle"></i>
                						<?php echo $msg_content; ?>
                						</div>
                						<?php
                						}
                						?>
                                        <form class="form-horizontal" role="form" method="POST">
										    <div class="form-group row">
												<label class="col-md-2 col-form-label">Hari</label>
												<div class="col-md-10">
													<input type="text" class="form-control" name="name" value="<?php echo date("d F Y", strtotime('tomorrow')); ?>">
											    </div>
										    </div>	
										 
											<div class="pull-right">
                                                <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-send"></i> Kirim </button>
                                            </div>
                                            <br />
                                            <br />
										</form>
									
								</div>
							</div>
						</div>
						<!-- end row -->
<?php
	include("../../lib/footer.php");
} else {
	header("Location: ".$cfg_baseurl);
}
?>