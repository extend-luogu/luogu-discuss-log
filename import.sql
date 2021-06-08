SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `discuss_count` (
  `thread` int(7) NOT NULL,
  `click` int(11) NOT NULL DEFAULT '0',
  `title` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `discuss_log` (
  `thread` int(8) NOT NULL,
  `page` int(8) NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `discuss_count`
  ADD PRIMARY KEY (`thread`) USING BTREE;

ALTER TABLE `discuss_log`
  ADD PRIMARY KEY (`thread`,`page`);
COMMIT;