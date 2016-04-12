# Host: 127.0.0.1  (Version: 5.7.9)
# Date: 2016-04-12 21:45:21
# Generator: MySQL-Front 5.3  (Build 4.271)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ct_addon"
#

DROP TABLE IF EXISTS `ct_addon`;
CREATE TABLE `ct_addon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '插件名或标识',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text NOT NULL COMMENT '插件描述',
  `config` text COMMENT '配置',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本号',
  `adminlist` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '插件类型',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='插件表';

#
# Data for table "ct_addon"
#

/*!40000 ALTER TABLE `ct_addon` DISABLE KEYS */;
INSERT INTO `ct_addon` VALUES (1,'ReturnTop','返回顶部','返回顶部','{\"status\":\"1\",\"theme\":\"rocket\",\"customer\":\"\",\"case\":\"\",\"qq\":\"\",\"weibo\":\"\"}','CoreThink','1.0',0,0,1407681961,1408602081,0,1),(2,'Email','邮件插件','实现系统发邮件功能','{\"status\":\"1\",\"MAIL_SMTP_TYPE\":\"2\",\"MAIL_SMTP_SECURE\":\"0\",\"MAIL_SMTP_PORT\":\"25\",\"MAIL_SMTP_HOST\":\"smtp.qq.com\",\"MAIL_SMTP_USER\":\"\",\"MAIL_SMTP_PASS\":\"\",\"default\":\"[MAILBODY]\"}','CoreThink','1.0',0,0,1428732454,1428732454,0,1),(3,'SyncLogin','第三方账号登陆','第三方账号登陆','{\"type\":[\"Weixin\",\"Qq\",\"Sina\"],\"meta\":\"\",\"WeixinKEY\":\"\",\"WeixinSecret\":\"\",\"QqKEY\":\"\",\"QqSecret\":\"\",\"SinaKEY\":\"\",\"SinaSecret\":\"\",\"RenrenKEY\":\"\",\"RenrenSecret\":\"\"}','CoreThink','1.0',1,0,1428250248,1428250248,0,1),(4,'AdFloat','图片漂浮广告','图片漂浮广告','{\"status\":\"0\",\"url\":\"http:\\/\\/www.corethink.cn\",\"image\":\"\",\"width\":\"100\",\"height\":\"100\",\"speed\":\"10\",\"target\":\"1\"}','CoreThink','1.0',0,0,1408602081,1408602081,0,1);
/*!40000 ALTER TABLE `ct_addon` ENABLE KEYS */;

#
# Structure for table "ct_addon_hook"
#

DROP TABLE IF EXISTS `ct_addon_hook`;
CREATE TABLE `ct_addon_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '钩子ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `addons` varchar(255) NOT NULL COMMENT '钩子挂载的插件 ''，''分割',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='钩子表';

#
# Data for table "ct_addon_hook"
#

/*!40000 ALTER TABLE `ct_addon_hook` DISABLE KEYS */;
INSERT INTO `ct_addon_hook` VALUES (1,'PageHeader','页面header钩子，一般用于加载插件CSS文件和代码','SyncLogin',1,1407681961,1407681961,1),(2,'PageFooter','页面footer钩子，一般用于加载插件CSS文件和代码','ReturnTop,AdFloat',1,1407681961,1407681961,1),(3,'PageSide','页面侧边栏钩子','',1,1407681961,1407681961,1),(4,'DocumentListBefore','文档列表页面顶部钩子','',1,1407681961,1407681961,1),(5,'DocumentListAfter','文档列表页面底部钩子','',1,1407681961,1407681961,1),(6,'DocumentDetailBefore','文档详情页面顶部钩子','',1,1407681961,1407681961,1),(7,'DocumentDetailAfter','文档详情页面底部钩子','',1,1407681961,1407681961,1),(8,'UploadFile','上传文件钩子','',1,1407681961,1407681961,1),(9,'SendMessage','发送消息钩子','',1,1407681961,1407681961,1),(10,'SyncLogin','第三方登陆','SyncLogin',1,1407681961,1407681961,1);
/*!40000 ALTER TABLE `ct_addon_hook` ENABLE KEYS */;

#
# Structure for table "ct_addon_sync_login"
#

DROP TABLE IF EXISTS `ct_addon_sync_login`;
CREATE TABLE `ct_addon_sync_login` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL COMMENT '用户ID',
  `type` varchar(15) NOT NULL DEFAULT '' COMMENT '类别',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'OpenID',
  `access_token` varchar(64) NOT NULL DEFAULT '' COMMENT 'AccessToken',
  `refresh_token` varchar(64) NOT NULL DEFAULT '' COMMENT 'RefreshToken',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='第三方登陆插件表';

#
# Data for table "ct_addon_sync_login"
#

/*!40000 ALTER TABLE `ct_addon_sync_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `ct_addon_sync_login` ENABLE KEYS */;

#
# Structure for table "ct_attendance_month"
#

DROP TABLE IF EXISTS `ct_attendance_month`;
CREATE TABLE `ct_attendance_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned DEFAULT NULL COMMENT 'uid',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `latetimes` int(11) unsigned DEFAULT '0' COMMENT '迟到次数',
  `earlytimes` int(11) unsigned DEFAULT '0' COMMENT '早退次数',
  `deductmoney` int(11) DEFAULT NULL COMMENT '迟到早退扣掉的钱',
  `leavedays` int(11) unsigned DEFAULT '0' COMMENT '请假天数',
  `createtime` int(11) unsigned DEFAULT '0' COMMENT '时间',
  `status` tinyint(3) unsigned DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='个人月考勤记录';

#
# Data for table "ct_attendance_month"
#

/*!40000 ALTER TABLE `ct_attendance_month` DISABLE KEYS */;
INSERT INTO `ct_attendance_month` VALUES (1,4,1,0,0,NULL,4,1460465747,1);
/*!40000 ALTER TABLE `ct_attendance_month` ENABLE KEYS */;

#
# Structure for table "ct_attendance_record"
#

DROP TABLE IF EXISTS `ct_attendance_record`;
CREATE TABLE `ct_attendance_record` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `firsttime` int(11) unsigned DEFAULT NULL COMMENT '早上签到时间',
  `secondtime` int(11) unsigned DEFAULT NULL COMMENT '晚上签到时间',
  `islate` tinyint(3) unsigned DEFAULT '0' COMMENT '是否迟到 0 没有 1 迟到',
  `isearly` tinyint(3) unsigned DEFAULT '0' COMMENT '是否早退 0 没有  1 早退',
  `status` tinyint(3) unsigned DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='考勤记录表';

#
# Data for table "ct_attendance_record"
#

/*!40000 ALTER TABLE `ct_attendance_record` DISABLE KEYS */;
/*!40000 ALTER TABLE `ct_attendance_record` ENABLE KEYS */;

#
# Structure for table "ct_attendance_rule"
#

DROP TABLE IF EXISTS `ct_attendance_rule`;
CREATE TABLE `ct_attendance_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) DEFAULT NULL COMMENT '子公司id',
  `firsttime` int(11) DEFAULT NULL COMMENT '上班时间',
  `secondtime` int(11) DEFAULT NULL COMMENT '下班时间',
  `deductmoney` int(11) DEFAULT NULL COMMENT '迟到一次需要扣点的money',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='考勤规则';

