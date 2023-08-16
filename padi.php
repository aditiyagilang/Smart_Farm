<?php 
include('koneksi.php');
require('auth.php');
require('limitKata.php');
$limit = new limit();

$sukses="";
$error="";



if(isset($_POST['submit'])) {
	$jumlah = count($_POST['demo2']);
	$jumlahpupuk = count($_POST['hstpupuk']);
	$jumlahpesti = count($_POST['hstpestisida']);
	// echo $jmlah;
	// echo print_r($_POST);
	// return;
	$nama_padi = $_POST['namaPadi'];
	$durasi = $_POST['durasi'];
	$deskripsi = $_POST['des'];

	$query =  "INSERT INTO jenis VALUES ( '$nama_padi','$deskripsi', '$durasi')";
	$result = mysqli_query($koneksi,$query);

	$query1 = "SELECT id_jenis FROM jenis ORDER BY id_jenis DESC";
	$result1 = mysqli_query($koneksi,$query1);
		$row1 = mysqli_fetch_assoc($result1);
    	$idbaru = $row1["id_jenis"];
	
	// if($jumlah<1 and $_POST['demo2']=0)
	for($i=0;$i<=$jumlah-1;$i++){
		$hst = $_POST['demo2'][$i];

		$query2 =  "INSERT INTO kegiatan VALUES ('$idbaru', 'Irigasi','$hst')";
		$result = mysqli_query($koneksi,$query2);
	}	
	for($i=0;$i<=$jumlahpupuk-1;$i++){
		$hst1 = $_POST['hstpupuk'][$i];

		$query3 =  "INSERT INTO kegiatan VALUES ('$idbaru', 'Pemupukan','$hst1')";
		$result = mysqli_query($koneksi,$query3);
	}	
	for($i=0;$i<=$jumlahpesti-1;$i++){
		$hst2 = $_POST['hstpestisida'][$i];

		$query4 =  "INSERT INTO kegiatan VALUES ('$idbaru', 'Pemberian Pestisida','$hst2')";
		$result = mysqli_query($koneksi,$query4);
	}	
}
if(isset($_POST['hapus'])) {
	$id = $_POST['id'];
	
	$query =  "DELETE from jenis where id_jenis = $id";
	$result = mysqli_query($koneksi,$query);
}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Padi</title>
		<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/logo_edifarm.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/logo_edifarm.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/logo_edifarm.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />
		<link rel="stylesheet" type="text/css" href="src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css"/>
		
		<script>
			function copyForm(){
				$("#asli")
				.clone()
				.appendTo($("#dinamis"))
			};
			function copyForm1(){
				$("#aslipupuk")
				.clone()
				.appendTo($("#dinamispupuk"))
			};
			function copyForm2(){
				$("#aslipestisida")
				.clone()
				.appendTo($("#dinamispestisida"))
			}
		</script>
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
									<h4>Padi</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="dashboard.php">Dashboard</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Padi
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="row clearfix">
						<?php 
						$query = "SELECT * FROM jenis";
						$result = mysqli_query($koneksi,$query);
						while($row = mysqli_fetch_array($result)){
							$id=$row["id_jenis"];
							$des=$row["deskripsi"];
						?>
						<div class="col-lg-3 col-md-6 col-sm-12 mb-30">
							<div class="card card-box text-center">
								<img
									class="card-img-top"
									src="vendors/images/ciherang.jpg"
									alt="Card image cap"
								/>
								<div class="card-body">
									<h5 class="card-title weight-500 text-left"><?= $row["nama_jenis"];?></h5>
									<p class="card-text text-left"><?= $limit->limit_kata($des,5) ;?></p>
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#detailPadi<?=$id?>">Detail</a>
									<div class="modal fade" id="detailPadi<?= $id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<form action="padi.php" method="POST">
												<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Detail Padi</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<input hidden type="text" name="id" value="<?= $id?>" />
													<p class="card-text text-left"><?=$des ?></p>
													<p class="card-text text-left" >Durasi tanam : <?=$row["durasi_tanam"]; ?> hari</p>
													<!-- <div class="form-group">
														<label>Deskripsi</label>
														<input class="form-control form-control-lg" type="text" name="namaPadi" required/>
													</div>
													<div class="form-group">
														<label>Lama tanam</label>
														<input class="form-control form-control-lg" type="text" name="namaPadi" required/>
													</div> -->
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
													<button type="hapus" name="hapus" class="btn btn-primary" onclick="return confirm('Yakin ingin hapus data?')">Hapus</button>
												</div>
												</form>
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
			<button href="#" class="welcome-modal-btn" data-toggle="modal" data-target="#exampleModal">
			(+) Tambah
		</button></div>
		
				<!-- Modal -->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<form action="padi.php" method="POST">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Padi</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
					<ul class="nav nav-tabs customtab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#detail" role="tab">Detail padi</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#irigasi" role="tab">Irigasi</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pupuk" role="tab">Pemupukan</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#pestisida" role="tab">Pestisida</a>
							</li>
						</ul>
						<div class="tab-content">
							<!-- Setting Tab start -->
							<div class="tab-pane fade show active" id="detail" role="tabpanel">
								<div class="profile-setting">
									<ul class="profile-edit-list row">
										<li class="weight-100 col-md-12">
											<div class="form-group">
												<label>Nama Padi</label>
												<input class="form-control form-control-lg" type="text" name="namaPadi" required/>
											</div>
											<div class="form-group">
												<label>Lama Tanam</label>
												<input class="form-control form-control-lg" type="text" name="durasi" onkeypress="return inputAngka(event)" required/>
											</div>
											<div class="form-group">
												<label>Deskripsi</label>
												<textarea class="form-control" name="des" required></textarea>
											</div>
										</li>
									</ul>
								</div>
							</div>
								<div class="tab-pane fade height-100-p" id="irigasi" role="tabpanel">
									<div class="profile-setting">
										<ul class="profile-edit-list row">
											<li class="weight-100 col-md-12">
												<div class="form-group" id="asli">
													<input id="demo2" type="text" value="0" name="demo2[]" onkeypress="return inputAngka(event)"/>
												</div>

												<div class="form-group" id="dinamis">
												</div>
											</li>
										</ul>
										<div class="add-more-task">
											<a
												href="#"
												data-toggle="tooltip"
												data-placement="bottom"
												onclick="copyForm()"
												data-original-title="Add Task"
												><i class="ion-plus-circled"></i> Tambah kolom</a
											>
										</div>
									</div>
								</div>
								<div class="tab-pane fade height-100-p" id="pupuk" role="tabpanel">
									<div class="profile-setting">
										<ul class="profile-edit-list row">
											<li class="weight-100 col-md-12">
												<div class="form-group" id="aslipupuk">
													<input id="hstpupuk[]" class="form-control form-control-lg" value="0"type="text" name="hstpupuk[]" onkeypress="return inputAngka(event)"/>
												</div>
												<div class="form-group" id="dinamispupuk">
													
												</div>
											</li>
										</ul>
										<div class="add-more-task">
											<a
												href="#"
												data-toggle="tooltip"
												data-placement="bottom"
												onclick="copyForm1()"
												data-original-title="Add Task"
												><i class="ion-plus-circled"></i> Tambah kolom</a
											>
										</div>
									</div>
								</div>
								<div class="tab-pane fade height-100-p" id="pestisida" role="tabpanel">
									<div class="profile-setting">
										<ul class="profile-edit-list row">
											<li class="weight-100 col-md-12">
												<div class="form-group" id="aslipestisida">
													<input id="hstpestisida[]" class="form-control form-control-lg" value="0" type="text" name="hstpestisida[]" onkeypress="return inputAngka(event)"/>
												</div>
												<div class="form-group" id="dinamispestisida">
												</div>
											</li>
										</ul>
										<div class="add-more-task">
											<a
												href="#"
												data-toggle="tooltip"
												data-placement="bottom"
												onclick="copyForm2()"
												data-original-title="Add Task"
												><i class="ion-plus-circled"></i> Tambah kolom</a
											>
										</div>
									</div>
								</div>
							<!-- Setting Tab End -->
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" name="submit" class="btn btn-primary">Simpan</button>
					</div>
					</form>
				</div>
			</div>
		</div>
				
							
													
		<!-- welcome modal end -->
		<!-- js -->
		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
		<script src="vendors/scripts/advanced-components.js"></script>
		<script src="src/plugins/sweetalert2/sweetalert2.all.js"></script>
		<script src="src/plugins/sweetalert2/sweet-alert.init.js"></script> 
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
