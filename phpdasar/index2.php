<?php

// Koneksi ke database
$db = mysqli_connect("localhost", "root", "", "anime");

// Ambil data dari tabel 
$result = mysqli_query($db,"SELECT * FROM daftar");
if (!$result) {
	echo mysqli_error($db);
}

// Ambil data (fetch) dari daftar
// mysqli_fetch_row() // menggunakan array numerik
// mysqli_fetch_assoc() // menggunakan array asosiatif
// mysqli_fetch_array() // menggunakan keduanya
// mysqli_fetch_object() // menggunakan object

// while ( $daftar = mysqli_fetch_assoc($result) ) {
// 	var_dump($daftar);
// }


?>

<!DOCTYPE html>
<html>
<head>
	<title>Daftar Anime</title>
</head>
<body>

	<h1>Daftar Anime</h1>

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

		<?php while ( $row = mysqli_fetch_assoc($result) ) : ?>

		<tr>
			<td>
				<?= $i; ?>
			</td>
			<td>
				<a href="">ubah</a> |
				<a href="">hapus</a>
			</td>
			<td>
				<img src="img/<?= $row["gambar"] ?>" width="50">
			</td>
			<td>
				<?= $row["judul"] ?>
			</td>
			<td>
				<?= $row["episode"] ?>
			</td>
			<td>
				<?= $row["genre"] ?>
			</td>
			<td>
				<?= $row["studio"] ?>
			</td>
		</tr>
		
		<?php $i++ ?>

		<?php endwhile ?>

	</table>



</body>
</html>