#
# Data for table "ct_attendance_rule"
#

/*!40000 ALTER TABLE `ct_attendance_rule` DISABLE KEYS */;
INSERT INTO `ct_attendance_rule` VALUES (1,1,8,18,10,1);
/*!40000 ALTER TABLE `ct_attendance_rule` ENABLE KEYS */;

#
# Structure for table "ct_category"
#

DROP TABLE IF EXISTS `ct_category`;
CREATE TABLE `ct_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父分类ID',
  `group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分组',
  `doc_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分类模型',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `url` varchar(127) NOT NULL COMMENT '链接地址',
  `content` text NOT NULL COMMENT '内容',
  `index_template` varchar(32) NOT NULL DEFAULT '' COMMENT '列表封面模版',
  `detail_template` varchar(32) NOT NULL DEFAULT '' COMMENT '详情页模版',
  `post_auth` tinyint(4) NOT NULL DEFAULT '0' COMMENT '投稿权限',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '缩略图',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='栏目分类表';

#
# Data for table "ct_category"
#

/*!40000 ALTER TABLE `ct_category` DISABLE KEYS */;
INSERT INTO `ct_category` VALUES (1,0,1,3,'文章','','','index_default','detail_default',1,'fa fa-send-o',1431926468,1435895071,1,1),(9,0,1,1,'会员','User/index','','','',0,'fa fa-users',1435894071,1435895080,9,1),(10,0,1,1,'标签','Tag/index','','','',0,'fa fa-tags',1435896603,1435896603,11,0),(15,0,3,1,'底部导航','','','','',1,'fa fa-navicon',1435896768,1435896768,1,0),(16,15,3,1,'关于','','','','',0,'',1435896839,1435896839,0,0),(17,16,3,2,'关于我们','','','','',0,'',1435896882,1435921242,0,0),(18,16,3,2,'联系我们','','','','',0,'',1435896882,1435896882,0,0),(19,16,3,2,'友情链接','','','','',0,'',1435896882,1435896882,0,0),(20,16,3,2,'加入我们','','','','',0,'',1435896882,1435896882,0,0),(21,15,3,1,'帮助','','','','',0,'',1435922411,1435922411,0,0),(22,21,3,2,'用户协议','','','','',0,'',1435922579,1435922579,0,0),(23,21,3,2,'常见问题','','','','',0,'',1435922602,1435922602,0,0),(24,21,3,2,'意见反馈','','','','',0,'',1435922628,1435922628,0,0),(25,15,3,1,'服务产品','','','','',0,'',1435922794,1435922794,0,0),(26,25,3,1,'CoreThink框架','','','','',0,'',1435922823,1435922823,0,0),(27,25,3,1,'微＋微信平台','','','','',0,'',1435922866,1435923215,0,0),(28,15,3,1,'手册','','','','',0,'',1435922918,1435922918,0,0),(29,28,3,1,'CoreThink手册','','','','',0,'',1435922944,1435923226,0,0),(30,28,3,1,'ThinkPHP3.2手册','http://document.thinkphp.cn/manual_3_2.html','','','',0,'',1435923030,1435923030,0,0);
/*!40000 ALTER TABLE `ct_category` ENABLE KEYS */;

#
# Structure for table "ct_company"
#

DROP TABLE IF EXISTS `ct_company`;
CREATE TABLE `ct_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(50) DEFAULT NULL COMMENT '名称',
  `address` varchar(50) DEFAULT NULL COMMENT '地址',
  `tel` varchar(11) DEFAULT NULL COMMENT '联系电话',
  `status` tinyint(3) DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='子公司表';

#
# Data for table "ct_company"
#

/*!40000 ALTER TABLE `ct_company` DISABLE KEYS */;
INSERT INTO `ct_company` VALUES (1,'子公司A','郑州','13849171733',1),(3,'子公司B','郑州','13849171733',1);
/*!40000 ALTER TABLE `ct_company` ENABLE KEYS */;

#
# Structure for table "ct_document"
#

DROP TABLE IF EXISTS `ct_document`;
CREATE TABLE `ct_document` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文档类型ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布者ID',
  `view` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `good` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赞数',
  `bad` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '踩数',
  `mark` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文档类型基础表';

#
# Data for table "ct_document"
#

/*!40000 ALTER TABLE `ct_document` DISABLE KEYS */;
INSERT INTO `ct_document` VALUES (1,1,3,1,3,0,1,0,1,1458132624,1458132624,0,1),(2,1,3,3,2,0,1,0,1,1460294920,1460294920,0,1);
/*!40000 ALTER TABLE `ct_document` ENABLE KEYS */;

#
# Structure for table "ct_document_article"
#

