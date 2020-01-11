<?php
session_start();
require("../../../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else {
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$check_user = mysqli_query($db, "SELECT * FROM barang WHERE br_id = '$post_id'");
			$data_user = mysqli_fetch_assoc($check_user);
			if (mysqli_num_rows($check_user) == 0) {
				header("Location: ".$cfg_baseurl."admin/users/data");
			} else {
?>
										
		    <div class="row">
		    	<div class="col-md-12">
                                    <form class="form-horizontal" role="form" method="POST">
										<div class="form-group">
											<label>ID Barang</label>
												<input type="number" name="id" readonly class="form-control" value="<?php echo $data_user['br_id']; ?>">
										</div>
											 <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning waves-effect" data-dismiss="modal"><i class="fa fa-repeat"></i> Reset</button>
                                            <button type="submit" class="btn btn-danger btn-bordered waves-effect w-md waves-light" name="delete"><i class="fa fa-trash"></i> Hapus</button>
                                        </div>
										</form>
                                    </div>
                    </div>
<?php
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/users/data");
		}
	}
} else {
	header("Location: ".$cfg_baseurl."admin");
}
?>