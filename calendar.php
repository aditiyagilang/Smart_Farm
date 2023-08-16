<?php 
require('koneksi.php');
require('auth.php');

if(isset($_GET['idlhn'])){
	$idPilihan = $_GET['idlhn'];
}else{
	$idPilihan = null;
};

//Tambah preset jadwal
if(isset($_POST['tambahJadwal'])) {
	$lahan = $_POST['lahanPilih'];
	$jenis = $_POST['padiPilih'];
	$startTgl = $_POST['tanggalMulai'];
	
	$query0 = "SELECT durasi_tanam FROM jenis where id_jenis = '$jenis'";
	$result2 = mysqli_query($koneksi,$query0);
		$row = mysqli_fetch_assoc($result2);
		$hst = $row["durasi_tanam"];
		$endTgl = date('Y-m-d', strtotime("+$hst days", strtotime($startTgl)));
		
	$query =  "INSERT INTO `sesi_tanam` ( `tgl_mulai`, `tgl_selesai`, `id_jenis`, `status`, `id_lahan`) VALUES ( '$startTgl','$endTgl','$jenis', 'belum', '$lahan')";
	$result = mysqli_query($koneksi,$query); 
	
	$query3 = "SELECT id_sesi FROM sesi_tanam ORDER BY id_sesi DESC";
	$result3 = mysqli_query($koneksi,$query3);
		$row1 = mysqli_fetch_assoc($result3);
    	$idbaru = $row1["id_sesi"];
	
	$query4 = mysqli_query($koneksi,"SELECT * FROM kegiatan where id_jenis ='$jenis'");
	if(mysqli_num_rows($query4)>0){ 
		while($data = mysqli_fetch_array($query4)){
			$kegiatan=$data["nama_kegiatan"];
			$hst1=$data["hst"];
			$hst2=$hst1 - 1;
			$tgl = date('Y-m-d', strtotime("+$hst2 days", strtotime($startTgl)));
			$tgl2 = date('Y-m-d', strtotime('+1 days', strtotime($tgl)));
			$query5 =  "INSERT INTO `jadwal` ( `id_user`, `kegiatan`, `tanggal_mulai`, `tanggal_selesai`, `status`, `id_sesi`, `id_lahan`) VALUES ( '1','$kegiatan','$tgl','$tgl2', 'belum', '$idbaru', '$lahan')";
			$result1 = mysqli_query($koneksi,$query5); 
			
		} 
	};
	$query =  "UPDATE lahan set status = 'produksi' where id_lahan='$lahan'";
	$result = mysqli_query($koneksi,$query);

}
//tambah jadwal satuan
if(isset($_POST['tambah'])) {
	$query7 =  mysqli_query($koneksi,"SELECT * from sesi_tanam where id_lahan = '$idPilihan' and status='belum'");
	$data5 = mysqli_fetch_array($query7);
	$idlama = $data5["id_sesi"];

	$user = $_POST['user'];
	$kegiatan = $_POST['kegiatan'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$lahan = $_POST['lahan'];
	$query =  "INSERT INTO `jadwal` ( `id_user`, `kegiatan`, `tanggal_mulai`, `tanggal_selesai`, `status`, `id_sesi`, `id_lahan`) VALUES ( '$user','$kegiatan','$start','$end', 'belum', '$idlama', '$lahan')";
	$result = mysqli_query($koneksi,$query); 
}
if(isset($_POST['Update'])) {
	$id2 = $_POST['idJadwal'];
	$user = $_POST['user'];
	$kegiatan = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$query9 =  "UPDATE jadwal set kegiatan = '$kegiatan', tanggal_mulai= '$start', tanggal_selesai = '$end', id_user = '$user' WHERE `jadwal`.`id_jadwal` = '$id2'";
	$result = mysqli_query($koneksi,$query9);
}
//hapus jadwal
if(isset($_POST['hapus'])) {
	$id = $_POST['idJadwal'];
	$query =  "DELETE FROM `jadwal` WHERE id_jadwal = $id";
	$result = mysqli_query($koneksi,$query); 

}
//drag n drop
if(isset($_POST['id'])) {
	$id2 = $_POST['id'];
	$kegiatan = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$query =  "UPDATE jadwal set kegiatan = '$kegiatan', tanggal_mulai= '$start', tanggal_selesai = '$end' WHERE `jadwal`.`id_jadwal` = '$id2'";
	$result = mysqli_query($koneksi,$query);
}
$sql5 = "SELECT * FROM jadwal right JOIN lahan ON jadwal.id_lahan=lahan.id_lahan where lahan.id_lahan = '$idPilihan'";
$result8 = mysqli_query($koneksi,$sql5);
$dataArr = array();
if(mysqli_num_rows($result8)>0){ 
while($data = mysqli_fetch_array($result8)){
	$namalhn = $data['nama_lahan'];
	$dataArr[] = array(
		'id' => $data['id_jadwal'],
		'karyawan'=> $data['id_user'],
		'title' => $data['kegiatan'],
		'start' => $data['tanggal_mulai'],
		'end' => $data['tanggal_selesai'],
	);
}};
if ($idPilihan){
	$judul = $namalhn;
} else{
	$judul = "Pilih Lahan";
};
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Edifarm</title>
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="vendors/images/logo_edifarm.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="vendors/images/logo_edifarm.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="vendors/images/logo_edifarm.png"
		/>
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="vendors/styles/icon-font.min.css"
		/>
		<link
			rel="stylesheet"
			type="text/css"
			href="src/plugins/fullcalendar/fullcalendar.css"
		/>
		<link rel="stylesheet" type="text/css" href="src/plugins/jquery-steps/jquery.steps.css" />
		<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />
	</head>
	<body>

		<?php include 'header.php'; ?>
		
		<div class="right-sidebar">
		<?php include 'rightbar.php'; ?>
		</div>

		<?php include 'sidebar.php'; ?>
		<div class="mobile-menu-overlay"></div>

		<div class="mobile-menu-overlay"></div>
		<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
				<div class="page-header">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="title">
									<h4>Jadwal</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="dashboard.php">Dashboard</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Jadwal
										</li>
									</ol>
								</nav>
							</div>
							<div class="col-md-6 col-sm-12 text-right">
								<div class="dropdown">
									<a
										class="btn btn-primary dropdown-toggle"
										href="#"
										role="button"
										data-toggle="dropdown"
									>
									<?php echo $judul ?>
									</a>
									<ul class="dropdown-menu dropdown-menu-right">
									<?php 
									$query1 = mysqli_query($koneksi,"SELECT * FROM lahan where status='produksi'");
									if(mysqli_num_rows($query1)>0){ 
									?>
									<?php
										while($data1 = mysqli_fetch_array($query1)){
											$namalahan1=$data1["nama_lahan"];
											$idlahan1=$data1["id_lahan"];
									?>		
										<li><a class="dropdown-item" href="calendar.php?idlhn=<?=$idlahan1;?>"><?php echo $namalahan1 ?></a></li>
									<?php  
										} 
									} 
									?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="pd-20 card-box mb-30">
						<div class="calendar-wrap">
							<div id="calendar"></div>
						</div>
						<!-- calendar modal -->
						<div
							id="modal-view-event"
							class="modal modal-top fade calendar-modal"
						>
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<form action="calendar.php?idlhn=<?=$idPilihan;?>" method="POST">
										<div class="modal-body">
											<h4 class="text-blue h4 mb-10">Detail Jadwal</h4>
											<div class="form-group">
												<input hidden type="text" class="idJadwal form-control" name="idJadwal" id="user" />
											</div>
											<div class="form-group">
												<label>Nama Karyawan</label>
													<select class="idkaryawan custom-select col-12" name="user" required>
													<?php 
													if($idPilihan){
														$query6 = mysqli_query($koneksi,"SELECT * FROM user where id_lahan = $idPilihan");
														if(mysqli_num_rows($query6)>0){ 
														?>
														<?php
															while($data3 = mysqli_fetch_array($query6)){
																$namauser5=$data3["nama"];
																$idlahan5=$data3["id_user"];
														?>		
															<option value="<?php echo $idlahan5 ?>"><?php echo $namauser5 ?></option>
															<?php  
															} 
														}else{?>
															<option disabled >Tidak ada karyawan di lahan ini</option><?php
														}
													}
													?>
													</select>
											</div>
											<div class="form-group">
												<label>Kegiatan</label>
												<input type="text" class="title form-control" name="title" id="title" required/>
											</div>
											<div class="form-group">
												<label>Mulai</label>
												<input type="datetime" class="tanggalstr form-control datetime" name="start" id="kegiatan" value="" />
											</div>
											<div class="form-group">
												<label>Selesai</label>
												<input type="datetime" class="tanggalend form-control datetime" name="end" id="kegiatan" value="" />
											</div>
											<div class="form-group">
												<input hidden type="text" class="form-control" readOnly name="lahan" id="user" value="<?php echo $idPilihan ?>" />
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary"  id="tombol_form" name="Update">
												Update
											</button>
											<button
												type="button"
												class="btn btn-primary"
												data-dismiss="modal"
											>
												Batal
											</button>
											<button type="submit" class="btn btn-primary"  id="tombol_form" name="hapus">
												Hapus
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div
							id="modal-view-event-add"
							class="modal modal-top fade calendar-modal"
						>
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<form action="calendar.php?idlhn=<?=$idPilihan;?>" method="POST">
										<div class="modal-body">
											<h4 class="text-blue h4 mb-10">Tambah Detail Jadwal</h4>
											<div class="form-group">
												<label>Nama Karyawan</label>
													<select class="custom-select col-12" name="user" required>
													<?php 
													if($idPilihan){
														$query6 = mysqli_query($koneksi,"SELECT * FROM user where id_lahan = $idPilihan");
														if(mysqli_num_rows($query6)>0){ 
														?>
														<?php
															while($data3 = mysqli_fetch_array($query6)){
																$namauser=$data3["nama"];
																$idlahan=$data3["id_user"];
														?>		
															<option value="<?php echo $idlahan ?>"><?php echo $namauser ?></option>
															<?php  
															} 
														}else{?>
															<option disabled >Tidak ada karyawan di lahan ini</option><?php
														}
													}
													?>
													</select>
											</div>
											<div class="form-group">
												<label>Kegiatan</label>
												<input type="text" class="form-control" name="kegiatan" id="kegiatan" required/>
											</div>
											<div class="form-group">
												<label>Mulai</label>
												<input type="text" class="tanggalstr form-control" readOnly name="start" id="kegiatan" value="" />
											</div>
											<div class="form-group">
												<label>Selesai</label>
												<input type="text" class="tanggalend form-control" readOnly name="end" id="kegiatan" value="" />
											</div>
											<div class="form-group">
												<label></label>
												<input type="text" class="form-control" name="lahan" hidden id="lahan" value="<?php echo $idPilihan ?>" />
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary"  id="tombol_form" name="tambah">
												Simpan
											</button>
											<button
												type="button"
												class="btn btn-primary"
												data-dismiss="modal"
											>
												Batal
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<button 
		href="#"
		class="welcome-modal-btn"
		data-toggle="modal" data-target="#exampleModal"
			>
			(+) Tambah
		</button>

		<div class="modal fade bs-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Sesi Tanam Baru</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="calendar.php?idlhn=<?=$idPilihan;?>" method="POST">
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Lahan</label>
								<div class="col-sm-12 col-md-10 ">
								<select class="form-control selectpicker" name="lahanPilih" title="Lahan yang tersedia" required>
									
								<?php 
								$query = mysqli_query($koneksi,"SELECT * FROM lahan where status = 'kosong'");
								if(mysqli_num_rows($query)>0){ 
								?>
								<?php
									while($data2 = mysqli_fetch_array($query)){
										$namalahan=$data2["nama_lahan"];
										$idlahan2=$data2["id_lahan"];
								?>		
									<option value="<?php echo $idlahan2 ?>"><?php echo $namalahan ?></option>
									<?php  
									} 
							 	} 
								?>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Janis Padi</label>
								<div class="col-sm-12 col-md-10 ">
								<select class="form-control selectpicker" name="padiPilih" title="Pilih jenis padi" required>
									
								<?php 
								$query2 = mysqli_query($koneksi,"SELECT * FROM jenis");
								if(mysqli_num_rows($query2)>0){ 
								?>
								<?php
									while($data1 = mysqli_fetch_array($query2)){
										$namajenis=$data1["nama_jenis"];
										$idjenis=$data1["id_jenis"];
								?>		
									<option value="<?php echo $idjenis ?>"><?php echo $namajenis ?></option>
									<?php  
									} 
							 	} 
								?>
								</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-12 col-md-2 col-form-label">Tgl. Mulai</label>
								<div class="col-sm-12 col-md-10">
									<input
										class="form-control date"
										placeholder="Pilih tanggal lahir"
										type="date"
										name="tanggalMulai"
										required
									/>
								</div>
							</div>
							</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal" alt="add-modal-kar" >Batal</button>
									<input type="submit" name="tambahJadwal" class="btn btn-primary" value="Simpan" id="sa-success">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<button
			type="button"
			id="success-modal-btn"
			hidden
			data-toggle="modal"
			data-target="#success-modal"
			data-backdrop="static"
		>
			Launch modal
		</button>
		<div
			class="modal fade"
			id="success-modal"
			tabindex="-1"
			role="dialog"
			aria-labelledby="exampleModalCenterTitle"
			aria-hidden="true"
		>
			<div
				class="modal-dialog modal-dialog-centered max-width-400"
				role="document"
			>
				<div class="modal-content">
					<div class="modal-body text-center font-18">
						<h3 class="mb-20">Data terkirim!</h3>
						<div class="mb-30 text-center">
							<img src="vendors/images/success.png" />
						</div>
						Berhasil membuat sesi tanam baru
					</div>
					<div class="modal-footer justify-content-center">
						<a href="calendar.php" class="btn btn-primary">Done</a>
					</div>
				</div>
			</div>
		</div>
		

		<script src="vendors/scripts/core.js"></script>
		<script src="vendors/scripts/script.min.js"></script>
		<script src="vendors/scripts/process.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/fullcalendar/fullcalendar.min.js"></script>
		<script src="vendors/scripts/layout-settings.js"></script>
		<script src="src/plugins/jquery-steps/jquery.steps.js"></script>
		<script src="vendors/scripts/steps-setting.js"></script>
		
		
		<!-- <script src="vendors/scripts/calendar-setting.js"></script> -->
		<script>
		jQuery("#calendar").fullCalendar({
			themeSystem: "bootstrap4",
			businessHours: false,
			defaultView: "month",
			
			header: {
				left: "title",
				center: "month,agendaWeek,agendaDay",
				right: "today prev,next",
			},
			events: <?php echo json_encode($dataArr); ?>,

			selectable: true,
			selecHelper: true,
			editable: true,
			select: function(start, end, allDay){
				var lahan = "<?php echo $idPilihan ?>";
				if(lahan==""){
					alert("Pilih Lahan terlebih dahulu!");
				}else{
					var start =$.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
				var end =$.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
				$(".tanggalstr").val(start);
				$(".tanggalend").val(end);
				$("#modal-view-event-add").modal();
				};
				
				
			},
			
			eventDrop: function(event){
				var start =$.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
				var end =$.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
				var title = event.title;
				var id = event.id;
				
				$.ajax({
					url: "calendar.php",
					type: "POST",
					data: {
						title: title,
						start:start,
						end:end,
						id:id
					}
					
				});
			},
			// dayClick: function () {
				
			// },
			eventClick: function (event, jsEvent, view) {
				jQuery(".event-icon").html("<i class='fa fa-" + event.icon + "'></i>");
				var start =$.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
				var end =$.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
				$(".idJadwal").val(event.id);
				$(".idkaryawan").val(event.karyawan);
				$(".tanggalstr").val(start);
				$(".tanggalend").val(end);
				$(".title").val(event.title);
				jQuery("#modal-view-event").modal();
			},
		});</script>
	</body>
</html>
