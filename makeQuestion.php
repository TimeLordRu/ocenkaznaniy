<!DOCTYPE html>
<html>
<head>

    <!-- Подключение CSS файла -->
    <link rel="stylesheet" href="css1.css">
</head>
<body>
<header>
    <nav class="links">
        <a href="index.php">На главную</a>
        <a href="tests.php">Назад</a>
        <a href="logout.php">Выход</a>

    </nav>
</header>

<?php
echo '<title>Редактирование КР</title>';
session_start();
echo "<br><br>";
if (($_SESSION['role'] == 2) || ($_SESSION['role'] == 1)) {
    $id = $_GET['id'];
    $numb = $_GET['number'];
    require_once 'setting.php';
    echo "<center>";
    $connection = new mysqli($host, $user, $pass, $data);
    if ($connection->connect_error) die('Error connection');
    $query = "SELECT * FROM questions WHERE taskID = $id ORDER BY numb DESC LIMIT 1";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    if (ISSET($row['numb'])) $numb1 = $row['numb']; else $numb1 = 1;
    $query = "SELECT * FROM tasks WHERE taskID = $id";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $workname = $row['name'];
        $autor = $row['autorID'];
    }
    if (($_SESSION['role'] == 2) || (($_SESSION['role'] == 1) && ($autor == $_SESSION['id']))) {
        echo '<h2>Название работы: ' . $workname . ' (ID ' . $id . '). Номер вопроса: ' . $numb . '. Всего вопросов: ' .$numb1 .'.</h2><br>';
        $query = "SELECT * FROM questions WHERE taskID = $id AND numb = $numb";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $question = $row['question'];
            $answer = $row['answer'];
            $photo = $row['photo'];
            echo '<form method="post" enctype="multipart/form-data" >';
            echo '<label>Вопрос:</label><textarea name="quest" rows="5" cols="30" placeholder="Вопрос">' . $question . '</textarea><br>';

            if ($photo != '-')
                echo '<img src="http://ocenkaznaniy.zzz.com.ua/image/' . $photo . '"><br><br>';
            //  echo '<a href="addphoto.php?id=' . $id . '&number=' . $numb . '" >Добавить/изменить фото</a><br>';
            echo '<label>Добавление/обновление фото:</label><br><input type="file" name="image" multiple accept="image/*,image/jpeg"><br><br>';
            echo '<label>Ответ:</label><textarea name="ans" rows="5" cols="30" placeholder="Ответ">' . $answer . '</textarea><br>';
            if ($numb > 1)
                echo '<br><input type="submit" name="prevquestion" value="Сохранить и перейти к предыдущему!">';
            echo '<input type="submit" name="nextquestion" value="Сохранить и перейти к следующему!"><br><br>';
            echo '</form>';

            if (isset($_POST['nextquestion'])) {
                $question = $_POST['quest'];
                $answer = $_POST['ans'];
                if (isset($_FILES['image'])) {
                    // $_FILES['name'] = date('Y-m-d H:i:s');
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    $array = explode('.', $file_name);
                    $file_ext = strtolower(end($array));
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    // Проверьте тип файла и размер, прежде чем сохранять его на сервере
                    if ($file_size > 2097152 || ($file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "png" && $file_ext != "gif")) {
                        echo "Ошибка! Файл либо не является картинкой, либо слишком тяжелый!";
                    } else {
                        $currentDateTime = date('Y-m-d-H-i-s');
                        move_uploaded_file($file_tmp, "image/" . $file_name);
                        rename("image/" . $file_name, "image/" . $currentDateTime . "." . $extension);
                        $photo = $currentDateTime . "." . $extension;

                    }
                }
                if ($photo == "") $photo = "-";

                $query = "UPDATE questions SET question = '$question', answer = '$answer', photo = '$photo' WHERE taskID = $id AND numb = $numb";
                $result = mysqli_query($connection, $query);
                $numb++;
                header('Location: makeQuestion.php?id=' . $id . '&number=' . $numb . '');
            }
            if (isset($_POST['prevquestion'])) {
                $question = $_POST['quest'];
                $answer = $_POST['ans'];
                if (isset($_FILES['image'])) {
                    // $_FILES['name'] = date('Y-m-d H:i:s');
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    $array = explode('.', $file_name);
                    $file_ext = strtolower(end($array));
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    // Проверьте тип файла и размер, прежде чем сохранять его на сервере
                    if ($file_size > 2097152 || ($file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "png" && $file_ext != "gif")) {
                        echo "Ошибка! Файл либо не является картинкой, либо слишком тяжелый!";
                    } else {
                        $currentDateTime = date('Y-m-d-H-i-s');
                        move_uploaded_file($file_tmp, "image/" . $file_name);
                        rename("image/" . $file_name, "image/" . $currentDateTime . "." . $extension);
                        $photo = $currentDateTime . "." . $extension;

                        // echo "Новое фото загружено!";
                        // echo '<img src="http://localhost/image/' . $currentDateTime . "." . $extension . '">';

                    }
                }
                if ($photo == "") $photo = "-";

                $query = "UPDATE questions SET question = '$question', answer = '$answer', photo = '$photo' WHERE taskID = $id AND numb = $numb";
                $result = mysqli_query($connection, $query);
                $numb--;
                header('Location: makeQuestion.php?id=' . $id . '&number=' . $numb . '');
            }

        } else {

            echo "<h2>Создание нового вопроса</h2>";
            if (isset($err)) {
                echo "$err";
            }
            echo '<form method="post" enctype="multipart/form-data" >';
            echo '<label>Вопрос:</label><textarea name="quest" rows="5" placeholder="Вопрос" cols="30"></textarea><br>';
            echo '<label>Добавление/обновление фото:</label><br><input type="file" name="image" multiple accept="image/*,image/jpeg"><br><br>';


            echo '<label>Ответ:</label><textarea name="ans" rows="5" cols="30" placeholder="Ответ"></textarea><br>';
            if ($numb > 1)
                echo '<br><input type="submit" name="prevquestion" value="Сохранить и перейти к предыдущему!">';
            echo '<input type="submit" name="nextquestion" value="Сохранить и перейти к следующему!"><br>';
            echo '</form>';
            if (isset($_POST['prevquestion'])) {
                $question = $_POST['quest'];
                $answer = $_POST['ans'];
                if (isset($_FILES['image'])) {
                    // $_FILES['name'] = date('Y-m-d H:i:s');
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    $array = explode('.', $file_name);
                    $file_ext = strtolower(end($array));
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    // Проверьте тип файла и размер, прежде чем сохранять его на сервере
                    if ($file_size > 2097152 || ($file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "png" && $file_ext != "gif")) {
                        echo "Ошибка! Файл либо не является картинкой, либо слишком тяжелый!";
                    } else {
                        $currentDateTime = date('Y-m-d-H-i-s');
                        move_uploaded_file($file_tmp, "image/" . $file_name);
                        rename("image/" . $file_name, "image/" . $currentDateTime . "." . $extension);
                        $photo = $currentDateTime . "." . $extension;

                        // echo "Новое фото загружено!";
                        // echo '<img src="http://localhost/image/' . $currentDateTime . "." . $extension . '">';

                    }
                }
                if ($photo == "") $photo = "-";

                $query = "UPDATE questions SET question = '$question', answer = '$answer', photo = '$photo' WHERE taskID = $id AND numb = $numb";
                $result = mysqli_query($connection, $query);
                $numb--;
                header('Location: makeQuestion.php?id=' . $id . '&number=' . $numb . '');
            }
            if (isset($_POST['nextquestion'])) {
                $question = $_POST['quest'];
                $answer = $_POST['ans'];
                if (isset($_FILES['image'])) {
                    // $_FILES['name'] = date('Y-m-d H:i:s');
                    $file_name = $_FILES['image']['name'];
                    $file_size = $_FILES['image']['size'];
                    $file_tmp = $_FILES['image']['tmp_name'];
                    $file_type = $_FILES['image']['type'];
                    $array = explode('.', $file_name);
                    $file_ext = strtolower(end($array));
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    // Проверьте тип файла и размер, прежде чем сохранять его на сервере
                    if ($file_size > 2097152 || ($file_ext != "jpg" && $file_ext != "jpeg" && $file_ext != "png" && $file_ext != "gif")) {
                        echo "Ошибка! Файл либо не является картинкой, либо слишком тяжелый!";
                    } else {
                        $currentDateTime = date('Y-m-d-H-i-s');
                        move_uploaded_file($file_tmp, "image/" . $file_name);
                        rename("image/" . $file_name, "image/" . $currentDateTime . "." . $extension);
                        $photo = $currentDateTime . "." . $extension;

                        // echo "Новое фото загружено!";
                        // echo '<img src="http://localhost/image/' . $currentDateTime . "." . $extension . '">';

                    }
                }
                if ($photo == "") $photo = "-";

                $query = "INSERT INTO questions (taskID, numb, question, answer, photo) VALUES ($id, $numb, '$question', '$answer', '$photo')";
                $result = mysqli_query($connection, $query);
                $numb++;
                header('Location: makeQuestion.php?id=' . $id . '&number=' . $numb . '');

            }
        }
        echo "<hr>";
        echo '<form method="post">';
        echo '<h2>Выбор вопроса</h2>';
        echo '<label>Номер вопроса</label> <input type="text" class="rounded-input" name="number"> ';
        echo '<input type="submit" name="submit1" value="Перейти"><br>';
        echo '<input type="submit" name="submit2" value="Создать новый вопрос">';
        echo '</form>';
        if (isset($_POST['submit1'])) {
            $number = $_POST['number'];
            $query = "SELECT * FROM questions WHERE taskID = $id ORDER BY numb DESC LIMIT 1";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $numb = $row['numb'];
            if ($number > $numb)
            {
                $numb++;
                header('Location: makeQuestion.php?id=' . $id . '&number=' . $numb . '');
            }
            else header('Location: makeQuestion.php?id=' . $id . '&number=' . $number . '');
        }
        if (isset($_POST['submit2'])) {
            $query = "SELECT * FROM questions WHERE taskID = $id ORDER BY numb DESC LIMIT 1";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $numb = $row['numb'];
            $numb++;
            header('Location: makeQuestion.php?id=' . $id . '&number=' . $numb . '');
        }
    }
    else echo "Отказано в доступе!";
}
else echo "Отказано в доступе!";