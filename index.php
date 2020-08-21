<html>
	<? require_once('include.php'); ?>
	
	<head>
	<title>Личный кабинет</title>
	<? require('templates/head.php'); ?>
	<script src="//<?=REMOTE_ROOT?>/js/tables.js" 	lazyload		type="text/javascript"></script>
	<script src="//<?=REMOTE_ROOT?>/js/editor.js" 	lazyload		type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.8/js/fileinput.min.js" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			var userAvatar = document.getElementById("user-avatar");
			var table = createTable('history',
			{
				"table" : "events",
				"edit":false,
				"delete":false,
				"add":false,
				colums:
				{
					"eventName":
					{
						"name":"Событие"
					},
					"date":
					{
						"name":"Дата/время",
					},
					"roleName":
					{
						"name":"Роль"
					},
					"points":
					{
						"name":"Изменение"
					}
					
				},
				'url': API_URL+"user.points.history.php"
			});
			/*$("#avatar-change").on('click', function() 
			{
				$('#avatar-input').click();
				
			});*/
			$(userAvatar).on('click', function() 
			{
				$('#avatar-input').click();
				
			});
			$("#avatar-cancel").on('click', function() 
			{
				//show("avatar-change");
				//show("avatar-delete");
				hide("avatar-cancel");
				hide("avatar-save");
				userAvatar.src = API_URL+"/avatar.get.php";
			});
			$("#avatar-save").on('click', function() 
			{
				
				console.log(document.getElementById('avatar-input'));
				var blobFile = document.getElementById('avatar-input').files[0];
				var formData = new FormData();
				formData.append("avatar", blobFile);

				$.ajax({
					url: API_URL+"/avatar.upload.php",
					type: "POST",
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) 
					{
						var ajaxRes = JSON.parse(response).responce;
						Toast.showAjaxRes(ajaxRes);
						if(ajaxRes.error == 0)
						{
							//show("avatar-change");
							//show("avatar-delete");
							hide("avatar-cancel");
							hide("avatar-save");
					   }
					},
					error: function(jqXHR, textStatus, errorMessage) {
						console.log(errorMessage); // Optional
					}
				});
			});
			$("#avatar-delete").on('click', function() 
			{
				
				$.ajax({
					url: API_URL+"/avatar.delete.php",
					type: "GET",
					processData: false,
					contentType: false,
					success: function(response) 
					{
						var ajaxRes = JSON.parse(response).responce;
						Toast.showAjaxRes(ajaxRes);
						if(ajaxRes.error == 0)
						{
							show("avatar-change");
							hide("avatar-delete");
							hide("avatar-cancel");
							hide("avatar-save");
							document.getElementById("user-avatar").src = API_URL+"/avatar.get.php";
					   }
					},
					error: function(jqXHR, textStatus, errorMessage) {
						console.log(errorMessage); // Optional
					}
				});
			});
			document.getElementById('avatar-input').onchange = function (evt) {
				var tgt = evt.target || window.event.srcElement,
					files = tgt.files;

				// FileReader support
				if (FileReader && files && files.length) {
					var fr = new FileReader();
					fr.onload = function () {
						userAvatar.src = fr.result;
						//hide("avatar-change");
						//hide("avatar-delete");
						show("avatar-cancel");
						show("avatar-save");
					}
					fr.readAsDataURL(files[0]);
				}

				// Not supported
				else {
					// fallback -- perhaps submit the input to an iframe and temporarily store
					// them on the server until the user's session ends.
				}
			}
			// DEV ONLY!!
			var formCheckin = document.getElementById("form-checkin");
			formCheckin.addEventListener("submit", function (event) 
			{
				event.preventDefault();
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
							alert("You've got "+ajaxRes.data.points+" points");
					}
				};
				xhttp.open("POST", API_URL+"/event.checkin.php", true);
				xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xhttp.send(new URLSearchParams(new FormData(formCheckin)).toString());
			});
		});
	</script>
	
	</head>
	<body onload="">
		<div class="top-bar">Личный кабинет</div>
		<? require('templates/menu.php'); ?>
		<div id="page" style="">
			<div>
				<div style="position: relative;">
					<div style="float:left; margin-left:0px; width: 40%">
						<img class="user-avatar" id="user-avatar" src="//<?=INC_ROOT?>/api/avatar.get.php" />
						<div class="button green"  	id="avatar-save" 	style="display: none">Сохранить</div>
						<div class="button red"  	id="avatar-cancel" 	style="display: none">Отменить</div>
					</div>
					<div style="float:left; margin-left:20px;">
						<h1><?=$USER_OBJ->name?></h1>
						<h3><?=$USER_OBJ->instituteName?></h3>
					</div>
					
				</div>
				<input type="file" accept="image/png, image/jpeg" id="avatar-input" name="avatar" style="visibility: hidden;width: 0;height: 0;" size="chars">
				<div style="text-align:center; width: 40%;">
					
					
					<br />
					
					
					
				</div>
				
			</div>
			<? if(IS_USER_ADMIN){?>
			<div style="width: 100%; float: left;border-top: 1px solid #8e44ad;margin-top: 15px;">
				<h1>TEST ONLY! Check-in manually:</h1>
				<form class="form" id="form-checkin" >
					<input type="text" required name="hash" placeholder="Hash*"/>
					<button class="button green" >Check-in</button>
					
				</form>
			</div>
			<?}?>
			<div style="width: 100%; float: left;border-top: 1px solid #CCC;margin-top: 15px;">
				<h1>История:</h1>
				<div id="history"></div>
			</div>
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
	
</html>

