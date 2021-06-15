<?php 
	require '../method/function.php';

	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	$getWaktu = getWaktu();
	if($getWaktu['waktu'] == 'pagi' || $getWaktu['waktu'] == 'malam'){
		$warna = 'E9E9E9';
	}else{
		$warna = '393939';
	}

	// ----------------------------
	// 		Get Ebook Data
	// ----------------------------
	if(!isset($_GET['idbuku'])){
		header('location:../');
	}
	$idBuku = $_GET["idbuku"];
	$dataNovel1 = tampil("SELECT * FROM ebook WHERE id = '$idBuku'")[0];

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../asset/imgBground/logo2.png" type="image/x-icon">
	<meta charset="UTF-8">
	<title>Download</title>

	<!------------------------------------------- CSS --------------------------------------------->
	<link rel="stylesheet" href="../asset/css/bootstrap.min.css">
	<style>
		body{
			background-image     : url(../asset/imgBground/<?= $getWaktu['bgBesar']; ?>);
			background-size      : cover;
			background-repeat    : no-repeat;
			background-attachment: fixed;
			overflow: hidden;
			height: 100vh;
		}
		@font-face {
		  font-family: Oswald;
		  src: url(../asset/font/Oswald-Light.ttf);
		}
		/*///////////////////////////////////////////////////////////////////////////////////////////////*/
		@media(max-width: 710px){
			body{
				background-image     : url(../asset/imgBground/<?= $getWaktu['bgKecil']; ?>);
				background-size      : cover;
				background-repeat    : no-repeat;
				background-attachment: fixed;
			}
		}
		@media(max-width: 640px){
			#col-deskripsi h1{
				text-align: center;
			}
			#col-deskripsi h1{
				font-size: 25px;
			}
			#col-deskripsi h5{
				font-size: 13px;
			}
		}
	</style>
</head>
<body class="d-flex flex-column">

	<!-- loader -->
	<div id="loader" class="d-flex justify-content-center align-items-center" style="background-color: white;position:fixed;top:0;bottom:0;left:0;right:0; z-index:1040;">
		<img src="../asset/imgBground/loading.svg">
	</div>

	<!-- NAV -->
	<nav class="navbar px-3" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 4px );-webkit-backdrop-filter: blur( 4px );">
		<button onclick="goBack()" class="navbar-brand font-weight-bold btn btn-info">
			<img src="../asset/imgBground/home.svg" width="28px">
		</button>
	</nav><!-- </NAV> -->

	<!-- <main> -->
	<div class="row container-fluid m-0 d-flex justify-content-center p-4" style="flex: 1;">
		<div class="col-sm-11 col-md-10 col-lg-9 col-xl-8 rounded-lg d-flex flex-column" style="background: rgba( 255, 255, 255, 0.25 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">	
			<div class="row">
				<!-- foto-preview -->
				<div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-3 p-3 d-flex justify-content-center" style="min-width: 200px;">
					<img src="../asset/imgEbook/<?= $dataNovel1['fotobuku']; ?>" style="width: 100%;max-width: 200px;">
				</div>
				<!-- deskripsi -->
				<div class="col p-3 d-flex justify-content-center flex-column" id="col-deskripsi">
					<h1 style="-webkit-text-stroke: 1px white;"><strong><?= $dataNovel1['judulbuku']; ?></strong></h1>
					<ul class="mt-4 mb-0 py-0 px-3">
						<li><h5>Penulis : <?= $dataNovel1['penulis']; ?></h5></li>
						<li><h5>Penerbit : <?= $dataNovel1['penerbit']; ?></h5></li>
						<li><h5>Tahun Terbit : <?= $dataNovel1['tglterbit']; ?></h5></li>
						<li><h5>Kategori : <?= $dataNovel1['kategori']; ?></h5></li>
					</ul>
				</div>
			</div>
			<div class="row p-3" style="flex: 1;">
				<!-- Sinopsis Box -->
				<div class="col px-4 py-2 rounded-lg h-100" style="overflow:auto;font-family: monospace; background: rgba( 255, 255, 255, 0.7 );box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );backdrop-filter: blur( 6px );-webkit-backdrop-filter: blur( 6px );">
					<h3 class="text-center mt-2"><strong>SINOPSIS</strong></h3>
					<h6 class="mt-3"><?= $dataNovel1['sinopsis']; ?></h6>
				</div>
			</div>
		</div>
	</div>
	<!-- </main> -->

	<!-- <download button> -->
	<a href="<?= ($dataNovel1['linkgdrive']) ? $dataNovel1['linkgdrive'] : '../asset/fileEbook/'.$dataNovel1['fileebook']  ?>" class="btn btn-success p-0 rounded-circle" target="_blank" title="download" data-toggle="tooltip" data-placement="left" style="position: fixed; bottom:20px; right:20px;">
		<img src="../asset/imgBground/download.svg" width="60px"></a>
	<!-- </download button> -->
		
	<!---------------------- js ---------------------->
	<script src="../asset/js/jquery-3.6.0.min.js"></script>
	<script src="../asset/js/popper.min.js"></script>
	<script src="../asset/js/bootstrap.min.js"></script>
	<script>
		// loader
		window.addEventListener('load',function(){
			document.querySelector('div#loader').classList.remove('d-flex');
			document.querySelector('div#loader').style.display = 'none';
			document.body.style.overflow = 'auto';
		})
		// go back 
		function goBack() {
			window.history.back();
		}
		// tooltip
		($('[data-toggle="tooltip"]')) ? $('[data-toggle="tooltip"]').tooltip() : ''; 
	</script>
</body>
</html>