<?php
//////////index_otgruzka
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
if(isset($_POST['otmen_otgruz'])){
  $sql = "DELETE FROM histori_otgruz WHERE obrabotka = 0";
  $result = mysql_query($sql) or die('ошибка'.mysql_error());
}
if(isset($_POST['okonch_otgruz'])){
	  $sql = "SELECT id, id_metal, kolich FROM histori_otgruz WHERE obrabotka = 0";
	  $result = mysql_query($sql);
	  while($row = mysql_fetch_array($result)){
	    $id_otgruz = $row['id'];
	    $id_metal_otgruz = $row['id_metal'];
		$kolich_otgruz = $row['kolich'];
		//////////знаем цену метала.
			  $sql6 = "SELECT cena FROM cena WHERE id_met = '$id_metal_otgruz'";
	          $result6 = mysql_query($sql6) or die('Ошибка111');
			  $row6 = mysql_fetch_array($result6);
			  $cena_met_otgruz = $row6['cena'];
		/////Узнаем количество на складе.
			  $sql2 = "SELECT kolich FROM sklad WHERE id_metal = '$id_metal_otgruz'";
	          $result2 = mysql_query($sql2) or die('Ошибка111');
			  $row2 = mysql_fetch_array($result2);
			  $kolich_sklad = $row2['kolich'];
		/////
		$ostatok = ($kolich_sklad - $kolich_otgruz);//Остаток
		/////////узнаем бонусы зп
		 $sql4 = "SELECT type FROM metal WHERE id = '$id_metal_otgruz'";
	     $result4 = mysql_query($sql4);
		 $row4 = mysql_fetch_array($result4);
		 $type_metal = $row4['type'];
		 if($type_metal == 1){
		   $bonus = 0.3;
		   $chermet_o += $kolich_otgruz;
		 }elseif($type_metal == 2){
		   $bonus = 1;
		   $cvetmet_o += $kolich_otgruz;
		   if($id_metal_otgruz == 2){
		   $med_o += $kolich_otgruz;
		   }elseif($id_metal_otgruz == 4){
		   $lat_o += $kolich_otgruz;
		   }
		 }elseif($type_metal == 3){
		   $bonus = 5;
		 }elseif($type_metal == 4){
		   $bonus = 1;
		   $akb_o += $kolich_otgruz;
		 }
		 ////////////считаем зп с бонусов
	    $zp_bonus = ($kolich_otgruz * $bonus);
		////////
		if($ostatok < 0){
		  //считаем зп
		$zp = (($ostatok * -1) * $cena_met_otgruz) + $zp_bonus;
		  //пишем остаток
		    $sql3 = "UPDATE sklad SET kolich = 0 WHERE id_metal = '$id_metal_otgruz'";
            $result3 = mysql_query($sql3);
			//Записываем зп в отчет
			if($type_metal == 1){
			$sql7 = "UPDATE histori_otgruz SET chermet = $zp WHERE id = '$id_otgruz'";/////////////////
            $result7 = mysql_query($sql7);
			}else{
			$sql7 = "UPDATE histori_otgruz SET cvetmet = $zp WHERE id = '$id_otgruz'";/////////////////
            $result7 = mysql_query($sql7);
			}
		  //записываем зп
		  	$sql8 = "UPDATE balans SET oborot = oborot - $zp, zarplata = zarplata + $zp";//возможно ошибка в запросе.
            $result8 = mysql_query($sql8);
		}else{
		//считаем зп
		$zp = $zp_bonus;
		//пишем остаток
			$sql3 = "UPDATE sklad SET kolich = '$ostatok' WHERE id_metal = '$id_metal_otgruz'";
            $result3 = mysql_query($sql3);
			//Записываем зп в отчет
			if($type_metal == 1){
			$sql7 = "UPDATE histori_otgruz SET chermet = $zp WHERE id = '$id_otgruz'";/////////////////
            $result7 = mysql_query($sql7);
			}else{
			$sql7 = "UPDATE histori_otgruz SET cvetmet = $zp WHERE id = '$id_otgruz'";/////////////////
            $result7 = mysql_query($sql7);
			}
		  //записываем зп
		  	$sql8 = "UPDATE balans SET oborot = oborot - $zp, zarplata = zarplata + $zp";//возможно ошибка в запросе.
            $result8 = mysql_query($sql8);
		
	  }
}
		 //////////////////////////////////////////////отправляем остатки в отгрузку
		 	$sqloo = "UPDATE ostatok_otgruz SET kolich_ostatok_c = kolich_ostatok_c - '$cvetmet_o', kolich_ostatok_med = kolich_ostatok_med - '$med_o', kolich_ostatok_lat = kolich_ostatok_lat - '$lat_o', kolich_ostatok_a = kolich_ostatok_a - '$akb_o', kolich_ostatok_ch = kolich_ostatok_ch - '$chermet_o' WHERE obrabotka = 0";/////////////////
            $resultoo = mysql_query($sqloo) or die('Ошибка7'.mysql_error());
			/////////////////узнаем минусовые ли остатки и дату
		 	 $sqly = "SELECT date, kolich_ostatok_c, kolich_ostatok_med, kolich_ostatok_lat, kolich_ostatok_a, kolich_ostatok_ch FROM ostatok_otgruz WHERE obrabotka = 0";
	         $resulty = mysql_query($sqly);
		     $rowy = mysql_fetch_array($resulty);
			 $kolich_ostatok_c = $rowy['kolich_ostatok_c'];
			 $kolich_ostatok_med = $rowy['kolich_ostatok_med'];
			 $kolich_ostatok_lat = $rowy['kolich_ostatok_lat'];
			 $kolich_ostatok_a = $rowy['kolich_ostatok_a'];
			 $kolich_ostatok_ch = $rowy['kolich_ostatok_ch'];
			 $date_otgr_ost = $rowy['date'];////Дата отгрузки
			 if($kolich_ostatok_c < 0){
			   $kolich_ostatok_c = 0;
			 }
			 if($kolich_ostatok_med < 0){
			   $kolich_ostatok_med = 0;
			 }
			 if($kolich_ostatok_lat < 0){
			   $kolich_ostatok_lat = 0;
			 }
			 if($kolich_ostatok_a < 0){
			   $kolich_ostatok_a = 0;
			 }
			 if($kolich_ostatok_ch < 0){
			   $kolich_ostatok_ch = 0;
			 }
			 $sqlyy = "UPDATE ostatok_otgruz SET kolich_ostatok_c = '$kolich_ostatok_c', kolich_ostatok_med = '$kolich_ostatok_med', kolich_ostatok_lat = '$kolich_ostatok_lat', kolich_ostatok_a = '$kolich_ostatok_a', kolich_ostatok_ch = '$kolich_ostatok_ch', obrabotka = 1 WHERE obrabotka = 0";/////////////////
             $resultyy = mysql_query($sqlyy) or die('Ошибка77'.mysql_error());
		 //////////////////////////////////////////////
/////меняем обработку в отгрузе
            $sql9 = "UPDATE histori_otgruz SET date = '$date_otgr_ost', obrabotka = 1 WHERE obrabotka = 0";//.............
            $result9 = mysql_query($sql9);
			header("Location: {$site}");//отправить на страницу с этой отгрузкой. .....................................................................................
			exit;
			}
