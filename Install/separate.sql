DROP TABLE IF EXISTS `bqyj_gonggao`;
CREATE TABLE IF NOT EXISTS `bqyj_gonggao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `con` varchar(1000) DEFAULT NULL,
  `addtime` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
 DROP TABLE IF EXISTS `bqyj_link`;
CREATE TABLE IF NOT EXISTS `bqyj_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qq` varchar(1000) DEFAULT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `link` varchar(1000) DEFAULT NULL,
  `addtime` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_qds`;
CREATE TABLE IF NOT EXISTS `bqyj_qds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `lx` int(11) DEFAULT NULL COMMENT '1',
  `adddate` date DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_chat`;
CREATE TABLE `bqyj_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` text,
  `user` text,
  `info` text,
  `time` text,
  `qid` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_kms`;
CREATE TABLE `bqyj_kms` (
  `kid` int(11) NOT NULL AUTO_INCREMENT,
  `kind` tinyint(1) NOT NULL DEFAULT '0',
  `daili` int(11) NOT NULL DEFAULT '0',
  `km` varchar(50) NOT NULL,
  `ms` int(2) NOT NULL DEFAULT '1',
  `isuse` tinyint(1) DEFAULT '0',
  `uid` int(11) DEFAULT NULL,
  `usetime` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`kid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_reg`;
CREATE TABLE IF NOT EXISTS `bqyj_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `reguid` int(11) NOT NULL,
  `regip` varchar(32) NOT NULL,
  `addtime` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_qqs`;
CREATE TABLE `bqyj_qqs` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `qq` decimal(10,0) NOT NULL,
  `pwd` varchar(80) DEFAULT NULL,
  `sid` varchar(80) NOT NULL,
  `skey` varchar(20) NOT NULL,
  `sidzt` tinyint(1) DEFAULT '0',
  `skeyzt` tinyint(1) DEFAULT '0',
  `ptsig` varchar(50) NOT NULL,
  `p_skey` varchar(50) NOT NULL,
  `pookie` varchar(1000) NOT NULL,
  `p_skey2` varchar(50) NOT NULL,
  `cookie` varchar(1000) NOT NULL,
  `istx` tinyint(1) DEFAULT '0',
  `lasttx` datetime DEFAULT NULL,
  `nexttx` datetime DEFAULT NULL,
  `ispf` tinyint(1) DEFAULT '0',
  `lastpf` datetime DEFAULT NULL,
  `nextpf` datetime DEFAULT NULL,
  `isqipao` tinyint(1) DEFAULT '0',
  `lastqipao` datetime DEFAULT NULL,
  `nextqipao` datetime DEFAULT NULL,
  `iszan` tinyint(1) DEFAULT '0',
  `zanrate` int(3) DEFAULT '60',
  `zannet` tinyint(1) DEFAULT '0',
  `lastzan` datetime DEFAULT NULL,
  `nextzan` datetime DEFAULT NULL,
  `istype` tinyint(1) DEFAULT '0',
  `zanlist` text,
  `isreply` tinyint(1) DEFAULT '0',
  `replycon` varchar(1000) DEFAULT NULL,
  `replypic` varchar(1000) DEFAULT NULL,
  `replyrate` int(3) DEFAULT '60',
  `replynet` tinyint(1) DEFAULT '0',
  `lastreply` datetime DEFAULT NULL,
  `nextreply` datetime DEFAULT NULL,
  `isshuo` tinyint(1) DEFAULT '0',
  `shuotype` tinyint(1) DEFAULT '0',
  `shuorate` int(3) DEFAULT '5',
  `shuonet` tinyint(1) DEFAULT '0',
  `shuoshuo` text DEFAULT '',
  `shuogg` text DEFAULT '',
  `shuopic` text DEFAULT '',
  `lastshuo` datetime DEFAULT NULL,
  `nextshuo` datetime DEFAULT NULL,
  `isdel` tinyint(1) DEFAULT '0',
  `delnet` tinyint(1) DEFAULT '0',
  `lastdel` datetime DEFAULT NULL,
  `nextdel` datetime DEFAULT NULL,
  `isdell` tinyint(1) DEFAULT '0',
  `dellnet` tinyint(1) DEFAULT '0',
  `lastdell` datetime DEFAULT NULL,
  `nextdell` datetime DEFAULT NULL,
  `isqd` tinyint(1) DEFAULT NULL,
  `qdcon` varchar(1000) DEFAULT NULL,
  `qdnet` tinyint(1) DEFAULT '0',
  `lastqd` datetime DEFAULT NULL,
  `nextqd` datetime DEFAULT NULL,
  `isqzoneqd` tinyint(1) NOT NULL DEFAULT '0',
  `lastqzoneqd` datetime DEFAULT NULL,
  `nextqzoneqd` datetime DEFAULT NULL,
  `iswyqd` tinyint(1) NOT NULL DEFAULT '0',
  `lastwyqd` datetime DEFAULT NULL,
  `nextwyqd` datetime DEFAULT NULL,
  `isdldqd` tinyint(1) NOT NULL DEFAULT '0',
  `lastdldqd` datetime DEFAULT NULL,
  `nextdldqd` datetime DEFAULT NULL,
  `isqqd` tinyint(1) NOT NULL DEFAULT '0',
  `lastqqd` datetime DEFAULT NULL,
  `nextqqd` datetime DEFAULT NULL,
  `isblqd` tinyint(1) NOT NULL DEFAULT '0',
  `lastblqd` datetime DEFAULT NULL,
  `nextblqd` datetime DEFAULT NULL,
  `qunnum` text,
  `isqt` tinyint(1) NOT NULL DEFAULT '0',
  `lastqt` datetime DEFAULT NULL,
  `nextqt` datetime DEFAULT NULL,
  `isfw` tinyint(1) NOT NULL DEFAULT '0',
  `lastfw` datetime DEFAULT NULL,
  `nextfw` datetime DEFAULT NULL,
  `isvipqd` tinyint(1) NOT NULL DEFAULT '0',
  `lastvipqd` datetime DEFAULT NULL,
  `nextvipqd` datetime DEFAULT NULL,
  `iszf` tinyint(4) NOT NULL DEFAULT '0',
  `zfok` text,
  `zfcon` text,
  `zfrate` tinyint(1) NOT NULL DEFAULT '15',
  `zfnet` tinyint(1) NOT NULL DEFAULT '0',
  `lastzf` datetime DEFAULT NULL,
  `nextzf` datetime DEFAULT NULL,
  `isht` tinyint(1) NOT NULL DEFAULT '0',
  `lastht` datetime DEFAULT NULL,
  `nextht` datetime DEFAULT NULL,
  `isqb` tinyint(1) NOT NULL DEFAULT '0',
  `lastqb` datetime DEFAULT NULL,
  `nextqb` datetime DEFAULT NULL,
  `is3gqq` tinyint(1) NOT NULL DEFAULT '0',
  `last3gqq` datetime DEFAULT NULL,
  `next3gqq` datetime DEFAULT NULL,
  `nextauto` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `gxmsg` varchar(1000) DEFAULT NULL,
  `qqlevel` varchar(80) DEFAULT NULL,
  `adddate` date DEFAULT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_users`;
