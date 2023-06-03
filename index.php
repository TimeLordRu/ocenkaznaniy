<!DOCTYPE html>
<html>
<head>

    <!-- Подключение CSS файла -->
    <link rel="stylesheet" href="css1.css">
</head>
<body>



<?php
session_start(); // Запускаем сессию
// авторизация завуча и препода
$_SESSION['role'] = 0;
if (isset($_POST['submit1'])) {
    // Получаем данные из формы

        $username = $_POST['username'];
        $password = $_POST['password'];

    // Проверяем, что поля не пустые
    if (empty($username) || empty($password)) {
        $error = 'Пожалуйста, заполните все поля'; // Ошибка, если поля пустые
    } else {
        // Подключаемся к базе данных
        require_once 'setting.php';
        $conn = new mysqli($host, $user, $pass, $data);
// проверка соединения
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $algorithm = "sha256";
        $password = hash($algorithm, $password);
        // Проверяем, что пользователь существует и пароль верный
        $sql = "SELECT * FROM users WHERE login='$username' AND passw='$password'";
        $result = mysqli_query($conn, $sql);
        if (!(mysqli_num_rows($result) > 0)) {
            $error = 'Неправильный логин или пароль'; // Ошибка, если логин/пароль не верны
        } else {
            // Если логин/пароль верны, сохраняем данные пользователя в сессию
            $_SESSION['username'] = $username;
            // Переходим на страницу "index.php" после успешной авторизации
            header('Location: gov.php');
            exit;
        }
    }
}

if (isset($_POST['submit'])) {
    // Получаем данные из формы

    $username = $_POST['name'];
    $taskID = $_POST['password'];
    $class = $_POST['class'];

    // Проверяем, что поля не пустые
    if (empty($username) || empty($taskID) || empty($class)) {
        $error = 'Пожалуйста, заполните все поля';
    } else {
        // Подключаемся к базе данных
        require_once 'setting.php';
        $conn = new mysqli($host, $user, $pass, $data);
// проверка соединения
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        // Проверяем, что данная контрольная работа существует
        $sql = "SELECT * FROM tasks WHERE taskID='$taskID'";
        $result = mysqli_query($conn, $sql);
        if (!(mysqli_num_rows($result) > 0)) {
            $error = 'Нет контрольной работы с таким номером!';
        } else {

            $row = mysqli_fetch_assoc($result);
            $nazvanie = $row['name'];
            $_SESSION['class'] = $class;
            $_SESSION['nazvanie'] = $nazvanie;
            $_SESSION['name'] = $username;
            $_SESSION['taskID'] = $taskID;
            $_SESSION['rightanswers'] = 0;
            $_SESSION['number'] = 1;

            $sql = "SELECT * FROM answers WHERE taskID = $taskID AND usrname = '$username' AND class = '$class'";
            $result = mysqli_query($conn, $sql);
            if (!(mysqli_num_rows($result) > 0)) {

                // Переходим на страницу "letsgo.php"
                header('Location: letsgo.php');
            }
            else $error = 'Вы уже выполняли данную работу. Если это были не вы, обратитесь к учителю!';
            //exit;
        }
    }
}

// Выводим форму, если пользователь не авторизован
if (!isset($_SESSION['username'])) {
    // Выводим ошибку, если она есть
    if (isset($error)) {
        echo '<p>' . $error . '</p>';
    }
    // Форма для ввода логина и пароля
   echo '<center>';
    echo '<title>Авторизация</title>';
    echo '<form method="post" class="form-wrapper">';
    echo '<h2>Начать выполнение работы</h2>';
    echo '<label>Фамилия, имя:</label> <br><input type="text" class="rounded-input" placeholder="Фамилия, имя" name="name"><br>';
    echo '<label>Класс:</label> <br><input type="text" class="rounded-input" placeholder="Класс" name="class"><br>';
    echo '<label>Пароль от задания:</label> <br><input type="text" class="rounded-input" placeholder="Пароль от задания" name="password"><br><br>';
    echo '<input type="submit" name="submit" value="Начать выполнение работы!">';
    echo '</form>';
echo '<hr>';
   echo '<form method="post" class="form-wrapper">';
   echo '<h2>Авторизация для учителей и завучей</h2>';
   echo '<label>Логин:</label> <br><input type="text" class="rounded-input" placeholder="Логин" name="username"><br>';
    echo '<label>Пароль:</label><br> <input type="password" class="rounded-input" placeholder="Пароль" name="password"><br><br>';

    echo '<input type="submit" name="submit1" value="Войти">';
    echo '</form>';
    echo '</center>';
} else {
    // Если пользователь уже авторизован, выводим его имя и кнопку "Выйти"
   // echo 'Добро пожаловать, ' . $_SESSION['username'] . '!<br>';
    //echo '<a href="index.php">Выйти</a>';
    header('Location: gov.php');

}