//////////////////
if(isset($_POST['otgruz'])){
  $sqlaaa = "SELECT obrabotka FROM ostatok_otgruz WHERE obrabotka = 0";
  $resultaaa = mysql_query($sqlaaa);
  $rowaaa = mysql_fetch_array($resultaaa);
  if($rowaaa['obrabotka'] == null){
  header("Location: {$site}otgruz?ostatok=no");
  exit;
  }
  ///////////////////
  $id_met = $_POST['id_met'];
  $kolich_otgruz = $_POST['kolich_otgruz'];
    $sql = "INSERT INTO histori_otgruz (id_metal, kolich, date) VALUES ('$id_met', '$kolich_otgruz', '$date')";
    $result = mysql_query($sql) or die('Ошибкаа'. mysql_error());
  //$sql = "UPDATE sklad SET kolich = $kolich_sklad WHERE id = '$id_sklad'";
  //$result = mysql_query($sql);
  header("Location: {$site}otgruz?otgruz=ok");
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
      <h1 style='color:blue; text-align:center;'>Отгрузка</h1><br>
	  <?php 
	  if($_GET['ostatok'] == 'no'){
	  echo "<b style='color:green;'>Вы не начали отгрузку в разделе учет</b><br>";
	  }
	  	  if($_GET['otgruz'] == 'ok'){//Успешно
	    echo "<center><b style='color:green;'>Успешно!</b></center><br>";
	  }
	  $sql = "SELECT id, id_metal, kolich, date FROM histori_otgruz WHERE obrabotka = 0";
	  $result = mysql_query($sql);
	  $i = 0;
	  while($row = mysql_fetch_array($result)){
	    $kolich_otgruz_met = $row['kolich'];
		$id_met_otgruz = $row['id_metal'];
		///////////////////////////Узнаем название метала
		  $sql2 = "SELECT name FROM metal WHERE id = '$id_met_otgruz'";
	      $result2 = mysql_query($sql2);
		  $row2 = mysql_fetch_array($result2);
		  $name_metal_otgruz = $row2['name'];
		/////////////////////////
	    $id_histori_otgruz = $row['id'];//сушествует ли отгруз
	    if($i == 1){
		}elseif(!empty($id_histori_otgruz)){
	      $i = 1;
	    ///
		  echo "<form class='form' action='' method='post'>";
		  echo "<center><input type='submit' name='okonch_otgruz' value='Закончить отгрузку'></center><br>";
	      echo "</form>";
		  
		  echo "<form class='form' action='' method='post'>";
		  echo "<center><input type='submit' name='otmen_otgruz' value='Очистить'></center><br>";
	      echo "</form>";
		  
		 echo"<table class='table'>";
         echo "<tr>
         <th class='th'>Наименование</th>
         <th class='th'>Вес</th>
         </tr>";
	    }
		echo "<tr>
        <td class='td'><b>$name_metal_otgruz</b></td>
        <td class='td'><b>$kolich_otgruz_met кг</b></td>
        </tr>";
	  }
	  echo"</table><br>";

	  //////////////////////////////////////////////////////
	  $sql = "SELECT id, name FROM metal";
	  $result = mysql_query($sql);
	  ///////////////
	  while($row = mysql_fetch_array($result)){
	    $id_met = $row['id'];//
		$name_met = $row['name'];//
		//////////////////////////////////////
		//$sql3 = "SELECT id, kolich FROM sklad WHERE id_metal = $id_met";
		//$result3 = mysql_query($sql3);
		//$row3 = mysql_fetch_array($result3);
		//$id_sklad = $row3['id'];//
		//$kolich_sklad = $row3['kolich'];//
		////////////////////////////
		echo "<form class='form' action='' method='post'>";
		echo " <b>$name_met</b> <center>Количество (кг): <input type='text' name='kolich_otgruz'>";
		echo "<input type='hidden' name='id_met' value='$id_met'>";
		echo "<input type='submit' name='otgruz' value='Отгрузить'></center><br>";
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