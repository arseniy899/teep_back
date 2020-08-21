<?/*<div id="menu">
	<a href="index.php">Главная</a>
	
</div> 
<div class="menu_icon"  onclick="ReverseDisplay('menu');"><i class="icofont-navigation-menu"></i></div>*/?>
<div class="logout_icon" >
	<?if(IS_USER_ADMIN){?><a href="//<?=REMOTE_ROOT?>/admin/"><i class="icofont-fix-tools"></i></a><?}?>
	<i class="icofont-logout" onclick="logout()"></i>
	
</div>
