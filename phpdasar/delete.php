<?php
session_start();

if ( !isset($_SESSION["login"]) ) {
	
	header("Location: login.php");

}

require 'functions.php';

$id = $_GET["id"];

if ( delete($id) > 0 ) {
	
	header("Location:index.php");

}

else {

	echo "Data gagal dihapus";

}

?>