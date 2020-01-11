<?php
session_start();
require("../../../../mainconfig.php");
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."user/logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."user/logout.php");
	} else {
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$check_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
			$data_news = mysqli_fetch_assoc($check_news);
			if (mysqli_num_rows($check_news) == 0) {
				header("Location: ".$cfg_baseurl."admin/news/index");
			} else {
?>
										
		    <div class="row">
		    	<div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                	                    <form class="form-horizontal" role="form" method="POST">
                	                        <div class="form-group">
												<label>ID Berita</label>
													<input type="number" name="id" class="form-control" value="<?php echo $data_news['id']; ?>" readonly>
											</div>
											<div class="form-group">
												<label>Konten</label>
													<textarea name="content" class="form-control"><?php echo $data_news['content']; ?></textarea>
											</div>
											 <div class="modal-footer">
                                            <button type="reset" class="btn btn-warning waves-effect" data-dismiss="modal"><i class="fa fa-repeat"></i> Reset</button>
                                            <button type="submit" class="btn btn-danger btn-bordered waves-effect w-md waves-light" name="delete"><i class="fa fa-trash"></i> Hapus</button>
                                        </div>
										</form>
                                    </div>
                    </div>
                </div>
            </div>
<?php
			}
		} else {
			header("Location: ".$cfg_baseurl."admin/news/index");
		}
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>