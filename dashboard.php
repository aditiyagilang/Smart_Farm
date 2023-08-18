<?php
require('auth.php');
require('koneksi.php');

$apiKey = "a4e873808077c72854f9549953b758af";
$cityId = "1643084"; // Jakarta city Code

function getWeatherData($apiKey, $cityId)
{
	$weatherServer = "http://api.openweathermap.org";
	$apiPath = "/data/2.5/weather";
	$url = "{$weatherServer}{$apiPath}?id={$cityId}&appid={$apiKey}";

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($curl);
	curl_close($curl);

	$weatherData = json_decode($response, true);

	return $weatherData;
}

// Fetch weather data
$weatherData = getWeatherData($apiKey, $cityId);
?>
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
<meta charset="utf-8" />
	<title>Smart Farm</title>
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/logo_edifarm.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/logo_edifarm.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/logo_edifarm.png" />

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css" />
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css" />
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css" />
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css" />

	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
		integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
		crossorigin="" />
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
	<script>
		var firebaseConfig = {
			apiKey: "AIzaSyDp_uLCSrlxJEn9EWbFYm_kY8lLbMuT3Q4",
			authDomain: "knupolije1.firebaseapp.com",
			databaseURL: "https://knupolije1-default-rtdb.firebaseio.com",
			projectId: "knupolije1",
			storageBucket: "knupolije1.appspot.com",
			messagingSenderId: "668839492490",
			appId: "1:668839492490:web:f8da0717cf185992762673",
			measurementId: "G-2DXHZL4HQH"
		};
		if (!firebase.apps.length) {
			firebase.initializeApp(firebaseConfig);
		}


		// Definisi fungsi-fungsi
		function handleSuccess(snapshot) {
			const data = snapshot.val();
			if (data) {
				const latestEntryKey = Object.keys(data).pop();
				const latestEntry = data[latestEntryKey];

				if (latestEntry.soilHumidity1) {
					const soilHumidity1Data = latestEntry.soilHumidity1.slice();
					updateDataText("data-text-1", soilHumidity1Data);
				}
				if (latestEntry.soilHumidity2) {
					const soilHumidity2Data = latestEntry.soilHumidity2.slice();
					updateDataText("data-text-2", soilHumidity2Data);
				}
			}
		}

		function updateDataText(elementId, dataArray) {
			const element = document.getElementById(elementId);
			element.textContent = JSON.stringify(dataArray);
		}

		function handleError(error) {
			console.error(error);
		}
		// Mendaftarkan listener untuk pembaruan data
		const dataRef = database.ref('/data');
		dataRef.on('value', handleSuccess, handleError);
	</script>
	<div class="main-container">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="row">
            <div class="col-md-6">
                <div class="title pb-20">
                    <h2 class="h2 mt-0">Dashboard</h2>
                </div>
            </div>
            <div class="col-md-6">
                <p style="text-align: right">
                    <?php
                    if ($weatherData) {
                        $kelvinTemp = $weatherData['main']['temp'];
                        $celsiusTemp = $kelvinTemp - 273.15;
                        echo "Temperature: " . round($celsiusTemp, 2) . " &#8451;<br>";

                        echo "Weather: " . $weatherData['weather'][0]['description'] . "<br>";
                        echo "Wind Speed: " . $weatherData['wind']['speed'] . " m/s";
                    } else {
                        echo "Failed to fetch weather data.";
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
	<div class="main-container">
		<div class="xs-pd-20-10 pd-ltr-20">
			<div class="row">
				<div class="col-md-6">
					<div class="card card-primary card-outline">
						<div class="card-body">
							<div id="data-text-1"></div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-primary card-outline">
						<div class="card-body">
							<div id="data-text-2"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>