<?php
	require('auth.php');
	require('koneksi.php');
	$tanggalnow = date('Y-m-d');

	$query5 =  mysqli_query($koneksi,"SELECT * from sesi_tanam where status='belum'");
	if(mysqli_num_rows($query5)>0){ 
	while($data2 = mysqli_fetch_array($query5)){
		$tanggalsesi=$data2["tgl_selesai"];
		if($tanggalsesi>=$tanggalnow){
?>
	<script>
	swal(
		{
			title: 'Good job!',
			text: 'You clicked the button!',
			type: 'success',
			showCancelButton: true,
			confirmButtonClass: 'btn btn-success',
			cancelButtonClass: 'btn btn-danger'
		}
	)</script>

<?php
		}
	}}

?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>Edifarm</title>
		<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/logo_edifarm.png"/>
		<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/logo_edifarm.png"/>
		<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/logo_edifarm.png"/>

		<!-- Mobile Specific Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

		<!-- Google Font -->
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css"/>
		<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css"/>
		<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css"/>
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />
		
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
	   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
	   crossorigin=""/>
	   <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

		<style type="text/css">
	  	
	  	#map{
	  		height: 100vh;
	  		width: 100%
	  	}
	  	header{
	  		position: absolute;
	  		top:10px;
	  		left:60px;
	  		z-index: 1000;
	  		background: #fffd;
	  		padding: 10px 20px;
	  		width: calc( 100% - 180px)
	  	}
	  	header h1{
	  		padding: 0;
	  		margin: 0 0  5px;
	  		font-size: 22px
	  	}
	  	header p{
	  		padding: 0;
	  		margin: 0;
	  		font-size: 14px;
	  	}
	  	header .select{
	  		position: absolute;
	  		right: 20px;
	  		top: 1rem
	  	}
	  	header .select>select{
	  		font-size: 1rem;
	  		padding: .5rem;
	  		border:1px solid #ddd !important;
	  	}
	  </style>
	</head>
	<body>
	
		<?php  include 'header.php'; ?>
		
		

		

		<div class="right-sidebar">
		<?php include 'rightbar.php'; ?>
		</div>

		<?php include 'sidebar.php'; ?>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			
			<div class="xs-pd-20-10 pd-ltr-20">
				<div class="title pb-20">
					<h2 class="h3 mb-0">Dashboard</h2>
				</div>

				<div class="card-box pb-10">
						<div class="title">
							<h1> Prakiraan Cuaca</h1>
							<p>Date : <span class="tanggal"></span></p>
						</div>
						<div class="select">
							<select name="select-tanggal"></select>
						</div>
					
					<div id="map"></div>
				</div>
				<div class="title pb-20">
				</div>
			

				<!-- <div class="row pb-10">
					
					
					<div class="col-md-4 mb-20">
						<a href = "konsultasi.php">
						<div
							class="card-box min-height-200px pd-20 mb-20"
							data-bgcolor="#455a64"
						>
							<div class="d-flex justify-content-between pb-20 text-white">
								<div class="icon h1 text-white">
									<i class="fa fa-bug" aria-hidden="true"></i> -->
									<!-- <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i> -->
								<!-- </div>
								<div class="font-14 text-right">
									<div class="font-12">Konsultasi</div>
								</div>
							</div>
							<div class="d-flex justify-content-between align-items-end">
								<div class="text-white">
									<div class="font-14"></div>
									<div class="font-25 weight-600">Konsultasi Pada Lahan</div>
								</div>
								<div class="max-width-150">
									<div id="appointment-chart"></div>
								</div>
							</div>
							</div>
						</div>
					</div>
				</div> -->

				<!-- <div class="row">
					<div class="col-lg-4 col-md-6 mb-20">
						<div class="card-box height-100-p pd-20 min-height-200px">
							<div class="d-flex justify-content-between pb-10">
								<div class="h5 mb-0">Jadwal Karyawan</div>
								<div class="dropdown">
									<a
										class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle"
										data-color="#1b3133"
										href="#"
										role="button"
										data-toggle="dropdown"
									>
										<i class="dw dw-more"></i>
									</a>
									<div
										class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
									>
										<a class="dropdown-item" href="calendar.php"
											><i class="dw dw-eye"></i> Lihat</a
										>
										<a class="dropdown-item" href="#"
											><i class="dw dw-edit2"></i> Edit</a
										>
										<a class="dropdown-item" href="#"
											><i class="dw dw-delete-3"></i> Hapus</a
										>
									</div>
								</div>
							</div>
							<div class="user-list">
								<ul>
									<li class="d-flex align-items-center justify-content-between">
										<div class="name-avatar d-flex align-items-center pr-2">
											<div class="avatar mr-2 flex-shrink-0">
											</div>
											<div class="txt">
												<span
													class="badge badge-pill badge-sm"
													data-bgcolor="#e7ebf5"
													data-color="#265ed7"
													></span
												>
												<div class="font-14 weight-600"></div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													
												</div>
											</div>
										</div>
										<div class="cta flex-shrink-0">
											<a href="calendar.php" class="btn btn-sm btn-outline-primary"
												>Jadwal</a
											>
										</div>
									</li>
									<li class="d-flex align-items-center justify-content-between">
										<div class="name-avatar d-flex align-items-center pr-2">
											<div class="avatar mr-2 flex-shrink-0">
											<div class="txt">
												<span
													class="badge badge-pill badge-sm"
													data-bgcolor="#e7ebf5"
													data-color="#265ed7"
													></span
												>
												<div class="font-14 weight-600"></div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													
												</div>
											</div>
									</li>
									<li class="d-flex align-items-center justify-content-between">
										<div class="name-avatar d-flex align-items-center pr-2">
											<div class="avatar mr-2 flex-shrink-0">
											</div>
											<div class="txt">
												<span
													class="badge badge-pill badge-sm"
													data-bgcolor="#e7ebf5"
													data-color="#265ed7"
													></span
												>
												<div class="font-14 weight-600"></div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													
												</div>
											</div>
										</div>
										<div class="cta flex-shrink-0">
											<a href="#" class="btn btn-sm btn-outline-primary"
												>Jadwal</a
											>
										</div>
									</li>
									<li class="d-flex align-items-center justify-content-between">
										<div class="name-avatar d-flex align-items-center pr-2">
											<div class="avatar mr-2 flex-shrink-0">
										
											</div>
											<div class="txt">
												<span
													class="badge badge-pill badge-sm"
													data-bgcolor="#e7ebf5"
													data-color="#265ed7"
													></span
												>
												<div class="font-14 weight-600"></div>
												<div class="font-12 weight-500" data-color="#b2b1b6">
													
												</div>
											</div>
										</div>
										<div class="cta flex-shrink-0">
											<a href="calendar.php" class="btn btn-sm btn-outline-primary"
												>Jadwal</a
											>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-lg-4 col-md-6 mb-20">
					<a href="padi.php"
					>
						<div class="card-box height-100-p pd-20 min-height-200px">
							<div class="max-width-300 mx-auto">
							</div>
								<img src="vendors/images/farm2.svg" alt="" 
								/> 
							<div 
								class="text-center">
								<div class="h5 mb-1">Jenis Padi</div>
								<div
									class="font-14 weight-500 max-width-200 mx-auto pb-20"
									data-color="#a6a6a7"
								>
								Pada lahan terdapat jenis padi yang dapat berpengaruh terhadap pertumbuhan padi
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 mb-20">
					<a href="padi.php"
					>
						<div class="card-box height-100-p pd-20 min-height-200px">
							<div class="max-width-300 mx-auto">
							</div>
								<img src="vendors/images/farming.svg" alt="" 
								/> 
							<div 
								class="text-center">
								<div class="h5 mb-1">Edifarm</div>
								<div
									class="font-14 weight-500 max-width-200 mx-auto pb-20"
									data-color="#a6a6a7"
								>
									Sawah memerlukan sistem management controlling oleh setiap karyawan
								</div>
								<a href="tentang.php" class="btn btn-primary btn-lg">Tentang</a>
							</div>
						</div>
					</div>
				</div> -->

				<div class="card-box pb-10">
					<div class="h5 pd-20 mb-0">Data Karyawan</div>
					<table class="data-table table stripe hover">
						<thead>
							<tr>
								<th class="table-plus datatable-nosort">Username</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>Alamat</th>
								<th>No. HP</th>
								<th>Tgl Lahir</th>
								<th>email</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$query = mysqli_query($koneksi,"SELECT * FROM user where id_level = '2'");
						if(mysqli_num_rows($query)>0){ ?>
						<?php
							while($data = mysqli_fetch_array($query)){
								$id=$data["id_user"];
								$jeniskel=$data["jenis_kelamin"];
						?>		
						<tr >
								<td><?php echo $data["username"];?></td>
								<td><?php echo $data["nama"];?></td>
								<td><?php echo $jeniskel;?></td>
								<td><?php echo $data["alamat"];?></td>
								<td><?php echo $data["no_hp"];?></td>
								<td><?php echo $data["tanggal_lahir"];?></td>
								<td><?php echo $data["email"];?></td>
							</tr>	
						<?php  
							} 
						} 
						?>	
						</tbody>
					</table>
				</div>

				<!-- <div class="title pb-20 pt-20">
					<h2 class="h3 mb-0">Lahan</h2>
				</div>

				<div class="row">
					<div class="col-md-4 mb-20">
						<a href="lahan.php" class="card-box d-block mx-auto pd-20 text-secondary">
							<div class="img pb-30">
								<img src="vendors/images/gambarlahan_1.png" alt="" />
							</div>
							<div class="content">
								<h3 class="h4">Lahan 1</h3>
								<p class="max-width-200">
									
								</p>
							</div>
						</a>
					</div>
					<div class="col-md-4 mb-20">
						<a href="lahan.php" class="card-box d-block mx-auto pd-20 text-secondary">
							<div class="img pb-30">
								<img src="vendors/images/gambarlahan_2.png" alt="" />
							</div>
							<div class="content">
								<h3 class="h4">Lahan 2</h3>
								<p class="max-width-200">
									
								</p>
							</div>
						</a>
					</div>
					<div class="col-md-4 mb-20">
						<a href="lahan.php" class="card-box d-block mx-auto pd-20 text-secondary">
							<div class="img pb-30">
								<img src="vendors/images/gambarlahan_3.png" alt="" />
							</div>
							<div class="content">
								<h3 class="h4">Lahan 3</h3>
								<p class="max-width-200">
									
								</p>
							</div>
						</a>
					</div>
				</div> -->
				</div>
			</div>
		</div>
		
		
		
		<!-- welcome modal end -->
		<!-- js -->
		<!-- add sweet alert js & css in footer -->
		<script src="src/plugins/sweetalert2/sweetalert2.all.js"></script>
		<script src="src/plugins/sweetalert2/sweet-alert.init.js"></script>
		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
		<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
		<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
		<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
		<script src="vendors/scripts/dashboard3.js"></script>
		<script src="vendors/scripts/apexcharts-setting.js"></script>
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
		integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
		crossorigin=""></script>
		<script type="text/javascript" src="node_modules/moment/moment.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js" integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script type="text/javascript" src="app.js"></script>
	</body>
</html>
<?php
	$tanggalnow = date('Y-m-d');

	$query5 =  mysqli_query($koneksi,"SELECT * from sesi_tanam inner join lahan on sesi_tanam.id_lahan = lahan.id_lahan where sesi_tanam.status_sesi='belum'");
	
	while($data2 = mysqli_fetch_array($query5)){
		$tanggalsesi=$data2["tgl_selesai"];
		$idsesi=$data2["id_sesi"];
		$idlahan=$data2["id_lahan"];

		if($tanggalsesi<=$tanggalnow){?>
			<script>alert('<?php echo $data2["nama_lahan"] ;?> telah selesai produksi dan akan diubah menjadi lahan kosong')</script>
			<?php
			mysqli_query($koneksi,"UPDATE `lahan` SET `status`='kosong' WHERE id_lahan = $idlahan");
			mysqli_query($koneksi,"UPDATE `sesi_tanam` SET `status_sesi`='selesai' WHERE id_sesi = $idsesi");
			}
		}

		?>