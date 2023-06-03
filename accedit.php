<title>Настройка аккаунта</title>
<script src="https://kit.fontawesome.com/aac53a065a.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="css1.css">
 <header>
  <nav class="links">
    <a href="index.php">На главную</a>
<a href="acctable.php">Назад</a>
    <a href="logout.php">Выход</a>
    
  </nav>
</header>
<br><br>
<?php
session_start();
require_once 'setting.php';
//echo '<i class="fa-solid fa-thumbs-up fa-2x"></i>';
$connection = new mysqli($host, $user, $pass, $data);
if ($connection->connect_error) die('Error connection');
$id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $log = $row['login'];
$role1 = $row['role'];
    $pass = $row['passw'];
    $algorithm = "sha256";
    //$pass = hash($algorithm, $pass);
    if ($row['role'] == 0) $role = "Заблокированный";
    if ($row['role'] == 1) $role = "Учитель";
    if ($row['role'] == 2) $role = "Завуч";
    //для учителя
if (isset($_POST['upd1'])) {
    // Получаем данные из формы

    $oldp = $_POST['password1'];
    $algorithm = "sha256";
    $oldp = hash($algorithm, $oldp);
    $pas = $_POST['password2'];
    $pas = hash($algorithm, $pas);
    $checkpas = $_POST['password3'];
    $checkpas = hash($algorithm, $checkpas);
    if (($oldp == $pass) && ($pas = $checkpas))
    {
        $query = "UPDATE users SET passw = '$pas' WHERE id = $id";
        $result = mysqli_query($connection, $query);
        $res = 'Пароль успешно изменен!';
    }
    else $res = 'Пароли не совпадают, либо старый пароль не правильный!';

}
//для завучей
    if (isset($_POST['upd2'])) {
        // Получаем данные из формы

        $newlogin = $_POST['login'];
        $newrole = $_POST['role'];
        $pas = $_POST['password2'];
        $checkpas = $_POST['password3'];
        if ((strlen($_POST['password2']) > 0) && ($pas = $checkpas))
        {
            $query = "UPDATE users SET passw = '$pas', login = '$newlogin', role = '$newrole' WHERE id = $id";
            $result = mysqli_query($connection, $query);
            $log = $newlogin;
            $role = $newrole;
            $res = 'Изменения сохранены!';
        }
        else if (strlen($_POST['password2']) == 0)
        {
            $query = "UPDATE users SET login = '$newlogin', role = '$newrole' WHERE id = $id";
            $result = mysqli_query($connection, $query);
            $log = $newlogin;
            $role = $newrole;
            $res = 'Изменения сохранены!';
        }
        else

            $res = 'Пароли не совпадают, либо старый пароль не правильный!';

    }
if (($_SESSION['role'] == 1) || ($_SESSION['role'] == 2)) {

        if (($_SESSION['role'] == 1) && ($id == $_SESSION['id'])) {
            if (isset($res)) echo $res;

            echo '<form method="post" class="form-wrapper">';
            echo "<center>";
            echo '<h2>Редактирование аккаунта</h2>';
            echo '<label>Логин: ' . $log . '</label><br>';
           echo '<label>Роль: ' . $role . '</label><br>';

            echo '<label>Старый пароль:</label><br> <input type="password" placeholder="Старый пароль" name="password1"><br>';
            echo '<label>Новый пароль:</label><br> <input type="password" placeholder="Новый пароль" name="password2"><br>';
            echo '<label>Повторите новый пароль:</label><br> <input type="password" placeholder="Новый пароль" name="password3"><br><br>';
            echo '<input type="submit" name="upd1" value="Сменить">';
            echo '</form>';
        }
        else if ($_SESSION['role'] == 2)
        {
            if (isset($res)) echo '<center>' .$res;
            echo '<form method="post" class="form-wrapper">';
            echo "<center>";
            echo '<h2>Редактирование аккаунта</h2>';
            echo '<label>Логин: </label><br><input type="text" class="rounded-input" name="login" value="' . $log .'"><br>';
           // echo '<label>Роль: </label><input type="text" name="role" value="' . $row['role'] .'"><br>';
            if ($role1 == 0)  echo '<label>Роль: </label><br><select name="role">
    <option value="0">Заблокированный</option>
    <option value="1">Учитель</option>
    <option value="2">Завуч</option>
    
</select><br>';

            if ($role1 == 1) echo '<label>Роль: </label><br><select name="role">
    <option value="1">Учитель</option>
    <option value="0">Заблокированный</option>
    <option value="2">Завуч</option>
    
</select><br>';
            if ($role1 == 2) echo '<label>Роль: </label><br><select name="role">
    <option value="2">Завуч</option>
    <option value="1">Учитель</option>
    <option value="0">Заблокированный</option>
    
    
</select><br>';

            echo '<label>Новый пароль:</label> <br><input type="password" placeholder="Пароль" class="rounded-input" name="password2"><br>';
            echo '<label>Повторите новый пароль:</label><br> <input type="password" placeholder="Пароль" class="rounded-input" name="password3"><br><br>';

            echo '<input type="submit" name="upd2" value="Сохранить">';
            echo '</form>';
        }
        else echo 'Отказано в доступе!';
    }
else echo 'Отказано в доступе!';
}	