CREATE TABLE `bqyj_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `daili` tinyint(1) DEFAULT '0',
  `vip` tinyint(1) DEFAULT '0',
  `vipstart` date DEFAULT NULL,
  `vipend` date DEFAULT NULL,
  `rmb` int(5) DEFAULT '0',
  `peie` tinyint(2) DEFAULT '1',
  `pwd` varchar(40) NOT NULL,
  `sid` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `fuzhan` tinyint(1) DEFAULT '0',
  `login` tinyint(255) DEFAULT '1',
  `qq` varchar(255) DEFAULT '0',
  `city` varchar(50) DEFAULT NULL,
  `regip` varchar(50) DEFAULT NULL,
  `lastip` varchar(50) DEFAULT NULL,
  `regtime` datetime DEFAULT NULL,
  `lasttime` datetime DEFAULT NULL,
  `aqproblem` varchar(255) DEFAULT NULL,
  `aqanswer` varchar(255) DEFAULT NULL,
  `yq` int(3) DEFAULT '0',
  `adddate` date DEFAULT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_users`;
CREATE TABLE `bqyj_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `daili` tinyint(1) DEFAULT '0',
  `vip` tinyint(1) DEFAULT '0',
  `vipstart` date DEFAULT NULL,
  `vipend` date DEFAULT NULL,
  `rmb` int(5) DEFAULT '0',
  `peie` tinyint(2) DEFAULT '1',
  `pwd` varchar(40) NOT NULL,
  `sid` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  `player` tinyint(1) DEFAULT '0',
  `fuzhan` tinyint(1) DEFAULT '0',
  `login` tinyint(255) DEFAULT '1',
  `qq` varchar(255) DEFAULT '0',
  `city` varchar(50) DEFAULT NULL,
  `regip` varchar(50) DEFAULT NULL,
  `lastip` varchar(50) DEFAULT NULL,
  `regtime` datetime DEFAULT NULL,
  `lasttime` datetime DEFAULT NULL,
  `aqproblem` varchar(255) DEFAULT NULL,
  `aqanswer` varchar(255) DEFAULT NULL,
  `yq` int(3) DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `bqyj_webconfigs`;
CREATE TABLE `bqyj_webconfigs` (
  `vkey` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`vkey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `bqyj_users` VALUES ('1', 'admin', '1', '1', null, '2020-12-30', '0', '127', '26ff3a5be026305db95aac0adc3ca352', '0b484609853c70cd87c8d1e3b2f5f34a', '9','1','0','1', '2302701417', '', '127.0.0.1', '127.0.0.1', '2015-06-04 10:33:39', '2015-06-04 10:33:44','','','0');
