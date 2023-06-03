<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
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

<?php
//выше вещь для создания границ у таблицы
session_start();
echo '<title>Контрольная работа</title>';
    echo 'Добро пожаловать, ' . $_SESSION['name'] . '! Вы выполняете работу "' . $_SESSION['nazvanie'] . '".<br>';
require_once 'setting.php';
$connection = new mysqli($host, $user, $pass, $data);
if ($connection->connect_error) die('Error connection');

$tID = $_SESSION['taskID'];
$numberr = $_SESSION['number'];
$fio = $_SESSION['name'];
$class = $_SESSION['class'];
$query = "SELECT * FROM questions WHERE taskID = $tID ORDER BY numb DESC LIMIT 1";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$numb = $row['numb'];
$query = "SELECT * FROM questions WHERE taskID = '$tID' AND numb = '$numberr'";
$result = mysqli_query($connection, $query);


if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $question = nl2br($row['question']);
    $photo = $row['photo'];
    $right = $row['answer'];
    echo '<hr>';
    echo '<center>';
    echo '<form method="post">';

    echo '<br>Вопрос №' . $_SESSION['number'] . '. Всего вопросов: ' .$numb;

    echo '<br>' . $question . '<br>';
    if ($photo != '-')
    echo '<img src="http://ocenkaznaniy.zzz.com.ua/image/' . $photo . '"><br><br>';
    echo '<textarea name="text" rows="5" cols="30"placeholder="Введите ответ"></textarea>  ';
    echo '<br><br><input type="submit" name="nextquestion" value="Ответить и перейти к следующему вопросу">';
    echo '</form>';
    echo '</center>';
}

else
{
    //i строки j столбцы
    echo '<hr><center>';
    echo '<h2>Вы закончили работу. Правильных ответов ' . $_SESSION['rightanswers'] . ' из ' . ($_SESSION['number'] - 1 . '</h2><br>'); //ДОБАВИТЬ СОХРАНЕНИЕ РЕЗУЛЬТАТА
    $rightAns = $_SESSION['rightanswers'];
    $ansAmount = $_SESSION['number'] - 1;
    $sql = "INSERT INTO marks (namee, class, taskID, rightAnsAmount, ansAmount) VALUES ('$fio', '$class', $tID, $rightAns, $ansAmount)";
    $result = mysqli_query($connection, $sql);
    echo "<body>";
    echo "<table>";

   echo "<tr>";
    echo "<th>Номер вопроса</th><th>Ваш ответ</th><th>Правильный ответ</th><th>Правильность(да/нет)</th>";
    echo "</tr>";
    for ($i = 1; $i <= ($_SESSION['number'] - 1); $i++) {
        echo "<tr>";
        $query = "SELECT * FROM answers WHERE taskID = $tID AND questionID = $i AND usrname = '$fio' AND class = '$class'";
        $result = mysqli_query($connection, $query);

        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $ransw = $row['rightAns'];
            $answ = $row['ans'];
        }
        if ($answ == $ransw) $cor = 'Да';
        else $cor = 'Нет';
        echo '<td><center>' . $i . '</center></td><td><center>' . $answ . '</center></td><td><center>' . $ransw . '</center></td><td><center>' . $cor . '</center></td>';
        echo "</tr>";
    }
    echo "</table>";
    echo "</body>";
    echo '<br>Если вы считаете, что на какой-то вопрос ответили правильно, но система не засчитала, обратитесь к учителю.<br>';
    echo '<a href="logout.php">Перейти на главную страницу</a>';
}

if (isset($_POST['nextquestion'])) {
    $text = $_POST['text'];

    $datatime = date('d-m-y/h:i:s');
    $mysqli = new mysqli($host, $user, $pass, $data);
    $sql = "INSERT INTO answers (taskID, questionID, ans, rightAns, class, usrname, datatime) VALUES ($tID, $numberr, '$text', '$right', '$class', '$fio', '$datatime')";
    $result = mysqli_query($mysqli, $sql);
    $mysqli->close();

    $_SESSION['number'] = $_SESSION['number'] + 1;

if ($right == $text)
{
    $_SESSION['rightanswers']++;
}
    header('Location: letsgo.php');
}
echo "</html>";
