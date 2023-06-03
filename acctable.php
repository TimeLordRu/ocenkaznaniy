<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<title>&#1058;&#1072;&#1073;&#1083;&#1080;&#1094;&#1072; &#1072;&#1082;&#1082;&#1072;&#1091;&#1085;&#1090;&#1086;&#1074;</title>
<head>
    <link type="image/x-icon" href="http://localhost/favicon.ico" rel="shortcut icon">
    <link type="Image/x-icon" href="http://localhost/favicon.ico" rel="icon">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        TABLE {
            width: 600px; /* &#1064;&#1080;&#1088;&#1080;&#1085;&#1072; &#1090;&#1072;&#1073;&#1083;&#1080;&#1094;&#1099; */
            border-collapse: collapse; /* &#1059;&#1073;&#1080;&#1088;&#1072;&#1077;&#1084; &#1076;&#1074;&#1086;&#1081;&#1085;&#1099;&#1077; &#1083;&#1080;&#1085;&#1080;&#1080; &#1084;&#1077;&#1078;&#1076;&#1091; &#1103;&#1095;&#1077;&#1081;&#1082;&#1072;&#1084;&#1080; */
        }
        TD, TH {
            padding: 3px; /* &#1055;&#1086;&#1083;&#1103; &#1074;&#1086;&#1082;&#1088;&#1091;&#1075; &#1089;&#1086;&#1076;&#1077;&#1088;&#1078;&#1080;&#1084;&#1086;&#1075;&#1086; &#1090;&#1072;&#1073;&#1083;&#1080;&#1094;&#1099; */
            border: 1px solid black; /* &#1055;&#1072;&#1088;&#1072;&#1084;&#1077;&#1090;&#1088;&#1099; &#1088;&#1072;&#1084;&#1082;&#1080; */
        }
        TH {
            background: #b0e0e6; /* &#1062;&#1074;&#1077;&#1090; &#1092;&#1086;&#1085;&#1072; */
        }

    </style>
</head>

