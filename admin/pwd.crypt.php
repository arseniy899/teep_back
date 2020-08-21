<? require_once('include.php'); ?>
<?


?>
<html>
	<head>
	<title>Шифратор пароля></title>
		<? require('templates/head.php'); ?>
	</head>
	
	
	<body>
		<div id="page" style="top: 15px;">
			<?
				if(IO::getString("pwd") != '')
				{
					echo "<b>".User::cryptPass(IO::getString("pwd"))."</b>";
				}
			?>
			 <form>
			  <label for="pwd">Пароль:</label><br>
			  <input type="text" id="pwd" name="pwd" value="<?=IO::getString("pwd")?>"><br>
			  <input class="button green" type="submit" value="Зашифровать">
			</form> 
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

