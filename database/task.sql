-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 29 2019 г., 06:01
-- Версия сервера: 10.1.35-MariaDB
-- Версия PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `title`, `description`) VALUES
(1, 'Title 1', 'Description 1');

-- --------------------------------------------------------

--
-- Структура таблицы `logo`
--

CREATE TABLE `logo` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `logo`
--

INSERT INTO `logo` (`id`, `name`, `image`, `category_id`) VALUES
(7, 'second new', '[\"photo_2019-02-27_09-20-53.jpg\"]', 1),
(8, '11111', '[]', 1),
(10, 'fsda', '[\"590x332.jpg\",\"photo_2019-02-27_09-21-39.jpg\"]', 1),
(11, 'fsda', '[\"590x332.jpg\"]', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tag`
--

INSERT INTO `tag` (`id`, `name`) VALUES
(1, 'green'),
(2, 'yellow'),
(3, 'red'),
(4, 'tttt'),
(5, 't2');

-- --------------------------------------------------------

--
-- Структура таблицы `tag_assign`
--

CREATE TABLE `tag_assign` (
  `id` int(11) NOT NULL,
  `logo_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tag_assign`
--

INSERT INTO `tag_assign` (`id`, `logo_id`, `tag_id`) VALUES
(7, 7, 2),
(8, 7, 1),
(9, 8, 1),
(10, 8, 2),
(11, 8, 3),
(12, 8, 4),
(20, 11, 1),
(21, 11, 2),
(22, 11, 3);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logo`
--
ALTER TABLE `logo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_logo_category_idx` (`category_id`);

--
-- Индексы таблицы `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tag_assign`
--
ALTER TABLE `tag_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tag_assign_logo1_idx` (`logo_id`),
  ADD KEY `fk_tag_assign_tag1_idx` (`tag_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `logo`
--
ALTER TABLE `logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `tag_assign`
--
ALTER TABLE `tag_assign`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `logo`
--
ALTER TABLE `logo`
  ADD CONSTRAINT `fk_logo_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tag_assign`
--
ALTER TABLE `tag_assign`
  ADD CONSTRAINT `fk_tag_assign_logo1` FOREIGN KEY (`logo_id`) REFERENCES `logo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tag_assign_tag1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
