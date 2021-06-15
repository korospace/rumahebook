<?php 
	require 'function.php';
	global $conn;

	// -------------------
	// cek session
	// -------------------
	session_start();
	if(!isset($_SESSION["admin"])){
		header("location:login.php");
		exit;
	}

	// -------------------
	// 		delete
	// -------------------
	$xx    = $_GET["xx"];
	$table = $_GET["table"];
	$colom = $_GET["colom"];
	
	$status = delete($xx,$table,$colom);
	
	if($status > (int)0){
		header("location:../crud/?xx=".$table);
		exit;
	}
	else{
		echo "
			<script>
				alert('gagal terhapus');
			</script>
		";
		echo $xx, $table, $colom;
		echo mysqli_error($conn);
	}
?>