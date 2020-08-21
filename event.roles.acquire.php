<html>
	<? include('api/event.roles.acquire.api.php'); ?>
	
	<head>
	<title>Применить роль</title>
	<? require('templates/head.php'); ?>
	
	</head>
	<body onload="">
		<div id="page" style="top: 150px;width: 30%;padding: 20px;text-align:center; margin:auto;">
			<div>
				<?
					if($errCode == 0)
					{?>
						<h1>Приглашение принято!</h1>
						<p>Ваше приглашение было обработано и вам назначена роль '<?=$acqRes['roleName']?>' на событии '<?=$acqRes['eventName']?>'</p>
					<?}
					else
					{?>
						<h1>Ошибка :(</h1>
						<p>#<?=$errCode?>: '<?=$acqRes?>'</p>
					<?}
				?>
			</div>
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
	
</html>

