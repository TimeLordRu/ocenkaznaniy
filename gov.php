<!DOCTYPE html>
<html>
<head>

    <!-- Подключение CSS файла -->
    <link rel="stylesheet" href="css1.css">
</head>
<body>
  <header>
  <nav class="links">
    <a href="logout.php">Выход</a>
    
  </nav>
</header>
<br><br>
<?php
session_start();
require_once 'setting.php';
$connection = new mysqli($host, $user, $pass, $data);
if ($connection->connect_error) die('Error connection');
$nam = $_SESSION['username'];
$query = "SELECT * FROM users WHERE login = '$nam'";
$result = mysqli_query($connection, $query);
$_SESSION['isTeacher'] = true;
if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['role'] = $row['role'];
    $_SESSION['id'] = $row['id'];
    if ($row['role'] == 1) $_SESSION['alterID'] = $row['id'];
    else $_SESSION['alterID'] = 'zav';
    }

if ($_SESSION['role'] != 0) {
    echo '<title>Управление</title>';
    echo '<center>';

    echo '<big>Добро пожаловать, ' . $_SESSION['username'] . '! ';
    echo '<a href="logout.php" class="button">Выйти</a>';
    echo '<br><br><a href="tests.php" ><input type="submit" name="tests" value="Контрольные работы"></a>';
    if ($_SESSION['role'] == 2)
    echo '<br><br><a href="acctable.php" ><input type="submit" name="tests" value="Таблица аккаунтов"></a>';
    if ($_SESSION['role'] == 1)
        echo '<br><br><a href="accedit.php?id='.$row['id']. '" ><input type="submit" name="tests" value="Ваш аккаунт"></a>';
}
else
{
    echo 'Вы были заблокированы!';
    echo '<br><a href="logout.php">Выйти</a>';

}
