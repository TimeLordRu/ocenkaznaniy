<?php
// запуск сессии, если еще не была запущена
session_start();

// удаляем все переменные сессии
session_unset();

// уничтожение сессии
session_destroy();

// перенаправление на страницу авторизации
header("Location: index.php");
?>
