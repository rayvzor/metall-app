<?php 
if($_SESSION['user'] === SES_ADMIN or $_SESSION['user'] === SES_PRODAVEC){
  $margin = '120';
}else{
  $margin = '40';
}
?>
<nav class="menu">
		  <ul>
		    <li style="margin-left:<?php echo $margin; ?>px;">
			  <a href="<?php echo $site; ?>">Главная</a><br>
		    </li>
		    <li>
			  <a href="<?php echo $site; ?>sklad">Заказы</a><br>
		    </li>
			<li>
			  <a href="<?php echo $site; ?>otgruz">Операторы</a><br>
		    </li>
			<li>
			</li>
		  </ul>
	    </nav>