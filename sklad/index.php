<?php
//////////index_sklad
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
//////////////////
if(isset($_POST['sohranka'])){
  $id_cena = $_POST['id_cena'];
  $cena_cena = $_POST['cena_cena'];
  $id_sklad = $_POST['id_sklad'];
  $kolich_sklad = $_POST['kolich_sklad'];
  $sql = "UPDATE cena SET cena = $cena_cena WHERE id = '$id_cena'";
  $result = mysql_query($sql);
  ////обновили цену
  $sql = "UPDATE sklad SET kolich = $kolich_sklad WHERE id = '$id_sklad'";
  $result = mysql_query($sql);
  header("Location: {$site}sklad");
  exit;
}
/////////////////
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
      <h1 style='color:blue; text-align:center;'>Склад</h1><br>
	  <?php 
	  //////////////////////////////////////////////////////.....ОБНОВА СКЛАДА.....
	  $sql = "SELECT id, name FROM metal";
	  $result = mysql_query($sql);
	  ///////////////
	  while($row = mysql_fetch_array($result)){
	    $id_met = $row['id'];//
		$name_met = $row['name'];//
		//////////////////////////////////////
		$sql2 = "SELECT id, cena FROM cena WHERE id_met = $id_met";
		$result2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($result2);
		$id_cena = $row2['id'];//
		$cena_cena = $row2['cena'];//
		//////////////////////////////////////
		$sql3 = "SELECT id, kolich FROM sklad WHERE id_metal = $id_met";
		$result3 = mysql_query($sql3);
		$row3 = mysql_fetch_array($result3);
		$id_sklad = $row3['id'];//
		$kolich_sklad = $row3['kolich'];//
		echo "<form class='form' action='' method='post'>";
		echo " <b>$name_met</b> <center>Цена: <input type='text' name='cena_cena' value='$cena_cena'> Количество: <input type='text' name='kolich_sklad' value='$kolich_sklad'>";
		echo "<input type='hidden' name='id_cena' value='$id_cena'>";
		echo "<input type='hidden' name='id_sklad' value='$id_sklad'>";
		echo "<input type='submit' name='sohranka' value='Сохранить'></center><br>";
	    echo "</form>";
	  }
	  ///
	  
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