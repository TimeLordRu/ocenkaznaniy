<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<title>Таблица аккаунтов</title>
<head>
    <link type="image/x-icon" href="http://localhost/favicon.ico" rel="shortcut icon">
    <link type="Image/x-icon" href="http://localhost/favicon.ico" rel="icon">
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
</head>

<link rel="stylesheet" href="css1.css">
<script language="javascript" type="text/javascript">
    <a href="#" onclick="window.close();">Закрыть вкладку</a>;
    </script>
  <header>
  <nav class="links">
    <a href="index.php">На главную</a>

    <a href="logout.php">Выход</a>
    
  </nav>
</header>
<br><br>
<?php
session_start();
echo "<center>";
    require_once 'setting.php';
    $connection = new mysqli($host, $user, $pass, $data);
    if ($connection->connect_error) die('Error connection');
    if ($_SESSION['role'] != 0) {
//получение кол-ва записей
        $sql = "SELECT COUNT(*) as total FROM users";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $amount = $row['total'];
        echo "<table>";

        echo "<tr>";
        echo "<th>ID</th><th>Логин</th><th>Роль</th><th>Редактировать</th>";
        echo "</tr>";
        for ($i = 1; $i <= $amount; $i++) {
            $query = "SELECT * FROM users WHERE id = $i";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $login = $row['login'];
                if ($row['role'] == 0) $role = "Заблокированный";
                if ($row['role'] == 1) $role = "Учитель";
                if ($row['role'] == 2) $role = "Завуч";

            }
            if (($_SESSION['role'] == 2) || ($_SESSION['username'] == $login)) {
                echo "<tr>";
                echo '<td><center>' . $id . '</center></td><td><center>' . $login . '</center></td><td><center>' . $role . '</center></td><td><center>' . '<a href="accedit.php?id=' . $id . '" class="button" >Настроить</a>' . '</center></td>';
                echo "</tr>";
            }
        }
        if (isset($_POST['submit'])) {
            // Получаем данные из формы

            $login = $_POST['login'];
            $role = $_POST['role'];
            $psw = $_POST['password'];
            $query = "SELECT * FROM users WHERE login = '$login'";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) == 1) {
                $res = "Пользователь с таким логином уже существует!";
            }
            else{
                $algorithm = "sha256";
                $psw = hash($algorithm, $psw);
            $sql = "INSERT INTO users (login, passw, role) VALUES ('$login', '$psw', '$role')";
            $result = mysqli_query($connection, $sql);
            $res = "Аккаунт удачно зарегистрирован! Обновите страницу, чтобы увидеть его в таблице.";
            header('Location: acctable.php');
            }
        }
        if ($_SESSION['role'] == 2)
        {
        echo "</table>";
        echo '<br><hr>';
        echo '<title>Создание аккаунта</title>';
        echo '<form method="post">';
        echo '<h2>Создать аккаунт</h2>';
        echo '<label>Логин:</label><br> <input type="text" class="rounded-input" placeholder="Логин" name="login"><br>';
       // echo '<label>Роль:</label> <br><input type="text" placeholder="Роль" name="role"><br>';
            ///
          echo '<label>Роль:</label><br><select name="role">
    <option value="1">Учитель</option>
    <option value="2">Завуч</option>
    <option value="0">Заблокированный</option>
</select><br>';
            ///
        echo '<label>Пароль:</label><br> <input type="text" class="rounded-input" placeholder="Пароль" name="password"><br><br>';
        echo '<input type="submit" name="submit" value="Создать!">';
        echo '</form>';
        if (isset($res)) {
            echo '<p>' . $res . '</p>';
        }
    }

    }
    else echo "Отказано в доступе";
