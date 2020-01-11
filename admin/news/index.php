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
	        $post_cat = $_POST['category'];
			$post_content = mysqli_real_escape_string($db, addslashes(htmlspecialchars(trim($_POST['content']))));

			if (empty($post_cat) || empty($post_content)) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
			} else {
				$insert_news = mysqli_query($db, "INSERT INTO news (date, time, category, content) VALUES ('$date', '$time', '$post_cat', '$post_content')");
				if ($insert_news == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Berita berhasil ditambahkan.";
				} else {
					$msg_type = "error";
					$msg_content = "<b>Gagal:</b> Error system.";
				}
			}
		} else if (isset($_POST['edit'])) {
	                $post_id = $_POST['id'];
	                $post_cat = $_POST['category'];
					$post_content = $_POST['content'];
					$checkdb_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
			        if (mysqli_num_rows($checkdb_news) == 0) {
				        $msg_type = "error";
				        $msg_content = "<b>Gagal:</b> Berita tidak ditemukan.";
					} else if (empty($post_content)) {
						$msg_type = "error";
						$msg_content = "<b>Gagal:</b> Mohon mengisi semua input.";
					} else {
						$update_news = mysqli_query($db, "UPDATE news SET category = '$post_cat', content = '$post_content' WHERE id = '$post_id'");
						if ($update_news == TRUE) {
							$msg_type = "success";
							$msg_content = "<b>Berhasil:</b> Berita berhasil diubah.";
						} else {
							$msg_type = "error";
							$msg_content = "<b>Gagal:</b> Error system.";
						}
					}
		} else if (isset($_POST['delete'])) {
			$post_id = $_POST['id'];
			$checkdb_news = mysqli_query($db, "SELECT * FROM news WHERE id = '$post_id'");
			if (mysqli_num_rows($checkdb_news) == 0) {
				$msg_type = "error";
				$msg_content = "<b>Gagal:</b> Berita tidak ditemukan.";
			} else {
				$delete_news = mysqli_query($db, "DELETE FROM news WHERE id = '$post_id'");
				if ($delete_news == TRUE) {
					$msg_type = "success";
					$msg_content = "<b>Berhasil:</b> Berita dihapus.";
				}
			}
		}

	include("../../lib/header.php");
?>

							<div class="row">
							<div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 m-b-30 header-title"><i class="fa fa-list"></i> Kelola Berita</h4>
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
										} else { ?>
										<div class="alert alert-info">
											<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
											<i class="fa fa-times-circle"></i>
											Pisahkan tiap baris pesannya dengan tombol Enter
										</div>
										<?php
										}
										?>
										<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-5">
                                        			<label>Filter Kategori</label>
                                        			<select class="form-control" name="status">
                                        				<option value="">Semua</option>
                                                        <option value="INFO" >INFO</option>
                                                        <option value="SERVICE" >SERVICE</option>
                                                        <option value="UPDATE" >UPDATE</option>
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
										<div class="form-group row">
    										<div class="col-md-6">
    											<a href="javascript:;" onclick="news('<?php echo $cfg_baseurl; ?>admin/news/lib/add/index')" class="btn btn-sm btn-info"><i class="fa fa-plus" title="Tambah"></i>Tambah</a>
    										</div>
    										<div class="col-md-6">
    										</div>
    										</div>
										<div class="table-responsive">
                                           <table class="table table-bordered table-hover">
												<thead>
													<tr class="text-uppercase">
														<th>ID</th>
														<th>Tanggal/Waktu</th>
														<th>Kategori</th>
														<th>Konten</th>
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
	   $query_list = "SELECT * FROM news WHERE content LIKE '%$search%' AND category LIKE '%$status%' ORDER BY id DESC"; // edit
	} else if (empty($search)) {
	   $query_list = "SELECT * FROM news WHERE category LIKE '%$status%' ORDER BY id DESC"; // edit 
	} else if (empty($status)) {
	   $query_list = "SELECT * FROM news WHERE content LIKE '%$search%' ORDER BY id DESC"; // edit 
	} else {
	    $query_list = "SELECT * FROM news ORDER BY id DESC"; // edit
	}
} else {
    $query_list = "SELECT * FROM news ORDER BY id DESC"; // edit
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
												    if($data_show['category'] == "INFO") {
										                $label = "info";
                									} else if($data_show['category'] == "SERVICE") {
                										$label = "primary";
                									} else if($data_show['category'] == "UPDATE") {
										                $label = "warning";
                									} else {
                									    $label = "success";
                									}
												?>
													<tr>
													<td><?php echo $data_show['id']; ?></td>
														<td><?php echo format_date($data_show['date']); ?>, <?php echo $data_show['time']; ?></td>
														<td><span class="badge badge-<?php echo $label; ?>"><?php echo $data_show['category']; ?></span></td>
														<td><?php echo $data_show['content']; ?></td>
														<td align="center">
														<a href="javascript:;" onclick="news('<?php echo $cfg_baseurl; ?>admin/news/lib/edit/index?id=<?php echo $data_show['id']; ?>')" class="btn btn-sm btn-warning"><i class="fa fa-edit" title="Edit"></i></a>
														<a href="javascript:;" onclick="news('<?php echo $cfg_baseurl; ?>admin/news/lib/delete/index?id=<?php echo $data_show['id']; ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
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
        function news(url) {
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
    				<h4 class="modal-title text-center"><i class="fa fa-newspaper-o fa-fw"></i> Berita</h4>
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
	header("Location: ".$cfg_baseurl);
}
?>