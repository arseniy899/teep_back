<? require_once('include.php'); ?>
<html>
	<head>
	<title>TEEP | Институты</title>
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
				"table" : "institutes",
				"edit":true,
				"delete":true,
				"add":true,
				colums:
				{
					"id":
					{
						"name":"ID",
						"edit":false
					},
					"name":
					{
						"name":"Название",
						"required":true
					}
					
				}
				
			});
			
		});
	</script>
	<body>
		<div class="top-bar">Институты</div>
		<? require('menu.php'); ?>
		
		<div id="page" style="">
			<!--<div class="table-add fab"><i class="icofont-ui-add"></i></div>-->
		</div>
		<? require('templates/bottom.php'); ?>
	</body>
</html>

