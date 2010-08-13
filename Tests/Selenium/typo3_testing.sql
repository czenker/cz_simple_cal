-- phpMyAdmin SQL Dump
-- version 3.3.2deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 13. August 2010 um 16:38
-- Server Version: 5.1.41
-- PHP-Version: 5.3.2-1ubuntu4.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `typo3_testing`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` text NOT NULL,
  `t3ver_state` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_stage` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_swapmode` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) unsigned NOT NULL DEFAULT '0',
  `sorting` int(11) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `perms_userid` int(11) unsigned NOT NULL DEFAULT '0',
  `perms_groupid` int(11) unsigned NOT NULL DEFAULT '0',
  `perms_user` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `perms_group` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `perms_everybody` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `editlock` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `crdate` int(11) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `title` text NOT NULL,
  `doktype` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `TSconfig` text,
  `storage_pid` int(11) NOT NULL DEFAULT '0',
  `is_siteroot` tinyint(4) NOT NULL DEFAULT '0',
  `php_tree_stop` tinyint(4) NOT NULL DEFAULT '0',
  `tx_impexp_origuid` int(11) NOT NULL DEFAULT '0',
  `url` text NOT NULL,
  `starttime` int(11) unsigned NOT NULL DEFAULT '0',
  `endtime` int(11) unsigned NOT NULL DEFAULT '0',
  `urltype` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `shortcut` int(10) unsigned NOT NULL DEFAULT '0',
  `shortcut_mode` int(10) unsigned NOT NULL DEFAULT '0',
  `no_cache` int(10) unsigned NOT NULL DEFAULT '0',
  `fe_group` varchar(199) NOT NULL DEFAULT '0',
  `subtitle` text NOT NULL,
  `layout` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `target` varchar(159) NOT NULL DEFAULT '',
  `media` text,
  `lastUpdated` int(10) unsigned NOT NULL DEFAULT '0',
  `keywords` text,
  `cache_timeout` int(10) unsigned NOT NULL DEFAULT '0',
  `newUntil` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text,
  `no_search` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `SYS_LASTCHANGED` int(10) unsigned NOT NULL DEFAULT '0',
  `abstract` text,
  `module` varchar(20) NOT NULL DEFAULT '',
  `extendToSubpages` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `author` text NOT NULL,
  `author_email` varchar(159) NOT NULL DEFAULT '',
  `nav_title` text NOT NULL,
  `nav_hide` tinyint(4) NOT NULL DEFAULT '0',
  `content_from_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `mount_pid` int(10) unsigned NOT NULL DEFAULT '0',
  `mount_pid_ol` tinyint(4) NOT NULL DEFAULT '0',
  `alias` varchar(64) NOT NULL DEFAULT '',
  `l18n_cfg` tinyint(4) NOT NULL DEFAULT '0',
  `fe_login_mode` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `parent` (`pid`,`sorting`,`deleted`,`hidden`),
  KEY `alias` (`alias`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Daten für Tabelle `pages`
--

INSERT INTO `pages` (`uid`, `pid`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3ver_swapmode`, `t3ver_move_id`, `t3_origuid`, `tstamp`, `sorting`, `deleted`, `perms_userid`, `perms_groupid`, `perms_user`, `perms_group`, `perms_everybody`, `editlock`, `crdate`, `cruser_id`, `hidden`, `title`, `doktype`, `TSconfig`, `storage_pid`, `is_siteroot`, `php_tree_stop`, `tx_impexp_origuid`, `url`, `starttime`, `endtime`, `urltype`, `shortcut`, `shortcut_mode`, `no_cache`, `fe_group`, `subtitle`, `layout`, `target`, `media`, `lastUpdated`, `keywords`, `cache_timeout`, `newUntil`, `description`, `no_search`, `SYS_LASTCHANGED`, `abstract`, `module`, `extendToSubpages`, `author`, `author_email`, `nav_title`, `nav_hide`, `content_from_pid`, `mount_pid`, `mount_pid_ol`, `alias`, `l18n_cfg`, `fe_login_mode`) VALUES
(1, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281605089, 256, 0, 1, 0, 31, 27, 0, 0, 1281434347, 1, 0, 'home', 1, '', 0, 1, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281605089, 'This is the home screen of testing environment - isn''t it beautiful?', '', 0, '', '', '', 0, 0, 0, 0, '', 0, 0),
(2, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281610984, 256, 0, 1, 0, 31, 27, 0, 0, 1281434636, 1, 0, 'testing list', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281610984, 'Test the list action and all its configurations', '', 0, '', '', '', 0, 0, 0, 0, 'action-list', 0, 0),
(3, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281610153, 128, 0, 1, 0, 31, 27, 0, 0, 1281518459, 1, 0, 'data', 254, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 0, '', '', 0, '', '', '', 0, 0, 0, 0, 'data', 0, 0),
(4, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281605466, 256, 0, 1, 0, 31, 27, 0, 0, 1281604261, 1, 0, 'includeStartedEvents', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281605466, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-includestartedevents', 0, 0),
(5, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281605485, 512, 0, 1, 0, 31, 27, 0, 0, 1281604281, 1, 0, 'excludeOverlongEvents', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281605485, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-excludeoverlong', 0, 0),
(6, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281606953, 128, 0, 1, 0, 31, 27, 0, 0, 1281606937, 1, 0, 'startDate', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281606953, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-startdate', 0, 0),
(7, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281606947, 192, 0, 1, 0, 31, 27, 0, 0, 1281606947, 1, 0, 'endDate', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281606947, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-enddate', 0, 0),
(8, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281606995, 224, 0, 1, 0, 31, 27, 0, 0, 1281606995, 1, 0, 'maxEvents', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281606995, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-maxevents', 0, 0),
(9, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281607019, 240, 0, 1, 0, 31, 27, 0, 0, 1281607019, 1, 0, 'orderBy', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281607019, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-orderby', 0, 0),
(10, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281607028, 248, 0, 1, 0, 31, 27, 0, 0, 1281607028, 1, 0, 'order', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281607028, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-order', 0, 0),
(11, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281607045, 252, 0, 1, 0, 31, 27, 0, 0, 1281607045, 1, 0, 'filterCategories', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281607045, '', '', 0, '', '', '', 0, 0, 0, 0, 'action-list-filtercategories', 0, 0),
(12, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 1281628721, 512, 0, 1, 0, 31, 27, 0, 0, 1281610955, 1, 0, 'testing minimonth', 1, '', 0, 0, 0, 0, '', 0, 0, 1, 0, 0, 0, '', '', 0, '', '', 0, '', 0, 0, '', 0, 1281628721, 'Test the minimonth view', '', 0, '', '', '', 0, 0, 0, 0, 'action-minimonth', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tt_content`
--

CREATE TABLE IF NOT EXISTS `tt_content` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` text NOT NULL,
  `t3ver_state` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_stage` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3ver_move_id` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `tstamp` int(11) unsigned NOT NULL DEFAULT '0',
  `crdate` int(11) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(11) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `sorting` int(11) unsigned NOT NULL DEFAULT '0',
  `CType` varchar(60) NOT NULL DEFAULT '',
  `header` text NOT NULL,
  `header_position` varchar(12) NOT NULL DEFAULT '',
  `bodytext` mediumtext,
  `image` text,
  `imagewidth` mediumint(11) unsigned NOT NULL DEFAULT '0',
  `imageorient` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `imagecaption` text,
  `imagecols` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `imageborder` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `media` text,
  `layout` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `cols` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `records` text,
  `pages` text,
  `starttime` int(11) unsigned NOT NULL DEFAULT '0',
  `endtime` int(11) unsigned NOT NULL DEFAULT '0',
  `colPos` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `subheader` text NOT NULL,
  `spaceBefore` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `spaceAfter` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `fe_group` varchar(199) NOT NULL DEFAULT '0',
  `header_link` text NOT NULL,
  `imagecaption_position` varchar(12) NOT NULL DEFAULT '',
  `image_link` text NOT NULL,
  `image_zoom` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `image_noRows` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `image_effects` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `image_compression` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `altText` text,
  `titleText` text,
  `longdescURL` text,
  `header_layout` varchar(60) NOT NULL DEFAULT '0',
  `text_align` varchar(12) NOT NULL DEFAULT '',
  `text_face` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `text_size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `text_color` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `text_properties` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `menu_type` varchar(60) NOT NULL DEFAULT '0',
  `list_type` varchar(72) NOT NULL DEFAULT '0',
  `table_border` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `table_cellspacing` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `table_cellpadding` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `table_bgColor` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `select_key` varchar(159) NOT NULL DEFAULT '',
  `sectionIndex` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `linkToTop` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `filelink_size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `section_frame` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `splash_layout` varchar(60) NOT NULL DEFAULT '0',
  `multimedia` text,
  `image_frames` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recursive` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `imageheight` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rte_enabled` tinyint(4) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `tx_impexp_origuid` int(11) NOT NULL DEFAULT '0',
  `pi_flexform` mediumtext,
  `l18n_parent` int(11) NOT NULL DEFAULT '0',
  `l18n_diffsource` mediumblob,
  PRIMARY KEY (`uid`),
  KEY `t3ver_oid` (`t3ver_oid`,`t3ver_wsid`),
  KEY `parent` (`pid`,`sorting`),
  KEY `language` (`l18n_parent`,`sys_language_uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `tt_content`
--

INSERT INTO `tt_content` (`uid`, `pid`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3ver_move_id`, `t3_origuid`, `tstamp`, `crdate`, `cruser_id`, `hidden`, `sorting`, `CType`, `header`, `header_position`, `bodytext`, `image`, `imagewidth`, `imageorient`, `imagecaption`, `imagecols`, `imageborder`, `media`, `layout`, `deleted`, `cols`, `records`, `pages`, `starttime`, `endtime`, `colPos`, `subheader`, `spaceBefore`, `spaceAfter`, `fe_group`, `header_link`, `imagecaption_position`, `image_link`, `image_zoom`, `image_noRows`, `image_effects`, `image_compression`, `altText`, `titleText`, `longdescURL`, `header_layout`, `text_align`, `text_face`, `text_size`, `text_color`, `text_properties`, `menu_type`, `list_type`, `table_border`, `table_cellspacing`, `table_cellpadding`, `table_bgColor`, `select_key`, `sectionIndex`, `linkToTop`, `filelink_size`, `section_frame`, `date`, `splash_layout`, `multimedia`, `image_frames`, `recursive`, `imageheight`, `rte_enabled`, `sys_language_uid`, `tx_impexp_origuid`, `pi_flexform`, `l18n_parent`, `l18n_diffsource`) VALUES
(1, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1281605092, 1281434462, 1, 1, 1000000000, 'text', 'Home', '', 'This is the home screen of testing environment - isn''t it beautiful?', NULL, 0, 0, NULL, 1, 0, NULL, 0, 1, 0, NULL, NULL, 0, 0, 0, '', 0, 0, '', '', '', '', 0, 0, 0, 0, NULL, NULL, NULL, '0', '', 0, 0, 0, 0, '0', '', 0, 0, 0, 0, '', 1, 0, 0, 0, 0, '0', NULL, 0, 0, 0, 0, 0, 0, NULL, 0, 0x613a313a7b733a363a2268696464656e223b4e3b7d),
(2, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1281605094, 1281434553, 1, 1, 1000000000, 'menu', '', '', NULL, NULL, 0, 0, NULL, 1, 0, NULL, 0, 1, 0, NULL, '', 0, 0, 0, '', 0, 0, '', '', '', '', 0, 0, 0, 0, NULL, NULL, NULL, '0', '', 0, 0, 0, 0, '4', '', 0, 0, 0, 0, '', 1, 0, 0, 0, 0, '0', NULL, 0, 0, 0, 0, 0, 0, NULL, 0, 0x613a313a7b733a363a2268696464656e223b4e3b7d),
(3, 2, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 1281604837, 1281435275, 1, 0, 1000000000, 'list', 'Calendar', '', NULL, NULL, 0, 0, NULL, 1, 0, NULL, 0, 1, 0, NULL, '3,2', 0, 0, 0, '', 0, 0, '', '', '', '', 0, 0, 0, 0, NULL, NULL, NULL, '0', '', 0, 0, 0, 0, '0', 'czsimplecal_pi1', 0, 0, 0, 0, '', 1, 0, 0, 0, 0, '0', NULL, 0, 0, 0, 0, 0, 0, '<?xml version="1.0" encoding="utf-8" standalone="yes" ?>\n<T3FlexForms>\n    <data>\n        <sheet index="sDEF">\n            <language index="lDEF">\n                <field index="settings.override.allowedActions">\n                    <value index="vDEF"></value>\n                </field>\n                <field index="settings.override.action.filterCategories">\n                    <value index="vDEF"></value>\n                </field>\n                <field index="settings.override.action.startDate">\n                    <value index="vDEF">0</value>\n                </field>\n                <field index="settings.override.action.endDate">\n                    <value index="vDEF">0</value>\n                </field>\n                <field index="settings.override.action.maxEvents">\n                    <value index="vDEF">0</value>\n                </field>\n                <field index="settings.override.action.orderBy">\n                    <value index="vDEF">0</value>\n                </field>\n                <field index="settings.override.action.order">\n                    <value index="vDEF">0</value>\n                </field>\n            </language>\n        </sheet>\n    </data>\n</T3FlexForms>', 0, 0x613a32313a7b733a353a224354797065223b4e3b733a31363a227379735f6c616e67756167655f756964223b4e3b733a363a22636f6c506f73223b4e3b733a31313a2273706163654265666f7265223b4e3b733a31303a2273706163654166746572223b4e3b733a31333a2273656374696f6e5f6672616d65223b4e3b733a31323a2273656374696f6e496e646578223b4e3b733a363a2268696464656e223b4e3b733a363a22686561646572223b4e3b733a31353a226865616465725f706f736974696f6e223b4e3b733a31333a226865616465725f6c61796f7574223b4e3b733a31313a226865616465725f6c696e6b223b4e3b733a343a2264617465223b4e3b733a393a226c696e6b546f546f70223b4e3b733a393a226c6973745f74797065223b4e3b733a31313a2270695f666c6578666f726d223b4e3b733a353a227061676573223b4e3b733a393a22726563757273697665223b4e3b733a393a22737461727474696d65223b4e3b733a373a22656e6474696d65223b4e3b733a383a2266655f67726f7570223b4e3b7d);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tx_czsimplecal_domain_model_event`
--

CREATE TABLE IF NOT EXISTS `tx_czsimplecal_domain_model_event` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `start_day` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT '-1',
  `end_day` int(11) DEFAULT '-1',
  `end_time` int(11) DEFAULT '-1',
  `timezone` varchar(40) DEFAULT 'GMT',
  `teaser` text,
  `description` text,
  `recurrance_type` varchar(60) DEFAULT 'none',
  `recurrance_until` int(11) DEFAULT '-1',
  `recurrance_times` int(11) DEFAULT '0',
  `location_name` text,
  `organizer_name` text,
  `category` int(11) unsigned NOT NULL DEFAULT '0',
  `exceptions` int(11) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(11) unsigned NOT NULL DEFAULT '0',
  `crdate` int(11) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `t3ver_oid` int(11) NOT NULL DEFAULT '0',
  `t3ver_id` int(11) NOT NULL DEFAULT '0',
  `t3ver_wsid` int(11) NOT NULL DEFAULT '0',
  `t3ver_label` varchar(60) NOT NULL DEFAULT '',
  `t3ver_state` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_stage` tinyint(4) NOT NULL DEFAULT '0',
  `t3ver_count` int(11) NOT NULL DEFAULT '0',
  `t3ver_tstamp` int(11) NOT NULL DEFAULT '0',
  `t3_origuid` int(11) NOT NULL DEFAULT '0',
  `sys_language_uid` int(11) NOT NULL DEFAULT '0',
  `l18n_parent` int(11) NOT NULL DEFAULT '0',
  `l18n_diffsource` mediumblob NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Daten für Tabelle `tx_czsimplecal_domain_model_event`
--

INSERT INTO `tx_czsimplecal_domain_model_event` (`uid`, `pid`, `title`, `start_day`, `start_time`, `end_day`, `end_time`, `timezone`, `teaser`, `description`, `recurrance_type`, `recurrance_until`, `recurrance_times`, `location_name`, `organizer_name`, `category`, `exceptions`, `tstamp`, `crdate`, `deleted`, `hidden`, `t3ver_oid`, `t3ver_id`, `t3ver_wsid`, `t3ver_label`, `t3ver_state`, `t3ver_stage`, `t3ver_count`, `t3ver_tstamp`, `t3_origuid`, `sys_language_uid`, `l18n_parent`, `l18n_diffsource`) VALUES
(1, 3, 'Bongo Day', 1262559600, -1, -1, -1, 'CEST', 'Every monday taking out the bongo and playing along.', 'This is an allday-event.', 'weekly', -1, 0, '', '', 0, 0, 1281518483, 1281435382, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31333a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b7d),
(2, 3, 'Playing Golf', 1262732400, 57600, -1, -1, 'CEST', 'Just to relax.', 'This is an event with a start, but no end-time.', 'weekly', -1, 0, '', '', 1, 0, 1281610411, 1281436356, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31333a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b7d),
(3, 3, 'Jogging with friends', 1262559600, 64800, -1, 70200, 'CEST', '', 'This is an event with start and end time.', 'weekly', -1, 0, '', '', 1, 0, 1281610391, 1281436448, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31333a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b7d),
(4, 3, 'Going fishing', 1262300400, 68400, 1262386800, 36000, 'CEST', '', 'end day on a different date', 'weekly', -1, 0, '', '', 0, 0, 1281518475, 1281436530, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31333a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b7d),
(5, 3, 'Hidden Event', 1262559600, 43200, -1, 50400, 'CEST', 'This event should never be displayed.', '', 'weekly', -1, 0, '', '', 0, 0, 1281518491, 1281436900, 0, 1, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a313a7b733a363a2268696464656e223b4e3b7d),
(6, 3, 'Deleted event', 1262300400, -1, -1, -1, 'CEST', 'This event was deleted and should therefore not be displayed.', '', 'weekly', -1, 0, '', '', 0, 0, 1281707756, 1281437020, 1, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31333a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b7d),
(7, 3, 'overlong event', 1262386800, -1, 1262905200, -1, 'CEST', 'A very long event that ends after the list ends', '', 'weekly', -1, 0, '', '', 0, 0, 1281704436, 1281518256, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31333a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b7d),
(8, 3, 'already started event', 1262214000, 68400, 1262300400, 50400, 'CEST', '', 'New Years Eve at Kasper''s.', 'none', -1, 0, '', '', 0, 0, 1281604831, 1281518581, 0, 0, 0, 0, 0, '', 0, 0, 0, 0, 0, 0, 0, 0x613a31343a7b733a353a227469746c65223b4e3b733a393a2273746172745f646179223b4e3b733a31303a2273746172745f74696d65223b4e3b733a373a22656e645f646179223b4e3b733a383a22656e645f74696d65223b4e3b733a383a2263617465676f7279223b4e3b733a363a22746561736572223b4e3b733a31313a226465736372697074696f6e223b4e3b733a31353a22726563757272616e63655f74797065223b4e3b733a31363a22726563757272616e63655f756e74696c223b4e3b733a31303a22657863657074696f6e73223b4e3b733a31333a226c6f636174696f6e5f6e616d65223b4e3b733a31343a226f7267616e697a65725f6e616d65223b4e3b733a31363a227379735f6c616e67756167655f756964223b4e3b7d);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tx_czsimplecal_domain_model_exception`
--

CREATE TABLE IF NOT EXISTS `tx_czsimplecal_domain_model_exception` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `day` int(11) DEFAULT NULL,
  `timezone` varchar(40) DEFAULT 'GMT',
  `recurrance_type` varchar(60) DEFAULT 'none',
  `recurrance_until` int(11) DEFAULT '-1',
  `recurrance_times` int(11) DEFAULT '0',
  `deleted` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tx_czsimplecal_domain_model_exception`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tx_czsimplecal_domain_model_exceptiongroup`
--

CREATE TABLE IF NOT EXISTS `tx_czsimplecal_domain_model_exceptiongroup` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `title` text,
  `exceptions` int(11) unsigned NOT NULL DEFAULT '0',
  `deleted` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tx_czsimplecal_domain_model_exceptiongroup`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tx_czsimplecal_event_category_mm`
--

CREATE TABLE IF NOT EXISTS `tx_czsimplecal_event_category_mm` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `uid_local` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int(11) unsigned NOT NULL DEFAULT '0',
  `tablenames` text NOT NULL,
  `sorting` int(11) unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int(11) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `tx_czsimplecal_event_category_mm`
--

INSERT INTO `tx_czsimplecal_event_category_mm` (`uid`, `pid`, `uid_local`, `uid_foreign`, `tablenames`, `sorting`, `sorting_foreign`, `tstamp`, `crdate`, `hidden`) VALUES
(1, 0, 3, 1, '', 1, 0, 0, 0, 0),
(2, 0, 2, 1, '', 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tx_czsimplecal_event_exception_mm`
--

CREATE TABLE IF NOT EXISTS `tx_czsimplecal_event_exception_mm` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `uid_local` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int(11) unsigned NOT NULL DEFAULT '0',
  `tablenames` text NOT NULL,
  `sorting` int(11) unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int(11) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tx_czsimplecal_event_exception_mm`
--


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tx_czsimplecal_exceptiongroup_exception_mm`
--

CREATE TABLE IF NOT EXISTS `tx_czsimplecal_exceptiongroup_exception_mm` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `uid_local` int(11) unsigned NOT NULL DEFAULT '0',
  `uid_foreign` int(11) unsigned NOT NULL DEFAULT '0',
  `tablenames` text NOT NULL,
  `sorting` int(11) unsigned NOT NULL DEFAULT '0',
  `sorting_foreign` int(11) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(10) unsigned NOT NULL DEFAULT '0',
  `crdate` int(10) unsigned NOT NULL DEFAULT '0',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Daten für Tabelle `tx_czsimplecal_exceptiongroup_exception_mm`
--

