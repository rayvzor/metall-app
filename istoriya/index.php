<?php
//////////index_istoriya
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
if($_GET['otmena'] == 'on'){
$kolich_otmena = $_GET['kolich_otmena'];
$summ_otmena = $_GET['summ_otmena'];
$id_otmena = $_GET['id_otmena'];
$id_metal = $_GET['id_metal'];
$date_otmena = $_GET['date_otmena'];
            if($date_otmena == $date){
			  $sql = "UPDATE sklad SET kolich = kolich - $kolich_otmena WHERE id_metal = $id_metal";/////////////////
              $result = mysql_query($sql) or die('Ошибка1'.mysql_error());
			  $sql = "UPDATE balans SET oborot = oborot + $summ_otmena WHERE id = 1";/////////////////
              $result = mysql_query($sql) or die('Ошибка2');
			  $sql = "UPDATE histori SET status = 0 WHERE id = $id_otmena";
			  $result = mysql_query($sql) or die('Ошибка3');
			  header("Location: {$site}istoriya?histori_date=$date");
			  exit;
			}else{
			  header("Location: {$site}istoriya?histori_date=$date&otmena=no");
			  exit;
			}
}

  $histori_date = $_GET['histori_date'];
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
      <h1 style='color:blue; text-align:center;'>История (<?php echo $histori_date; ?>)</h1><br>
	  <?php 
	  if($_GET['otmena'] == 'no'){
	    echo "<center></b style='color:red;'>Нельзя отменить действие прошедшего рабочего дня!<b></center><br>";
	  }
      $sql = "SELECT id, date, id_metal, kolich, cena, time, status FROM histori WHERE date = '$histori_date' ORDER BY id DESC";
	  $result = mysql_query($sql);
	  /////////
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
	  
	  echo"<table class='table'>";
echo "<tr>
<th class='th'>Статус</th>
<th class='th'>Время</th>
<th class='th'>Наименование</th>
<th class='th'>Вес</th>
<th class='th'>Цена</th>
<th class='th'>Сумма</th>
</tr>";
	  //////////
	  
	  while($row = mysql_fetch_array($result)){
	  ///////////////////////////////////////////
	   $id_metal = $row['id_metal'];
	   $kolich = $row['kolich'];
	   $cena = $row['cena'];
	   $time = $row['time'];
	   $status = $row['status'];
	   $date_otmena = $row['date'];
	   //////////////////////////////////////////
	   $sql2 = "SELECT name FROM metal WHERE id = $id_metal";
	   $result2 = mysql_query($sql2);
	   $row2 = mysql_fetch_array($result2);
	   $name_metal = $row2['name'];//наименование метала.
	   //////////////////////////////////////////////
	   if($status != 1){
	     $status_met = 'Отменeно';
	   }else{
	     $status_met = 'Отменить';
	   }
	   $summ_otmena = $kolich * $cena;
	   $id_otmena = $row['id'];
	   ////////////////////////////////////////////// ниже был минус в сумме
echo "<tr>
<td class='td'>";
if($status_met == 'Отменить'){
  if($date_otmena != $date){
    echo "<b title='Нельзя отменить действие за старую дату'>{$status_met}</b>";
  }else{
  echo "<b><a href='{$site}istoriya?otmena=on&kolich_otmena=$kolich&summ_otmena=$summ_otmena&id_otmena=$id_otmena&id_metal=$id_metal&date_otmena=$date_otmena'>{$status_met}</a></b>";
  }
  }else{
  echo "$status_met";
}
echo "</td>
<td class='td'><b>{$time}</b></td>
<td class='td'><b>{$name_metal}</b></td>
<td class='td'><b>{$kolich}</b>кг.</td>
<td class='td'><b>{$cena}</b>руб.</td>
<td class='td'><b>".($kolich * $cena)."</b>руб.</td>
</tr>";
	  }
	  ///////////
	   echo"</table><br>";
	   /////////////
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