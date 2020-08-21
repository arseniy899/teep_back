
<html>
	<? require_once('include.php'); ?>
	<head>
	<title>Авторизация</title>
	<? require('templates/head.php'); ?>
	<style>
	.login-form {
		z-index: 1;
		background: #FFFFFF;
		max-width: 360px;
		margin: 0 auto 20px;
		padding: 45px;
		text-align: center;
		display: table-column;
		box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
	}
	.parent_blocks
	{
		display: flex;width: 100%;
	}
	@media only screen and (max-width:767px)
	{
		.parent_blocks
		{
			display: grid;width: 100%;
		}
		.login-form {
			width: 100vw;
		}
	}
	.login-form input {
		font-family: "Roboto", sans-serif;
		outline: 0;
		background: #f2f2f2;
		width: 100%;
		border: 0;
		margin: 0 0 15px;
		padding: 15px;
		box-sizing: border-box;
		font-size: 14px;
	}
	.login-form button {
		font-family: "Roboto", sans-serif;
		text-transform: uppercase;
		outline: 0;
		background: #4CAF50;
		width: 100%;
		border: 0;
		padding: 15px;
		color: #FFFFFF;
		font-size: 14px;
		-webkit-transition: all 0.3 ease;
		transition: all 0.3 ease;
		cursor: pointer;
	}
	.login-form button:hover,.login-form button:active,.login-form button:focus {
		background: #43A047;
	}
	.login-form .message {
		margin: 15px 0 0;
		color: #b3b3b3;
		font-size: 12px;
	}
	.login-form .message a {
		color: #4CAF50;
		text-decoration: none;
	}
	.login-form .register-form {
		display: none;
	}
	.container {
		position: relative;
		z-index: 1;
		max-width: 300px;
		margin: 0 auto;
	}
	.container:before, .container:after {
		content: "";
		display: block;
		clear: both;
	}
	.container .info {
		margin: 50px auto;
		text-align: center;
	}
	.container .info h1 {
		margin: 0 0 15px;
		padding: 0;
		font-size: 36px;
		font-weight: 300;
		color: #1a1a1a;
	}
	.container .info span {
		color: #4d4d4d;
		font-size: 12px;
	}
	.container .info span a {
		color: #000000;
		text-decoration: none;
	}
	.container .info span .fa {
		color: #EF3B3A;
	}
	
	</style>
	<script>
		window.addEventListener("load", function ()
		{
			function submitFormLogin()
			{
				
				var xhttp;
				xhttp = new XMLHttpRequest();
				ShowLoading();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4)
						DismissLoading();
					if (this.readyState == 4 && this.status == 200) 
					{
						var ajaxRes = JSON.parse(this.responseText).responce;
						Toast.showAjaxRes(ajaxRes);
						if(ajaxRes.error == 0)
							window.location.href = "";
					}
				};
				xhttp.open("POST", "api/user.auth.login.php", true);
				xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xhttp.send(new URLSearchParams(new FormData(formLogin)).toString());
			}
			var formLogin = document.getElementById("form-login");
			formLogin.addEventListener("submit", function (event) 
			{
				event.preventDefault();
				submitFormLogin();
			});
			function submitFormCreate()
			{
				
				var xhttp;
				xhttp = new XMLHttpRequest();
				ShowLoading();
				xhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4)
						DismissLoading();
					if (this.readyState == 4 && this.status == 200) 
					{
						var ajaxRes = JSON.parse(this.responseText).responce;
						Toast.showAjaxRes(ajaxRes);
						if(ajaxRes.error == 0)
							window.location.href = "";
					}
				};
				xhttp.open("POST", "api/user.auth.create.php", true);
				xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xhttp.send(new URLSearchParams(new FormData(formCreate)).toString());
			}
			var formCreate = document.getElementById("form-create");
			formCreate.addEventListener("submit", function (event) {
				event.preventDefault();
				submitFormCreate();
			});
		});
	</script>
	
	</head>
	<body>
		<div class="top-bar">Авторизация</div>
		<div class="parent_blocks">
		<form class="login-form" id="form-create">
			<h2>Регистрация</h2>
			<input type="text" required name="login" placeholder="Логин*"/>
			<input type="text" required name="name" placeholder="Имя*"/>
			<select name="instID">
			<? foreach (Misc::getInstitutes() as $id => $value): ?>
				<option value="<?=$id?>"><?=$value['name']?></option>
			<? endforeach ?>
			<input type="text" required name="mail" placeholder="E-mail*"/>
			<input type="password" required name="repass" placeholder="Пароль*"/>
			<input type="password" required name="passw" placeholder="Пароль*"/>
			<button>Зарегистрироваться</button>
			<!--<p class="message">Not registered? <a href="#">Create an account</a></p>-->
		</form>
		<form class="login-form" id="form-login">
			<h2>Вход</h2>
			<input type="text" required name="login" placeholder="Логин или E-mail"/>
			<input type="password" required name="passw" placeholder="Пароль"/>
			<button>Войти</button>
			<!--<p class="message">Not registered? <a href="#">Create an account</a></p>-->
		</form>
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

