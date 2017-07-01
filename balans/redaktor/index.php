<?php
//////////index_redaktor_balans
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
if(isset($_POST['prihod'])){/////////////Редактировать приход.
  $kolich_prihod = $_POST['kolich_prihod'];
  $kolich_snyat = $_POST['kolich_snyat'];
  $sql = "UPDATE balans SET oborot = $kolich_prihod - $kolich_snyat WHERE id = '1'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  header("Location: {$site}balans/redaktor");
  exit;
}
if(isset($_POST['snyat'])){/////////////Редактировать зарплату.
  $kolich_snyat = $_POST['kolich_snyat'];
  $kolich_prihod = $_POST['kolich_prihod'];
  $summ_r = ($kolich_prihod - $kolich_snyat);
  $sql = "UPDATE balans SET oborot = $summ_r WHERE id = '1'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  $sql = "UPDATE balans SET zarplata = $kolich_snyat WHERE id = '1'";
  $result = mysql_query($sql) or die(mysql_error().'ошибка');
  header("Location: {$site}balans/redaktor");
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
      <h1 style='color:blue; text-align:center;'>Редактировать баланс</h1><br>
	  <?php 
  $sql = "SELECT oborot FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $oborot = $row['oborot'];
  $sql = "SELECT zarplata FROM balans WHERE id = '1'";
  $result = mysql_query($sql);
  $row = mysql_fetch_array($result);
  $zarplata = $row['zarplata'];
  $balans = ($oborot + $zarplata);
  echo "<b style='color:blue;'>Баланс:</b> <b style='color:red;'>$balans</b>
  <form class='form' action='' method='post'>
  <input type='text' name='kolich_prihod' value='$balans'>
  <input type='hidden' name='kolich_snyat' value='$zarplata'>
  <input type='submit' name='prihod' value='Сохранить'><br>
  </form>
  <br> <b style='color:blue;'>Зарплата: </b><b style='color:green;'>$zarplata</b> 
  <form class='form' action='' method='post'>
  <input type='text' name='kolich_snyat' value='$zarplata'>
  <input type='hidden' name='kolich_prihod' value='$balans'>
  <input type='submit' name='snyat' value='Сохранить'><br>
  </form>
  <br>";
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