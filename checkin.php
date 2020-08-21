<html>
	<? include('api/event.checkin.php'); ?>
	
	<head>
	<title>Отметка на событии</title>
	<? require('templates/head.php'); ?>
	
	</head>
	<body onload="">
		<div id="page" style="top: 150px;width: 30%;min-width: 300px;padding: 20px;text-align:center; margin:auto;">
			<div>
				<?
					if($errCode == 0)
					{?>
						<h1>Замётано!</h1>
						<p>Вы успешно отметились на мероприятии <b>'<?=$acqRes['name']?>'</b></p>
					<?}
					else
					{?>
						<h1>Ошибка :(</h1>
						<p>#<?=$errCode?>: '<?=$acqRes?>'</p>
					<?}
				?>
				<a href="index.php" class="button">Личный кабинет</a>
			</div>
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
	
</html>

