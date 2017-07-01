	  <header>
	    <div class="header">
<table>
<tr>
<td class='header_td_1'>
<div class='div_name'>
<?php
if($_SESSION['user'] === SES_ADMIN){
  echo "<span>Дата: <b>$date</b></span>";
}
?>
</div>
</td>
<td class='header_td_2'>
<div class='div_search'>
<?php
if($_SESSION['user'] === SES_ADMIN){
  $sql = "SELECT oborot FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $oborot = $row['oborot'];
  $sql = "SELECT zarplata FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $zarplata = $row['zarplata'];
  $balans = ($oborot + $zarplata);
  echo "<span><b style='color:green;'>Баланс:</b> [<a href='{$site}balans'> <b>$balans</b></a>]</span>";
}
?>
</div>
</td>
<td class='header_td_3'>
<div>
<?php
if($_SESSION['user'] === SES_ADMIN){
}
if($_SESSION['user'] === SES_ADMIN){
echo "<td><div style='padding-top:5px;'><a href='?exit=on'><img style='width:70px; height:60px;' src='{$site}images/exit.png'></a></div></td>";
}
?>
</div>
</td>
</tr>
</table>
	    </div>
	  </header>