DROP TABLE IF EXISTS `ct_document_article`;
CREATE TABLE `ct_document_article` (
  `id` int(11) unsigned NOT NULL COMMENT '文档ID',
  `title` varchar(127) NOT NULL DEFAULT '' COMMENT '标题',
  `abstract` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `content` text NOT NULL COMMENT '正文内容',
  `tags` varchar(127) NOT NULL COMMENT '标签',
  `cover` int(11) NOT NULL DEFAULT '0' COMMENT '封面图片ID',
  `file` int(11) NOT NULL DEFAULT '0' COMMENT '附件ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章类型扩展表';

#
# Data for table "ct_document_article"
#

/*!40000 ALTER TABLE `ct_document_article` DISABLE KEYS */;
INSERT INTO `ct_document_article` VALUES (1,'现在','现在','现在在','自习',0,0),(2,'缩放时','vds','vs:','',0,0);
/*!40000 ALTER TABLE `ct_document_article` ENABLE KEYS */;

#
# Structure for table "ct_document_attribute"
#

DROP TABLE IF EXISTS `ct_document_attribute`;
CREATE TABLE `ct_document_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `doc_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '文档模型',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='文档属性字段表';

#
# Data for table "ct_document_attribute"
#

/*!40000 ALTER TABLE `ct_document_attribute` DISABLE KEYS */;
INSERT INTO `ct_document_attribute` VALUES (1,'cid','分类','int(11) unsigned NOT NULL ','select','0','所属分类',1,'',0,1383891233,1384508336,1),(2,'uid','用户ID','int(11) unsigned NOT NULL ','num','0','用户ID',0,'',0,1383891233,1384508336,1),(3,'view','阅读量','varchar(255) NOT NULL','num','0','标签',0,'',0,1413303715,1413303715,1),(4,'comment','评论数','int(11) unsigned NOT NULL ','num','0','评论数',0,'',0,1383891233,1383894927,1),(5,'good','赞数','int(11) unsigned NOT NULL ','num','0','赞数',0,'',0,1383891233,1384147827,1),(6,'bad','踩数','int(11) unsigned NOT NULL ','num','0','踩数',0,'',0,1407646362,1407646362,1),(7,'ctime','创建时间','int(11) unsigned NOT NULL ','time','0','创建时间',1,'',0,1383891233,1383895903,1),(8,'utime','更新时间','int(11) unsigned NOT NULL ','time','0','更新时间',0,'',0,1383891233,1384508277,1),(9,'sort','排序','int(11) unsigned NOT NULL ','num','0','用于显示的顺序',1,'',0,1383891233,1383895757,1),(10,'status','数据状态','tinyint(4) NOT NULL ','radio','1','数据状态',0,'-1:删除\r\n0:禁用\r\n1:正常',0,1383891233,1384508496,1),(11,'title','标题','char(127) NOT NULL ','text','','文档标题',1,'',3,1383891233,1383894778,1),(12,'abstract','简介','varchar(255) NOT NULL','textarea','','文档简介',1,'',3,1383891233,1384508496,1),(13,'content','正文内容','text','kindeditor','','文章正文内容',1,'',3,1383891233,1384508496,1),(14,'tags','文章标签','varchar(127) NOT NULL','tags','','标签',1,'',3,1383891233,1384508496,1),(15,'cover','封面','int(11) unsigned NOT NULL ','picture','0','文档封面',1,'',3,1383891233,1384508496,1),(16,'file','附件','int(11) unsigned NOT NULL ','file','0','附件',1,'',3,1439454552,1439454552,1);
/*!40000 ALTER TABLE `ct_document_attribute` ENABLE KEYS */;

#
# Structure for table "ct_document_type"
#

DROP TABLE IF EXISTS `ct_document_type`;
CREATE TABLE `ct_document_type` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(16) NOT NULL DEFAULT '' COMMENT '模型名称',
  `title` char(16) NOT NULL DEFAULT '' COMMENT '模型标题',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '缩略图',
  `main_field` int(11) NOT NULL DEFAULT '0' COMMENT '主要字段',
  `list_field` varchar(127) NOT NULL DEFAULT '' COMMENT '列表显示字段',
  `field_sort` varchar(255) NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '' COMMENT '表单字段分组',
  `system` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '系统类型',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文档模型表';

#
# Data for table "ct_document_type"
#

/*!40000 ALTER TABLE `ct_document_type` DISABLE KEYS */;
INSERT INTO `ct_document_type` VALUES (1,'link','链接','fa fa-link',0,'','','',1,1426580628,1426580628,0,1),(2,'page','单页','fa fa-file-text',0,'','','',1,1426580628,1426580628,0,1),(3,'article','文章','fa fa-file-word-o',11,'11','{\"1\":[\"1\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\"],\"2\":[\"9\",\"7\"]}','1:基础\n2:扩展',0,1426580628,1426580628,0,1);
/*!40000 ALTER TABLE `ct_document_type` ENABLE KEYS */;

#
# Structure for table "ct_leaves"
#

DROP TABLE IF EXISTS `ct_leaves`;
CREATE TABLE `ct_leaves` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) DEFAULT NULL COMMENT 'uid',
  `companyid` int(11) DEFAULT NULL COMMENT '公司id',
  `to_uid` int(11) DEFAULT NULL COMMENT '请假的上级',
  `title` varchar(50) DEFAULT NULL COMMENT '标题',
  `timestart` int(11) DEFAULT NULL COMMENT '开始时间',
  `timeend` int(11) DEFAULT NULL COMMENT '结束时间',
  `days` int(11) DEFAULT NULL COMMENT '天数',
  `status` tinyint(3) DEFAULT NULL COMMENT '状态',
  `result` tinyint(3) DEFAULT '0' COMMENT '1 同意 2拒绝',
  `ext` varchar(50) DEFAULT NULL COMMENT '备注',
  `ctime` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='请假表';

#
# Data for table "ct_leaves"
#

/*!40000 ALTER TABLE `ct_leaves` DISABLE KEYS */;
INSERT INTO `ct_leaves` VALUES (1,4,1,3,'有事请假一天',1460433600,1460606400,2,1,1,'早回',1460377381);
/*!40000 ALTER TABLE `ct_leaves` ENABLE KEYS */;

#
# Structure for table "ct_public_comment"
#

DROP TABLE IF EXISTS `ct_public_comment`;
CREATE TABLE `ct_public_comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '评论父ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `table` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据表ID',
  `group` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分组',
  `data_id` int(11) unsigned NOT NULL COMMENT '数据ID',
  `content` text NOT NULL COMMENT '评论内容',
  `pictures` varchar(15) NOT NULL DEFAULT '' COMMENT '图片列表',
  `rate` tinyint(3) NOT NULL DEFAULT '0' COMMENT '评价/评分',
  `good` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赞数',
  `bad` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '踩数',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `ip` varchar(15) NOT NULL COMMENT '来源IP',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='评论表';

#
# Data for table "ct_public_comment"
#

/*!40000 ALTER TABLE `ct_public_comment` DISABLE KEYS */;
INSERT INTO `ct_public_comment` VALUES (1,0,1,3,0,1,'12356不回家','',0,0,0,1450937059,1450937059,0,1,'127.0.0.1');
/*!40000 ALTER TABLE `ct_public_comment` ENABLE KEYS */;

#
# Structure for table "ct_public_digg"
#

DROP TABLE IF EXISTS `ct_public_digg`;
CREATE TABLE `ct_public_digg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `table` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '数据表ID',
  `data_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据ID',
  `type` tinyint(3) NOT NULL DEFAULT '0' COMMENT 'Digg类型',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Digg表';

#
# Data for table "ct_public_digg"
#

/*!40000 ALTER TABLE `ct_public_digg` DISABLE KEYS */;
INSERT INTO `ct_public_digg` VALUES (1,1,1,1,3,1459951116,1459951116,0,1),(2,1,1,3,3,1459951117,1459951117,0,1),(3,1,2,1,1,1460468663,1460468663,0,1),(4,1,2,3,1,1460468665,1460468665,0,1);
/*!40000 ALTER TABLE `ct_public_digg` ENABLE KEYS */;

#
# Structure for table "ct_public_tag"
#

DROP TABLE IF EXISTS `ct_public_tag`;
CREATE TABLE `ct_public_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(32) NOT NULL COMMENT '标签',
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数量',
  `group` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '分组',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '图标',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签表';

