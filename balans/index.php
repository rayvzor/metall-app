<?php
//////////index_balans
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
if($_GET['otmena_oborot'] == 'on'){
$kolich_otmena = $_GET['kolich_otmena'];
$id_otmena = $_GET['id_otmena'];
$sql = "UPDATE balans SET oborot = oborot - $kolich_otmena";
$result = mysql_query($sql);
$sql = "UPDATE histori_money SET status = 0 WHERE id = $id_otmena";
$result = mysql_query($sql);
header("Location: {$site}balans?histori_date=$date");
exit;
}
if($_GET['otmena_zarplata'] == 'on'){
$kolich_otmena = $_GET['kolich_otmena'];
$id_otmena = $_GET['id_otmena'];
$sql = "UPDATE balans SET zarplata = zarplata + $kolich_otmena";
$result = mysql_query($sql);
$sql = "UPDATE histori_zarplata SET status = 0 WHERE id = $id_otmena";
$result = mysql_query($sql);
header("Location: {$site}balans?histori_date=$date");
exit;
}
$histori_date = $_GET['histori_date'];
if(isset($_POST['prihod'])){/////////////приход
if(empty($_POST['kolich_prihod'])){
  header("Location: {$site}balans?histori_date=$date");
  exit;
}
  $kolich_prihod = $_POST['kolich_prihod'];
  $sql = "UPDATE balans SET oborot = oborot + '$kolich_prihod' WHERE id = '1'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  $sql = "INSERT INTO histori_money (kolich, date) VALUES ($kolich_prihod, '$date')";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  header("Location: {$site}balans?histori_date=$date");
  exit;
}
if(isset($_POST['snyat'])){///////////снятие зарплаты
if(empty($_POST['kolich_prihod'])){
  header("Location: {$site}balans?histori_date=$date");
  exit;
}
  $sql = "SELECT zarplata FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $zarplata = $row['zarplata'];
  $kolich_snyat = $_POST['kolich_snyat'];
  if($kolich_snyat > $zarplata){
  header("Location: {$site}balans?zp=no&histori_date=$date");
  exit;
  }
  $sql = "UPDATE balans SET zarplata = zarplata - '$kolich_snyat' WHERE id = '1'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  $sql = "INSERT INTO histori_zarplata (kolich, date) VALUES ($kolich_snyat, '$date')";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  header("Location: {$site}balans?histori_date=$date");
  exit;
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
      <h1 style='color:blue; text-align:center;'>Баланс</h1><br>
	  <?php 
	  echo "<center><b><a href='{$site}balans/redaktor'>Редактировать баланс</a></b></center><br>";
  $sql = "SELECT oborot FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $oborot = $row['oborot'];
  $sql = "SELECT zarplata FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $zarplata = $row['zarplata'];
  $balans = ($oborot + $zarplata);
  if($_GET['zp'] == 'no'){
    echo "<center><b style='color:red;'>Нельзя снять сумму превышающюю зарплату!</b></center><br>";
  }
  echo "<b style='color:blue;'>Баланс:</b> <b style='color:red;'>$balans</b>
  <form class='form' action='' method='post'>
  <input type='text' name='kolich_prihod'><br>
  <input type='submit' name='prihod' value='Приход'><br>
  </form>
  <br> <b style='color:blue;'>Зарплата: </b><b style='color:green;'>$zarplata</b> 
  <form class='form' action='' method='post'>
  <input type='text' name='kolich_snyat'><br>
  <input type='submit' name='snyat' value='Снять'><br>
  </form>
  <br>";
  
   echo 
	   "<form class='form' action='' method='get'>
	   <b>Дата:</b> 
	   <input type='text' name='histori_date' value='$date'>
       <input type='submit' value='Поиск'><br>
       </form><br>"; 
	    $sql = "SELECT id, date, kolich, status FROM histori_money WHERE date = '$histori_date' ORDER BY id DESC";
	    $result = mysql_query($sql) or die('ошибка 333'.mysql_query());
		echo "<b style='color: green;'>Приходы:</b><br>";
	     echo"<table class='table'>";
echo "<tr>
<th class='th'>Статус</th>
<th class='th'>Дата</th>
<th class='th'>Количество</th>
</tr>";
	  //////////
	  
	  while($row = mysql_fetch_array($result)){
	  ///////////////////////////////////////////
	   $kolich = $row['kolich'];
	   $status = $row['status'];
	   $date_prihod = $row['date'];
	   $id_otmena = $row['id'];
	   //////////////////////////////////////////
	   if($status != 1){
	     $status_met = 'Отменeно';
	   }else{
	     $status_met = 'Отменить';
	   }
	   ////////////////////////////////////////////// ниже был минус в сумме
echo "<tr>
<td class='td'>";
if($status_met == 'Отменить'){
  if($date_prihod != $date){
    echo "<b title='Нельзя отменить действие за старую дату'>{$status_met}</b>";
  }else{
  echo "<b><a href='{$site}balans?otmena_oborot=on&kolich_otmena=$kolich&id_otmena=$id_otmena'>{$status_met}</a></b>";
  }
  }else{
  echo "$status_met";
}
echo "</td>
<td class='td'><b>{$date_prihod}</b></td>
<td class='td'><b>{$kolich}</b> Руб</td>
</tr>";
	  }
	  ///////////
	   echo"</table><br>";
	   ////////////////////////////////
	   
	    $sql = "SELECT id, date, kolich, status FROM histori_zarplata WHERE date = '$histori_date' ORDER BY id DESC";
	    $result = mysql_query($sql) or die('ошибка 333'.mysql_query());
		echo "<b style='color: green;'>Снятие зарплаты:</b><br>";
	     echo"<table class='table'>";
echo "<tr>
<th class='th'>Статус</th>
<th class='th'>Дата</th>
<th class='th'>Количество</th>
</tr>";
	  //////////
	  
	  while($row = mysql_fetch_array($result)){
	  ///////////////////////////////////////////
	   $kolich = $row['kolich'];
	   $status = $row['status'];
	   $date_prihod = $row['date'];
	   $id_otmena = $row['id'];
	   //////////////////////////////////////////
	   if($status != 1){
	     $status_met = 'Отменeно';
	   }else{
	     $status_met = 'Отменить';
	   }
	   ////////////////////////////////////////////// ниже был минус в сумме
echo "<tr>
<td class='td'>";
if($status_met == 'Отменить'){
  if($date_prihod != $date){
    echo "<b title='Нельзя отменить действие за старую дату'>{$status_met}</b>";
  }else{
  echo "<b><a href='{$site}balans?otmena_zarplata=on&kolich_otmena=$kolich&id_otmena=$id_otmena'>{$status_met}</a></b>";
  }
  }else{
  echo "$status_met";
}
echo "</td>
<td class='td'><b>{$date_prihod}</b></td>
<td class='td'><b>{$kolich}</b> Руб</td>
</tr>";
	  }
	  ///////////
	   echo"</table><br>";
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