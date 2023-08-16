<?php 
require('koneksi.php');
require('auth.php');
include('limitKata.php');
$limit = new limit();
 // Check If form submitted, insert form data into users table.
 if(isset($_POST['submit'])) {
	 $nama = $_POST['nama'];
	 $luas = $_POST['luas'];
	 $des = $_POST['des'];
	 $tempat = $_POST['tempat'];
	 $query =  "INSERT INTO `lahan` ( `nama_lahan`, `luas_lahan`, `tempat`, `deskripsi`, `status`) VALUES ( '$nama','$luas','$tempat','$des','kosong')";
	 $result = mysqli_query($koneksi,$query);
 }
 if(isset($_POST['update'])) {
	$id=$_POST['id'];
	$nama = $_POST['nama'];
	 $luas = $_POST['luas'];
	 $des = $_POST['des'];
	 $tempat = $_POST['tempat'];
	
	$query =  "UPDATE `lahan` SET `nama_lahan`='$nama',`luas_lahan`='$luas',`tempat`='$tempat',`deskripsi`='$des' WHERE id_lahan='$id'";
	$result = mysqli_query($koneksi,$query);
}
if(isset($_POST['delete'])){
	$id=$_POST['id'];
	$query =  "DELETE FROM lahan WHERE id_lahan='$id'";
	$result = mysqli_query($koneksi,$query);
}

 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Lahan</title>
		<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/logo_edifarm.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/logo_edifarm.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/logo_edifarm.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />
	</head>
	<body>
		<?php include 'header.php'; ?>
		
		<div class="right-sidebar">
		<?php include 'rightbar.php'; ?>
		</div>

		<?php include 'sidebar.php'; ?>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
				<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Lahan</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="dashboard.php">Dashboard</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Lahan
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<?php 
						$query = "SELECT * FROM lahan";
						$result = mysqli_query($koneksi,$query);
						while($row= $row = mysqli_fetch_array($result)){
							$id=$row["id_lahan"];
							$status=$row["status"];
							$des=$row['deskripsi'];
						?>
						<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
							<div class="card card-box text-center">
								<div class=" d-flex justify-content-between pb-10">
									<img class="card-img-top" src="vendors/images/gambarlahan_2.png" alt=""/>
									
								</div>
								<div class="card-body">
									<h5 class="card-title weight-500 text-left"><?php echo $row["nama_lahan"];?></h5>
									<p class="card-text text-left"><?= $limit->limit_kata($des,5) ;?></p>
									<p class="card-text text-left"><?= $status?></p>
									<div>
										<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#detail<?= $row["id_lahan"];?>" >Detail</a>
										<div
											class="modal fade bs-example-modal-lg"
											id="detail<?php echo $row["id_lahan"];?>"
											tabindex="-1"
											role="dialog"
											aria-labelledby="myLargeModalLabel"
											aria-hidden="true"
										>
											<div class="modal-dialog modal-lg modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title" id="myLargeModalLabel">
														<?= $row["nama_lahan"];?>
														</h4>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
															×
														</button>
													</div>
													<div class="modal-body">
														<form action="lahan.php" method="POST">
															<input hidden class="form-control" value="<?= $id?>" type="text" name="id">
															<div class="form-group row">
																<label class="col-sm-12 col-md-2 col-form-label" for="des">Nama Lahan</label>
																<div class="col-sm-12 col-md-10">
																	<input class="form-control" value="<?= $row["nama_lahan"];?>" type="text" name="nama">
																</div>
															</div>									
															
															<div class="form-group row">
																<label class="col-sm-12 col-md-2 col-form-label" for="des">Tempat</label>
																<div class="col-sm-12 col-md-10">
																	<input class="form-control" value="<?= $row["tempat"];?>" type="text" name="tempat">
																</div>
															</div>	
															<div class="form-group row">
																<label class="col-sm-12 col-md-2 col-form-label" for="des">Deskripsi</label>
																<div class="col-sm-12 col-md-10">
																	<input class="form-control" value="<?= $row["deskripsi"];?>" type="text" name="des">
																</div>
															</div>	
															<div class="form-group row">
																<label class="col-sm-12 col-md-2 col-form-label" for="des">Status</label>
																<div class="col-sm-12 col-md-10">
																	<input disabled class="form-control" value="<?= $status?>" type="text" name="tempat">
																</div>
															</div>	
															<div class="form-group row">
																<label class="col-sm-12 col-md-2 col-form-label" for="des">Luas Lahan</label>
																<div class="col-sm-12 col-md-10">
																	<input class="form-control" value="<?= $row["luas_lahan"];?>" type="text" name="luas" onkeypress="return inputAngka(event)">
																</div>
															</div>	
															
														</div>
														<div class="modal-footer">
															<input type="submit" name="delete" class="btn btn-primary" value="Delete" onclick="return confirm('Yakin ingin hapus data?')">	
															<button type="button" class="btn btn-secondary" data-dismiss="modal" alt="add-modal-kar">Close</button>
															<input type="submit" name="update" class="btn btn-primary" value="Update" onclick= "">
														</div>
													</form>	
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>		
		<div class="add-modal-kar">
			<button href="#" class="welcome-modal-btn" data-toggle="modal" data-target="#tambahlahan">(+) Tambah</button>
		</div>
		
		<div class="modal fade bs-example-modal-lg"
			id="tambahlahan"
			tabindex="-1"
			role="dialog"
			aria-labelledby="myLargeModalLabel"
			aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myLargeModalLabel">Tambah Lahan</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" alt="add-modal-kar">x</button>
					</div>
					<div class="modal-body">						
						<form action="lahan.php" method="POST">
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="nama">Nama Lahan</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" type="nama" placeholder="Lahan" name="nama" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="des">Deskripsi</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" placeholder="Dataran tinggi" type="des" name="des" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="tempat">Tempat</label>
								<div class="col-sm-12 col-md-10">
									<input class="form-control" placeholder="Jember" type="tempat" name="tempat" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label" for="luas">Luas Lahan</label>
								<div class="col-sm-12 col-md-10" >
									<input class="form-control" id="luas" type="text" value="0" name="luas" onkeypress="return inputAngka(event)"/>
								</div>
							</div>
							</div>
								<div class="modal-footer">
									<button
										type="button"
										class="btn btn-secondary"
										data-dismiss="modal"
										alt="add-modal-kar"
									>Batal
									</button>
									<input type="submit" name="submit" class="btn btn-primary" value="Simpan" id="sa-success">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- js -->
		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
		<script src="vendors/scripts/advanced-components.js"></script>
		<script>
			function inputAngka(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode
			if (charCode > 31 && (charCode < 48 || charCode > 57))
				return false;
				return true;
			}
		</script>
	</body>
</html>
