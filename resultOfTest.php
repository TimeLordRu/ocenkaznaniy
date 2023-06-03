<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<title>Детализация</title>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        TABLE {
            width: 700px; /* Ширина таблицы */
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
</head>
<link rel="stylesheet" href="css1.css">
<?php
require_once 'setting.php';
$connection = new mysqli($host, $user, $pass, $data);
if ($connection->connect_error) die('Error connection');
$tID = $_GET['id'];
$fio = $_GET['name'];
$class = $_GET['class'];
echo '<header><nav class="links"><a href="index.php">На главную</a><a href="testsresult.php?id='.$tID.'">Назад</a><a href="logout.php">Выход</a></nav></header><br><br>';
echo "<center>";
echo "<h2>Детализация по ученику: $fio из класса $class</h2>";
$query = "SELECT name FROM tasks WHERE taskID = $tID";
$result = mysqli_query($connection, $query);
if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $rabota = $row['name'];
    echo "<h2>Название работы: $rabota</h2><br>";
}
echo "<body>";
echo "<table>";

echo "<tr>";
echo "<th>Номер вопроса</th><th>Ответ</th><th>Правильный ответ</th><th>Правильность(да/нет)</th><th>Дата и время</th>";
echo "</tr>";
$isQuestion = true;
$i = 1;
while ($isQuestion) {
    echo "<tr>";
    $query = "SELECT * FROM answers WHERE taskID = $tID AND questionID = $i AND usrname = '$fio' AND class = '$class'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $ransw = $row['rightAns'];
        $answ = $row['ans'];
        $date = $row['datatime'];
        if ($answ == $ransw) $cor = 'Да';
        else $cor = 'Нет';
        echo '<td><center>' . $i . '</center></td><td><center>' . $answ . '</center></td><td><center>' . $ransw . '</center></td><td><center>' . $cor . '</center></td><td><center>' . $date . '</center></td>';
        echo "</tr>";
        $i++;
    }
    else $isQuestion = false;

}
echo "</table>";
echo "</body>";