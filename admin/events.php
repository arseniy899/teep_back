<? require_once('include.php'); ?>
<html>
	<head>
	<title>TEEP | События</title>
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
				"edit":true,
				"delete":true,
				"add":true,
				colums:
				{
					"name":
					{
						"name":"Название"
					},
					"points":
					{
						"name":"Кол-во очков",
					},
					"dtStart":
					{
						"name":"Дата начала",
						"type":"date"
					},
					"dtEnd":
					{
						"name":"Дата завершения",
						"type":"date"
					}
					
				},
				'saveUrl': ADMIN_URL+"event.edit.php",
				'onRowClicked':function(entry)
				{
					console.log(entry);
					window.open("event.info.php?id="+entry.id,"_self");
				}
			});
			
		});
	</script>
	<body>
		<div class="top-bar">События</div>
		<? require('menu.php'); ?>
		
		<div id="page" style="">
			<!--<div class="table-add fab"><i class="icofont-ui-add"></i></div>-->
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