#
# Data for table "ct_public_tag"
#

/*!40000 ALTER TABLE `ct_public_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ct_public_tag` ENABLE KEYS */;

#
# Structure for table "ct_public_upload"
#

DROP TABLE IF EXISTS `ct_public_upload`;
CREATE TABLE `ct_public_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '上传ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件链接',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件sha1编码',
  `location` varchar(15) NOT NULL DEFAULT '' COMMENT '文件存储位置',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='文件上传表';

#
# Data for table "ct_public_upload"
#

/*!40000 ALTER TABLE `ct_public_upload` DISABLE KEYS */;
INSERT INTO `ct_public_upload` VALUES (1,'{7953FF1A-A866-41F1-A82C-91C0575B8EDF}.jpg','/Uploads/2015-11-09/56405dafac158.jpg','','jpg',3481,'37d57dbce17ddcb0cf59939b49039f9f','b0e4e8124c1e354c9f6327e9c6a65d4ac4578d13','Local',0,1447058863,1447058863,0,1),(2,'favicon.png','/Uploads/2016-03-01/56d4f517024d9.png','','png',1899,'3cc843ac6eed66145c929a6f4dc7109f','edcf50aa0f83438c9b28bd86314a47574e656e1c','Local',0,1456796950,1456796950,0,1),(3,'1.png','/Uploads/2016-04-04/570265e3aaa99.png','','png',102104,'7832fb06e6c3481e984a1089b30011f2','a7bde9f4728781aab2a1f8d70658ffdae65d4371','Local',0,1459774947,1459774947,0,1),(4,'7~1DBDUZ]D%3%IB2NKXHIAK.png','/Uploads/2016-04-04/5702660704731.png','','png',32178,'b257d4aa28e5eaaa188251866eb2cc25','75e5609e5ed07e928020bb043c034c54f5cb4d6f','Local',0,1459774982,1459774982,0,1);
/*!40000 ALTER TABLE `ct_public_upload` ENABLE KEYS */;

#
# Structure for table "ct_system_config"
#

DROP TABLE IF EXISTS `ct_system_config`;
CREATE TABLE `ct_system_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '配置标题',
  `name` varchar(32) NOT NULL COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `group` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `type` varchar(16) NOT NULL DEFAULT '' COMMENT '配置类型',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置额外值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

#
# Data for table "ct_system_config"
#

/*!40000 ALTER TABLE `ct_system_config` DISABLE KEYS */;
INSERT INTO `ct_system_config` VALUES (1,'站点开关','TOGGLE_WEB_SITE','1',1,'select','0:关闭,1:开启','站点关闭后将不能访问',1378898976,1406992386,1,1),(2,'网站标题','WEB_SITE_TITLE','RFID',1,'text','','网站标题前台显示标题',1378898976,1379235274,2,1),(3,'网站口号','WEB_SITE_SLOGAN','RFID考勤系统',1,'text','','网站口号、宣传标语、一句话介绍',1434081649,1434081649,2,1),(4,'网站LOGO','WEB_SITE_LOGO','',1,'picture','','网站LOGO',1407003397,1407004692,3,1),(5,'网站描述','WEB_SITE_DESCRIPTION','基于RFID技术的考勤 系统，让考勤更加简单！',1,'textarea','','网站搜索引擎描述',1378898976,1379235841,4,1),(6,'网站关键字','WEB_SITE_KEYWORD','RFID考勤系统',1,'textarea','','网站搜索引擎关键字',1378898976,1381390100,5,1),(7,'版权信息','WEB_SITE_COPYRIGHT','版权所有 © 2014-2016 河南中医药大学信息技术学院',1,'text','','设置在网站底部显示的版权信息，如“版权所有 © 2014-2015 科斯克网络科技”',1406991855,1406992583,6,1),(8,'网站备案号','WEB_SITE_ICP','',1,'text','','设置在网站底部显示的备案号，如“苏ICP备1502009-2号\"',1378900335,1415983236,7,1),(9,'站点统计','WEB_SITE_STATISTICS','',1,'textarea','','支持百度、Google、cnzz等所有Javascript的统计代码',1407824190,1407824303,8,1),(10,'注册开关','TOGGLE_USER_REGISTER','1',2,'select','0:关闭注册\r\n1:允许注册','是否开放用户注册',1379504487,1379504580,1,1),(11,'允许注册方式','ALLOW_REG_TYPE','username',2,'checkbox','username:用户名注册\r\nemail:邮箱注册\r\nmobile:手机注册','',0,0,2,1),(12,'注册时间间隔','LIMIT_TIME_BY_IP','0',2,'num','','同一IP注册时间间隔秒数',1379228036,1379228036,3,1),(13,'评论开关','TOGGLE_USER_COMMENT','1',2,'select','0:关闭评论,1:允许评论','评论关闭后用户不能进行评论',1418715779,1418716106,4,1),(14,'文件上传大小','UPLOAD_FILE_SIZE','10',2,'num','','文件上传大小单位：MB',1428681031,1428681031,5,1),(15,'图片上传大小','UPLOAD_IMAGE_SIZE','2',2,'num','','图片上传大小单位：MB',1428681071,1428681071,6,1),(16,'敏感字词','SENSITIVE_WORDS','傻逼,垃圾',2,'textarea','','用户注册及内容显示敏感字词',1420385145,1420387079,7,1),(17,'后台主题','ADMIN_THEME','default',3,'select','default:默认主题\r\nblue:蓝色理想\r\ngreen:绿色生活','后台界面主题',1436678171,1436690570,1,1),(18,'URL模式','URL_MODEL','3',3,'select','0:普通模式\r\n1:PATHINFO模式\r\n2:REWRITE模式\r\n3:兼容模式','',1438423248,1438423248,2,1),(19,'是否显示页面Trace','SHOW_PAGE_TRACE','0',3,'select','0:关闭\r\n1:开启','是否显示页面Trace信息',1387165685,1387165685,3,1),(20,'开发模式','DEVELOP_MODE','1',3,'select','1:开启\r\n0:关闭','开发模式下会显示菜单管理、配置管理、数据字典等开发者工具',1432393583,1432393583,4,1),(21,'静态资源版本标识','STATIC_VERSION','20150803',3,'text','','静态资源版本标识可以防止服务器缓存',1438564784,1438564784,5,1),(22,'CDN静态资源列表','CDN_RESOURCE_LIST','',3,'textarea','','配置此项后系统自带的jquery等类库将不会再重复加载',1438564784,1438564784,6,1),(23,'系统加密KEY','AUTH_KEY','#o|<{VielH&-$,jp|ux[ECZvT@ZrMwcBW[+Wf}YX%L,Lpu;u_YrYlE_rKdx)k~yR',3,'textarea','','轻易不要修改此项，否则容易造成用户无法登录；如要修改，务必备份原key',1438647773,1438647815,7,1),(24,'配置分组','CONFIG_GROUP_LIST','1:基本\r\n2:用户\r\n3:系统\r\n',3,'array','','配置分组',1379228036,1426930700,8,1),(25,'分页数量','ADMIN_PAGE_ROWS','10',3,'num','','分页时每页的记录数',1434019462,1434019481,9,1),(26,'栏目分组','CATEGORY_GROUP_LIST','1:默认\r\n3:导航\r\n',3,'array','','栏目分类分组',1433602137,1433602165,10,1);
/*!40000 ALTER TABLE `ct_system_config` ENABLE KEYS */;

