<?php 
if($_SESSION['user'] === SES_ADMIN or $_SESSION['user'] === SES_PRODAVEC){
  $margin = '20';
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
			  <a href="<?php echo $site; ?>sklad">Склад</a><br>
		    </li>
			<li>
			  <a href="<?php echo $site; ?>otgruz">Отгрузка</a><br>
		    </li>
			<li>
			  <a href="<?php echo $site; ?>otgruzki">Отгрузки</a><br>
		    </li>
			<li>
			  <a href="<?php echo $site; ?>balans?histori_date=<?php echo $date; ?>">Баланс</a><br>
		    </li>
			<li>
			  <a href="<?php echo $site; ?>istoriya?histori_date=<?php echo $date; ?>">История</a><br>
		    </li>
			<li>
			  <a href="<?php echo $site; ?>uchet?histori_date=<?php echo $date; ?>">Учет</a><br>
		    </li>
			<li>
			</li>
		  </ul>
	    </nav>