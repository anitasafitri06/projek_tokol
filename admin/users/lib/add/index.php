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
?>
										
		    <div class="row">
		    	<div class="col-md-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-content">
                	                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST">
											<div class="form-group">
												<label>Nama Barang</label>
													<input type="text" name="barang" class="form-control" placeholder="Nama Barang">
											</div>
											<div class="form-group">
												<label>Kategori</label>
											<select type="form-control" class="form-control" name="kategori">
												<option value="Kaos">Kaos</option>
												<option value="Jaket">Jaket</option>
											</select>
											</div>
											<div class="form-group">
												<label>Jenis Produk</label>
												<select type="form-control" class="form-control" name="jenis">
												<option value="New Arrival">New Arrival</option>
												<option value="Umum">Umum</option>
											</select>
											</div>
											<div class="form-group">
												<label>Harga</label>
													<input type="number" name="harga" class="form-control" placeholder="Harga">
											</div>
											<div class="form-group">
												<label>Stok</label>
													<input type="number" name="stok" class="form-control" placeholder="Stok">
											</div>
											<div class="form-group">
												<label>Keterangan</label>
												<textarea name="keterangan" class="form-control" row="3"></textarea>
											</div>
											<div class="form-group">
												<label>Unggah Gambar</label>
													<input type="file" name="gambar" class="form-control" placeholder="Gambar">
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