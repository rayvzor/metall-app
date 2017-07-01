<?php
//////////index_uchet
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
if(isset($_POST['otmenaa'])){
  $sql = "DELETE FROM histori_otgruz WHERE obrabotka = 0";
  $result = mysql_query($sql) or die('ошибка'.mysql_error());
    $sql = "DELETE FROM ostatok_otgruz WHERE obrabotka = 0";
  $result = mysql_query($sql) or die('ошибка'.mysql_error());
  header("Location: {$site}uchet/?histori_date=$date");
}
$histori_date = $_GET['histori_date'];
///////////////отправка остатков в отгрузку
if(isset($_POST['nachat'])){
  $balans = $_POST['balans_z'];
  $kolich_ostatok_c = $_POST['kolich_ostatok_c_z'];
  $kolich_ostatok_med = $_POST['kolich_ostatok_med_z'];
  $kolich_ostatok_lat = $_POST['kolich_ostatok_lat_z'];
  $kolich_ostatok_a = $_POST['kolich_ostatok_a_z'];
  $kolich_ostatok_ch = $_POST['kolich_ostatok_ch_z'];
  $sql = "INSERT INTO ostatok_otgruz (date, balans, kolich_ostatok_c, kolich_ostatok_med, kolich_ostatok_lat, kolich_ostatok_a, kolich_ostatok_ch) VALUES ('$date', $balans, $kolich_ostatok_c, $kolich_ostatok_med, $kolich_ostatok_lat, $kolich_ostatok_a, $kolich_ostatok_ch)";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  header("Location: {$site}uchet?histori_date=$date");
  exit;
}
///////////////////////////отправка отчета в бд
if(isset($_POST['zakonchit'])){
  $balans = $_POST['balans_z'];
  $kolich_ostatok_c = $_POST['kolich_ostatok_c_z'];
  $kolich_ostatok_med = $_POST['kolich_ostatok_med_z'];
  $kolich_ostatok_lat = $_POST['kolich_ostatok_lat_z'];
  $kolich_ostatok_a = $_POST['kolich_ostatok_a_z'];
  $kolich_ostatok_ch = $_POST['kolich_ostatok_ch_z'];
  $sql = "INSERT INTO histori_otchet (date, balans, kolich_ostatok_c, kolich_ostatok_med, kolich_ostatok_lat, kolich_ostatok_a, kolich_ostatok_ch) VALUES ('$date', $balans, $kolich_ostatok_c, $kolich_ostatok_med, $kolich_ostatok_lat, $kolich_ostatok_a, $kolich_ostatok_ch)";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  $sql = "DELETE FROM date";
  $result = mysql_query($sql);
  header("Location: {$site}?exit=on");
  exit;
}
///////////////////////////
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
      <h1 style='color:blue; text-align:center;'>Учет (<?php echo $histori_date; ?>)</h1><br>
	  
	  
	   <?php 
	   
	   ///////////
	   echo"</table><br>";
	   //////////////////////////////////////////
	   echo 
	   "<form class='form' action='' method='get'>
	   <b>Дата:</b> 
	   <input type='text' name='histori_date' value='$date'>
       <input type='submit' value='Поиск'><br>
       </form><br>";
	   ///////////////////////////////////////////
	   
	  /////////
	  echo"<table class='table'>";
echo "<tr>
<th class='th'>ДАТА</th>
<th class='th'>ЦМ</th>
<th class='th'>АКБ</th>
<th class='th'>РЗМ</th>
<th class='th'>ЛЧМ</th>
<th class='th'>ПРИХОД</th>
<th class='th'>ЗАТРАТЫ</th>
<th class='th'>ОСТАТОК</th>
<th class='th'>ЦО</th>
<th class='th'>МО</th>
<th class='th'>ЛО</th>
<th class='th'>АО</th>
<th class='th'>ЧО</th>
</tr>";
//////////////////////////подсчет приход///////////////////////////////////////////////////////////////////////////////////////////////
	  $sql = "SELECT kolich, status FROM histori_money WHERE date = '$histori_date'";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result)){
	    if($row['status'] != 1){
		  continue;
		}
	    $kolich_money += $row['kolich'];
	  }
