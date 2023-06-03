<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<title>Результаты</title>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        TABLE {
            width: 600px; /* Ширина таблицы */
            border-collapse: collapse; /* Убираем двойные линии между ячейками */
        }
        TD, TH {
            padding: 3px; /* Поля вокруг содержимого таблицы */
            border: 1px solid black; /* Параметры рамки */
        }
        TH {
            background: #b0e0e6; /* Цвет фона */
        }
    </style>
    <link rel="stylesheet" href="css1.css">
</head>
 <header>
  <nav class="links">
    <a href="index.php">На главную</a>
<a href="tests.php">Назад</a>
    <a href="logout.php">Выход</a>
    
  </nav>
</header>
<br><br>
<?php
session_start();
$id = $_GET['id'];
echo "<center>";
echo "<h2>Вы просматриваете результаты контрольной работы №$id.</h2><br>";
require_once 'setting.php';
$connection = new mysqli($host, $user, $pass, $data);
if ($connection->connect_error) die('Error connection');

$query = "SELECT * FROM marks WHERE taskID = $id";
$result = $connection->query($query);

if(!$result) die('Error SELECT');

$rows = $result->num_rows;

echo "<table>";

echo "<tr>";
echo "<th>Номер</th><th>Ученик</th><th>Класс</th><th>Верные ответы/Кол-во вопросов</th><th>% верных ответов</th><th>Детализация</th>";
echo "</tr>";
for ($i = 0; $i < $rows; ++$i)
{
    echo "<tr>";
//body
    $result->data_seek($i);
    $sec = $result;
    $second = $result->fetch_assoc()['namee'];
    $result->data_seek($i);
    $third = $result->fetch_assoc()['class'];
    $result->data_seek($i);
    $RANS = $result->fetch_assoc()['rightAnsAmount'];
    $result->data_seek($i);
    $ANS = $result->fetch_assoc()['ansAmount'];
    $nom = $i + 1;
    $fourth = $RANS . "/" . $ANS;
    $fiveth = round($RANS / $ANS * 100, 2);

    echo '<td><center>' . $nom . '</center></td><td><center>' . $second . '</center></td><td><center>' . $third . '</center></td><td><center>' . $fourth . '</center></td><td><center>' . $fiveth . '</center></td><td><center>' . '<a href="resultOfTest.php?id=' . $id . '&name='. $second .'&class=' . $third .'" class = "button" >Посмотреть</a>' . '</center></td>';
    echo "</tr>";

}
echo "</table>";
