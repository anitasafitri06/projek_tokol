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
	} else {
	    if (isset($_POST['add'])) {
			$post_username = $_POST['username'];
			$post_password = $_POST['password'];

			$checkdb_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
			$datadb_user = mysqli_fetch_assoc($checkdb_user);
			if (empty($post_username)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua inputs.";
			} else {
				$insert_user = mysqli_query($db, "INSERT INTO users (username, password) VALUES ('$post_username', '$post_password')");
				if ($insert_user == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Data Pengguna berhasil ditambahkan.";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
	    } else if (isset($_POST['edit'])) {
					$post_id = $_POST['id'];
					$post_password = $_POST['status'];
					if (empty($post_id)) {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
					} else {
						$update_user = mysqli_query($db, "UPDATE orders SET status_pesanan = '$post_password' WHERE id = '$post_id'");
						if ($update_user == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Pesanan berhasil diubah.";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}  
		} else if (isset($_POST['delete'])) {
		    $post_id = $_POST['id'];
			$checkdb_user = mysqli_query($db, "SELECT * FROM users WHERE id = '$post_id'");
			if (mysqli_num_rows($checkdb_user) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Data tidak ditemukan.";
			} else {
				$delete_user = mysqli_query($db, "DELETE FROM users WHERE id = '$post_id'");
				if ($delete_user == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Data <b>$post_id</b> dihapus.";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
		}

	include("../../lib/header.php");
?>
							
                        <div class="row">
                            <div class="col-lg-12">
                                    <div class="card-box">
                                        <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-list"></i> Manajemen Transaksi</h4>
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
    										</div>
    										</div>
								            <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
												<thead>
													<tr class="text-uppercase">
														<th>ID</th>
														<th>Invoice ID</th>
														<th>Nama Barang</th>
														<th>Nama Pemesan</th>
														<th>Total Harga</th>
														<th>Tgl Pesanan</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
												<?php
// start paging config
$query_list = "SELECT * FROM orders ORDER BY id DESC"; // edit

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
													    <td><a href="javascript:;" onclick="users('<?php echo $cfg_baseurl; ?>admin/userss/detail/index.php?id=<?php echo $data_show['id']; ?>')" class="badge badge-info">#<?php echo $data_show['id']; ?></a></td>  
													    <td><?php echo $data_show['invoice']; ?></td>
														<td><?php echo $data_show['nama_barang']; ?></td>
														<td><?php echo $data_show['nama']; ?></td>
														<td><?php echo $data_show['biaya']; ?></td>
														<td><?php echo $data_show['tgl_pesan']; ?></td>
														<td align="center">
														<a href="javascript:;" onclick="users('<?php echo $cfg_baseurl; ?>admin/userss/delete/index.php?id=<?php echo $data_show['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
														<a href="javascript:;" onclick="users('<?php echo $cfg_baseurl; ?>admin/userss/edit/index.php?id=<?php echo $data_show['id']; ?>')" class="btn btn-sm btn-info"><i class="fa fa-edit" title="Edit"></i></a>
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
	<script type="text/javascript">
        function users(url) {
        	$.ajax({
        		type: "GET",
        		url: url,
        		beforeSend: function() {
        			$('#modal-detail-body').html('Sedang memuat...');
        		},
        		success: function(result) {
        			$('#modal-detail-body').html(result);
        		},
        		error: function() {
        			$('#modal-detail-body').html('Terjadi kesalahan.');
        		}
        	});
        	$('#modal-detail').modal();
        }
    </script>
    
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
    	<div class="modal-dialog modal-dialog-centered modal-lg">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    				<h4 class="modal-title text-center"><i class="fa fa-numbers"></i> Data Pengguna</h4>
    			</div>
    			<div class="modal-body" id="modal-detail-body">
    			</div>
    			<div class="modal-footer">
    				<button type="button" class="btn btn-light" data-dismiss="modal">Tutup</button>
    			</div>
    		</div>
    	</div>
    </div>
<?php
	include("../../lib/footer.php");
	}
} else {
	header("Location: ".$cfg_baseurl."admin");
}
?>