INSERT INTO `bqyj_webconfigs` VALUES ('introduce', '全网最大的秒赞平台,离线秒赞功能,自动点赞,空间签到发说说,商城点卡,自动充值自动发货,24小时离线秒赞平台');
INSERT INTO `bqyj_webconfigs` VALUES ('keyword', '远哥秒赞网，墨衫孤城秒赞网');
INSERT INTO `bqyj_webconfigs` VALUES ('zhanname', '墨衫孤城');
INSERT INTO `bqyj_webconfigs` VALUES ('webfuqq', '1423005401');
INSERT INTO `bqyj_webconfigs` VALUES ('web_quanquanjk', 'http://xunsongmz.cn/quan.php?qq=');
INSERT INTO `bqyj_webconfigs` VALUES ('addqq', '');
INSERT INTO `bqyj_webconfigs` VALUES ('cronrand', '1234');
INSERT INTO `bqyj_webconfigs` VALUES ('regpeie', '1');
INSERT INTO `bqyj_webconfigs` VALUES ('music', '0');
INSERT INTO `bqyj_webconfigs` VALUES ('txprotect', '1');
INSERT INTO `bqyj_webconfigs` VALUES ('zannet', '3');
INSERT INTO `bqyj_webconfigs` VALUES ('webmoney', '20');
INSERT INTO `bqyj_webconfigs` VALUES ('shuonet', '3');
INSERT INTO `bqyj_webconfigs` VALUES ('replynet', '3');
INSERT INTO `bqyj_webconfigs` VALUES ('netnum', '200');
INSERT INTO `bqyj_webconfigs` VALUES ('do', 'set');
INSERT INTO `bqyj_webconfigs` VALUES ('price_1vip', '8');
INSERT INTO `bqyj_webconfigs` VALUES ('price_3vip', '20');
INSERT INTO `bqyj_webconfigs` VALUES ('price_6vip', '30');
INSERT INTO `bqyj_webconfigs` VALUES ('XlchKey', '1423005401');
INSERT INTO `bqyj_webconfigs` VALUES ('price_12vip', '50');
INSERT INTO `bqyj_webconfigs` VALUES ('price_1peie', '20');
INSERT INTO `bqyj_webconfigs` VALUES ('price_3peie', '40');
INSERT INTO `bqyj_webconfigs` VALUES ('webindex', 'Function/Template/index_bqyj.php');
INSERT INTO `bqyj_webconfigs` VALUES ('price_5peie', '50');
INSERT INTO `bqyj_webconfigs` VALUES ('price_10peie', '66');
INSERT INTO `bqyj_webconfigs` VALUES ('submit', '确认修改');
INSERT INTO `bqyj_webconfigs` VALUES ('webfoot', '');
INSERT INTO `bqyj_webconfigs` VALUES ('version', '1036');
INSERT INTO `bqyj_webconfigs` VALUES ('dgapi', '');
INSERT INTO `bqyj_webconfigs` VALUES ('usertype', '0');
INSERT INTO `bqyj_webconfigs` VALUES ('webkey', '为您提供最快最稳定的免费离线秒赞平台，无需下载秒赞软件即可实现全自动秒赞！使用双协议全网最新稳定秒赞秒评，快来加入我们一起来秒赞吧！');
INSERT INTO `bqyj_webconfigs` VALUES ('webgroup', '');
INSERT INTO `bqyj_webconfigs` VALUES ('qdgg', '');
INSERT INTO `bqyj_webconfigs` VALUES ('number', '0');
INSERT INTO `bqyj_webconfigs` VALUES ('shuogg', ' - 远哥秒赞网');
INSERT INTO `bqyj_webconfigs` VALUES ('web_quanquanjk', '');
INSERT INTO `bqyj_webconfigs` VALUES ('webname', '远哥秒赞网');
INSERT INTO `bqyj_webconfigs` VALUES ('webdomain', '');
INSERT INTO `bqyj_webconfigs` VALUES ('webqq', '1423005401');
INSERT INTO `bqyj_webconfigs` VALUES ('kmurl', '');
INSERT INTO `bqyj_webconfigs` VALUES ('web_separate_gg', '');
INSERT INTO `bqyj_webconfigs` VALUES ('web_shop_gg', '');
INSERT INTO `bqyj_webconfigs` VALUES ('webfree', '1');
INSERT INTO `bqyj_webconfigs` VALUES ('price_1dvip', '1');
INSERT INTO `bqyj_webconfigs` VALUES ('regrmb', '1');
INSERT INTO `bqyj_webconfigs` VALUES ('web_rmb_gg', '');
INSERT INTO `bqyj_webconfigs` VALUES ('changyan_appid', '');
INSERT INTO `bqyj_webconfigs` VALUES ('changyan_conf', '');
INSERT INTO `bqyj_webconfigs` VALUES ('index_pic_1', 'http://h2302701417.kuaiyunds.com/h2302701417/20128181071010672.jpg');
INSERT INTO `bqyj_webconfigs` VALUES ('index_pic_2', 'http://h2302701417.kuaiyunds.com/h2302701417/36330.jpg');
INSERT INTO `bqyj_webconfigs` VALUES ('index_pic_3', 'http://h2302701417.kuaiyunds.com/h2302701417/opw7xdvzvvvk.jpg');
INSERT INTO `bqyj_webconfigs` VALUES ('index_pic_4', 'http://h2302701417.kuaiyunds.com/h2302701417/1101741.jpg');
INSERT INTO `bqyj_webconfigs` VALUES ('index_pic_yhzx', 'http://h2302701417.kuaiyunds.com/h2302701417/c0.jpg');
INSERT INTO `bqyj_webconfigs` VALUES ('163_music', 'http://music.163.com/outchain/player?type=0&id=588510730&auto=1&height=66');
INSERT INTO `bqyj_webconfigs` VALUES ('index_logo', 'http://h2302701417.kuaiyunds.com/h2302701417/bqyj1.63/bqyjmzmb/logo.png');
