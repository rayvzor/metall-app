<?php
//////////obrabotka_met
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
///////
$id_met = $_GET['id'];
$sql = "SELECT name FROM metal WHERE id = '$id_met'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$name_met = $row['name'];//Наименование метала.
///////////////////////////////////////////////////////////////
if(isset($_POST['ok'])){
$kg = $_POST['kolich'];
$cena_met = $_POST['cena'];
$zasor = $_POST['zasor'];
$summ = $_POST['summ'];
$kg = $kg -(($kg/100)*$zasor);
//отправка в историю.
  $time = date('H:i');
  $sql = "INSERT INTO histori (id_metal, kolich, cena, date, time) VALUES ($id_met, $kg, $cena_met, '$date', '$time')";
  $result = mysql_query($sql) or die(mysql_error().'ошибка2'.mysql_error());
  $sql = "UPDATE sklad SET kolich = kolich + '$kg' WHERE id_metal = '$id_met'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  $sql = "UPDATE balans SET oborot = oborot - '$summ' WHERE id = '1'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  header("Location: {$site}");
  exit;
}
if(isset($_POST['otmena'])){
header("Location: {$site}obrabotka_met.php?id=$id_met");
exit;
}
///////////////////////////////////////////////////////////////
if(isset($_POST['kg']) and isset($_POST['zasor'])){
$kg = $_POST['kg'];
$zasor = $_POST['zasor'];
$kg_zasor = $kg -(($kg/100)*$zasor);
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
      <h1 style='color:blue; text-align:center;'>ЧЕК</h1><br>
	  <?php
	  $sql = "SELECT cena FROM cena WHERE id_met = '$id_met'";
      $result = mysql_query($sql);
      $row = mysql_fetch_array($result);
	  $cena_met = $row['cena'];
	  $summ = ($kg*$cena_met) - ((($kg*$cena_met)/100)*$zasor);
echo"<table class='table'>";
echo "<tr>
<th class='th'>Наименование</th>
<th class='th'>Вес</th>
<th class='th'>Засор</th>
<th class='th'>Вес с засором</th>
<th class='th'>Цена</th>
<th class='th'>Сумма</th>
</tr>";
echo "<tr>
<td class='td'><b>$name_met</b></td>
<td class='td'><b>$kg</b> кг</td>
<td class='td'><b>$zasor</b> %</td>
<td class='td'><b>$kg_zasor</b> кг</td>
<td class='td'><b>$cena_met</b> руб</td>
<td class='td'><b>$summ</b> руб</td>
</tr>";
echo"</table><br>";
?>
            <form action='' method='post'>
			<input type='hidden' name='kolich' value='<?php echo $kg; ?>'>
			<input type='hidden' name='summ' value='<?php echo $summ; ?>'>
			<input type='hidden' name='cena' value='<?php echo $cena_met; ?>'>
			<input type='hidden' name='zasor' value='<?php echo $zasor; ?>'>
			<input type='submit' name='ok' value='ОК'>
			<input type='submit' name='otmena' value='ОТМЕНА'><br>
			</form><br>
</div>
</section>
<?php require "$siteinc"."index/footer.php"; ?>
</div>
</body>
</html>
<?php
exit;
}
///////////////////////////////////////////////////////////////////
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
      <h1 style='color:blue; text-align:center;'><?php echo $name_met; ?></h1><br>
	  			<form action='' method='post'>
			<b>КГ</b>
			<input type='text' name='kg'>
			<b>%</b>
			<input type='text' name='zasor'>
			<input type='submit' value='ЧЕК'><br>
			</form><br>
	  
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