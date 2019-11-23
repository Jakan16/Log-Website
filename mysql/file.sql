-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2019 at 05:03 PM
-- Server version: 10.1.41-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MaincoreDBdev5`
--

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBadmin_info`
--

CREATE TABLE `ReplaceDBadmin_info` (
  `id` int(11) NOT NULL,
  `titel` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBcore_groups`
--

CREATE TABLE `ReplaceDBcore_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `rules` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBcore_groups`
--

INSERT INTO `ReplaceDBcore_groups` (`id`, `name`, `description`, `rules`) VALUES
(0, 'Not in a group', 'The user is not in any group', ''),
(1, 'admin', 'Adminstrators of the site', '');

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBcore_rules`
--

CREATE TABLE `ReplaceDBcore_rules` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBcore_rules`
--

INSERT INTO `ReplaceDBcore_rules` (`id`, `name`, `description`) VALUES
(0, 'allow_any', 'This is a rule for a visitor, the visitor does not have to login '),
(1, 'Master Control Access', 'Have access to enter and modify options in the master control'),
(2, 'user_control_panel', 'Gain access to the user controlpanel'),
(3, 'Allow upload', 'The user can upload files '),
(4, 'Modify uploads', 'The user have the permission to modify/delete uploaded files '),
(5, 'Site editor', 'The user have the rights to use the site editor');

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBcountry`
--

CREATE TABLE `ReplaceDBcountry` (
  `countryID` int(8) NOT NULL,
  `name` varchar(16) NOT NULL DEFAULT '',
  `code` varchar(4) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBcountry`
--

INSERT INTO `ReplaceDBcountry` (`countryID`, `name`, `code`, `active`) VALUES
(1, 'denmark', 'DK', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBimages`
--

CREATE TABLE `ReplaceDBimages` (
  `id` int(11) NOT NULL,
  `img_text` text NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `dir` varchar(128) NOT NULL DEFAULT '',
  `uploaded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_profile_img` int(11) NOT NULL DEFAULT '0',
  `show_order` int(11) NOT NULL DEFAULT '0',
  `attached_group` varchar(64) NOT NULL DEFAULT '',
  `attached_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBimages`
--

INSERT INTO `ReplaceDBimages` (`id`, `img_text`, `user_id`, `dir`, `uploaded`, `is_profile_img`, `show_order`, `attached_group`, `attached_id`) VALUES
(1, '', 0, '', '0000-00-00 00:00:00', 0, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBinstalled_plugins`
--

CREATE TABLE `ReplaceDBinstalled_plugins` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `version` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBnavi`
--

CREATE TABLE `ReplaceDBnavi` (
  `id` int(11) NOT NULL,
  `link` varchar(40) NOT NULL DEFAULT '',
  `required` int(11) NOT NULL DEFAULT '0',
  `navi_order` int(11) NOT NULL DEFAULT '0',
  `permission` int(11) NOT NULL DEFAULT '0',
  `place` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBnavi`
--

INSERT INTO `ReplaceDBnavi` (`id`, `link`, `required`, `navi_order`, `permission`, `place`) VALUES
(1, 'index', 1, 1, 0, 'standart'),
(3, 'kontakt', 0, 6, 0, 'standart'),
(4, 'control/index', 1, 1, 2, 'controlpanel'),
(5, 'control/user_control', 1, 2, 2, 'controlpanel'),
(6, 'control/master_control', 1, 3, 1, 'controlpanel'),
(13, 'NewPage', 0, 5, 1, 'standart');

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBnavi_name`
--

CREATE TABLE `ReplaceDBnavi_name` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `language` varchar(8) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBnavi_name`
--

INSERT INTO `ReplaceDBnavi_name` (`id`, `name`, `language`, `parent_id`) VALUES
(1, 'Forside', 'DK', 1),
(3, 'Kontakt', 'DK', 3),
(4, 'Min side', 'DK', 4),
(5, 'Mine instillinger', 'DK', 5),
(6, 'Master control', 'DK', 6),
(13, 'NewPage', 'DK', 13);

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBplugs_group`
--

CREATE TABLE `ReplaceDBplugs_group` (
  `id` int(11) NOT NULL,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `rules` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBplugs_permissions`
--

CREATE TABLE `ReplaceDBplugs_permissions` (
  `plugin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `permission_list` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBplugs_rule`
--

CREATE TABLE `ReplaceDBplugs_rule` (
  `id` int(11) NOT NULL,
  `plugin_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL DEFAULT '',
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBpost`
--

CREATE TABLE `ReplaceDBpost` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `text` mediumtext NOT NULL,
  `thumbnail` varchar(256) NOT NULL DEFAULT '',
  `link` varchar(64) NOT NULL DEFAULT '',
  `category` varchar(32) NOT NULL DEFAULT '',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `language` varchar(16) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT '0',
  `orders` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBtext`
--

CREATE TABLE `ReplaceDBtext` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `text` longtext NOT NULL,
  `language` varchar(8) NOT NULL DEFAULT '',
  `content_group` varchar(64) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `required` int(11) NOT NULL DEFAULT '0',
  `bgimg` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBtext`
--

INSERT INTO `ReplaceDBtext` (`id`, `description`, `text`, `language`, `content_group`, `parent_id`, `required`, `bgimg`) VALUES
(2, '', '<p>Standart forside</p>\n\n<p>&nbsp;</p>\n\n<p>Dette er version rt5.0.0a0</p>\n', 'DK', 'page', 1, 1, ''),
(3, '', '<p>Kontakt:</p>\r\n\r\n<p>mail: kontakt@guld-berg.dk</p>\r\n', 'DK', 'page', 3, 0, ''),
(11, '', 'NewPage', 'DK', 'page', 13, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBusers`
--

CREATE TABLE `ReplaceDBusers` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL DEFAULT '',
  `username_clean` varchar(40) NOT NULL DEFAULT '',
  `mail` varchar(64) NOT NULL DEFAULT '',
  `mobile` varchar(16) NOT NULL DEFAULT '',
  `permission_group_id` int(11) NOT NULL DEFAULT '0',
  `permission_list` text NOT NULL,
  `password` varchar(128) NOT NULL DEFAULT '',
  `active` int(11) NOT NULL DEFAULT '0',
  `recoverycode` varchar(16) NOT NULL DEFAULT '',
  `recoverytime` varchar(16) NOT NULL DEFAULT '',
  `permissions_reload` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBusers`
--

INSERT INTO `ReplaceDBusers` (`id`, `username`, `username_clean`, `mail`, `mobile`, `permission_group_id`, `permission_list`, `password`, `active`, `recoverycode`, `recoverytime`, `permissions_reload`) VALUES
(2, 'Sandsized_admin', 'sandsized_admin', 'contact@sandsized.com', '', 0, 'a:1:{i:0;i:1;}', 'eccbbb9d8d23af67ae68c9ef2919a356884365473ee6dbfa0778a7b798902173', 1, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ReplaceDBuser_info`
--

CREATE TABLE `ReplaceDBuser_info` (
  `id` int(11) NOT NULL,
  `firstname` varchar(64) NOT NULL DEFAULT '',
  `lastname` varchar(64) NOT NULL DEFAULT '',
  `profile_text` text NOT NULL,
  `profile_img` varchar(128) NOT NULL DEFAULT '',
  `hidden` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ReplaceDBuser_info`
--

INSERT INTO `ReplaceDBuser_info` (`id`, `firstname`, `lastname`, `profile_text`, `profile_img`, `hidden`) VALUES
(2, '', '', '', '/design/default-profile.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ReplaceDBadmin_info`
--
ALTER TABLE `ReplaceDBadmin_info`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBcore_groups`
--
ALTER TABLE `ReplaceDBcore_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBcore_rules`
--
ALTER TABLE `ReplaceDBcore_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBcountry`
--
ALTER TABLE `ReplaceDBcountry`
  ADD PRIMARY KEY (`countryID`),
  ADD UNIQUE KEY `countryID` (`countryID`);

--
-- Indexes for table `ReplaceDBimages`
--
ALTER TABLE `ReplaceDBimages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBinstalled_plugins`
--
ALTER TABLE `ReplaceDBinstalled_plugins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBnavi`
--
ALTER TABLE `ReplaceDBnavi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `link` (`link`);

--
-- Indexes for table `ReplaceDBnavi_name`
--
ALTER TABLE `ReplaceDBnavi_name`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBplugs_group`
--
ALTER TABLE `ReplaceDBplugs_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBplugs_permissions`
--
ALTER TABLE `ReplaceDBplugs_permissions`
  ADD PRIMARY KEY (`plugin_id`,`user_id`);

--
-- Indexes for table `ReplaceDBplugs_rule`
--
ALTER TABLE `ReplaceDBplugs_rule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBpost`
--
ALTER TABLE `ReplaceDBpost`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ReplaceDBtext`
--
ALTER TABLE `ReplaceDBtext`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_name` (`id`);

--
-- Indexes for table `ReplaceDBusers`
--
ALTER TABLE `ReplaceDBusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `ReplaceDBuser_info`
--
ALTER TABLE `ReplaceDBuser_info`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ReplaceDBcore_groups`
--
ALTER TABLE `ReplaceDBcore_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ReplaceDBcore_rules`
--
ALTER TABLE `ReplaceDBcore_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ReplaceDBcountry`
--
ALTER TABLE `ReplaceDBcountry`
  MODIFY `countryID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ReplaceDBimages`
--
ALTER TABLE `ReplaceDBimages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ReplaceDBinstalled_plugins`
--
ALTER TABLE `ReplaceDBinstalled_plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReplaceDBnavi`
--
ALTER TABLE `ReplaceDBnavi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ReplaceDBnavi_name`
--
ALTER TABLE `ReplaceDBnavi_name`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `ReplaceDBplugs_group`
--
ALTER TABLE `ReplaceDBplugs_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReplaceDBplugs_rule`
--
ALTER TABLE `ReplaceDBplugs_rule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReplaceDBpost`
--
ALTER TABLE `ReplaceDBpost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReplaceDBtext`
--
ALTER TABLE `ReplaceDBtext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `ReplaceDBusers`
--
ALTER TABLE `ReplaceDBusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
