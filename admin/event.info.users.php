<? require_once('include.php'); ?>
<?
if(IO::getInt("id") == 0)
	exit("No event selected!");
$event = new Event(IO::getInt("id"));
$event->load_admin();

?>
<html>
	<head>
	<title>Выгрузка пользователей <?=$event->name?> на <?=date("m.d.y H:i:s")?></title>
		<? require('templates/head.php'); ?>
	</head>
	
	<script src="//<?=REMOTE_ROOT?>/js/tables.js" 	lazyload		type="text/javascript"></script>
	<script src="//<?=REMOTE_ROOT?>/js/editor.js" 	lazyload		type="text/javascript"></script>
	<script src="//<?=REMOTE_ROOT?>/js/cronstrue.js" lazyload async=""></script>
	<script src="//<?=REMOTE_ROOT?>/js/later.js" lazyload type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() 
		{	
			var table = createTable('page',
			{
				"table" : "events",
				"edit":false,
				"delete":false,
				"add":false,
				colums:
				{
					"userid":
					{
						"name":"ID пользователя"
					},
					"name":
					{
						"name":"ФИО",
					},
					"instituteName":
					{
						"name":"Институт",
					},
					"login":
					{
						"name":"Логин",
					},
					"points":
					{
						"name":"Кол-во очков"
					},
					"roleName":
					{
						"name":"Роль"
					},
					"dtAdded":
					{
						"name":"Дата/время"
					}
					
				},
				'url': ADMIN_URL+"event.info.load.users.php?id="+<?=IO::getInt("id")?>,
				'onRowClicked':function(entry)
				{
					console.log(entry);
					window.open("event.info.php?id="+entry.id,"_self");
				}
			});
			
		});
	</script>
	<body>
		<div id="page" style="top: 15px;">
			<h1>Выгрузка пользователей <b><?=$event->name?></b> на <?=date("m.d.y H:i:s")?></h1>
			<!--<div class="table-add fab"><i class="icofont-ui-add"></i></div>-->
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