/////////////////////////
/////////////////////////подсчет остатков//////////////////////////

	  $sql = "SELECT date, balans, kolich_ostatok_c, kolich_ostatok_med, kolich_ostatok_lat, kolich_ostatok_a, kolich_ostatok_ch FROM histori_otchet WHERE date = '$histori_date'";
	  $result = mysql_query($sql);
	  $row = mysql_fetch_array($result);
	  if($row['date'] == $histori_date){
	  $balans = $row['balans'];
	  $kolich_ostatok_c = $row['kolich_ostatok_c'];
	  $kolich_ostatok_med = $row['kolich_ostatok_med'];
	  $kolich_ostatok_lat = $row['kolich_ostatok_lat'];
	  $kolich_ostatok_a = $row['kolich_ostatok_a'];
	  $kolich_ostatok_ch = $row['kolich_ostatok_ch'];
	  }else{
////////////////БАЛАНС//////////////////////////////////////
  $sql = "SELECT oborot FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $oborot = $row['oborot'];
  $sql = "SELECT zarplata FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $zarplata = $row['zarplata'];
  $balans = ($oborot + $zarplata);
////////////////////////////////////////////////////////////


	  $sql = "SELECT kolich FROM sklad WHERE id_metal = 2";
	  $result = mysql_query($sql) or die('Ошибка1');
	  $row = mysql_fetch_array($result);
	  $kolich_ostatok_med = $row['kolich'];//Медь остаток
	  
	  	  $sql = "SELECT kolich FROM sklad WHERE id_metal = 4";
	  $result = mysql_query($sql) or die('Ошибка2');
	  $row = mysql_fetch_array($result);
	  $kolich_ostatok_lat = $row['kolich'];//Латунь остаток
	  
	  
	  
	  $sql = "SELECT id, type FROM metal";
	  $result = mysql_query($sql) or die('Ошибка3');
	  while($row = mysql_fetch_array($result)){
	  $id_metal = $row['id'];
	    if($row['type'] == 1){
		  $sql2 = "SELECT kolich FROM sklad WHERE id_metal = '$id_metal'";
	      $result2 = mysql_query($sql2) or die('Ошибка');
		  $row2 = mysql_fetch_array($result2);
		  $kolich_ostatok_ch += $row2['kolich'];//чермет
		}elseif($row['type'] == 2){
		$sql2 = "SELECT kolich FROM sklad WHERE id_metal = '$id_metal'";
	    $result2 = mysql_query($sql2) or die('Ошибка');
		$row2 = mysql_fetch_array($result2);
		$kolich_ostatok_c += $row2['kolich'];//цветмет
		}elseif($row['type'] == 4){
		$sql2 = "SELECT kolich FROM sklad WHERE id_metal = '$id_metal'";
	    $result2 = mysql_query($sql2) or die('Ошибка');
		$row2 = mysql_fetch_array($result2);
		$kolich_ostatok_a += $row2['kolich'];//акб
		}
	  }
	  //$row = mysql_fetch_array($result);
	  }
///////////////////////////////////////////////////////////////////
	  //////////////
	  $sql = "SELECT id_metal, kolich, cena, status FROM histori WHERE date = '$histori_date' AND status = 1";
	  $result = mysql_query($sql);
	  ////////////
	  while($row = mysql_fetch_array($result)){
	  ///////////////////////////////////////////
	   $id_metal = $row['id_metal'];
	   $kolich = $row['kolich'];
	   $cena = $row['cena'];
	   $time = $row['time'];
	   $status = $row['status'];
	   ///////////////////////////////////////////////////
	  $sql3 = "SELECT type FROM metal WHERE id = '$id_metal'";
	  $result3 = mysql_query($sql3) or die('Ошибка');
	  $row3 = mysql_fetch_array($result3);
	  $type_met = $row3['type'];
	  if($type_met == 1){
	  /////
	  $kolich_ch += $kolich;
	  $zatraty += ($kolich * $cena);
	  //////
	  }elseif($type_met == 2){
	  //////
	  $kolich_c += $kolich;
	  $zatraty += ($kolich * $cena);
	  //////
	  }elseif($type_met == 3){
	  //////
	  $kolich_r += $kolich;
	  $zatraty += ($kolich * $cena);
	  //////
	  }elseif($type_met == 4){
	  //////
	  $kolich_a += $kolich;
	  $zatraty += ($kolich * $cena);
	  //////
	  }

	}
	
		  /////////////////////////////////если нету пишем '0'.
