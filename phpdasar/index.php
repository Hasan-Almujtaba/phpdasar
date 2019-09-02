<?php
session_start();

// cek apakah sudah login

if ( !isset($_SESSION["login"]) ) {
	
	header("Location: login.php");

}

require 'functions.php';

// pagination
$jmlDataPerhalaman = 3; //jumlah data yg ditampilkan perhalamanz
$jmlData = count( query("SELECT * FROM daftar") );  //jumlah data yg ada di db
$jmlHalaman = ceil( $jmlData / $jmlDataPerhalaman ); //jumlah halaman yg dibuat berdasarkan jumlah data & data yg ingin ditanpilkan
$halAktif = ( isset($_GET['hal']) ) ? $_GET['hal'] : 1; //halaman saat ini
$dataAwal = ( $jmlDataPerhalaman * $halAktif ) - $jmlDataPerhalaman; //data yang ditampilkan di tiap halaman

// menampilkan data dari db
$animes = query("SELECT * FROM daftar LIMIT $dataAwal, $jmlDataPerhalaman ");


// jika tombol cari ditekan

if (isset($_GET["submit"])) {
	
	$keyword = $_GET["keyword"];
	$animes = search($keyword);

}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Daftar Anime</title>
</head>
<body>

	<a href="logout.php">Logout</a>

	<h1>Daftar Anime</h1>

	<a href="insert.php">Tambahkan Data</a> 


	<form action="" method="get">
		
		<input type="text" name="keyword" placeholder="masukkan keyword..." autocomplete="off" autofocus>
		<button type="submit" name="submit">Cari</button>

	</form>

	<!-- navigasi -->
	
	<?php if( $halAktif > 1 ) : ?> 
	<a href="?hal=<?= $halAktif - 1; ?>">&laquo</a>
	<?php endif ?>

	<?php for( $i = 1; $i <= $jmlHalaman; $i++ ) : ?>
		<?php if( $i == $halAktif ) : ?>
			<a href="?hal=<?= $i; ?>" style='font-weight: bold; color: red;'  > <?= $i; ?> </a>
		<?php else : ?>
			<a href="?hal=<?= $i; ?>"> <?= $i; ?> </a>

		<?php endif ?>
	<?php endfor ?>

	<?php if( $halAktif < $jmlHalaman ) : ?> 
	<a href="?hal=<?= $halAktif + 1; ?>">&raquo</a>
	<?php endif ?>

	<br>

	<table border="1" cellpadding="10" cellspacing="0">
		
		<tr>
			<th>No</th>
			<th>Aksi</th>
			<th>Cover</th>
			<th>Judul</th>
			<th>Episode</th>
			<th>Genre</th>
			<th>Studio</th>
		</tr>

		<?php $i = 1; ?>

		<?php foreach( $animes as $anime ) : ?>

		<tr>
			<td>
				<?= $i + $dataAwal ; ?>
			</td>
			<td>
				<a href="update.php?id=<?= $anime["id"] ?>">ubah</a> |
				<a href="delete.php?id=<?= $anime["id"] ?>" onclick="return confirm('Data akan dihapus?'); ">hapus</a>
			</td>
			<td>
				<img src="img/<?= $anime["gambar"] ?>" width="50">
			</td>
			<td>
				<?= $anime["judul"] ?>
			</td>
			<td>
				<?= $anime["episode"] ?>
			</td>
			<td>
				<?= $anime["genre"] ?>
			</td>
			<td>
				<?= $anime["studio"] ?>
			</td>
		</tr>
		
		<?php $i++ ?>

		<?php endforeach ?>

	</table>



</body>
</html>