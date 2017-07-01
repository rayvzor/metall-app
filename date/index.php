<?php
//////////index_date
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if(isset($_SESSION['name'])){
$sql = "SELECT date FROM date";
		$result = mysql_query($sql) or die('Ошибка 555'.mysql_error());
		$row = mysql_fetch_array($result);
		$prov_date = $row['date'];
if(isset($_POST['date'])){
		if(!empty($prov_date)){
		  if($_POST['date'] != $prov_date){
		  header("Location: {$site}date?vhoddate=no");
		  exit;
		  }
		}
        if(empty($_POST['date'])){
		 $text_date =  "Вы не ввели дату!<br>";
		}else{
		$sqll = "SELECT date FROM histori_otchet";
		$resultl = mysql_query($sqll);
		  while($rowl = mysql_fetch_array($resultl)){
		    if($rowl['date'] == $_POST['date']){
		      header("Location: {$site}");
			  exit;
		    }else{
			continue;
			}
		  }
  	    $_SESSION['user'] = SES_ADMIN;
		$_SESSION['date'] = $_POST['date'];
		$date_save = $_POST['date'];
		if($_POST['date'] != $prov_date){
		$sql = "INSERT INTO date (date) VALUES ('$date_save')";
        $result = mysql_query($sql) or die('Ошибкаа'. mysql_error());
		}
		////////
		/////////
		header("Location: {$site}");
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
      <?php require "$siteinc"."index/inc/form_inc3.php"; ?>
      <div class="content">
	  <?php
	  if(!empty($prov_date)){
	    echo "Предыдущий рабочий день: $prov_date <br>";
	  }
	  if($_GET['vhoddate'] == 'no'){
	    echo "<b style='color: red;'>Сначало нужно закончить предыдущий рабочий день!</b><br>";
	  }
      echo $text_date;
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