-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 31 2020 г., 12:40
-- Версия сервера: 10.1.41-MariaDB-0+deb9u1
-- Версия PHP: 7.1.33-2+0~20191128.28+debian9~1.gbpc60685

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ringuel_accounts`
--

-- --------------------------------------------------------

--
-- Структура таблицы `accounts_adds`
--

CREATE TABLE `accounts_adds` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `company` int(11) NOT NULL,
  `type` enum('shop_multi','shop_alone','bank') NOT NULL DEFAULT 'shop_multi',
  `count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `accounts_adds`
--

INSERT INTO `accounts_adds` (`id`, `date`, `company`, `type`, `count`) VALUES
(1, 1600461861, 2, 'shop_multi', 1),
(2, 1600710816, 5, 'shop_multi', 1),
(3, 1600710842, 18, 'bank', 1),
(4, 1600710865, 18, 'bank', 1),
(5, 1600881971, 12, 'shop_multi', 1),
(6, 1600881997, 12, 'shop_multi', 1),
(7, 1600882023, 12, 'shop_multi', 1),
(8, 1601690919, 12, 'shop_alone', 1),
(9, 1602436931, 13, 'bank', 1),
(10, 1602441860, 17, 'bank', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `title`, `email`, `pass`) VALUES
(1, 'rip', 'rip76@mail.ru', '123456');

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `seller` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `type` enum('shop_multi','shop_alone','bank') NOT NULL DEFAULT 'shop_multi',
  `company` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `desc` text NOT NULL,
  `balance` text NOT NULL,
  `total_balance` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `price` float(16,2) NOT NULL DEFAULT '0.00',
  `garant` int(11) NOT NULL DEFAULT '0',
  `status` enum('sell','selled') NOT NULL DEFAULT 'sell'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `seller`, `user`, `state`, `type`, `company`, `country`, `title`, `desc`, `balance`, `total_balance`, `count`, `price`, `garant`, `status`) VALUES
(7, 1, NULL, NULL, 'shop_multi', 2, 1, '5656', '565+', '', 0, 0, 1850.00, 1, 'selled'),
(8, 1, NULL, NULL, 'shop_multi', 2, 1, 'dfsdfs', 'gdsgsdgdsg', '', 0, 0, 55.00, 1, 'selled'),
(9, 1, NULL, NULL, 'shop_multi', 12, 1, 'ss', 'sfs', '', 0, 1, 55.00, 1, 'sell'),
(10, 1, NULL, NULL, 'bank', 17, NULL, 'sf', 'sfs', '', 0, 1, 370.00, 1, 'sell'),
(11, 1, NULL, NULL, 'shop_alone', 5, 1, 'sfsf', 'sfs', '', 0, 1, 5.00, 1, 'sell'),
(12, 1, NULL, NULL, 'bank', 13, NULL, 'fdefs', 'dsfsfs', '', 0, 1, 22.00, 1, 'sell'),
(13, 1, NULL, NULL, 'shop_multi', 2, 3, '3345345345345345', 'xccvbcxvbcvb', '', 0, 1, 55.00, 24, 'sell'),
(14, 1, NULL, NULL, 'shop_multi', 5, 1, 'sds', 'sds', '', 0, 1, 6.00, 1, 'sell'),
(15, 1, NULL, NULL, 'bank', 18, NULL, 'sfs', '565', '', 0, 1, 69.00, 1, 'sell'),
(16, 1, NULL, NULL, 'bank', 18, NULL, 'fdf', 'sfdsf', '', 0, 1, 8989.00, 1, 'sell'),
(17, 1, NULL, NULL, 'shop_multi', 12, 1, 'Товар 1', '5645964', '', 0, 1, 45.00, 1, 'sell'),
(18, 1, NULL, NULL, 'shop_multi', 12, 1, 'товар 2 ', '5646', '', 0, 1, 52.00, 1, 'sell'),
(19, 1, NULL, 19, 'shop_multi', 12, 1, 'товар 3 ', 'вауу', '', 0, 1, 49.00, 1, 'sell'),
(20, 1, NULL, NULL, 'shop_alone', 12, 1, '11111111111', '11111111111111111', '', 0, 1, 111.00, 1, 'sell'),
(21, 1, NULL, NULL, 'bank', 13, NULL, 'цукцукецукецукецуке', 'чсмсичсмичсмисчмисчми', '', 234, 1, 334.00, 1, 'sell'),
(22, 1, NULL, NULL, 'bank', 17, NULL, 'rio', '', '', 59, 1, 1000.00, 1, 'sell');

-- --------------------------------------------------------

--
-- Структура таблицы `articles_accounts`
--

