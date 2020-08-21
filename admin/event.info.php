<? require_once('include.php'); ?>
<?
if(IO::getInt("id") == 0)
	exit("No event selected!");
$event = new Event(IO::getInt("id"));
$event->load_admin();

?>
<html>
	<head>
	<title>TEEP | События.<?=$event->name?></title>
		<? require('templates/head.php'); ?>
	</head>
	
	<script src="//<?=REMOTE_ROOT?>/js/tables.js" 	lazyload		type="text/javascript"></script>
	<script src="//<?=REMOTE_ROOT?>/js/editor.js" 	lazyload		type="text/javascript"></script>
	<script src="//<?=REMOTE_ROOT?>/js/cronstrue.js" lazyload async=""></script>
	<script src="//<?=REMOTE_ROOT?>/js/later.js" lazyload type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			
			var table = createTable('role-links',
			{
				"table" : "events",
				"edit":false,
				"delete":false,
				"add":false,
				colums:
				{
					"roleName":
					{
						"name":"Роль"
					},
					"link":
					{
						"name":"Ссылка",
					}
					
				},
				'url': ADMIN_URL+"event.roles.link.list.php?id="+<?=$event->id?>
			});
			
		});
		function addLink()
		{
			var type = document.getElementById('link-create-role-type').value;
			$.ajax({
				url: ADMIN_URL+"/event.roles.link.create.php?id="+EVENT_ID+"&role="+type,
				type: "GET",
				processData: false,
				contentType: false,
				success: function(response) 
				{
					var ajaxRes = JSON.parse(response).responce;
					Toast.showAjaxRes(ajaxRes);
					if(ajaxRes.error == 0)
					{
						window.location.reload(true);
				   }
				},
				error: function(jqXHR, textStatus, errorMessage) {
					console.log(errorMessage); // Optional
				}
			});
		}
		var EVENT_ID = <?=$event->id?>;
	</script>
	<body>
		<div class="top-bar">События.<?=$event->name?></div>
		<? require('menu.php'); ?>
		
		<div id="page" style="">
			<div>
				<div style="float: left;border-right: 1px solid #CCC; padding: 50px; height: 500px;width:60%">
					<h1>Название: <b><?=$event->name?></b></h1>
					<h3>Даты проведения: <b><?=$event->dtStart?> - <?=$event->dtEnd?></b></h3>
					<h3>Кол-во очков: <b><?=$event->points?></b></h3>
					<h3>Кол-во участников: <b><?=$event->usersChecked?></b></h3>
					<br /><br /><br />
					<div class="button green"  onclick="window.open('event.info.users.php?id='+EVENT_ID,'_blank');">Выгрузка участников (HTML)</div>
					<div class="button green"  onclick="window.open('event.info.load.users.export.csv.php?id='+EVENT_ID,'_blank');">Выгрузка участников (CSV)</div>
					
				</div>
				<div style="float: right;text-align:center; width: 40%; margin-top: 50px;">
					
					<img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&format=png&ecc=H&qzone=3&data=<?=$event->hash?>" />
					<br /><br /><br /><br />
					<h5>Хеш события: <b><?=$event->hash?></b></h5>
					<div class="button green"  onclick="window.open('https://api.qrserver.com/v1/create-qr-code/?size=250x250&format=svg&ecc=H&qzone=3&data=<?=$event->hash?>','_blank');">Распечатать</div>
					
				</div>
				
			</div>
			<div style="width: 100%; float: left;border-top: 1px solid #CCC;margin-top: 15px;">
				<h1>Ссылки организаторов:</h1>
					<div style="border: 1px solid #CCC;padding: 20px;margin: 5px;">
						<h3>Создать ссылку</h3>
						<select id="link-create-role-type" style="width: 50%;float: inherit;">
							<?
								foreach (Event::get_roles() as $id => $name)
								{
									$id = $name['id'];
									$name = $name['name'];
									echo "<option value='{$id}'>{$name}</option>";
								}
							?>
						</select>
						<div class="button green"  onclick="addLink()">Создать</div>
					</div>
				<div id="role-links"></div>
			</div>
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

