<?php
//////////index_admin
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_http_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_define_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_func_inc.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/scripts/my_cfg_inc.php";
/////////////////////////////////
if($_SESSION['user'] === SES_ADMIN){
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
      <h1 style='color:blue; text-align:center;'>ЛЧМ/ЛЦМ</h1><br>
      <?php
      echo"<table class='table'>";
echo "<tr>
<th class='th'><a href='{$site}obrabotka_met.php?id=1'>ЧЕРМЕТ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=2'>МЕДЬ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=3'>АЛЮМИНИЙ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=4'>ЛАТУНЬ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=5'>СВИНЕЦ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=6'>НЕРЖАВЕЙКА</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=7'>НЕРЖАВЕЙКА6%</a></th>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=8'>Газ колонка</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=9'>Радиаторы</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=10'>Алюминий эл</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=11'>Алюминий мот</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=12'>Алюминий сам</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=13'>Заз блоки</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=14'>Банка алюм</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=15'>Свинец переп</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=16'>Свинец груз</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=17'>Цинк раз</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=18'>Цинк карб</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=19'>Струж медн</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=20'>Струж лат</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=21'>Струж алюм</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=22'>Струж нерж</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=23'>Теплообм чер ал</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=24'>Теплообм нерж ал</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=25'>Теплообм лат ал</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=26'>Теплообм медь ал</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=27'>Аккум полипр</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=28'>Аккум карб</a></td>
</tr>";
echo"</table><br>";
      ?>
<h1 style='color:blue; text-align:center;'>РЗМ</h1><br>
     <?php
      echo"<table class='table'>";
echo "<tr>
<th class='th'><a href='{$site}obrabotka_met.php?id=30'>БАБИТ Б80</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=34'>ВОЛЬФРАМ ЛОМ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=37'>ВК ТК БЕЗ НАПЛ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=55'>ТИТАН ЛОМ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=39'>МОЛИБДЕН ЛОМ</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=42'>БЫСТРОРЕЗ Р9 Р12 Р9К5</a></th>
<th class='th'><a href='{$site}obrabotka_met.php?id=48'>НИКЕЛЬ ЛОМ</a></th>

</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=29'>Бабит б83</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=31'>Бабит б50</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=32'>Бабит б16</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=33'>Бабит бн</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=35'>Вольфрам вн внжк</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=36'>Вольфрам вд внд</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=38'>Вк тк с наплавками</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=40'>Магниты 25 юндк</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=41'>Р6м5 р18</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=43'>Быстрорез микс</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=44'>Никель катодный</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=45'>Никель анодный</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=46'>Никель гранулир</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=47'>Никель бу</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=49'>Нихром х20н80</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=50'>Нихром х15н60</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=51'>Нержав б28</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=52'>Никельсод</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=53'>Скрап жаропроч</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=54'>Медно никел мн20</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=56'>Титан засор</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=57'>Титан струж</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=58'>Олово</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=59'>Сурьма</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=60'>Припой пос18-90</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=61'>Припой поссу 4-14</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=62'>Феррован фвд50</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=63'>Феррован фвд80</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=64'>Феррониоб 60 70</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=65'>Ферромолиб фмо60</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=66'>Ферромолиб фмо55</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=67'>Ферромолиб фмо50</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=68'>Феррохром 800</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=69'>Ферросилиц 45</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=70'>Ферромарг фмн</a></td>
</tr>";
echo "<tr>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=71'>Акум батареи тнж</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=72'>Акум батареи нк</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=73'>Акум батареи тпнж</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=74'>Плата электр</a></td>
<td class='td'><b><a href='{$site}obrabotka_met.php?id=75'>Вольфрам внк</a></td>
</tr>";
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
?>
<!DOCTYPE html>
<html>
<?php require "$siteinc"."index/head.php"; ?>
<body>
<div class="big_content">
<?php require "$siteinc"."index/header.php"; ?>
<section>
<?php require "$siteinc"."index/inc/form_inc.php"; ?>
<div class="content">
Например Логин: <b style='color: green;'>чр1</b> Пароль: <b style='color: green;'>8888</b><br>

</div>
</section>
<?php require "$siteinc"."index/footer.php"; ?>
</div>
</body>
</html>

<?php
}
?>