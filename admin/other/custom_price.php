<?php
session_start();
require("../../mainconfig.php");
$page_type = "admin";
$msg_type = "nothing";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['level'] != "Developers") {
		header("Location: ".$cfg_baseurl);
	} else {
	    if (isset($_POST['add'])) {
			$post_user = $_POST['user'];
			$post_bonus = $_POST['bonus'];

			$checkdb_bonus = mysqli_query($db, "SELECT * FROM bonus WHERE user = '$post_user'");
			$datadb_bonus = mysqli_fetch_assoc($checkdb_bonus);
			if (empty($post_user) || empty($post_bonus)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon masukan semua input.";
			} else if (mysqli_num_rows($checkdb_bonus) > 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Pengguna: $post_user Sudah terdaftar didatabse.";
			} else {
				$insert_provider = mysqli_query($db, "INSERT INTO bonus (user, bonus) VALUES ('$post_user', '$post_bonus')");
				if ($insert_provider == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Bonus berhasil ditambahkan";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> System Error.";
				}
			}
		} else if (isset($_POST['edit'])) {
	                $post_user = $_POST['user'];
        			$post_bonus = $_POST['bonus'];
					if (empty($post_user) || empty($post_bonus)) {
						$msg_type = "error";
						$msg_content = "<b>Failed:</b> Mohon masukan semua input.";
					} else {
						$update_provider = mysqli_query($db, "UPDATE bonus SET user = '$post_user', bonus = '$post_bonus' WHERE id = '$post_id'");
						if ($update_provider == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Bonus berhasil diubah.";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Failed:</b> Error system.";
						}
					}
		} else if (isset($_POST['delete'])) {
			$post_id = $_GET['id'];
			$checkdb_bonus = mysqli_query($db, "SELECT * FROM bonus WHERE id = '$post_id'");
			if (mysqli_num_rows($checkdb_bonus) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Data tidak ditemukan.";
			} else {
				$delete_news = mysqli_query($db, "DELETE FROM bonus WHERE id = '$post_id'");
				if ($delete_news == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Bonus dihapus.";
				}
			}
		}

	include("../../lib/header.php");
?>

							<div class="row">
							    <!-- sample modal content -->
                            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="custom-width-modalLabel"><i class="fa fa-plus"></i> Tambah Provider</h4>
                                        </div>
                                        <div class="modal-body">
										<form class="form-horizontal" role="form" method="POST">
											<div class="alert alert-info"> Isilah Kolom 'Api ID' dengan 123, apabila tidak digunakan providernya.</div>
											<div class="form-group">
												<label>Pengguna</label>
													<input type="text" name="user" class="form-control" placeholder="example : pengguna">
											</div>
											<div class="form-group">
												<label>Bonus</label>
													<input type="number" name="bonus" class="form-control" placeholder="example : 5">
											</div>
                                        <div class="modal-footer">
                                            <div class="pull-left">
                                            <a href="<?php echo $cfg_baseurl; ?>admin/providers/sosmed.php" class="btn btn-info btn-bordered waves-effect w-md waves-light"><i class="fa fa-arrow-left"></i> Kembali</a>
                                            </div>
                                            <button type="reset" class="btn btn-warning waves-effect" data-dismiss="modal"><i class="fa fa-repeat"></i> Reset</button>
                                            <button type="submit" class="btn btn-success btn-bordered waves-effect w-md waves-light" name="add"><i class="fa fa-plus"></i> Tambah</button>
                                        </div>
                                        </form>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
								<div class="col-lg-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-list"></i> Daftar Provider Medsos</h4>
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
										<div class="form-group row">
										<div class="col-md-6">
											<button data-toggle="modal" data-target="#myModal" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>
										</div>
										<div class="col-md-6">
										</div>
										</div>
										<div class="table-responsive">
                                            <table class="table table-bordered table-hover">
												<thead>
													<tr class="text-uppercase">
														<th>ID</th>
														<th>Pengguna</th>
														<th>Bonus (Persen)</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
    $query_list = "SELECT * FROM bonus ORDER BY id DESC"; // edit

$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												
												while ($data_show = mysqli_fetch_assoc($new_query)) {
												?>
													<tr class="text-uppercase">
													<form action="<?php echo $_SERVER['PHP_SELF']; ?>?provider_id=<?php echo $data_show['id']; ?>" class="form-inline" role="form" method="POST">
													    <td><input type="text" class="form-control" name="id" value="<?php echo $data_show['id']; ?>"></td>
														<td><input type="text" class="form-control" name="user" value="<?php echo $data_show['user']; ?>"></td>
														<td><input type="text" class="form-control" name="bonus" value="<?php echo $data_show['bonus']; ?>"></td>
														<td align="center">
														<button type="submit" name="edit" class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Edit"></i></button>
														<button type="submit" name="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></button>
														</td>
														</form>
													</tr>
												<?php
										
												}
												?>
										</tbody>
											</table>
											<?php include("../../inc/other/pagination.php"); ?>
											</div>
									</div>
								</div>
							</div>
						<!-- end row -->
<?php
	include("../../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>