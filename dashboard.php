<?php
require('auth.php');
require('koneksi.php');
$tanggalnow = date('Y-m-d');

$query5 =  mysqli_query($koneksi, "SELECT * from sesi_tanam where status='belum'");
if (mysqli_num_rows($query5) > 0) {
	while ($data2 = mysqli_fetch_array($query5)) {
		$tanggalsesi = $data2["tgl_selesai"];
		if ($tanggalsesi >= $tanggalnow) {
?>
			<script>
				swal({
					title: 'Good job!',
					text: 'You clicked the button!',
					type: 'success',
					showCancelButton: true,
					confirmButtonClass: 'btn btn-success',
					cancelButtonClass: 'btn btn-danger'
				})
			</script>

<?php
		}
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8" />
	<title>Edifarm</title>
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/logo_edifarm.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/logo_edifarm.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/logo_edifarm.png" />

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

	<style type="text/css">
		#map {
			height: 100vh;
			width: 100%
		}

		header {
			position: absolute;
			top: 10px;
			left: 60px;
			z-index: 1000;
			background: #fffd;
			padding: 10px 20px;
			width: calc(100% - 180px)
		}

		header h1 {
			padding: 0;
			margin: 0 0 5px;
			font-size: 22px
		}

		header p {
			padding: 0;
			margin: 0;
			font-size: 14px;
		}

		header .select {
			position: absolute;
			right: 20px;
			top: 1rem
		}

		header .select>select {
			font-size: 1rem;
			padding: .5rem;
			border: 1px solid #ddd !important;
		}
	</style>
</head>
<body>

    <?php include 'header.php'; ?>

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
            <div class="row">
                <div class="col-md-6">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Line Chart 1
                            </h3>
                            <!-- Add your card header buttons here -->
                        </div>
                        <div class="card-body">
                            <div id="line-chart-1" style="height: 500px;"></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-chart-bar"></i>
                                Line Chart 2
                            </h3>
                            <!-- Add your card header buttons here -->
                        </div>
                        <div class="card-body">
                            <div id="line-chart-2" style="height: 500px;"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.tooltip.min.js"></script>

    <script>
        $(function () {
            // Example data generation for Line Chart 1
            var sin1 = [];
            for (var i = 0; i <= 14; i += 0.5) {
                sin1.push([i, Math.sin(i)]);
            }
            var line_data1 = {
                data: sin1,
                label: "Sin 1",
                color: '#3c8dbc'
            };
            
            // Example data generation for Line Chart 2
            var cos2 = [];
            for (var i = 0; i <= 14; i += 0.5) {
                cos2.push([i, Math.cos(i)]);
            }
            var line_data2 = {
                data: cos2,
                label: "Cos 2",
                color: '#00c0ef'
            };

            var plotOptions = {
                // Your plot options here
            };

            // Initialize Line Chart 1
            var $chart1 = $('#line-chart-1');
            $.plot($chart1, [line_data1], plotOptions);

            // Initialize Line Chart 2
            var $chart2 = $('#line-chart-2');
            $.plot($chart2, [line_data2], plotOptions);

            // Rest of your chart setup and interaction logic
        });
    </script>

    <!-- Include other JavaScript files as needed -->

</body>


</html>