#
# Structure for table "ct_system_menu"
#

DROP TABLE IF EXISTS `ct_system_menu`;
CREATE TABLE `ct_system_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(127) NOT NULL DEFAULT '' COMMENT '链接地址',
  `icon` varchar(64) NOT NULL COMMENT '图标',
  `dev` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否开发模式可见',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

#
# Data for table "ct_system_menu"
#

/*!40000 ALTER TABLE `ct_system_menu` DISABLE KEYS */;
INSERT INTO `ct_system_menu` VALUES (1,0,'首页','Admin/Index/index','fa fa-home',0,1426580628,1438276217,1,1),(2,0,'系统','Admin/SystemConfig/group','fa fa-cog',0,1426580628,1438276235,2,1),(3,0,'内容','Admin/Category/index','fa fa-tasks',0,1430290092,1438276260,2,0),(4,0,'员工','Admin/User/index','fa fa-users',0,1426580628,1458009535,3,1),(5,0,'其它','Admin/Other/index','fa fa-cloud',0,1426580628,1426580628,3,0),(6,1,'系统操作','','fa fa-folder-open-o',0,1426580628,1426580628,1,1),(7,2,'系统功能','','fa fa-folder-open-o',0,1426580628,1438277612,1,1),(8,2,'扩展中心','','fa fa-folder-open-o',0,1437185077,1459817769,4,0),(9,2,'数据中心','','fa fa-folder-open-o',0,1426580628,1426580628,3,1),(10,3,'内容管理','','fa fa-folder-open-o',0,1430290276,1438277591,1,1),(11,3,'文件管理','','fa fa-folder-open-o',0,1430290276,1438277393,1,1),(12,4,'员工管理','','fa fa-folder-open-o',0,1426580628,1459818461,1,1),(13,6,'清空缓存','Admin/Index/rmdirr','',0,1427475588,1427475588,1,1),(14,7,'系统设置','Admin/SystemConfig/group','fa fa-gears',0,1426580628,1438276516,1,1),(15,14,'修改设置','Admin/SystemConfig/groupSave','',0,1426580628,1426580628,1,1),(16,7,'文档模型','Admin/DocumentType/index','fa fa-th-list',1,1426580628,1438277140,2,1),(17,16,'添加','Admin/DocumentType/add','',0,1426580628,1426580628,1,1),(18,16,'编辑','Admin/DocumentType/edit','',0,1426580628,1426580628,2,1),(19,16,'设置状态','Admin/DocumentType/setStatus','',0,1426580628,1426580628,3,1),(20,16,'字段管理','Admin/DocumentAttribute/index','',0,1426580628,1430291065,1,1),(21,20,'添加','Admin/DocumentAttribute/add','',0,1426580628,1426580628,1,1),(22,20,'编辑','Admin/DocumentAttribute/edit','',0,1426580628,1426580628,2,1),(23,20,'设置状态','Admin/DocumentAttribute/setStatus','',0,1426580628,1426580628,3,1),(24,7,'菜单管理','Admin/SystemMenu/index','fa fa-bars',1,1426580628,1438276552,3,1),(25,24,'添加','Admin/SystemMenu/add','',0,1426580628,1426580628,1,1),(26,24,'编辑','Admin/SystemMenu/edit','',0,1426580628,1426580628,2,1),(27,24,'设置状态','Admin/SystemMenu/setStatus','',0,1426580628,1426580628,3,1),(28,7,'配置管理','Admin/SystemConfig/index','fa fa-cogs',1,1426580628,1438276571,4,1),(29,28,'添加','Admin/SystemConfig/add','',0,1426580628,1426580628,1,1),(30,28,'编辑','Admin/SystemConfig/edit','',0,1426580628,1426580628,2,1),(31,28,'设置状态','Admin/SystemConfig/setStatus','',0,1426580628,1426580628,3,1),(32,8,'功能模块','Admin/SystemModule/index','fa fa-th-large',0,1437185242,1438276915,1,1),(33,32,'安装','Admin/SystemModule/install','',0,1427475588,1427475588,1,1),(34,32,'卸载','Admin/SystemModule/uninstall','',0,1427475588,1427475588,2,1),(35,32,'更新信息','Admin/SystemModule/updateInfo','',0,1427475588,1427475588,3,1),(36,32,'设置状态','Admin/SystemModule/setStatus','',0,1427475588,1427475588,4,1),(37,8,'前台主题','Admin/SystemTheme/index','fa fa-adjust',0,1437185290,1438277065,2,1),(38,37,'安装','Admin/SystemTheme/install','',0,1427475588,1427475588,1,1),(39,37,'卸载','Admin/SystemTheme/uninstall','',0,1427475588,1427475588,2,1),(40,37,'更新信息','Admin/SystemTheme/updateInfo','',0,1427475588,1427475588,3,1),(41,37,'设置状态','Admin/SystemTheme/setStatus','',0,1427475588,1427475588,4,1),(42,37,'切换主题','Admin/SystemTheme/setCurrent','',0,1427475588,1427475588,5,1),(43,8,'系统插件','Admin/Addon/index','fa fa-th',0,1427475588,1438277115,3,1),(44,43,'安装','Admin/Addon/install','',0,1427475588,1427475588,1,1),(45,43,'卸载','Admin/Addon/uninstall','',0,1427475588,1427475588,2,1),(46,43,'执行','Admin/Addon/execute','',0,1427475588,1427475588,3,1),(47,43,'插件设置','Admin/Addon/config','',0,1427475588,1427475588,4,1),(48,43,'插件后台管理','Admin/Addon/adminList','',0,1427475588,1427475588,5,1),(49,48,'新增数据','Admin/Addon/adminAdd','',0,1426580628,1426580628,1,1),(50,48,'编辑数据','Admin/Addon/adminEdit','',0,1426580628,1426580628,2,1),(51,48,'设置状态','Admin/Addon/setStatus','',0,1426580628,1426580628,3,1),(52,9,'数据字典','Admin/Datebase/index','fa fa-database',1,1429851071,1438276624,1,1),(53,9,'数据备份','Admin/Datebase/export','fa fa-copy',0,1426580628,1426580628,2,1),(54,53,'备份','Admin/Datebase/do_export','',0,1426580628,1426580628,1,1),(55,53,'优化表','Admin/Datebase/optimize','',0,1426580628,1426580628,2,1),(56,53,'修复表','Admin/Datebase/repair','',0,1426580628,1426580628,3,1),(57,9,'数据还原','Admin/Datebase/import','fa fa-refresh',1,1426580628,1438276890,3,1),(58,57,'还原备份','Admin/Datebase/do_import','',0,1426580628,1426580628,1,1),(59,57,'删除备份','Admin/Datebase/del','',0,1426580628,1426580628,2,1),(60,10,'栏目分类','Admin/Category/index','fa fa-th-list',0,1426580628,1438277233,1,1),(61,60,'添加','Admin/Category/add','',0,1426580628,1426580628,1,1),(62,60,'编辑','Admin/Category/edit','',0,1426580628,1426580628,2,1),(63,60,'设置状态','Admin/Category/setStatus','',0,1426580628,1426580628,3,1),(64,60,'文档列表','Admin/Document/index','',0,1427475588,1427475588,4,1),(65,64,'添加','Admin/Document/add','',0,1426580628,1426580628,1,1),(66,64,'编辑','Admin/Document/edit','',0,1426580628,1426580628,2,1),(67,64,'移动','Admin/Document/move','',0,1426580628,1426580628,3,1),(68,64,'设置状态','Admin/Document/setStatus','',0,1426580628,1426580628,4,1),(69,10,'标签列表','Admin/PublicTag/index','fa fa-tags',0,1426580628,1438277250,3,1),(70,69,'添加','Admin/PublicTag/add','',0,1426580628,1426580628,1,1),(71,69,'编辑','Admin/PublicTag/edit','',0,1426580628,1426580628,2,1),(72,69,'设置状态','Admin/PublicTag/setStatus','',0,1426580628,1426580628,3,1),(73,69,'搜索标签(自动完成)','Admin/PublicTag/searchTags','',0,1426580628,1426580628,4,1),(74,10,'万能评论','Admin/PublicComment/index','fa fa-comments',0,1426580628,1438277284,4,1),(75,74,'添加','Admin/PublicComment/add','',0,1426580628,1426580628,1,1),(76,74,'编辑','Admin/PublicComment/edit','',0,1426580628,1426580628,2,1),(77,74,'设置状态','Admin/PublicComment/setStatus','',0,1426580628,1426580628,3,1),(78,10,'回收站','Admin/Document/recycle','fa fa-trash',0,1427475588,1438277313,5,1),(79,11,'上传管理','Admin/PublicUpload/index','fa fa-upload',0,1427475588,1438277518,1,1),(80,79,'上传文件','Admin/PublicUpload/upload','',0,1427475588,1427475588,1,1),(81,79,'删除文件','Admin/PublicUpload/delete','',0,1427475588,1427475588,2,1),(82,79,'设置状态','Admin/PublicUpload/setStatus','',0,1426580628,1426580628,3,1),(83,79,'下载图片','Admin/PublicUpload/downremoteimg','',0,1427475588,1427475588,4,1),(84,79,'文件浏览','Admin/PublicUpload/fileManager','',0,1427475588,1427475588,5,1),(85,12,'员工列表','Admin/User/index','fa fa-user',0,1426580628,1459818492,1,1),(86,85,'添加','Admin/User/add','',0,1426580628,1426580628,1,1),(87,85,'编辑','Admin/User/edit','',0,1426580628,1426580628,2,1),(88,85,'设置状态','Admin/User/setStatus','',0,1426580628,1426580628,3,1),(89,7,'系统权限','Admin/UserGroup/index','fa fa-sitemap',0,1426580628,1459818053,2,1),(90,89,'添加','Admin/UserGroup/add','',0,1426580628,1426580628,1,1),(91,89,'编辑','Admin/UserGroup/edit','',0,1426580628,1426580628,2,1),(92,89,'设置状态','Admin/UserGroup/setStatus','',0,1426580628,1426580628,3,1),(93,102,'消息列表','Admin/UserMessage/index','fa fa-envelope-o',0,1440050363,1458656027,0,1),(94,93,'添加','Admin/UserMessage/add','',0,1426580628,1458655574,1,1),(95,93,'编辑','Admin/UserMessage/edit','',0,1426580628,1426580628,2,1),(96,93,'设置状态','Admin/UserMessage/setStatus','',0,1426580628,1426580628,3,1),(97,0,'考勤','Admin/AttendanceMonth/index','fa fa-navicon',0,1458009348,1458655386,0,1),(98,0,'请假','Admin/Leaves/index','fa fa-fax',0,1458009472,1460291443,0,1),(99,0,'通知','Admin/UserMessage/index','fa fa-bullhorn',0,1458009557,1458655524,0,1),(100,97,'每月统计','','fa fa-reorder',0,1458654902,1460466799,0,1),(101,97,'个人详情','Admin/AttendanceRecord/index','fa fa-barcode',0,1458655348,1458655369,2,1),(102,99,'消息','','fa fa-bolt',0,1458655999,1458655999,0,1),(103,0,'考勤规则','Admin/AttendanceRule/index','fa fa-cube',0,1459775291,1459849083,0,1),(104,2,'公司管理','','fa fa-folder-open-o',0,1459817709,1459817709,2,1),(105,104,'公司列表','Admin/Company/index','fa fa-sort-alpha-asc',0,1459817884,1459823204,1,1),(106,104,'公司高层','Admin/UserAdmin/index','fa fa-male',0,1459818350,1459824654,0,1),(107,104,'考勤统计','','fa fa-bar-chart-o',0,1459819326,1459819326,0,1),(108,105,'新增','Admin/Company/add','',0,1459823313,1459823313,0,1),(109,105,'编辑','Admin/Company/edit','',0,1459823368,1459823368,0,1),(110,106,'新增','Admin/UserAdmin/add','',0,1459824725,1459824725,0,1),(111,106,'编辑','Admin/UserAdmin/edit','',0,1459824823,1459824823,0,1),(112,106,'删除','Admin/UserAdmin/delete','',0,1459841765,1459841765,0,1),(113,103,'规则设置','','fa fa-folder-open-o',0,1459849015,1459849448,0,1),(114,116,'添加','Admin/AttendanceRule/add','',0,1459849133,1459849405,0,1),(115,116,'编辑','Admin/AttendanceRule/edit','',0,1459849161,1459849416,0,1),(116,113,'考勤规则','Admin/AttendanceRule/index','fa fa-sort-alpha-asc',0,1459849308,1459849468,0,1),(117,98,'请假列表','','',0,1460291623,1460291623,0,1),(118,117,'待批准','Admin/Leaves/index','fa fa-ellipsis-v',0,1460291829,1460376428,0,1),(119,117,'已批准','Admin/Leaves/agree','fa fa-child',0,1460376466,1460380325,0,1),(120,117,'已拒绝','Admin/Leaves/refuse','fa fa-flash',0,1460376525,1460380346,0,1),(121,118,'编辑','Admin/Leaves/edit','',0,1460378854,1460378854,0,1),(122,100,'本月统计','Admin/AttendanceMonth/index','fa fa-bars',0,1460466845,1460466845,0,1),(123,100,'上月统计','Admin/AttendanceMonth/last','fa fa-bars',0,1460466884,1460466960,0,1);
/*!40000 ALTER TABLE `ct_system_menu` ENABLE KEYS */;

#
# Structure for table "ct_system_module"
#

DROP TABLE IF EXISTS `ct_system_module`;
CREATE TABLE `ct_system_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(127) NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(32) NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本',
  `admin_menu` text NOT NULL COMMENT '菜单节点',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='模块功能表';

