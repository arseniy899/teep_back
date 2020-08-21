<html>
	<? require_once('include.php'); ?>
	<head>
	<title>TEEP | Обслуживание</title>
	<? require('templates/head.php'); ?>
	<style>
	
	.dashboard table {
		width: 100%;
		max-width: 450px;
		margin: 0 auto;
	}
	.dash-board table, td, th {
		vertical-align: middle;
		padding-right: 5px;
	}
	.dashtable tr,td {
		height: 25px;
		border-bottom: 1px solid #ebebeb;
	}
	.dash-board table {
		border-collapse: separate;
		border-spacing: 0;
		white-space: nowrap;
	}
	.val-field {
		color: gray;
	}
	</style>
	
	</head>
	<body>
		<div class="top-bar">Обслуживание.Главная</div>
		<? require('menu.php'); ?>
		<div id="page">
			<table class="dashboard">
				
			</table>
			Панель управления системой
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

