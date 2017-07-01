<?php
//////////index_активация
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
$kluch = '';
if(isset($_POST['activ'])){
$activ = $_POST['activ'];
$login = $_GET['login'];
$password = $_GET['password'];
$activ = md5($activ);//ключ
$login = trim(strip_tags($login));//Логин
$password = trim(strip_tags($password));//Пароль
$sql = "
    SELECT kluch
        FROM kluch
	    WHERE kluch = '$activ'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
    $activ_baza = $row['kluch'];
	if($activ_baza === $activ){
	  $sql = "INSERT INTO users (login, password) VALUES ('$login', '$password')";
	  mysql_query($sql) or die(mysql_error().'Ошибка запроса');
	  $_SESSION["user"] = 'admin';
	  $sql = "DELETE FROM kluch WHERE kluch = '$activ'";
	  mysql_query($sql) or die(mysql_error().'Ошибка запроса');
	  header("Location: {$site}?exit=on");////////активация.
	  exit;
	  //вносим 
	}else{
	  $kluch = "Не верно введен ключ!<br>";
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
      <?php require "$siteinc"."index/inc/form_inc2.php"; ?>
      <div class="content">
	  <?php
	  echo "<b>Создатель не несет ответственности за хранение информации!</b><br>";
	  echo $kluch;
	  echo "<a href='"."{$site}"."'>Повторно ввести пароль.";
  ?>
      </div>
    </section>
  <?php require "$siteinc"."index/footer.php"; ?>
    </div>
</body>
</html>