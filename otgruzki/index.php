<?php
//////////index_otgruzki
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
 if(isset($_GET['otgruz_date'])){
 if(empty($_GET['otgruz_date'])){
 header("Location: {$site}otgruzki?otgruz_date=$date");
 exit;
 }
 }
  ?>
  <!DOCTYPE html>
  <html>
  <?php require "$siteinc"."index/head.php"; ?>
  <body>
    <div class="big_content">
    <?php require "$siteinc"."index/header.php"; ?>
    <section>
      <?php require "$siteinc"."index/menu.php"; ?>
      <div class="content">
      <h1 style='color:blue; text-align:center;'>История отгрузок</h1><br>
	  <?php 
	   if(isset($_GET['otgruz_date'])){
    $otgruz_date = $_GET['otgruz_date'];
	$sql = "SELECT id, id_metal, kolich, chermet, cvetmet, date FROM histori_otgruz WHERE date = '$otgruz_date' AND obrabotka = 1";
    $result = mysql_query($sql);
	echo"<table class='table'>";
	         echo "<tr>
			  <th class='th'>Дата</th>
         <th class='th'>Наименование</th>
         <th class='th'>Вес</th>
         </tr>";
	while($row = mysql_fetch_array($result)){
	$id_metal = $row['id_metal'];
	$kolich_otgruz = $row['kolich'];
	$chermet = $row['chermet'];
	$cvetmet = $row['cvetmet'];
	$date_otgruz = $row['date'];
	////Считаем зп
	  $zp_chermet += $chermet;
	  $zp_cvetmet += $cvetmet;
	////
	$sql2 = "SELECT name FROM metal WHERE id = $id_metal";
    $result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2);
	$name_metal = $row2['name'];
	//////////////////
	 
		echo "<tr>
		<td class='td'><b>$date_otgruz</b></td>
        <td class='td'><b>$name_metal</b></td>
        <td class='td'><b>$kolich_otgruz кг</b></td>
        </tr>";
	 
	  }
	   echo"</table><br>";
	   /////////////
	   echo"<table class='table'>";
	    echo "<tr>
			  <th class='th'>Зарплата с чермета</th>
         <th class='th'>Зарплата с цветного</th>
         </tr>";
		 echo "<tr>
		<td class='td'><b>$zp_chermet</b></td>
        <td class='td'><b>$zp_cvetmet</b></td>
        </tr>";
	   echo"</table><br>";
	   //////////////
	   	   echo"</table><br>";
	   /////////////Пишем остатки после отгрузки
	   $sqloa = "SELECT balans, kolich_ostatok_c, kolich_ostatok_med, kolich_ostatok_lat, kolich_ostatok_a, kolich_ostatok_ch FROM ostatok_otgruz WHERE date = '$date_otgruz'";
	   $resultoa = mysql_query($sqloa) or die('Ошибка 777'.mysql_error());
	   $rowoa = mysql_fetch_array($resultoa);
	   $balans_oa = $rowoa['balans'];
	   $kolich_ostatok_c_oa = $rowoa['kolich_ostatok_c'];
	   $kolich_ostatok_med_oa = $rowoa['kolich_ostatok_med'];
	   $kolich_ostatok_lat_oa = $rowoa['kolich_ostatok_lat'];
	   $kolich_ostatok_a_oa = $rowoa['kolich_ostatok_a'];
	   $kolich_ostatok_ch_oa = $rowoa['kolich_ostatok_ch'];
	   echo"<table class='table'>";
	    echo "<tr>
		      <th class='th'>Остаток денег</th>
			  <th class='th'>Остаток цветного</th>
              <th class='th'>Остаток меди</th>
			  <th class='th'>Остаток латуни</th>
			  <th class='th'>Остаток акб</th>
			  <th class='th'>Остаток черного</th>
         </tr>";
		 echo "<tr>
		<td class='td'><b>$balans_oa</b></td>
        <td class='td'><b>$kolich_ostatok_c_oa</b></td>
		<td class='td'><b>$kolich_ostatok_med_oa</b></td>
        <td class='td'><b>$kolich_ostatok_lat_oa</b></td>
	    <td class='td'><b>$kolich_ostatok_a_oa</b></td>
        <td class='td'><b>$kolich_ostatok_ch_oa</b></td>
        </tr>";
	   echo"</table><br>";
	   ///////////////
	   
  }else{
	  	echo "<form class='form' action='' method='get'>";
		echo "<center><b>Дата: </b><input type='text' name='otgruz_date'>";
		echo "<input type='submit' name='otgruz' value='Поиск'></center><br>";
	    echo "</form>";
  $sql = "SELECT date FROM histori_otgruz WHERE obrabotka = 1 ORDER BY id DESC LIMIT 100";//последнии 50 отгрузок
  $result = mysql_query($sql);
  echo "<b>Список последних отгрузок</b><br>";
  echo"<table class='table'>";
  	    echo "<tr>
			  <th class='th'><center>Дата</center></th>
         </tr>";
  while($row = mysql_fetch_array($result)){
    $row_date = $row['date'];
    if($sec_date == $row_date){
      continue;
    }else{
    $sec_date = $row_date;
		 echo "<tr>
		<td class='td'><b><a href='{$site}otgruzki?otgruz_date=$row_date'>$row_date</a></b><br></td>
        </tr>";
    }
 }
 echo"</table><br>";
 }
	  ?>
</div>
</section>
<?php require "$siteinc"."index/footer.php"; ?>
</div>
</body>
</html>
<?php
}else{
header("Location: {$site}");
}
?>