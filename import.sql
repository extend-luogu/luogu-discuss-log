SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
-- --------------------------------------------------------

--
-- 表的结构 `discuss_count`
--

CREATE TABLE `discuss_count` (
  `thread` int(10) UNSIGNED NOT NULL,
  `click` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `title` tinytext NOT NULL,
  `reply_count` mediumint(9) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `discuss_log`
--

CREATE TABLE `discuss_log` (
  `thread` int(10) UNSIGNED NOT NULL,
  `page` int(10) UNSIGNED NOT NULL,
  `content` longtext NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 KEY_BLOCK_SIZE=8 ROW_FORMAT=COMPRESSED;

--
-- 转储表的索引
--

--
-- 表的索引 `discuss_count`
--
ALTER TABLE `discuss_count`
  ADD PRIMARY KEY (`thread`) USING BTREE;

--
-- 表的索引 `discuss_log`
--
ALTER TABLE `discuss_log`
  ADD PRIMARY KEY (`thread`,`page`) KEY_BLOCK_SIZE=1024;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
