-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-03-13 10:08:54
-- 伺服器版本: 10.1.9-MariaDB
-- PHP 版本： 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `carry_photo`
--

-- --------------------------------------------------------

--
-- 資料表結構 `carrybazi_talk`
--

CREATE TABLE `carrybazi_talk` (
  `id` int(20) NOT NULL,
  `sender` varchar(10) CHARACTER SET latin1 NOT NULL,
  `receiver` varchar(10) CHARACTER SET latin1 NOT NULL,
  `type` varchar(10) CHARACTER SET latin1 NOT NULL,
  `content` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `isRead` tinyint(1) NOT NULL DEFAULT '0',
  `postDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `carrybazi_user`
--

CREATE TABLE `carrybazi_user` (
  `id` int(11) NOT NULL,
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` int(11) NOT NULL COMMENT 'comsumer or photographer',
  `registertype` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'facebook, instagram etc',
  `registerDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `carrybazi_userinfo`
--

CREATE TABLE `carrybazi_userinfo` (
  `userid` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `carrybazi_talk`
--
ALTER TABLE `carrybazi_talk`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `carrybazi_user`
--
ALTER TABLE `carrybazi_user`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `carrybazi_userinfo`
--
ALTER TABLE `carrybazi_userinfo`
  ADD KEY `userid` (`userid`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `carrybazi_talk`
--
ALTER TABLE `carrybazi_talk`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
--
-- 使用資料表 AUTO_INCREMENT `carrybazi_user`
--
ALTER TABLE `carrybazi_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `carrybazi_userinfo`
--
ALTER TABLE `carrybazi_userinfo`
  ADD CONSTRAINT `carrybazi_userinfo_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `carrybazi_user` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
