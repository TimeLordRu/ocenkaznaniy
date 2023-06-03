<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<title>Контрольные работы</title>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        TABLE {
            width: 900px; /* Ширина таблицы */
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
        <!-- Подключение CSS файла -->
        <link rel="stylesheet" href="css1.css">

</head>
  <header>
  <nav class="links">
    <a href="index.php">На главную</a>
    <a href="logout.php">Выход</a>
    
  </nav>
</header>
<br><br>
<?php
session_start();
if (($_SESSION['role'] == 2) || ($_SESSION['role'] == 1)) {
    $max = 1;
    echo "<center>";
    require_once 'setting.php';
    $connection = new mysqli($host, $user, $pass, $data);
    if ($connection->connect_error) die('Error connection');
//получение кол-ва записей
    $sql = "SELECT COUNT(*) as total FROM tasks";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    $amount = $row['total'];
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th><th>Название</th><th>Автор</th><th>Редактировать</th><th>Результаты</th>";
    echo "</tr>";
    for ($i = 1; $i <= $amount; $i++) {

        $query = "SELECT * FROM tasks WHERE taskID = $i";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $id = $row['taskID'];
            $nazv = $row['name'];
            $autorID = $row['autorID'];
            $query = "SELECT * FROM users WHERE id = $autorID";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $log = $row['login'];
            }

        }
        $max = $i;
        if (($_SESSION['role'] == 2) || ($_SESSION['username'] == $log)) {
            echo "<tr>";
            echo '<td><center>' . $id . '</center></td><td><center>' . $nazv . '</center></td><td><center>' . $log . '</center></td><td><center>' . '<a href="makeQuestion.php?id=' . $i . '&number=1" class = "button" >Редактировать</a>' . '</center></td><td><center>' . '<a href="testsresult.php?id=' . $id . '" class = "button">Посмотреть</a>' . '</center></td>';
            echo "</tr>";
        }

    }

    echo "</table>";
    echo '<form method="post">';
    echo "<br><hr>";
    echo '<h2>Создать контрольную работу</h2>';
    echo '<label>Название</label> <input type="text" class="rounded-input" placeholder="Название" name="workname">&nbsp;&nbsp;';
    echo '<input type="submit" name="create" value="Перейти к созданию">';
    echo '</form>';
    if (isset($_POST['create'])) {
        // Получаем данные из формы

        $workname = $_POST['workname'];
        $max++;
        $autorID = $_SESSION['id'];
        $sql = "INSERT INTO tasks (taskID, autorID, name) VALUES ($max, $autorID, '$workname')";
        $result = mysqli_query($connection, $sql);
        header('Location: makeQuestion.php?id=' . $max . '&number=1');
    }
}
else echo "Отказано в доступе!";