<link rel="stylesheet" href="css1.css">
<script language="javascript" type="text/javascript">
    <a href="#" onclick="window.close();">&#1047;&#1072;&#1082;&#1088;&#1099;&#1090;&#1100; &#1074;&#1082;&#1083;&#1072;&#1076;&#1082;&#1091;</a>;
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
//&#1087;&#1086;&#1083;&#1091;&#1095;&#1077;&#1085;&#1080;&#1077; &#1082;&#1086;&#1083;-&#1074;&#1072; &#1079;&#1072;&#1087;&#1080;&#1089;&#1077;&#1081;
        $sql = "SELECT COUNT(*) as total FROM users";
        $result = $connection->query($sql);
        $row = $result->fetch_assoc();
        $amount = $row['total'];
        echo "<table>";

        echo "<tr>";
        echo "<th>ID</th><th>&#1051;&#1086;&#1075;&#1080;&#1085;</th><th>&#1056;&#1086;&#1083;&#1100;</th><th>&#1056;&#1077;&#1076;&#1072;&#1082;&#1090;&#1080;&#1088;&#1086;&#1074;&#1072;&#1090;&#1100;</th>";
        echo "</tr>";
        for ($i = 1; $i <= $amount; $i++) {
            $query = "SELECT * FROM users WHERE id = $i";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $id = $row['id'];
                $login = $row['login'];
                if ($row['role'] == 0) $role = "&#1047;&#1072;&#1073;&#1083;&#1086;&#1082;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1085;&#1099;&#1081;";
                if ($row['role'] == 1) $role = "&#1059;&#1095;&#1080;&#1090;&#1077;&#1083;&#1100;";
                if ($row['role'] == 2) $role = "&#1047;&#1072;&#1074;&#1091;&#1095;";

            }
            if (($_SESSION['role'] == 2) || ($_SESSION['username'] == $login)) {
                echo "<tr>";
                echo '<td><center>' . $id . '</center></td><td><center>' . $login . '</center></td><td><center>' . $role . '</center></td><td><center>' . '<a href="accedit.php?id=' . $id . '" class="button" >&#1053;&#1072;&#1089;&#1090;&#1088;&#1086;&#1080;&#1090;&#1100;</a>' . '</center></td>';
                echo "</tr>";
            }
        }
        if (isset($_POST['submit'])) {
            // &#1055;&#1086;&#1083;&#1091;&#1095;&#1072;&#1077;&#1084; &#1076;&#1072;&#1085;&#1085;&#1099;&#1077; &#1080;&#1079; &#1092;&#1086;&#1088;&#1084;&#1099;

            $login = $_POST['login'];
            $role = $_POST['role'];
            $psw = $_POST['password'];
            $query = "SELECT * FROM users WHERE login = '$login'";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) == 1) {
                $res = "&#1055;&#1086;&#1083;&#1100;&#1079;&#1086;&#1074;&#1072;&#1090;&#1077;&#1083;&#1100; &#1089; &#1090;&#1072;&#1082;&#1080;&#1084; &#1083;&#1086;&#1075;&#1080;&#1085;&#1086;&#1084; &#1091;&#1078;&#1077; &#1089;&#1091;&#1097;&#1077;&#1089;&#1090;&#1074;&#1091;&#1077;&#1090;!";
            }
            else{
                $algorithm = "sha256";
                $psw = hash($algorithm, $psw);
            $sql = "INSERT INTO users (login, passw, role) VALUES ('$login', '$psw', '$role')";
            $result = mysqli_query($connection, $sql);
            $res = "&#1040;&#1082;&#1082;&#1072;&#1091;&#1085;&#1090; &#1091;&#1076;&#1072;&#1095;&#1085;&#1086; &#1079;&#1072;&#1088;&#1077;&#1075;&#1080;&#1089;&#1090;&#1088;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;! &#1054;&#1073;&#1085;&#1086;&#1074;&#1080;&#1090;&#1077; &#1089;&#1090;&#1088;&#1072;&#1085;&#1080;&#1094;&#1091;, &#1095;&#1090;&#1086;&#1073;&#1099; &#1091;&#1074;&#1080;&#1076;&#1077;&#1090;&#1100; &#1077;&#1075;&#1086; &#1074; &#1090;&#1072;&#1073;&#1083;&#1080;&#1094;&#1077;.";
            header('Location: acctable.php');
            }
        }
        if ($_SESSION['role'] == 2)
        {
        echo "</table>";
        echo '<br><hr>';
        echo '<title>&#1057;&#1086;&#1079;&#1076;&#1072;&#1085;&#1080;&#1077; &#1072;&#1082;&#1082;&#1072;&#1091;&#1085;&#1090;&#1072;</title>';
        echo '<form method="post">';
        echo '<h2>&#1057;&#1086;&#1079;&#1076;&#1072;&#1090;&#1100; &#1072;&#1082;&#1082;&#1072;&#1091;&#1085;&#1090;</h2>';
        echo '<label>&#1051;&#1086;&#1075;&#1080;&#1085;:</label><br> <input type="text" class="rounded-input" placeholder="&#1051;&#1086;&#1075;&#1080;&#1085;" name="login"><br>';
       // echo '<label>&#1056;&#1086;&#1083;&#1100;:</label> <br><input type="text" placeholder="&#1056;&#1086;&#1083;&#1100;" name="role"><br>';
            ///
          echo '<label>&#1056;&#1086;&#1083;&#1100;:</label><br><select name="role">
    <option value="1">&#1059;&#1095;&#1080;&#1090;&#1077;&#1083;&#1100;</option>
    <option value="2">&#1047;&#1072;&#1074;&#1091;&#1095;</option>
    <option value="0">&#1047;&#1072;&#1073;&#1083;&#1086;&#1082;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1085;&#1099;&#1081;</option>
</select><br>';
            ///
        echo '<label>&#1055;&#1072;&#1088;&#1086;&#1083;&#1100;:</label><br> <input type="text" class="rounded-input" placeholder="&#1055;&#1072;&#1088;&#1086;&#1083;&#1100;" name="password"><br><br>';
        echo '<input type="submit" name="submit" value="&#1057;&#1086;&#1079;&#1076;&#1072;&#1090;&#1100;!">';
        echo '</form>';
        if (isset($res)) {
            echo '<p>' . $res . '</p>';
        }
    }

    }
    else echo "&#1054;&#1090;&#1082;&#1072;&#1079;&#1072;&#1085;&#1086; &#1074; &#1076;&#1086;&#1089;&#1090;&#1091;&#1087;&#1077;";