if(empty($kolich_c)){
$kolich_c = '0';
}if(empty($kolich_a)){
$kolich_a = '0';
}if(empty($kolich_r)){
$kolich_r = '0';
}if(empty($kolich_ch)){
$kolich_ch = '0';
}if(empty($kolich_money)){
$kolich_money = '0';
}if(empty($zatraty)){
$zatraty = '0';
}

	  //////////////////////////////////////////////////
	
echo "<tr>
<td class='td'><b>{$histori_date}</b></td>
<td class='td'><b>{$kolich_c}</b></td>
<td class='td'><b>{$kolich_a}</b></td>
<td class='td'><b>{$kolich_r}</b></td>
<td class='td'><b>{$kolich_ch}</b></td>
<td class='td'><b>{$kolich_money}</b></td>
<td class='td'><b>{$zatraty}</b></td>
<td class='td'><b>{$balans}</b></td>
<td class='td'><b>{$kolich_ostatok_c}</b></td>
<td class='td'><b>{$kolich_ostatok_med}</b></td>
<td class='td'><b>{$kolich_ostatok_lat}</b></td>
<td class='td'><b>{$kolich_ostatok_a}</b></td>
<td class='td'><b>{$kolich_ostatok_ch}</b></td>
</tr>";
	  ///////////
	   echo"</table><br>";
	   //////////////////////////////////////////
	   $sqlo = "SELECT obrabotka FROM ostatok_otgruz WHERE obrabotka = 0";
	   $resulto = mysql_query($sqlo);
	   $rowo = mysql_fetch_array($resulto);
	   $obrabotkao = $rowo['obrabotka'];
	   if($obrabotkao == null){
	   	   echo 
	   "<form class='form' action='' method='post'>
       <input type='hidden' name='balans_z' value='$balans'>
	   <input type='hidden' name='kolich_ostatok_c_z' value='$kolich_ostatok_c'>
	   <input type='hidden' name='kolich_ostatok_med_z' value='$kolich_ostatok_med'>
	   <input type='hidden' name='kolich_ostatok_lat_z' value='$kolich_ostatok_lat'>
	   <input type='hidden' name='kolich_ostatok_a_z' value='$kolich_ostatok_a'>
	   <input type='hidden' name='kolich_ostatok_ch_z' value='$kolich_ostatok_ch'>
       <input type='submit' name='nachat' value='Начать отгрузку'><br>
       </form><br>";
	   }else{
	     echo "[<b style='color:green;'>Ожидание отгрузки</b>]<br><br>";
		  	   echo 
	   "<form class='form' action='' method='post'>
       <input type='submit' name='otmenaa' value='Отменить отгрузку'><br>
       </form><br>";
	   }
	   echo 
	   "<form class='form' action='' method='post'>
       <input type='hidden' name='balans_z' value='$balans'>
	   <input type='hidden' name='kolich_ostatok_c_z' value='$kolich_ostatok_c'>
	   <input type='hidden' name='kolich_ostatok_med_z' value='$kolich_ostatok_med'>
	   <input type='hidden' name='kolich_ostatok_lat_z' value='$kolich_ostatok_lat'>
	   <input type='hidden' name='kolich_ostatok_a_z' value='$kolich_ostatok_a'>
	   <input type='hidden' name='kolich_ostatok_ch_z' value='$kolich_ostatok_ch'>
       <input type='submit' name='zakonchit' value='Закончить рабочий день'><br>
       </form>";
	   ///////////////////////////////////////////
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