#
# Data for table "ct_system_module"
#

/*!40000 ALTER TABLE `ct_system_module` DISABLE KEYS */;
/*!40000 ALTER TABLE `ct_system_module` ENABLE KEYS */;

#
# Structure for table "ct_system_theme"
#

DROP TABLE IF EXISTS `ct_system_theme`;
CREATE TABLE `ct_system_theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(127) NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(32) NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本',
  `config` text NOT NULL COMMENT '主题配置',
  `current` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否当前主题',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='前台主题表';

#
# Data for table "ct_system_theme"
#

/*!40000 ALTER TABLE `ct_system_theme` DISABLE KEYS */;
INSERT INTO `ct_system_theme` VALUES (1,'default','默认主题','CoreThink默认主题','南京科斯克网络科技有限公司','1.0','',1,1437786501,1437786501,0,1);
/*!40000 ALTER TABLE `ct_system_theme` ENABLE KEYS */;

#
# Structure for table "ct_user"
#

DROP TABLE IF EXISTS `ct_user`;
CREATE TABLE `ct_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `companyid` int(11) DEFAULT NULL COMMENT '所属公司id',
  `usertype` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '用户类型',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名或昵称',
  `email` varchar(32) DEFAULT NULL COMMENT '用户邮箱',
  `mobile` char(11) DEFAULT NULL COMMENT '手机号',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '用户密码',
  `group` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '部门/用户组ID',
  `vip` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT ' VIP等级',
  `avatar` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户头像',
  `score` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户积分',
  `money` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `sex` enum('-1','0','1') NOT NULL DEFAULT '0' COMMENT '用户性别',
  `age` int(4) NOT NULL DEFAULT '0' COMMENT '年龄',
  `birthday` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `summary` varchar(127) NOT NULL DEFAULT '' COMMENT '心情',
  `realname` varchar(15) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `idcard_no` varchar(18) NOT NULL DEFAULT '' COMMENT '身份证号码',
  `extend` varchar(1024) NOT NULL DEFAULT '' COMMENT '用户信息扩展',
  `login` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `last_login_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最近登陆时间',
  `last_login_ip` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最近登陆IP',
  `reg_ip` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_type` varchar(12) NOT NULL DEFAULT '' COMMENT '注册方式',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='用户会员信息表';

