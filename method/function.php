<?php
	//  ---- Development Connection ----
	$conn = mysqli_connect("localhost","root","","db_rumahebook");

	//  ---- 000webhost ----
	// $conn = mysqli_connect("localhost","?BDs?AMgFaQ0XBy1","id14594997_ruangebook");
	
	//  ---- Remote Mysql ----
	// $conn = mysqli_connect("remotemysql.com","NFL077dXS9","MWqUSK2Rwz","NFL077dXS9");
	
	// ----------------------------
	// 		Waktu&Tanggal
	// ----------------------------
	function getWaktu(){
		$date    = new DateTime(null,new DateTimeZone('Asia/Jakarta'));
		$tglKritik    = $date->format('Y-m-d|H:i:s');
		$kalender1    = $date->format('d');
		$kalender2    = $date->format('M, Y');
		$nowTime = (int)date($date->format('H'),mktime(0,0,0));
		if($nowTime <= 9 && $nowTime>= 0){
			$waktu = 'pagi';
		}
		else if($nowTime <= 15 && $nowTime>= 9){
			$waktu = 'siang';
		}
		else if($nowTime <= 18 && $nowTime>= 15){
			$waktu = 'sore';
		}
		else{
			$waktu = 'malam';
		}
		$bgBesar  = $waktu;
		$bgBesar .= '.jpeg';
		$bgKecil  = $waktu;
		$bgKecil .= '2.jpeg';

		$arrayWaktu = array('waktu' => $waktu,'kalender1' => $kalender1,'kalender2' => $kalender2,'bgBesar' => $bgBesar,'bgKecil' => $bgKecil,'tglKritik' => $tglKritik);

		return $arrayWaktu;
	}

	// --------------------
	// 		get data
	// --------------------
	function tampil($query){
		global $conn;

		$result = mysqli_query($conn,$query);
		$temporaryArray = [];

		while($row = mysqli_fetch_assoc($result))
		{
			$temporaryArray[] = $row;
		}
		return $temporaryArray;
	}

	// --------------------
	// 		delete
	// --------------------
	function delete($xx,$table,$colom){
		global $conn;

		$xx    = $xx;
		$table = $table;
		$colom = $colom;

		if($table != 'kritik'){
			if($table == 'admin'){
				$imgAdmin = tampil("SELECT adminfoto FROM admin WHERE id='$xx'")[0]['adminfoto'];
				if($imgAdmin != 'gambardefault.jpg'){
					if (unlink('../asset/imgAdmin/'.$imgAdmin)) {
						mysqli_query($conn,"DELETE FROM $table WHERE $colom='$xx'");
					}
				} 
			}else{
				$fotobuku = tampil("SELECT fotobuku FROM ebook WHERE id='$xx'")[0]['fotobuku'];
				$fileebook = tampil("SELECT fileebook FROM ebook WHERE id='$xx'")[0]['fileebook'];
				if($fotobuku != 'gambardaefault.png'){
					if (unlink('../asset/imgEbook/'.$fotobuku)) {
						unlink('../asset/fileEbook/'.$fileebook);
					}
				} 
				mysqli_query($conn,"DELETE FROM $table WHERE $colom='$xx'");			
			}
		}

		return mysqli_affected_rows($conn);
	}

	// --------------------
	// 	KRITIK & SARAN
	// --------------------
	function sendKritik($post){
		global $conn;

		$namaKritik  = htmlspecialchars(stripslashes($post["namaKritik"]));
		$pesanKritik = htmlspecialchars(stripslashes($post["pesanKritik"]));
		$tglKritik   = htmlspecialchars(stripslashes($post["tglKritik"]));
		
		$query       = "INSERT INTO kritik VALUES('0','$namaKritik','$pesanKritik','$tglKritik')";
		mysqli_query($conn,$query);

		return mysqli_affected_rows($conn);
	}

	// --------------------
	// 	  tambah admin
	// --------------------
	function daftaradmin($post){
		global $conn;

		$adminname = htmlspecialchars(strtolower(stripslashes($post["adminname"])));
		$password  = mysqli_real_escape_string($conn,htmlspecialchars($post["password"]));
		$retype    = mysqli_real_escape_string($conn,htmlspecialchars($post["retype"]));

		$result    = mysqli_query($conn,"SELECT adminname FROM admin WHERE adminname='$adminname'");
		if(mysqli_fetch_assoc($result))
		{
			return 'sama';
		}

		if($password != $retype)
		{
			return 'salah';
		}

		$password = password_hash($password, PASSWORD_DEFAULT);

		mysqli_query($conn,"INSERT INTO admin VALUES('0','$adminname','$password','gambardefault.jpg')");

		return mysqli_affected_rows($conn);
	}

	// --------------------
	//  	edit admin
	// --------------------
	function editadmin($post){
		global $conn;

		$idadmin        = $post["idadmin"];
		$passwordLama = $post["passwordLama"];
		$fotolama      = $post["fotolama"];
		
		if($_FILES["fotoadmin"]["error"] === 4)
		{
			$fotoadmin = $fotolama;
		}
		else
		{
			$fotoadmin = uploadFotoAdmin($idadmin);
			if($fotoadmin === 'bukanfoto')
			{
				return 'bukanfoto';
			}
			if($fotoadmin === 'oversize')
			{
				return 'oversize';
			}
		}

		$adminlama     = tampil("SELECT * FROM admin WHERE id ='$idadmin'")[0];
		if($post["adminnameBaru"] === $adminlama["adminname"] && $post["passwordBaru"] === $adminlama["pasword"] && $fotoadmin === $adminlama["adminfoto"])
		{
			return 'nothingupload';
		}

		$adminnameBaru = htmlspecialchars(strtolower(stripslashes($post["adminnameBaru"])));
		$passwordBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["passwordBaru"]));

		$adminlain     = tampil("SELECT * FROM admin WHERE id !='$idadmin'");
		foreach ($adminlain as $adminX) {
			if($adminnameBaru === $adminX['adminname']){
				return 'sama';
			}
		}

		if($passwordBaru == $passwordLama){
			$passwordBaru = $passwordLama;
		}
		else{
			$passwordBaru = password_hash($passwordBaru, PASSWORD_DEFAULT);;
		}

		mysqli_query($conn, "UPDATE admin SET adminname='$adminnameBaru', pasword='$passwordBaru', adminfoto='$fotoadmin' WHERE id='$idadmin'");

		return mysqli_affected_rows($conn);
	}
	
	// --------------------
	// 	upload foto admin 
	// --------------------
	function uploadFotoAdmin($idadmin = null){
		$namafoto    = $_FILES['fotoadmin']['name'];
		$ukuranfoto  = $_FILES['fotoadmin']['size'];
		$error       = $_FILES['fotoadmin']['error'];
		$tempat_foto = $_FILES['fotoadmin']['tmp_name'];
		$fotolama = tampil("SELECT adminfoto FROM admin WHERE id='$idadmin'")[0]['adminfoto'];

		if($error === 4)
		{
			return false;
		}

		if($ukuranfoto > 1048576)
		{
			return 'oversize';
		}

		$ekstensivalid = ['jpg','png','jpeg'];
		$ekstensifoto  = explode('.', $namafoto);
		$ekstensifoto  = strtolower(end($ekstensifoto));

		if(!in_array($ekstensifoto, $ekstensivalid))
		{
			return 'bukanfoto';
		}

		$namafoto = uniqid();
		$namafoto .= '.';
		$namafoto .= $ekstensifoto;

		move_uploaded_file($tempat_foto, '../asset/imgAdmin/'.$namafoto);
		if($fotolama != 'gambardefault.jpg'){
			unlink('../asset/imgAdmin/'.$fotolama);
		} 
		return $namafoto;
	}

	// --------------------
	// 	tambah ebook
	// --------------------
	function upload($post){
		global $conn;

		$uploader = mysqli_real_escape_string($conn,htmlspecialchars($post["uploader"]));
		$judulbuku= mysqli_real_escape_string($conn,htmlspecialchars($post["judulbuku"]));
		$penulis  = mysqli_real_escape_string($conn,htmlspecialchars($post["penulis"]));
		$penerbit = mysqli_real_escape_string($conn,htmlspecialchars($post["penerbit"]));
		$tglterbit= mysqli_real_escape_string($conn,htmlspecialchars($post["tglterbit"]));
		$fileebook= '';
		$kategori = mysqli_real_escape_string($conn,htmlspecialchars($post["kategori"]));
		$sinopsis = mysqli_real_escape_string($conn,htmlspecialchars($post["sinopsis"]));
		if(isset($post["linkgdrive"])){
			$linkgdrive = mysqli_real_escape_string($conn,htmlspecialchars($post["linkgdrive"]));
		}else{
			$linkgdrive = '';
		}

		// foto ebook
		if($_FILES["fotobuku"]["error"] != 4){
			$fotobuku = uploadFotoBuku();
			if($fotobuku === 'bukanfoto')
			{
				return 'bukanfoto';
			}
			if($fotobuku === 'bukanebook')
			{
				return 'bukanebook';
			}
			if($fotobuku === 'oversize')
			{
				return 'oversize';
			}
			if($fotobuku === 'bukuoversize')
			{
				return 'bukuoversize';
			}
		}else{
			$fotobuku = 'gambardaefault.png';
		}
		
		// file ebook
		if(isset($_FILES['fileebook'])){
			$fileebook = uploadFileEbook();
			if($fileebook === 'bukanebook')
			{
				return 'bukanebook';
			}
			if($fileebook === 'bukuoversize')
			{
				return 'bukuoversize';
			}
		}

		$query = "INSERT INTO ebook VALUES('$uploader','$judulbuku','$penulis','$penerbit','$tglterbit','$fotobuku','$fileebook','$kategori','$sinopsis','0','$linkgdrive')";
		mysqli_query($conn,$query);

		return mysqli_affected_rows($conn);
	}

	// --------------------
	//  edit ebook
	// --------------------
	function editebook($post){
		global $conn;
		
		$idbuku = $post["idbuku"];
		$ebookLama = tampil("SELECT * FROM ebook WHERE id='$idbuku'")[0];

		$uploader  = $ebookLama['uploader'];
		$judulbukuBaru = mysqli_real_escape_string($conn,htmlspecialchars($post["judulbukuBaru"]));
		$penulisBaru   = mysqli_real_escape_string($conn,htmlspecialchars($post["penulisBaru"]));
		$penerbitBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["penerbitBaru"]));
		$tglterbitBaru = mysqli_real_escape_string($conn,htmlspecialchars($post["tglterbitBaru"]));
		if(isset($post['kategoriBaru'])){
			$kategoriBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["kategoriBaru"]));
		}else{
			$kategoriBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["kategoriLama"]));
		}
		$sinopsisBaru  = mysqli_real_escape_string($conn,htmlspecialchars($post["sinopsisBaru"]));
		if(isset($post["linkgdrive"])){
			$linkgdrive = mysqli_real_escape_string($conn,htmlspecialchars($post["linkgdrive"]));
		}else{
			$linkgdrive = '';
		}

		if($_FILES["fotobuku"]["error"] === 4)
		{
			$fotobukuBaru = $post["fotolama"];
		}
		else
		{
			$fotobukuBaru = uploadFotoBuku($idbuku);
			if($fotobukuBaru === 'oversize')
			{
				return 'oversize';
			}
			if($fotobukuBaru === 'bukanfoto')
			{
				return 'bukanfoto';
			}
		}

		mysqli_query($conn, "UPDATE ebook SET uploader='$uploader', judulbuku='$judulbukuBaru', penulis='$penulisBaru', penerbit='$penerbitBaru', tglterbit='$tglterbitBaru', fotobuku='$fotobukuBaru', kategori='$kategoriBaru', sinopsis='$sinopsisBaru', linkgdrive='$linkgdrive' WHERE id='$idbuku'");

		return mysqli_affected_rows($conn);
	}

	// --------------------
	// 	upload foto ebook
	// --------------------
	function uploadFotoBuku($idbuku = null){
		$namaFotoBuku   = $_FILES["fotobuku"]["name"];
		$ukuranFotoBuku = $_FILES["fotobuku"]["size"];
		$error          = $_FILES["fotobuku"]["error"];
		$tmpFotoBuku    = $_FILES["fotobuku"]["tmp_name"]; 

		if($error === 4)
		{
			return false;
		}

		$ekstensivalid    = ['jpg','png','jpeg'];
		$ekstensiFotoBuku = explode('.', $namaFotoBuku);
		$ekstensiFotoBuku = strtolower(end($ekstensiFotoBuku));

		if(!in_array($ekstensiFotoBuku, $ekstensivalid))
		{
			return 'bukanfoto';
		}

		if($ukuranFotoBuku > 1048576)
		{
			return 'oversize';
		}

		if(isset($_FILES['fileebook'])){
			if(uploadFileEbook() == 'bukanebook')
			{
				return 'bukanebook';
			}
			if(uploadFileEbook() == 'bukuoversize')
			{
				return 'bukuoversize';
			}
		}

		$namaFotoBuku  = uniqid();
		$namaFotoBuku .= '.';
		$namaFotoBuku .= $ekstensiFotoBuku;

		move_uploaded_file($tmpFotoBuku, '../asset/imgEbook/'.$namaFotoBuku);
		if($idbuku){
			$fotolama = tampil("SELECT fotobuku FROM ebook WHERE id='$idbuku'")[0]['fotobuku'];
			if($fotolama != 'gambardaefault.png'){
				unlink('../asset/imgEbook/'.$fotolama);
			} 
		}

		return $namaFotoBuku;
	}

	// --------------------
	// 	upload file ebook
	// --------------------
	function uploadFileEbook(){
		$namaFileEbook   = $_FILES["fileebook"]["name"];
		$ukuranFileEbook = $_FILES["fileebook"]["size"];
		$error          = $_FILES["fileebook"]["error"];
		$tmpFileEbook    = $_FILES["fileebook"]["tmp_name"]; 

		if($error === 4)
		{
			return false;
		}

		$ekstensivalid    = ['pdf','docx','doc'];
		$ekstensiFileEbook = explode('.', $namaFileEbook);
		$ekstensiFileEbook = strtolower(end($ekstensiFileEbook));

		if(!in_array($ekstensiFileEbook, $ekstensivalid))
		{
			return 'bukanebook';
		}

		if($ukuranFileEbook > 10485760)
		{
			return 'bukuoversize';
		}

		move_uploaded_file($tmpFileEbook, '../asset/fileEbook/'.$namaFileEbook);

		return $namaFileEbook;
	}
?>
