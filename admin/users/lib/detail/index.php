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
	} else {
		if (isset($_GET['id'])) {
			$post_id = $_GET['id'];
			$checkdb_user = mysqli_query($db, "SELECT * FROM barang WHERE br_id = '$post_id'");
			$datadb_user = mysqli_fetch_assoc($checkdb_user);
			
			if (mysqli_num_rows($checkdb_user) == 0) {
				header("Location: ".$cfg_baseurl."admin/users/data");
			} else {
?>
										
		    <div class="row">
		    	<div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                	                    <div class="table-responsive">
                                            <table class="table table-stripped" data-page-size="8" data-filter=#filter>
                                                <tr>
													<td><b>ID Barang</b></td>
													<td><?php echo $datadb_user['br_id']; ?></td>
												</tr>
												<tr>
													<td><b>Nama Barang</b></td>
													<td><?php echo $datadb_user['br_nm']; ?></td>
												</tr>
												<tr>
													<td><b>Kategori</b></td>
													<td><?php echo $datadb_user['kategori']; ?></td>
												</tr>
												<tr>
													<td><b>Jenis Produk</b></td>
													<td><?php echo $datadb_user['status']; ?></td>
												</tr>
												<tr>
													<td><b>Stok</b></td>
													<td><?php echo $datadb_user['br_stok']; ?></td>
												</tr>
												<tr>
													<td><b>Keterangan</b></td>
													<td><?php echo $datadb_user['ket']; ?></td>
												</tr>
												<tr>
													<td><b>Harga</b></td>
													<td><?php echo $datadb_user['br_hrg']; ?></td>
												</tr>
												<tr>
													<td><b>Gambar Produk</b></td>
													<td><img src="http://localhost/tokol/<?php echo $datadb_user['br_gbr']; ?>"></td>
												</tr>
						                    </table>
					                    </div>
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
	header("Location: ".$cfg_baseurl."admin");
}
?>