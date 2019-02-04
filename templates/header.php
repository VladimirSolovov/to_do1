<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
		<title>Список дел</title>
	</head>
<body>
<?
if(!empty($_SESSION['username']))
{
?>
	<div>
		<?= "Вы авторизованы как: " . $_SESSION['username'];?>
	</div>
	<div>
		<a href="../enter.php?action=logout" class="btn btn-secondary"> Выйти</a>
	</div>
<? } ?>


