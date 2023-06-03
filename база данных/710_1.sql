-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 03 2023 г., 19:06
-- Версия сервера: 10.5.19-MariaDB-10+deb11u2
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `710_1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `taskID` int(11) NOT NULL,
  `questionID` int(11) NOT NULL,
  `ans` varchar(100) NOT NULL,
  `rightAns` varchar(100) NOT NULL,
  `class` varchar(3) NOT NULL,
  `usrname` varchar(50) NOT NULL,
  `datatime` varchar(17) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`taskID`, `questionID`, `ans`, `rightAns`, `class`, `usrname`, `datatime`) VALUES
(1, 1, 'Моргенштерн', 'Моргенштерн', '11', 'Гнездилов Игорь', '06-04-23/02:37:20'),
(1, 2, '7', '7', '11', 'Гнездилов Игорь', '06-04-23/02:37:26'),
(1, 1, 'Морген', 'Моргенштерн', '11', 'Учеников Ученик', '06-04-23/02:38:52'),
(1, 2, '7', '7', '11', 'Учеников Ученик', '06-04-23/02:38:55'),
(1, 1, 'Моргенштерн', 'Моргенштерн', '11', 'Вася Васин', '07-04-23/06:19:30'),
(1, 2, '7', '7', '11', 'Вася Васин', '07-04-23/06:19:32'),
(1, 1, 'Морген', 'Моргенштерн', '11', 'Гнездилов Игорь2', '07-04-23/06:30:19'),
(1, 2, '7', '7', '11', 'Гнездилов Игорь2', '07-04-23/06:30:22'),
(1, 3, '6', '6', '11', 'Гнездилов Игорь2', '07-04-23/06:30:26'),
(1, 1, 'Моренштерн', 'Моргенштерн', '2', 'Гнездилов Игорь', '10-04-23/03:53:21'),
(1, 2, '7', '7', '2', 'Гнездилов Игорь', '10-04-23/03:53:24'),
(1, 3, '6', '6', '2', 'Гнездилов Игорь', '10-04-23/03:53:27'),
(1, 1, 'Цой', 'Моргенштерн', '1', 'Сергей Голенов', '13-04-23/08:18:39'),
(1, 2, '10', '7', '1', 'Сергей Голенов', '13-04-23/08:18:44'),
(1, 3, '8', '6', '1', 'Сергей Голенов', '13-04-23/08:18:47'),
(1, 1, '', 'Моргенштерн', '11', 'сергей', '13-04-23/09:52:19'),
(1, 2, '', '7', '11', 'сергей', '13-04-23/09:52:30'),
(1, 3, '', '6', '11', 'сергей', '13-04-23/09:52:32'),
(2, 1, 'да', 'да', '11', 'Вася Васин', '06-05-23/05:40:08'),
(1, 1, '123', 'Моргенштерн', '1', 'учеников уч', '06-05-23/05:40:47'),
(1, 2, '7', '7', '1', 'учеников уч', '06-05-23/05:40:52'),
(1, 3, 'ваыыфваафвы', '6', '1', 'учеников уч', '06-05-23/05:40:56'),
(1, 4, '122', '1672', '1', 'учеников уч', '06-05-23/05:40:59'),
(1, 5, 'да', 'нет', '1', 'учеников уч', '06-05-23/05:41:04');

-- --------------------------------------------------------

--
-- Структура таблицы `marks`
--

CREATE TABLE `marks` (
  `ID` int(11) NOT NULL,
  `namee` varchar(40) NOT NULL,
  `class` varchar(3) NOT NULL,
  `taskID` int(11) NOT NULL,
  `rightAnsAmount` int(11) NOT NULL,
  `ansAmount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `marks`
--

INSERT INTO `marks` (`ID`, `namee`, `class`, `taskID`, `rightAnsAmount`, `ansAmount`) VALUES
(1, 'Гнездилов Игорь', '11', 1, 2, 2),
(2, 'Учеников Ученик', '11', 1, 1, 2),
(38, 'Вася Васин', '11', 1, 2, 2),
(39, 'Вася Васин', '11', 1, 2, 2),
(40, 'Гнездилов Игорь2', '11', 1, 2, 3),
(41, 'Гнездилов Игорь', '2', 1, 2, 3),
(42, 'Сергей Голенов', '1', 1, 0, 3),
(43, 'сергей', '11', 1, 0, 3),
(44, 'Вася Васин', '11', 2, 1, 1),
(45, 'учеников уч', '1', 1, 1, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `taskID` int(11) NOT NULL,
  `numb` int(11) NOT NULL,
  `question` varchar(9999) NOT NULL,
  `answer` varchar(999) NOT NULL,
  `photo` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`taskID`, `numb`, `question`, `answer`, `photo`) VALUES
(1, 1, 'Кто изображен на фото?', 'Пушкин', '2023-06-03-17-30-42.jpg'),
(1, 2, 'Решите задачу. В ответ напишите число без указания единицы измерения.', '7', '2023-06-03-17-30-52.png'),
(1, 3, 'Сколько будет 2+2*2', '6', '-'),
(1, 5, 'Является ли СЛАУ однородной?(да/нет)', 'нет', '2023-06-03-17-31-04.png'),
(1, 4, 'В каком году родился Петр первый?', '1672', '-'),
(2, 1, 'Есть прямоугольный треугольник ABC, ∠ACB = 90, ∠BAC = 45, ∠CAB = 45. Является ли треугольник равнобедренным?(да/нет)', 'да', '-'),
(7, 1, 'что это такое', 'дом', '-');

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--

CREATE TABLE `tasks` (
  `taskID` int(11) NOT NULL,
  `autorID` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`taskID`, `autorID`, `name`) VALUES
(1, 1, 'Проверка возможностей №1'),
(2, 3, 'Геометрия, 7 класс, итоговая работа'),
(3, 3, 'Тестирование'),
(4, 4, 'Математика, 2 класс, 5 вариант'),
(5, 3, 'Тестирование123'),
(6, 3, 'test'),
(7, 3, 'тестирование 12.05');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(25) NOT NULL,
  `passw` varchar(64) NOT NULL,
  `role` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Пользователи';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `passw`, `role`) VALUES
(1, 'admin', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2'),
(2, 'zavuch', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2'),
(3, 'root', '430005175c4c7810996d3481f0dbc3ec01103d6abcc5beec5db4b3f1eae35047', '2'),
(4, 'teacher', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1'),
(5, 'galinapetrovna', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1'),
(6, 'galinamikhailovna', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1'),
(7, 'petrivanov', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2'),
(8, 'hacker', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '0'),
(9, 'checking', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '0'),
(10, 'test', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`taskID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `marks`
--
ALTER TABLE `marks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
