-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-01-06 11:33:36
-- 服务器版本： 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- 表的结构 `sys_admin`
--
DROP TABLE IF EXISTS `sys_admin`;
CREATE TABLE `sys_admin` (
  `id` tinyint(3) NOT NULL COMMENT 'ID',
  `uname` varchar(16) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `tel` varchar(11) NOT NULL DEFAULT '' COMMENT '电话',
  `name` varchar(12) NOT NULL DEFAULT '' COMMENT '姓名',
  `department` varchar(12) NOT NULL DEFAULT '' COMMENT '部门',
  `position` varchar(12) NOT NULL DEFAULT '' COMMENT '职称',
  `rtime` datetime DEFAULT NULL COMMENT '注册时间',
  `state` enum('1','2') NOT NULL DEFAULT '1' COMMENT '状态(1正常,2禁用)',
  `perm` text COMMENT '权限'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sys_admin`
--

INSERT INTO `sys_admin` (`id`, `uname`, `password`, `email`, `tel`, `name`, `department`, `position`, `rtime`, `state`, `perm`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'klingsoul@163.com', '15088885555', 'WebMIS', '项目中心', '管理员', '2017-05-10 00:00:00', '1', '1:0 2:0 10:0 3:0 4:0 5:0 6:31 7:31 8:63');

-- --------------------------------------------------------

--
-- 表的结构 `sys_menus`
--
DROP TABLE IF EXISTS `sys_menus`;
CREATE TABLE `sys_menus` (
  `id` tinyint(3) NOT NULL COMMENT 'ID',
  `fid` tinyint(3) NOT NULL COMMENT '父ID',
  `title` varchar(12) NOT NULL COMMENT '标题',
  `url` varchar(32) NOT NULL DEFAULT '' COMMENT '地址',
  `perm` varchar(6) NOT NULL DEFAULT '' COMMENT '预设权限',
  `ico` varchar(16) NOT NULL DEFAULT '' COMMENT '图标',
  `ctime` datetime DEFAULT NULL COMMENT '创建时间',
  `sort` tinyint(3) NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(32) NOT NULL DEFAULT '' COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sys_menus`
--

INSERT INTO `sys_menus` (`id`, `fid`, `title`, `url`, `perm`, `ico`, `ctime`, `sort`, `remark`) VALUES
(1, 0, '首页', 'Welcome', '0', 'ico-home', '2017-05-12 00:00:00', 0, ''),
(2, 0, '系统', 'System', '0', 'ico-system', '2017-05-12 00:00:00', 0, ''),
(3, 1, '桌面', '#', '0', 'ico-disktop', '2017-05-12 00:00:00', 0, ''),
(4, 2, '系统管理', '#', '0', 'ico-system1', '2017-05-12 00:00:00', 0, ''),
(5, 3, '用户首页', 'Desktop', '0', 'ico-user', '2017-05-12 00:00:00', 0, ''),
(6, 4, '菜单管理', 'SysMenus', '31', 'ico-menu', '2017-05-12 00:00:00', 0, ''),
(7, 4, '菜单动作', 'SysMenusAction', '31', 'ico-menuA', '2017-05-12 00:00:00', 0, ''),
(8, 4, '系统用户', 'SysAdmins', '63', 'ico-pwd', '2017-05-12 00:00:00', 0, ''),
(9, 4, '系统配置', 'SysConfig', '0', 'ico-system2', '2017-05-12 00:00:00', 0, ''),
(10, 0, '网站', 'Web', '0', 'ico-web', NULL, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `sys_menus_action`
--
DROP TABLE IF EXISTS `sys_menus_action`;
CREATE TABLE `sys_menus_action` (
  `id` int(2) NOT NULL COMMENT 'ID',
  `name` varchar(32) NOT NULL COMMENT 'Name',
  `perm` enum('1','2','4','8','16','32','64','128','256','512','1024','2048') NOT NULL COMMENT 'Authority',
  `ico` varchar(24) DEFAULT NULL COMMENT 'ICON'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sys_menus_action`
--

INSERT INTO `sys_menus_action` (`id`, `name`, `perm`, `ico`) VALUES
(1, '列表', '1', 'ico-list'),
(2, '搜索', '2', 'ico-search'),
(3, '添加', '4', 'ico-add'),
(4, '编辑', '8', 'ico-edit'),
(5, '删除', '16', 'ico-del'),
(6, '审核', '32', 'ico-audit'),
(7, '导出', '64', 'ico-exp'),
(8, '导入', '128', 'ico-imp'),
(9, '图表', '256', 'ico-chart');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sys_admin`
--
ALTER TABLE `sys_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_menus`
--
ALTER TABLE `sys_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_menus_action`
--
ALTER TABLE `sys_menus_action`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `sys_admin`
--
ALTER TABLE `sys_admin`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `sys_menus`
--
ALTER TABLE `sys_menus`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `sys_menus_action`
--
ALTER TABLE `sys_menus_action`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
