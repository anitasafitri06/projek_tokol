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
		if (isset($_POST['delete'])) {
			$post_id = $_POST['id'];
			$checkdb_user = mysqli_query($db, "SELECT * FROM tickets WHERE id = '$post_id'");
			if (mysqli_num_rows($checkdb_user) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Failed:</b> Tiket tidak ditemukan di database.";
			} else {
				$delete_ticket = mysqli_query($db, "DELETE FROM tickets WHERE id = '$post_id'");
				$delete_ticket = mysqli_query($db, "DELETE FROM tickets_message WHERE ticket_id = '$post_id'");
				if ($delete_ticket == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Success:</b> Ticket dihapus.";
				}
			}
		}

	include("../../lib/header.php");
?>
						
							<div class="row">
							    <div class="col-lg-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-list"></i> Daftar Tiket</h4>
										<?php 
										if ($msg_type == "success") {
										?>
										<div class="alert alert-icon alert-success alert-dismissible fade in" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-check-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										} else if ($msg_type == "error") {
										?>
										<div class="alert alert-icon alert-danger alert-dismissible fade in" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											<i class="fa fa-times-circle"></i>
											<?php echo $msg_content; ?>
										</div>
										<?php
										}
										?>
										<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-5">
                                        			<label>Filter Status</label>
                                        			<select class="form-control" name="status">
                                        				<option value="">Semua</option>
                                                        <option value="Pending" >Pending</option>
                                                        <option value="Waiting" >Waiting</option>
                                                        <option value="Responded" >Responded</option>
                                                        <option value="Closed" >Closed</option>
                                        			</select>
                                        		</div>
                                        		<div class="form-group col-lg-5">
                                        			<label>Kata Kunci Cari</label>
                                        			<input type="text" class="form-control" name="search" placeholder="Kata Kunci..." value="">
                                        		</div>
                                        		<div class="form-group col-lg-2">
                                        			<label>Submit</label>
                                        			<button type="submit" class="btn btn-block btn-dark">Filter</button>
                                        		</div>
                                        	</div>
								        </form>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
												<thead>
													<tr class="text-uppercase">
														<th>Status</th>
														<th>Subjek</th>
														<th>Pengguna</th>
														<th>Tanggal diterima</th>
														<th>Terakhir Update</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
<?php
// start paging config
$search = mysqli_real_escape_string($db, trim($_GET['search']));
$status = mysqli_real_escape_string($db, trim($_GET['status']));
if (isset($search) AND isset($status)) {
	if (!empty($search) AND !empty($status)) {
	   $query_list = "SELECT * FROM tickets WHERE user LIKE '%$search%' OR subject LIKE '%$search%' OR message LIKE '%$search%' AND status LIKE '%$status%' ORDER BY id DESC"; // edit
	} else if (empty($search)) {
	   $query_list = "SELECT * FROM tickets WHERE status LIKE '%$status%' ORDER BY id DESC"; // edit 
	} else if (empty($status)) {
	   $query_list = "SELECT * FROM tickets WHERE user LIKE '%$search%' OR subject LIKE '%$search%' OR message LIKE '%$search%' ORDER BY id DESC"; // edit 
	} else {
	    $query_list = "SELECT * FROM tickets ORDER BY id DESC"; // edit
	}
} else {
    $query_list = "SELECT * FROM tickets ORDER BY id DESC"; // edit
}

$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
// end paging config
while ($data_show = mysqli_fetch_assoc($new_query)) {
	if($data_show['status'] == "Closed") {
		$label = "danger";
	} else if($data_show['status'] == "Responded") {
		$label = "success";
	} else if($data_show['status'] == "Waiting") {
		$label = "info";
	} else {
		$label = "warning";
	}
?>
													<tr>
														<td><label class="badge badge-<?php echo $label; ?>"><?php echo $data_show['status']; ?></label></td>
														<td><?php if($data_show['seen_admin'] == 0) { ?><label class="badge badge-warning">NEW!</label><?php } ?> <?php echo $data_show['subject']; ?></td>
														<td><?php echo $data_show['user']; ?></td>
														<td><?php echo $data_show['datetime']; ?></td>
														<td><?php echo $data_show['last_update']; ?></td>
														<td align="center">
														<a href="<?php echo $cfg_baseurl; ?>admin/ticket/reply.php?id=<?php echo $data_show['id']; ?>" class="btn btn-sm btn-success"><i class="fa fa-reply"></i></a>
														<a href="<?php echo $cfg_baseurl; ?>admin/ticket/close.php?id=<?php echo $data_show['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
														<a href="<?php echo $cfg_baseurl; ?>admin/ticket/delete.php?id=<?php echo $data_show['id']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
														</td>
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