#
# Data for table "ct_user"
#

/*!40000 ALTER TABLE `ct_user` DISABLE KEYS */;
INSERT INTO `ct_user` VALUES (1,NULL,0,'admin',NULL,NULL,'60d908217a487a048d81b3da0fc0ca64',1,0,0,0,0.00,'1',0,0,'','','','',52,1460468660,2130706433,2130706433,'admin',1438651748,1438651748,0,1),(3,1,1,'ztb','1611128494@qq.com','13849171733','fa4532a409a824ccf5f0bf8c767a4f8c',3,0,3,0,0.00,'0',0,0,'','','','',18,1460467583,2130706433,2130706433,'1',1456796953,1456796953,0,1),(4,1,1,'ztb001','13849171733@163.com','13849171744','1faf405dc098efb412c1d3e1651c4758',0,0,4,0,0.00,'0',0,0,'','','','',3,1460380195,2130706433,2130706433,'1',1459774991,1459774991,0,1),(5,3,1,'ztb01','13849171744@163.com','13849171755','1faf405dc098efb412c1d3e1651c4758',3,1,0,0,0.00,'0',0,0,'','','','',0,0,0,2130706433,'',1459839838,1459839838,0,1),(9,1,0,'ztb03','13849171777@163.com','13849171777','1faf405dc098efb412c1d3e1651c4758',0,0,0,0,0.00,'0',0,0,'','','','',0,0,0,2130706433,'',1459847283,1459847283,0,1),(11,1,0,'ztb04','13849171788@163.com','13849171788','1faf405dc098efb412c1d3e1651c4758',0,0,0,0,0.00,'0',0,0,'','','','',0,0,0,2130706433,'',1459847524,1459847524,0,1);
/*!40000 ALTER TABLE `ct_user` ENABLE KEYS */;

