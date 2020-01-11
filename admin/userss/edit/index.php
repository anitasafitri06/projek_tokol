<?php
session_start();
require("../../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."user/logout.php");
	} else {
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$check_user = mysqli_query($db, "SELECT * FROM orders WHERE id = '$post_id'");
			$data_user = mysqli_fetch_assoc($check_user);
			if (mysqli_num_rows($check_user) == 0) {
				header("Location: ".$cfg_baseurl."admin/users/data");
			} else {
?>
										
		    <div class="row">
		    	<div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                	                    <form class="form-horizontal" role="form" method="POST">
                	                        <div class="form-group">
												<label>ID</label>
													<input type="number" name="id" class="form-control" value="<?php echo $data_user['id']; ?>" readonly>
											</div>
											<div class="form-group">
												<label>Status Pembayaran</label>
													<select class="form-control" name="status">
														<option value="<?php echo $data_user['status_pesanan'];?>"><?php echo $data_user['status_pesanan'];?></option>
														<option value="Selesai">Selesai</option>
														<option value="Dibatalkan">Dibatalkan</option>
													</select>
											</div>
											 <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning waves-effect" data-dismiss="modal"><i class="fa fa-repeat"></i> Reset</button>
                                            <button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="edit"><i class="fa fa-edit"></i> Edit</button>
                                        </div>
										</form>
                                    </div>
                    </div>
                </div>
            </div>
<?php
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/users/data");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>