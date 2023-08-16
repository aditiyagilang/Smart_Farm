<?php
require("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="header">
			<div class="header-left">
				<div class="menu-icon bi bi-list"></div>
				
			</div>
			<div class="header-right">
				<div class="">
					<div class="dropdown">
						<a
							
						>
						</a>
					</div>
				</div>
				<div class=>
					<div class="dropdown">
						<a
							class="dropdown-toggle no-arrow"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
						</a>
						<div class=>
							<div class=>
								<ul>
									
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a
							class="dropdown-toggle"
							href="#"
							role="button"
							data-toggle="dropdown"
						>
							<span class="user-icon">
								<img src="<?php echo $_SESSION["fotoUser"];?>" alt="" />
							</span>
							<span class="user-name"><?= $_SESSION["namaUser"];?></span>
						</a>
						<div
							class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list"
						>
							<a class="dropdown-item" href="profile.php"
								><i class="dw dw-user1"></i> Profil</a
							>
							<a class="dropdown-item" href="javascript:;"
							data-toggle="right-sidebar"
								><i class="dw dw-settings2"></i> Pengaturan</a
							>
							<a class="dropdown-item" href="tentang.php"
								><i class="dw dw-help"></i> Tentang</a
							>
							<a class="dropdown-item" href="logout.php" onclick="return confirm('Yakin ingin keluar?')"
								><i class="dw dw-logout"></i> Keluar</a
							>
						</div>
					</div>
				</div>
				
					</a>
				</div>
			</div>
		</div>
</body>
</html>