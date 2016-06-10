-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016 年 06 月 10 日 13:11
-- 伺服器版本: 10.1.13-MariaDB
-- PHP 版本： 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `carrybazi_photo`
--

-- --------------------------------------------------------

--
-- 資料表結構 `bazi_chat`
--

CREATE TABLE `bazi_chat` (
  `chat_id` int(32) NOT NULL,
  `sender` int(32) NOT NULL COMMENT 'user_id',
  `receiver` int(32) NOT NULL COMMENT 'user_id',
  `type` varchar(32) COLLATE utf8_unicode_520_ci NOT NULL,
  `content` varchar(32) COLLATE utf8_unicode_520_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user_information`
--

CREATE TABLE `user_information` (
  `user_id` int(32) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_520_ci NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_520_ci NOT NULL,
  `email` varchar(32) COLLATE utf8_unicode_520_ci NOT NULL,
  `photo` varchar(32) COLLATE utf8_unicode_520_ci NOT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `bazi_chat`
--
ALTER TABLE `bazi_chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- 資料表索引 `user_information`
--
ALTER TABLE `user_information`
  ADD PRIMARY KEY (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
