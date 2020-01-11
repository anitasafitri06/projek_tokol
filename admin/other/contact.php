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
		if (isset($_POST['edit'])) {
			$contact_id = $_GET['contact_id'];
			$post_name = $_POST['name'];
			$post_line = $_POST['line'];
			$post_facebook = $_POST['facebook'];
			$post_whatsapp = $_POST['whatsapp'];
			$checkdb_contact = mysqli_query($db, "SELECT * FROM contact WHERE id = '$contact_id'");
			if (mysqli_num_rows($checkdb_contact) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Kontak tidak ditemukan.";
			} else {
				$delete_staff = mysqli_query($db, "UPDATE contact SET name = '$post_name', line = '$post_line', facebook = '$post_facebook', whatsapp = '$post_whatsapp' WHERE id = '$contact_id'");
				if ($delete_staff == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Kontak berhasil diperbarui.";
				}
			}
		}

	include("../../lib/header.php");
?>
                        <div class="row">
							<div class="col-lg-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-user"></i> Kelola Kontak Admin</h4>
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
										<div class="clearfix"></div>
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover m-0">
											    <div class="alert alert-info"><b>Informasi:</b> Masukan Username Line atau Facebook dan Nomer WA anda sesuai kolom!</div>
												<thead>
													<tr>
													    <th>Nama</th>
														<th>Username LINE</th>
														<th>Username Facebook</th>
														<th>No. WhatsApp</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
$query_list = "SELECT * FROM contact"; // edit
$records_per_page = 10; // edit

$starting_position = 0;
if(isset($_GET["page_no"])) {
	$starting_position = ($_GET["page_no"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
												while ($data_show = mysqli_fetch_assoc($new_query)) {
												?>
													<tr>
													    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?contact_id=<?php echo $data_show['id']; ?>" class="form-inline" role="form" method="POST">
													    <td><input type="text" class="form-control" name="name" value="<?php echo $data_show['name']; ?>"></td>
														<td><input type="text" class="form-control" name="line" value="<?php echo $data_show['line']; ?>"></td>
														<td><input type="text" class="form-control" name="facebook" value="<?php echo $data_show['facebook']; ?>"></td>
														<td><input type="text" class="form-control" name="whatsapp" value="<?php echo $data_show['whatsapp']; ?>"></td>
														
														<td align="center">
														<button type="submit" name="edit" class="btn btn-xs btn-warning"><i class="fa fa-edit" title="Edit"></i></button>
														</td>
														</form>
													</tr>
												<?php
												}
												?>
												</tbody>
											</table>
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