<?php
session_start();
require("mainconfig.php");
$page_type = "user_login";
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) !== 0) {
		header("Location: ".$cfg_baseurl."login");
	}
}
    
    if (isset($_POST['login'])) {
		$post_username = mysqli_real_escape_string($db, htmlspecialchars(trim($_POST['username'])));
		$post_password = mysqli_real_escape_string($db, htmlspecialchars(trim($_POST['password'])));
		
		if (empty($post_username) || empty($post_password)) {
			$msg_type = "error";
			$msg_content = '<b>Gagal:</b> Mohon mengisi semua input.';
		} else {
			$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			if (mysqli_num_rows($check_user) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Usernames tidak ditemukan.";
			} else {
				$data_user = mysqli_fetch_assoc($check_user);
				if ($post_password <> $data_user['password']) {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Password salah.";
				} else {
				    $_SESSION['user'] = $data_user;
				    $sess_username = $_SESSION['user']['username'];
					header("Location: ".$cfg_baseurl."admin");
				}
			}
		}
	}


include("lib/header.php");
?>  
                    <div class="row">
                        <div class="offset-lg-3 col-lg-6">
                    		<div class="card-box">
                    			<h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-sign-in fa-fw"></i> Masuk</h4>
								<?php 
									if ($msg_type == "error") {
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
									<div class="form-group">
										<label>Username</label>
                                            <input type="text" class="form-control" name="username" placeholder="Username">
									</div>
									<div class="form-group">
										<label>Password</label>
											<input type="password" class="form-control" name="password" placeholder="Password">
									</div>
									<div class="pull-right">
                                        <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Ulangi </button>
                                        <button type="submit" name="login" class="btn btn-success"><i class="fa fa-send"></i> Kirim </button>
                                    </div>
                                    <br />
                                    <br />
		                        </form>
                            </div>
                        </div>
    </script>
<?php
include("lib/footer.php");
?>