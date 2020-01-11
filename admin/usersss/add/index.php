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
?>
										
		    <div class="row">
		    	<div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                	                    <form class="form-horizontal" role="form" method="POST">
											<div class="form-group">
												<label>Username</label>
													<input type="text" name="username" class="form-control" placeholder="Username">
											</div>
											<div class="form-group">
												<label>Password</label>
													<input type="password" name="password" class="form-control" placeholder="Kata Sandi">
											</div>
											 <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning waves-effect" data-dismiss="modal"><i class="fa fa-repeat"></i> Reset</button>
                                            <button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="add"><i class="fa fa-plus"></i> Tambah</button>
                                        </div>
										</form>
                                    </div>
                    </div>
                </div>
            </div>
<?php
	}
} else {
	header("Location: ".$cfg_baseurl."admin");
}
?>