#
# Structure for table "ct_user_group"
#

DROP TABLE IF EXISTS `ct_user_group`;
CREATE TABLE `ct_user_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '部门名称',
  `icon` varchar(32) NOT NULL COMMENT '图标',
  `menu_auth` text COMMENT '菜单权限',
  `category_auth` text COMMENT '栏目分类权限',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='部门信息表';

#
# Data for table "ct_user_group"
#

/*!40000 ALTER TABLE `ct_user_group` DISABLE KEYS */;
INSERT INTO `ct_user_group` VALUES (1,0,'管理员','','','',1426881003,1427552428,0,1),(3,1,'子公司管理员','fa fa-adjust','1,6,13,89,90,91,92,4,12,85,86,87,88,97,100,122,123,101,98,117,118,121,119,120,99,102,93,94,95,96,103,113,116,114,115',NULL,1459774470,1460467405,0,1);
/*!40000 ALTER TABLE `ct_user_group` ENABLE KEYS */;

#
# Structure for table "ct_user_message"
#

DROP TABLE IF EXISTS `ct_user_message`;
CREATE TABLE `ct_user_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '消息ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '消息父ID',
  `title` varchar(1024) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` text COMMENT '消息内容',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '0系统消息,1评论消息,2私信消息',
  `to_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接收用户ID',
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '私信消息发信用户ID',
  `is_read` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否已读',
  `ctime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `utime` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='用户消息表';

#
# Data for table "ct_user_message"
#

/*!40000 ALTER TABLE `ct_user_message` DISABLE KEYS */;
INSERT INTO `ct_user_message` VALUES (1,0,'3','333',0,23,1,0,1459950239,1459950239,0,1),(2,0,'fsef ','sdvf&nbsp;',0,3,1,1,1459950600,1459950600,0,1),(3,0,'2','2',0,2,1,0,1460036980,1460036980,0,1),(4,0,'543','534',0,54,1,0,1460037075,1460037075,0,1),(5,0,'3fs ','fs&nbsp;',0,3,1,1,1460038001,1460038001,0,1),(6,0,'43','433',0,0,3,0,1460038658,1460038658,0,1),(13,0,'方式','说',0,4,3,0,0,0,0,1),(14,0,'方式','说',0,9,3,0,0,0,0,1),(15,0,'方式','说',0,11,3,0,0,0,0,1),(16,0,'石佛沉砂池','阿斯顿',0,4,3,0,0,0,0,1),(17,0,'石佛沉砂池','阿斯顿',0,9,3,0,0,0,0,1),(18,0,'石佛沉砂池','阿斯顿',0,11,3,0,0,0,0,1),(19,0,'4324','4234',2,5,1,0,1460120394,1460120394,0,1),(21,0,'的地方多的是的方式','vdsvs',0,3,1,1,0,0,0,1),(22,0,'的地方多的是的方式','vdsvs',0,4,1,0,0,0,0,1),(23,0,'的地方多的是的方式','vdsvs',0,5,1,0,0,0,0,1),(24,0,'的地方多的是的方式','vdsvs',0,9,1,0,0,0,0,1),(25,0,'的地方多的是的方式','vdsvs',0,11,1,0,0,0,0,1),(26,0,'得瑟','犯得上',0,3,1,1,1460208020,1460208020,0,1),(27,0,'得瑟','犯得上',0,4,1,0,1460208020,1460208020,0,1),(28,0,'得瑟','犯得上',0,5,1,0,1460208020,1460208020,0,1),(29,0,'得瑟','犯得上',0,9,1,0,1460208020,1460208020,0,1),(30,0,'得瑟','犯得上',0,11,1,0,1460208020,1460208020,0,1),(31,0,'粉丝1','        的我    ',0,3,1,1,1460208056,1460208070,0,1),(32,0,'吃的是草','出生地',0,4,3,0,1460208262,1460208262,0,1),(33,0,'吃的是草','出生地',0,9,3,0,1460208262,1460208262,0,1),(34,0,'吃的是草','出生地',0,11,3,0,1460208262,1460208262,0,1),(35,0,'已同意请假申请','早回',0,4,0,0,1460380157,1460380157,0,1),(36,0,'已同意请假申请','早回',0,4,0,0,1460382993,1460382993,0,1),(37,0,'已同意请假申请','早回',0,4,0,0,1460383205,1460383205,0,1),(38,0,'已同意请假申请','早回',0,4,0,0,1460383398,1460383398,0,1),(39,0,'已同意请假申请','早回',0,4,0,0,1460383450,1460383450,0,1),(40,0,'已同意请假申请','早回',0,4,0,0,1460383647,1460383647,0,1),(41,0,'已同意请假申请','早回',0,4,0,0,1460383800,1460383800,0,1),(42,0,'已同意请假申请','早回',0,4,0,0,1460383911,1460383911,0,1),(43,0,'已同意请假申请','早回',0,4,0,0,1460384003,1460384003,0,1),(44,0,'已同意请假申请','早回',0,4,0,0,1460384070,1460384070,0,1),(45,0,'已同意请假申请','早回',0,4,0,0,1460384247,1460384247,0,1),(46,0,'已同意请假申请','早回',0,4,0,0,1460384359,1460384359,0,1),(47,0,'已同意请假申请','早回',0,4,0,0,1460384417,1460384417,0,1),(48,0,'已同意请假申请','早回',0,4,0,0,1460462837,1460462837,0,1),(49,0,'已同意请假申请','早回',0,4,0,0,1460465441,1460465441,0,1),(50,0,'已同意请假申请','早回',0,4,0,0,1460465592,1460465592,0,1),(51,0,'已同意请假申请','早回',0,4,0,0,1460465747,1460465747,0,1),(52,0,'拒绝了你的请假申请','早回',0,4,0,0,1460465786,1460465786,0,1),(53,0,'已同意请假申请','早回',0,4,0,0,1460465815,1460465815,0,1);
/*!40000 ALTER TABLE `ct_user_message` ENABLE KEYS */;
