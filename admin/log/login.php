<?php
session_start();
require("../../mainconfig.php");
$page_type = "admin";

if (isset($_SESSION['user'])) {
	$sess_username = $_SESSION['user']['username'];
	$check_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sess_username'");
	$data_user = mysqli_fetch_assoc($check_user);
	if (mysqli_num_rows($check_user) == 0) {
		header("Location: ".$cfg_baseurl."logout.php");
	} else if ($data_user['status'] == "Suspended") {
		header("Location: ".$cfg_baseurl."logout.php");
    } else if ($data_user['level'] != "Developers" AND $data_user['level'] != "Admin" AND $data_user['level'] != "Reseller") {
		header("Location: ".$cfg_baseurl);
	} else {

	include("../../lib/header.php");
	$check_wtransfer = mysqli_query($db, "SELECT SUM(quantity) AS total FROM transfer_balance");
	$data_wtransfer = mysqli_fetch_assoc($check_wtransfer);
?>
							
                        <div class="row">
							<div class="col-lg-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-list"></i> Daftar Riwayat Login</h4>
										<div class="table-responsive">
										    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-5">
                                        			<label>Filter Status</label>
                                        			<select class="form-control" name="action">
                                        				<option value="">Semua</option>
                                                        <option value="" >TANGGAL/WAKTU</option>
                                                        <option value="" >ALAMAT IP</option>
                                                        <option value="" >OPERASI SISTEM</option>>
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
													    <th>ID</th>
												    	<th>Pengguna</th>
														<th>Tanggal/Waktu</th>
														<th>Alamat IP</th>
														<th>Operasi Sistem</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
if (isset($_GET['search']) AND isset($_GET['action'])) {
    $search = mysqli_real_escape_string($db, trim($_GET['search']));
	$action = mysqli_real_escape_string($db, trim($_GET['action']));
	if (!empty($search) AND !empty($action)) {
	   $query_list = "SELECT * FROM login_history WHERE ip_address LIKE '%$search%' OR operating_system LIKE '%$search%' ORDER BY id ASC"; // edit
	} else if (empty($search)) {
	   $query_list = "SELECT * FROM login_history ORDER BY id ASC"; // edit
	} else if (empty($action)) {
	   $query_list = "SELECT * FROM login_history WHERE ip_address LIKE '%$search%' OR operating_system LIKE '%$search%' ORDER BY id ASC"; // edit 
	} else {
	    $query_list = "SELECT * FROM login_history ORDER BY id DESC"; // edit
	}
} else {
    $query_list = "SELECT * FROM login_history ORDER BY id DESC"; // edit
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
												?>
													<tr>
													    <td><?php echo $data_show['id']; ?></td>
													    <td><?php echo $data_show['username']; ?></td>
														<td><?php echo $data_show['datetime']; ?></td>
														<td><?php echo $data_show['ip_address']; ?></td>
														<td><?php echo $data_show['operating_system']; ?></td>
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
							</div>
						<!-- end row -->
<?php
	include("../../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl);
}
?>