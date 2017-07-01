<?php 
session_start();
connectDb();
mysql_query("set names utf8");
if(isset($_POST['login']) and isset($_POST['password'])){
    filterUser($_POST['login'], $_POST['password']);
	//теперь нам доступны $name; $login; $password;
	$sql = "
    SELECT id, login, password, ses
        FROM users
	    WHERE login = '$login'
	    AND password = '$password'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
    $ses = $row['ses'];
	$ses_id = $row['id'];
	$ses_name = $row['login'];
    if($ses === SES_ADMIN){
	   //$_SESSION['user'] = SES_ADMIN;
		$_SESSION['id'] = $ses_id;
		$_SESSION['name'] = $ses_name;
		//header("Location: {$_SERVER['PHP_SELF']}");
		header("Location: {$site}date/");
		exit;
	}else{
	  header("Location: {$site}activ/?login={$login}&password={$password}");////////активация.
	  exit;
	}
}
if($_SESSION['user'] === SES_ADMIN){
    if(isset($_GET['exit'])){
	    if($_GET['exit'] === 'on'){
		  if($_SESSION['user'] === SES_ADMIN){
		    $site = korenSite();
			if($_SERVER['PHP_SELF'] === '/catalog/info_tovar.php'){
			session_destroy();
			header("Location: {$site}catalog/");
			exit;
			}
		    //удаление сесии.
			session_destroy();
			header("Location: {$_SERVER['PHP_SELF']}");
			exit;
		  }
		    //удаление сесии.
			session_destroy();
			header("Location: {$_SERVER['PHP_SELF']}");
			exit;
        }
    }
	$name = $_SESSION['name'];//Имя.
	$id = $_SESSION['id'];//Идитинтификатор.
	$sql = '';
    $select = mysql_query($sql);
    $users = array();
	$date = $_SESSION['date'];
}
$site = korenSite();
$siteinc = incSite();
/////////////
?>