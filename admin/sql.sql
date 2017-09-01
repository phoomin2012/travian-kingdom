SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `error_nodejs`;
CREATE TABLE `error_nodejs` (
  `id` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `error` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `error_php`;
CREATE TABLE `error_php` (
  `id` int(11) NOT NULL,
  `host` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `file` text NOT NULL,
  `line` varchar(255) NOT NULL,
  `count` int(11) NOT NULL,
  `last` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `global_avatar`;
CREATE TABLE `global_avatar` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `hairColor` int(11) NOT NULL,
  `beard` int(11) NOT NULL,
  `ear` int(11) NOT NULL,
  `eye` int(11) NOT NULL,
  `eyebrow` int(11) NOT NULL,
  `hair` int(11) NOT NULL,
  `mouth` int(11) NOT NULL,
  `nose` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `global_msid`;
CREATE TABLE `global_msid` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `global_server_data`;
CREATE TABLE `global_server_data` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `tag` varchar(255) CHARACTER SET latin1 NOT NULL,
  `folder` varchar(255) CHARACTER SET latin1 NOT NULL,
  `prefix` varchar(255) CHARACTER SET latin1 NOT NULL,
  `speed_world` int(11) DEFAULT NULL,
  `speed_unit` int(11) DEFAULT NULL,
  `multiple_hero_item` int(11) DEFAULT NULL,
  `multiple_hero_resource` int(11) DEFAULT NULL,
  `multiple_hero_speed` int(11) DEFAULT NULL,
  `multiple_hero_power` int(11) DEFAULT NULL,
  `multiple_storage` int(11) DEFAULT NULL,
  `base_storage` int(11) NOT NULL,
  `plus_time` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `protection` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `start` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `natar` int(11) DEFAULT NULL,
  `wwvillage` int(11) DEFAULT NULL,
  `peace` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `genmap` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `maintenance` int(11) NOT NULL,
  `recommended` int(11) NOT NULL,
  `installed` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `global_server_data` (`sid`, `name`, `tag`, `folder`, `prefix`, `speed_world`, `speed_unit`, `multiple_hero_item`, `multiple_hero_resource`, `multiple_hero_speed`, `multiple_hero_power`, `multiple_storage`, `base_storage`, `plus_time`, `protection`, `start`, `natar`, `wwvillage`, `peace`, `genmap`, `maintenance`, `recommended`, `installed`) VALUES
(1, 'Developing', 'server1', 'http://ks1.t5.ph', 's1_', 100, 100, 1, 1, 1, 1, 1, 800, '86400*7', '86400*7', '1504286658', 1, 1, '0', '2', 0, 1, 1);

DROP TABLE IF EXISTS `global_user`;
CREATE TABLE `global_user` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `timed` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `prestige` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `process_php`;
CREATE TABLE `process_php` (
  `id` int(11) NOT NULL,
  `pdi` varchar(255) NOT NULL,
  `server` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_auction`;
CREATE TABLE `s1_auction` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `bid` int(11) NOT NULL,
  `bidder` int(11) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_building`;
CREATE TABLE `s1_building` (
  `id` int(10) UNSIGNED NOT NULL,
  `wid` varchar(10) NOT NULL,
  `location` tinyint(2) UNSIGNED NOT NULL,
  `type` tinyint(2) UNSIGNED NOT NULL,
  `sort` int(11) NOT NULL,
  `start` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `timestamp` int(16) NOT NULL,
  `queue` tinyint(1) NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `cost` text NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `s1_cache`;
CREATE TABLE `s1_cache` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `data` text CHARACTER SET latin1 NOT NULL,
  `timed` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `s1_chat_line`;
CREATE TABLE `s1_chat_line` (
  `id` int(11) NOT NULL,
  `room` varchar(255) NOT NULL,
  `from` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_chat_room`;
CREATE TABLE `s1_chat_room` (
  `id` int(11) NOT NULL,
  `roomId` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `line` text NOT NULL,
  `close` int(11) NOT NULL,
  `closeby` int(11) NOT NULL,
  `lastOtherRead` varchar(255) NOT NULL,
  `lastOwnRead` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `playersRead` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_field`;
CREATE TABLE `s1_field` (
  `id` int(10) UNSIGNED NOT NULL,
  `wid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `location` int(11) NOT NULL,
  `rubble` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

DROP TABLE IF EXISTS `s1_gamecard`;
CREATE TABLE `s1_gamecard` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `free` int(11) NOT NULL,
  `card1` varchar(255) NOT NULL,
  `card2` varchar(255) NOT NULL,
  `card3` varchar(255) NOT NULL,
  `card4` varchar(255) NOT NULL,
  `card5` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_hero`;
CREATE TABLE `s1_hero` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `village` varchar(255) NOT NULL,
  `move` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `levelUp` int(11) NOT NULL,
  `speed` int(11) NOT NULL DEFAULT '7',
  `point` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `dead` int(11) NOT NULL,
  `health` double(11,6) NOT NULL DEFAULT '100.000000',
  `power` int(11) NOT NULL,
  `itempower` int(11) NOT NULL,
  `atkBonus` int(11) NOT NULL,
  `defBonus` int(11) NOT NULL,
  `resBonus` int(11) NOT NULL,
  `resType` int(11) NOT NULL,
  `regen` int(11) NOT NULL DEFAULT '10',
  `lastupdate` varchar(255) NOT NULL,
  `advPoint` int(11) NOT NULL,
  `useAdvPoint` int(11) NOT NULL,
  `advNext` varchar(255) NOT NULL,
  `advShort` varchar(255) NOT NULL,
  `advLong` varchar(255) NOT NULL,
  `revive` varchar(255) NOT NULL,
  `max_scroll` int(11) NOT NULL,
  `use_scroll` int(11) NOT NULL,
  `use_waterbucket` int(11) NOT NULL,
  `use_ointments` int(11) NOT NULL,
  `use_advcard` int(11) NOT NULL,
  `use_reschest` int(11) NOT NULL,
  `use_cropchest` int(11) NOT NULL,
  `use_artwork` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_hero_item`;
CREATE TABLE `s1_hero_item` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `slot` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `tier` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `bonus` text NOT NULL,
  `upgrade` text NOT NULL,
  `equip` int(11) NOT NULL,
  `lastChange` varchar(255) NOT NULL,
  `previousOwners` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_influence`;
CREATE TABLE `s1_influence` (
  `wid` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `kingdom` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_kingdom`;
CREATE TABLE `s1_kingdom` (
  `id` int(11) NOT NULL,
  `king` int(11) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `vca` int(11) NOT NULL COMMENT 'Victory Point All',
  `vcw` int(11) NOT NULL COMMENT 'Victory Point Weekly',
  `indesc` text NOT NULL COMMENT 'Internal Description',
  `pubdesc` text NOT NULL COMMENT 'Public Description',
  `duke1` varchar(255) NOT NULL,
  `duke2` varchar(255) NOT NULL,
  `duke3` varchar(255) NOT NULL,
  `duke4` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_market`;
CREATE TABLE `s1_market` (
  `id` int(10) UNSIGNED NOT NULL,
  `wid` varchar(255) NOT NULL,
  `gtype` tinyint(1) UNSIGNED NOT NULL,
  `gamt` int(11) UNSIGNED NOT NULL,
  `wtype` tinyint(1) UNSIGNED NOT NULL,
  `wamt` int(11) UNSIGNED NOT NULL,
  `accept` tinyint(1) UNSIGNED NOT NULL,
  `maxtime` int(11) UNSIGNED NOT NULL,
  `kingdom` int(11) UNSIGNED NOT NULL,
  `merchant` tinyint(2) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `s1_nodejs`;
CREATE TABLE `s1_nodejs` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `sent` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_notepad`;
CREATE TABLE `s1_notepad` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_notification`;
CREATE TABLE `s1_notification` (
  `id` int(11) NOT NULL,
  `player` varchar(255) NOT NULL,
  `itemId` varchar(255) NOT NULL,
  `type` int(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `expire` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_oasis`;
CREATE TABLE `s1_oasis` (
  `id` int(11) NOT NULL,
  `wid` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `wood` double(20,2) NOT NULL DEFAULT '750.00',
  `clay` double(20,2) NOT NULL DEFAULT '750.00',
  `iron` double(20,2) NOT NULL DEFAULT '750.00',
  `woodp` double(20,2) NOT NULL DEFAULT '0.00',
  `clayp` double(20,2) NOT NULL DEFAULT '0.00',
  `ironp` double(20,2) NOT NULL DEFAULT '0.00',
  `maxstore` double(20,2) NOT NULL DEFAULT '800.00',
  `crop` double(20,2) NOT NULL DEFAULT '750.00',
  `cropp` double(20,2) NOT NULL DEFAULT '0.00',
  `maxcrop` double(20,2) NOT NULL DEFAULT '800.00',
  `lasttrain` varchar(255) NOT NULL,
  `lastupdate` varchar(255) NOT NULL,
  `loyalty` int(11) NOT NULL DEFAULT '100',
  `owner` varchar(255) NOT NULL DEFAULT '-1',
  `unit` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_oasis_rank`;
CREATE TABLE `s1_oasis_rank` (
  `id` int(11) NOT NULL,
  `oasis` varchar(255) NOT NULL,
  `player` varchar(255) NOT NULL,
  `village` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  `point` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_php`;
CREATE TABLE `s1_php` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `data` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_report_body`;
CREATE TABLE `s1_report_body` (
  `id` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `source_data` longtext NOT NULL,
  `target_data` longtext NOT NULL,
  `detail_data` longtext NOT NULL,
  `module_source` longtext NOT NULL,
  `module_target` longtext NOT NULL,
  `module_support` longtext NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_report_head`;
CREATE TABLE `s1_report_head` (
  `id` int(11) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `collection` varchar(255) NOT NULL,
  `token` int(6) NOT NULL,
  `type` int(11) NOT NULL,
  `source_data` longtext NOT NULL,
  `target_data` longtext NOT NULL,
  `detail_data` longtext NOT NULL,
  `favorite` int(11) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_robber`;
CREATE TABLE `s1_robber` (
  `id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `kingdom` varchar(255) NOT NULL,
  `wood` int(11) NOT NULL,
  `clay` int(11) NOT NULL,
  `iron` int(11) NOT NULL,
  `crop` int(11) NOT NULL,
  `treasure` int(11) NOT NULL,
  `troop` varchar(255) NOT NULL,
  `expire` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_setting`;
CREATE TABLE `s1_setting` (
  `id` int(11) NOT NULL,
  `uid` varchar(255) NOT NULL,
  `attacksFilter` varchar(255) NOT NULL DEFAULT '2',
  `disableAnimations` varchar(255) NOT NULL DEFAULT '0',
  `HelpNotifications` varchar(255) NOT NULL DEFAULT '0',
  `TabNotifications` varchar(255) NOT NULL DEFAULT '1',
  `extendedSimulator` varchar(255) NOT NULL DEFAULT '0',
  `lang` varchar(255) NOT NULL,
  `mapFilter` varchar(255) NOT NULL DEFAULT '-1',
  `musicVolume` varchar(255) NOT NULL DEFAULT '0',
  `muteAll` varchar(255) NOT NULL DEFAULT '0',
  `notpadsVisible` varchar(255) NOT NULL DEFAULT '0',
  `onlineStatusFilter` varchar(255) NOT NULL DEFAULT '0',
  `premiumConfirmation` varchar(255) NOT NULL DEFAULT '2',
  `soundVolume` varchar(255) NOT NULL DEFAULT '0',
  `timeFormat` varchar(255) NOT NULL DEFAULT '0',
  `timeZone` varchar(255) NOT NULL DEFAULT '1',
  `uiSoundVolume` varchar(255) NOT NULL DEFAULT '50',
  `WelcomeScreen` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_tdata`;
CREATE TABLE `s1_tdata` (
  `wid` varchar(11) NOT NULL,
  `t1` int(11) NOT NULL,
  `t2` int(2) NOT NULL DEFAULT '-2',
  `t3` int(2) NOT NULL DEFAULT '-2',
  `t4` int(2) NOT NULL DEFAULT '-2',
  `t5` int(2) NOT NULL DEFAULT '-2',
  `t6` int(2) NOT NULL DEFAULT '-2',
  `t7` int(2) NOT NULL DEFAULT '-2',
  `t8` int(2) NOT NULL DEFAULT '-2',
  `t9` int(2) NOT NULL DEFAULT '-2'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `s1_tqueue`;
CREATE TABLE `s1_tqueue` (
  `id` int(11) NOT NULL,
  `wid` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL,
  `building` int(11) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_train`;
CREATE TABLE `s1_train` (
  `id` int(11) NOT NULL,
  `wid` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `start` varchar(255) NOT NULL,
  `next` varchar(255) NOT NULL,
  `order` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_train_queue`;
CREATE TABLE `s1_train_queue` (
  `id` int(11) NOT NULL,
  `tid` varchar(255) NOT NULL COMMENT 'Train id',
  `amount` int(11) NOT NULL,
  `duration` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_troop_move`;
CREATE TABLE `s1_troop_move` (
  `id` int(11) NOT NULL,
  `from` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `spy` varchar(255) NOT NULL,
  `redeployHero` varchar(255) NOT NULL,
  `start` varchar(255) NOT NULL,
  `end` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `merchant` int(11) NOT NULL,
  `data` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_troop_stay`;
CREATE TABLE `s1_troop_stay` (
  `id` int(11) NOT NULL,
  `wid` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_units`;
CREATE TABLE `s1_units` (
  `id` int(11) NOT NULL,
  `wid` varchar(255) NOT NULL COMMENT 'Owner',
  `u1` bigint(11) NOT NULL,
  `u2` bigint(11) NOT NULL,
  `u3` bigint(11) NOT NULL,
  `u4` bigint(11) NOT NULL,
  `u5` bigint(11) NOT NULL,
  `u6` bigint(11) NOT NULL,
  `u7` bigint(11) NOT NULL,
  `u8` bigint(11) NOT NULL,
  `u9` bigint(11) NOT NULL,
  `u10` bigint(11) NOT NULL,
  `u11` bigint(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `s1_user`;
CREATE TABLE `s1_user` (
  `uid` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `tribe` int(1) NOT NULL,
  `kingdom` int(11) NOT NULL,
  `gold` varchar(255) DEFAULT NULL,
  `silver` int(11) NOT NULL,
  `cp` double(20,6) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `serial` int(11) NOT NULL,
  `desc` longtext NOT NULL COMMENT 'Description',
  `protection` varchar(255) NOT NULL DEFAULT '0',
  `tutorial` int(11) NOT NULL,
  `quest` varchar(255) NOT NULL,
  `master` tinyint(1) NOT NULL DEFAULT '0',
  `online` int(11) NOT NULL,
  `spawn` varchar(255) NOT NULL DEFAULT '0',
  `plus` varchar(255) NOT NULL DEFAULT '0',
  `resBonus` varchar(255) NOT NULL DEFAULT '0',
  `cropBonus` varchar(255) NOT NULL DEFAULT '0',
  `starterPack` varchar(255) NOT NULL DEFAULT '0',
  `autoExtend` int(11) NOT NULL DEFAULT '0',
  `lastLogin` varchar(255) NOT NULL,
  `attp` bigint(20) NOT NULL COMMENT 'Attack point',
  `defp` bigint(20) NOT NULL COMMENT 'Defend point'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_village`;
CREATE TABLE `s1_village` (
  `wid` int(11) NOT NULL,
  `vname` varchar(255) DEFAULT NULL,
  `owner` int(11) DEFAULT NULL,
  `pop` int(11) DEFAULT '0',
  `wood` double(11,5) DEFAULT '0.00000',
  `clay` double(11,5) DEFAULT '0.00000',
  `iron` double(11,5) DEFAULT '0.00000',
  `pwood` int(11) DEFAULT '0',
  `pclay` int(11) DEFAULT '0',
  `piron` int(11) DEFAULT '0',
  `maxstore` int(11) DEFAULT '0',
  `maxcrop` int(11) DEFAULT '0',
  `crop` double(11,5) DEFAULT '0.00000',
  `pcrop` int(11) DEFAULT '0',
  `cp` double(11,5) DEFAULT '0.00000',
  `settler` int(11) NOT NULL,
  `settler_used` int(11) NOT NULL,
  `capitel` int(2) NOT NULL DEFAULT '0',
  `town` int(11) NOT NULL,
  `effect` varchar(255) DEFAULT NULL,
  `ref` varchar(255) DEFAULT NULL,
  `lastupdate` varchar(255) DEFAULT NULL,
  `settled` varchar(255) NOT NULL,
  `expandedfrom` varchar(255) NOT NULL,
  `natar` int(11) NOT NULL,
  `area` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `s1_world`;
CREATE TABLE `s1_world` (
  `id` int(10) UNSIGNED NOT NULL,
  `fieldtype` varchar(5) NOT NULL,
  `oasistype` varchar(5) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `bonus` tinyint(2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `error_nodejs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `error_php`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `global_avatar`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `global_msid`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `global_server_data`
  ADD PRIMARY KEY (`sid`,`name`,`tag`,`folder`);

ALTER TABLE `global_user`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `process_php`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_auction`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_building`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wid` (`wid`),
  ADD KEY `field` (`location`);

ALTER TABLE `s1_cache`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_chat_line`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_chat_room`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_field`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vref` (`id`);

ALTER TABLE `s1_gamecard`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_hero`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_hero_item`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_influence`
  ADD PRIMARY KEY (`wid`);

ALTER TABLE `s1_kingdom`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_market`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_nodejs`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_notification`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_oasis`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_oasis_rank`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_php`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_report_body`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_report_head`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_tdata`
  ADD PRIMARY KEY (`wid`);

ALTER TABLE `s1_tqueue`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_train`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_train_queue`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_troop_move`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_troop_stay`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_units`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `s1_user`
  ADD PRIMARY KEY (`uid`);

ALTER TABLE `s1_village`
  ADD PRIMARY KEY (`wid`);

ALTER TABLE `s1_world`
  ADD PRIMARY KEY (`id`),
  ADD KEY `x` (`x`),
  ADD KEY `y` (`y`),
  ADD KEY `wdata` (`x`,`y`);


ALTER TABLE `error_nodejs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `error_php`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;
ALTER TABLE `global_avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
ALTER TABLE `global_msid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `global_server_data`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `global_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
ALTER TABLE `process_php`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_auction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_building`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `s1_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_chat_line`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_chat_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_field`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
ALTER TABLE `s1_gamecard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `s1_hero_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_kingdom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_market`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_nodejs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;
ALTER TABLE `s1_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `s1_oasis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_oasis_rank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_php`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_report_body`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `s1_report_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `s1_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `s1_tqueue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `s1_train`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `s1_train_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `s1_troop_move`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `s1_troop_stay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15200;
ALTER TABLE `s1_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15202;
ALTER TABLE `s1_user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
