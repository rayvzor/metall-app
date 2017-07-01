<?php 
function filterUser($login, $password, $name=''){
    $GLOBALS['name'] = trim(strip_tags($name));
	$GLOBALS['login'] = trim(strip_tags($login));
	$GLOBALS['password'] = md5(trim(strip_tags($password)));
}

function filterName($name){
    $GLOBALS['name'] = trim(strip_tags($name));
}

function connectDb(){
	$connect = @mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD);
	if(!$connect){
	die(mysql_error() . ' Сайт временно не доступен.');
    }
	mysql_select_db(DB_NAME);
	return $connect;
}

function korenSite(){
    $korensite = "http://{$_SERVER["SERVER_NAME"]}/"; //"http://"."{$_SERVER["SERVER_NAME"]}"."/";
	return $korensite;
}

function incSite(){
    $incsite = $_SERVER['DOCUMENT_ROOT']."/";
	return $incsite;
}

function razdel(){
    $sql = "SELECT id, name, status FROM razdel";
    $result = mysql_query($sql);
    while($row = mysql_fetch_array($result)){
	  if($row['status'] === '0'){
	  continue;
	  }
      echo "<a href='?section={$row['id']}'>{$row['name']}</a><br>";
    }
}
?>