CREATE TABLE `articles_accounts` (
  `id` bigint(20) NOT NULL,
  `article` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles_accounts`
--

INSERT INTO `articles_accounts` (`id`, `article`, `text`) VALUES
(24, 9, 'sfs'),
(25, 10, 'sfs'),
(26, 11, 'fs'),
(27, 12, ''),
(28, 13, 'fsdfsdfssdf | sfsdfsdfsdfwer32234 | 34234234234234234234'),
(29, 14, '222'),
(30, 15, 'ssf'),
(31, 16, '56'),
(32, 17, '56598'),
(33, 18, 'ыауа'),
(35, 20, '111111111'),
(39, 21, 'смичсмисчмисчмисчмиывапывапывапвыапвыап'),
(40, 22, ''),
(45, 19, 'цпа');

-- --------------------------------------------------------

--
-- Структура таблицы `articles_bank_accounts`
--

CREATE TABLE `articles_bank_accounts` (
  `parent` int(11) NOT NULL,
  `type` enum('calling','saving') NOT NULL DEFAULT 'calling',
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `articles_bank_accounts`
--

INSERT INTO `articles_bank_accounts` (`parent`, `type`, `number`) VALUES
(22, 'saving', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `article` int(11) DEFAULT NULL,
  `type` enum('shop','bank') NOT NULL DEFAULT 'shop',
  `user` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`article`, `type`, `user`, `count`) VALUES
(13, 'shop', 1, 1),
(10, 'shop', 1, 1),
(12, 'shop', 1, 1),
(9, 'shop', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `group` enum('bank','shop') NOT NULL,
  `title` text NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`id`, `group`, `title`, `desc`) VALUES
(1, 'shop', 'Ebay Valid Email', 'ЛОЛ'),
(2, 'shop', 'Ebay Brute', '77879794'),
(3, 'shop', 'WayFair', ''),
(4, 'shop', 'Victoria\'s Secret', ''),
(5, 'shop', 'NordVPN', ''),
(12, 'shop', 'Apple', ''),
(13, 'bank', 'Tcunet+AN_RN', ''),
(14, 'bank', 'TrustMark+AN_RN', ''),
(15, 'bank', 'IBC+AN_RN', ''),
(16, 'bank', 'OnPoint+AN_RN', ''),
(17, 'bank', 'FirstCitizens+AN_RN', 'dsfsadfsdfsdfsdf'),
(18, 'bank', 'Golde1+AN_RN', '');

-- --------------------------------------------------------

--
-- Структура таблицы `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `flag` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `country`
--

INSERT INTO `country` (`id`, `title`, `flag`) VALUES
(1, 'USA', '/images/flag/usa.png'),
(2, 'France', '/images/flag/fr.png'),
(3, 'Germany', '/images/flag/germany.png'),
(4, 'Italia', '/images/flag/it.png'),
(5, 'Англия', '/images/flag/uk.png'),
(6, 'Австрия', '/images/flag/at.png'),
(7, 'Canada', '/images/flag/ca.png');

-- --------------------------------------------------------

--
-- Структура таблицы `payout`
--

CREATE TABLE `payout` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `tx_hash` text NOT NULL,
  `sum` int(11) NOT NULL DEFAULT '0',
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payout`
--

INSERT INTO `payout` (`id`, `date`, `tx_hash`, `sum`, `address`) VALUES
(1, 1597507874, '1c5290ebfcf4640ad603381744684495e14649ccedbfb468f5d74cf994270aca', 10000, '3MmKrEYVeoEzanJcScu919wukRHbU5LVsk');

-- --------------------------------------------------------

--
-- Структура таблицы `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `pay_hash` text NOT NULL,
  `amount_btc` float(20,14) NOT NULL DEFAULT '0.00000000000000',
  `fee` float(20,14) NOT NULL DEFAULT '0.00000000000000',
  `btcusd` float(12,4) NOT NULL DEFAULT '0.0000',
  `date` int(11) NOT NULL DEFAULT '0',
  `usd_before` float(12,4) NOT NULL DEFAULT '0.0000',
  `status` enum('new','confirmed','finished','fail') NOT NULL DEFAULT 'new',
  `confirmations` int(11) NOT NULL DEFAULT '0',
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pays`
--

INSERT INTO `pays` (`id`, `user`, `pay_hash`, `amount_btc`, `fee`, `btcusd`, `date`, `usd_before`, `status`, `confirmations`, `address`) VALUES
(7, 1, '3552375002eec6187bb101306267ce97d5745c67a55c65c900fd4a76c95aa6ac', 0.00015000000712, 0.00000000000000, 11824.7002, 1597501938, 5004.0601, 'finished', 3, '3JKoF9tcVFH6jgeJtkdY2LnTf23AbLGcZ5'),
(8, 1, '99d1fad97f4750230e217e8dc61a46fe9f715fbf10c07ab21a6e2a967d35dd94', 0.00030000001425, 0.00000000000000, 11884.6104, 1597506038, 5005.8301, 'finished', 3, '3JKoF9tcVFH6jgeJtkdY2LnTf23AbLGcZ5');

-- --------------------------------------------------------

--
-- Структура таблицы `purchased`
--

CREATE TABLE `purchased` (
  `id` int(11) NOT NULL,
  `slot` int(11) NOT NULL DEFAULT '0',
  `seller` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `type` enum('shop_multi','shop_alone','bank') NOT NULL DEFAULT 'shop_multi',
  `company` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `desc` text NOT NULL,
  `price` float(16,2) NOT NULL DEFAULT '0.00',
  `garant` int(11) NOT NULL DEFAULT '0',
  `status` enum('purchased','expired','ticket','returned','not_returned','part_returned') NOT NULL DEFAULT 'purchased'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `purchased`
--

INSERT INTO `purchased` (`id`, `slot`, `seller`, `user`, `type`, `company`, `country`, `title`, `desc`, `price`, `garant`, `status`) VALUES
(12, 5, 1, 1, 'bank', 17, NULL, '5656', 'мваыапупп', 56.00, 1599901729, 'expired'),
(13, 6, 1, 1, 'bank', 18, NULL, 'test2', 'wewerwerwerwersdfsdfsdf', 30.00, 1600102723, 'not_returned'),
(14, 7, 1, 1, 'shop_multi', 2, 1, '5656', '565+', 1850.00, 1600027299, 'expired'),
(15, 8, 1, 1, 'shop_multi', 2, 1, 'dfsdfs', 'gdsgsdgdsg', 55.00, 1600123107, 'expired'),
(16, 2, 1, 1, 'shop_multi', 4, 1, 'xcxcvxcvxcvxcv', 'lqkwerklj lkjw elkjwqerl kj\r\nsdfsadfsdaf\r\n234234234234', 2.00, 1600193486, 'ticket');

-- --------------------------------------------------------

--
-- Структура таблицы `purchased_accounts`
--

CREATE TABLE `purchased_accounts` (
  `id` bigint(20) NOT NULL,
  `article` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `purchased_accounts`
--

INSERT INTO `purchased_accounts` (`id`, `article`, `text`) VALUES
(28, 12, 'ппкпкупку'),
(29, 13, '121232323 | qweqweqweqwe | zxcxczxczxczxc'),
(30, 14, '565+'),
(31, 15, 'dsggcxv ere'),
(32, 16, '');

-- --------------------------------------------------------

--
-- Структура таблицы `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `name` text NOT NULL,
  `balance` float(10,2) NOT NULL DEFAULT '0.00',
  `slots` int(11) NOT NULL DEFAULT '3',
  `multi` tinyint(1) NOT NULL DEFAULT '0',
  `banks` tinyint(1) NOT NULL DEFAULT '0',
  `fee` int(11) NOT NULL DEFAULT '50',
  `wallet` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sellers`
--

INSERT INTO `sellers` (`id`, `email`, `pass`, `name`, `balance`, `slots`, `multi`, `banks`, `fee`, `wallet`) VALUES
(1, 'rip76@mail.ru', '123456', 'Максим', 6496.40, 5, 1, 0, 70, 'rip76@mail.ru');

-- --------------------------------------------------------

--
-- Структура таблицы `states`
--

CREATE TABLE `states` (
  `id` int(11) NOT NULL,
  `code` text NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `states`
--

INSERT INTO `states` (`id`, `code`, `title`) VALUES
(1, 'IA', ''),
(2, 'AL', ''),
(3, 'AK', ''),
(4, 'AZ', ''),
(5, 'AR', ''),
(6, 'WY', ''),
(7, 'WA', ''),
(8, 'VT', ''),
(9, 'VA', ''),
(10, 'WI', ''),
(11, 'HI', ''),
(12, 'DE', ''),
(13, 'GA', ''),
(14, 'WV', ''),
(15, 'IL', ''),
(16, 'IN', ''),
(17, 'CA', ''),
(18, 'KS', ''),
(19, 'KY', ''),
(20, 'CO', ''),
(21, 'CT', ''),
(22, 'LA', ''),
(23, 'MA', ''),
(24, 'MN', ''),
(25, 'MS', ''),
(26, 'MO', ''),
(27, 'MI', ''),
(28, 'MT', ''),
(29, 'ME', ''),
(30, 'MD', ''),
(31, 'NE', ''),
(32, 'NV', ''),
(33, 'NH', ''),
(34, 'NJ', ''),
(35, 'NY', ''),
(36, 'NM', ''),
(37, 'OH', ''),
(38, 'OK', ''),
(39, 'OR', ''),
(40, 'PA', ''),
(41, 'RI', ''),
(42, 'ND', ''),
(43, 'NC', ''),
(44, 'TN', ''),
(45, 'TX', ''),
(46, 'FL', ''),
(47, 'SD', ''),
(48, 'SC', ''),
(49, 'UT', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `type` enum('support','deal','deal_seller','balance') NOT NULL DEFAULT 'support',
  `parent` int(11) NOT NULL DEFAULT '0',
  `user` int(11) DEFAULT NULL,
  `seller` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `title` text,
  `status` enum('open','work','finished','closed','good','bad') DEFAULT 'open',
  `updated` int(11) NOT NULL DEFAULT '0',
  `seller_updated` int(11) NOT NULL DEFAULT '0',
  `user_checked` int(11) NOT NULL DEFAULT '0',
  `admin_checked` int(11) NOT NULL DEFAULT '0',
  `seller_checked` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`id`, `date`, `type`, `parent`, `user`, `seller`, `admin`, `title`, `status`, `updated`, `seller_updated`, `user_checked`, `admin_checked`, `seller_checked`) VALUES
(6, 1600089157, 'deal', 13, 1, NULL, NULL, 'ываываываыва', 'finished', 0, 0, 0, 0, 0),
(7, 1600119580, 'deal', 15, 1, NULL, NULL, 'HELP', 'finished', 0, 0, 0, 0, 0),
(8, 1600182700, 'deal', 16, 1, 1, NULL, 'Ремонт и техническое обслуживание Hyundai i20', 'open', 1600271978, 1600276117, 0, 0, 0),
(11, 1600339533, 'support', 0, NULL, 1, NULL, 'цйукйцукцуйкйцук', 'open', 1600351407, 0, 0, 0, 0),
(12, 1600352955, 'support', 0, 1, NULL, NULL, 'qweqwexzccxzxcz', 'open', 1600352955, 1600352964, 0, 0, 0),
(13, 1600369382, 'support', 0, NULL, 1, NULL, 'Ногтевой сервис', 'open', 1600369382, 0, 0, 0, 0),
(14, 1600634759, 'support', 0, NULL, 1, NULL, 'rtr', 'open', 1600634759, 0, 0, 0, 0),
(15, 1600685525, 'support', 0, 1, NULL, NULL, 'test1', 'open', 1600685525, 0, 0, 0, 0),
(16, 1600710887, 'support', 0, NULL, 1, NULL, 'это продавец', 'open', 1600710956, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tickets_messages`
--

CREATE TABLE `tickets_messages` (
  `id` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `date` int(11) NOT NULL DEFAULT '0',
  `owner` enum('user','admin','seller') NOT NULL DEFAULT 'user',
  `type` enum('msg','file','service') NOT NULL DEFAULT 'msg',
  `text` text NOT NULL,
  `param` int(11) NOT NULL,
  `mode` enum('user','seller') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tickets_messages`
--

INSERT INTO `tickets_messages` (`id`, `parent`, `date`, `owner`, `type`, `text`, `param`, `mode`) VALUES
(15, 6, 1600089157, 'user', 'msg', 'ячсмячсмячсмясмячсмчясм\r\nчясмчясмчясмчсмчясмчясмчсямчсмчясм\r\nцкцукцукцукцук', 0, 'user'),
(16, 7, 1600119580, 'user', 'msg', 'test', 0, 'user'),
(17, 7, 1600119680, 'admin', 'msg', 'ssds', 0, 'user'),
(18, 6, 1600174006, 'admin', 'msg', 'Ответ администратора.', 0, 'user'),
(19, 6, 1600180916, 'admin', 'msg', 'erer', 0, 'user'),
(20, 8, 1600182700, 'user', 'msg', '5689', 0, 'user'),
(22, 8, 1600271905, 'admin', 'msg', 'Проверка сообщения к продавцу', 0, 'seller'),
(23, 8, 1600271978, 'admin', 'msg', '', 0, 'seller'),
(24, 8, 1600276117, 'seller', 'msg', 'проверка ответа админу от продавца', 0, 'seller'),
(25, 11, 1600339533, 'seller', 'msg', 'цук15421334123412342341234', 0, 'seller'),
(26, 11, 1600351407, 'admin', 'msg', 'проверка админа', 0, 'user'),
(27, 12, 1600352955, 'user', 'msg', '1212123123123123123123\r\nwqeqweqweqweqwe\r\nvcxcvxcvxcvcxvxcvxcvxcvxcv', 0, 'user'),
(29, 12, 1600353018, 'user', 'msg', 'sadfsdfsdf', 0, 'user'),
(30, 13, 1600369382, 'seller', 'msg', 'gyufgyukf', 0, 'seller'),
(31, 14, 1600634759, 'seller', 'msg', 'rtrgvbgvbgvbgvbfgfgbbfgfgbfgbfgbfgbfgfgbfgb', 0, 'seller'),
(32, 6, 1600685328, 'user', 'msg', 'xcvxcv', 0, 'user'),
(33, 15, 1600685525, 'user', 'msg', 'test', 0, 'user'),
(34, 16, 1600710887, 'seller', 'msg', '777', 0, 'seller'),
(35, 16, 1600710956, 'admin', 'msg', 'dfd', 0, 'user'),
(36, 8, 1600711019, 'user', 'msg', 'sdsds', 0, 'user'),
(37, 8, 1600711145, 'user', 'msg', '5656565', 0, 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL,
  `pass` text NOT NULL,
  `name` text NOT NULL,
  `balance` float(16,2) NOT NULL,
  `btc` text NOT NULL,
  `confirm` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `name`, `balance`, `btc`, `confirm`) VALUES
(1, 'rip76@mail.ru', 'e10adc3949ba59abbe56e057f20f883e', 'Максим1', 6998.40, '3JKoF9tcVFH6jgeJtkdY2LnTf23AbLGcZ5', NULL),
(3, 'rip1976@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'rip', 0.00, '3QdoBxrfoTpubEyedXkhL6q9iMQpVfRRAn', 'b30d30dea700dc976c808d81f21d7768784b1e7d');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `accounts_adds`
--
ALTER TABLE `accounts_adds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`);

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`),
  ADD KEY `country` (`country`),
  ADD KEY `seller` (`seller`),
  ADD KEY `user` (`user`),
  ADD KEY `state` (`state`);

--
-- Индексы таблицы `articles_accounts`
--
ALTER TABLE `articles_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article` (`article`);

--
-- Индексы таблицы `articles_bank_accounts`
--
ALTER TABLE `articles_bank_accounts`
  ADD KEY `parent` (`parent`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD KEY `article` (`article`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `payout`
--
ALTER TABLE `payout`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `purchased`
--
ALTER TABLE `purchased`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company` (`company`),
  ADD KEY `country` (`country`),
  ADD KEY `seller` (`seller`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `purchased_accounts`
--
ALTER TABLE `purchased_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article` (`article`);

--
-- Индексы таблицы `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `seller` (`seller`),
  ADD KEY `admin` (`admin`);

--
-- Индексы таблицы `tickets_messages`
--
ALTER TABLE `tickets_messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `accounts_adds`
--
ALTER TABLE `accounts_adds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `articles_accounts`
--
ALTER TABLE `articles_accounts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `payout`
--
ALTER TABLE `payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `purchased`
--
ALTER TABLE `purchased`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `purchased_accounts`
--
ALTER TABLE `purchased_accounts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `states`
--
ALTER TABLE `states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT для таблицы `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `tickets_messages`
--
ALTER TABLE `tickets_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `accounts_adds`
--
ALTER TABLE `accounts_adds`
  ADD CONSTRAINT `accounts_adds_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`);

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`company`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`country`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`seller`) REFERENCES `sellers` (`id`),
  ADD CONSTRAINT `articles_ibfk_4` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `articles_ibfk_5` FOREIGN KEY (`state`) REFERENCES `states` (`id`);

--
-- Ограничения внешнего ключа таблицы `articles_accounts`
--
ALTER TABLE `articles_accounts`
  ADD CONSTRAINT `articles_accounts_ibfk_1` FOREIGN KEY (`article`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `articles_bank_accounts`
--
ALTER TABLE `articles_bank_accounts`
  ADD CONSTRAINT `articles_bank_accounts_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `articles` (`id`);

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`article`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_4` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pays`
--
ALTER TABLE `pays`
  ADD CONSTRAINT `pays_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `purchased_accounts`
--
ALTER TABLE `purchased_accounts`
  ADD CONSTRAINT `purchased_accounts_ibfk_1` FOREIGN KEY (`article`) REFERENCES `purchased` (`id`);

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`seller`) REFERENCES `sellers` (`id`),
  ADD CONSTRAINT `tickets_ibfk_3` FOREIGN KEY (`admin`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
