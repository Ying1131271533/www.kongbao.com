/*
 Navicat MySQL Data Transfer

 Source Server         : 神织知更
 Source Server Type    : MySQL
 Source Server Version : 50736
 Source Host           : localhost:3306
 Source Schema         : www_kongbao_com

 Target Server Type    : MySQL
 Target Server Version : 50736
 File Encoding         : 65001

 Date: 30/03/2022 17:20:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for address
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `province` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '省',
  `city` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '市',
  `county` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '区',
  `address` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '详细地址',
  `addresser` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发货人',
  `phone` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电话',
  `postcode` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮编',
  `default` tinyint(3) UNSIGNED NOT NULL COMMENT '默认地址 1 = 是 0 = 否',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_address_user1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_address_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of address
-- ----------------------------
INSERT INTO `address` VALUES (1, '广东省', '阳江市', '江城区', '埠场镇山外东', '阿卡丽', '15119498976', '529532', 1, 74);
INSERT INTO `address` VALUES (2, '广东省', '阳江市', '江城区', '埠场镇山外西', '锐雯', '13680638816', '529532', 0, 74);
INSERT INTO `address` VALUES (3, '江苏省', '南京市', '玄武区', '天马山街道解放路121号大洋百货星巴克咖啡', '锐雯', '13680638816', '529564', 0, 81);

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `password` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `status` tinyint(3) UNSIGNED NOT NULL COMMENT '登录状态 1 = 正常 0 = 禁止',
  `real_name` char(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `qq` bigint(19) UNSIGNED NULL DEFAULT NULL COMMENT '联系QQ',
  `login_num` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '登录次数',
  `login_ip` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '登录ip',
  `last_login_time` int(10) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT '上次登录时间',
  `create_time` int(10) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, '神织知更', 'e10adc3949ba59abbe56e057f20f883e', 1, '刘志超', 1131271533, 541, '127.0.0.1', 1648631961, 1560766716);
INSERT INTO `admin` VALUES (3, '艾丝缇布兰雪', '1fe7eb899b5b2e4d9a17a3b1682588c5', 1, '锐雯', 932046899, 24, '127.0.0.1', 1559352640, 1557558655);

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role`  (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`admin_id`, `role_id`) USING BTREE,
  INDEX `fk_admin_has_role_role1_idx`(`role_id`) USING BTREE,
  INDEX `fk_admin_has_role_admin1_idx`(`admin_id`) USING BTREE,
  CONSTRAINT `fk_admin_has_role_admin1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_admin_has_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES (1, 9);
INSERT INTO `admin_role` VALUES (3, 9);
INSERT INTO `admin_role` VALUES (3, 30);
INSERT INTO `admin_role` VALUES (3, 32);

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '审核状态 1 = 通过 0 = 未通过',
  `popularity` int(10) UNSIGNED NOT NULL COMMENT '访问量',
  `sourec_title` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源名称',
  `sourec_url` varchar(1000) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '来源地址',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `type_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `type_id`, `admin_id`) USING BTREE,
  INDEX `fk_article_article_type1_idx`(`type_id`) USING BTREE,
  INDEX `fk_article_admin1_idx`(`admin_id`) USING BTREE,
  CONSTRAINT `fk_article_admin1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_article_article_type1` FOREIGN KEY (`type_id`) REFERENCES `article_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES (3, '阿卡丽', '<p>大家围观的直播</p><p><a href=\"https://live.bilibili.com/10977892\" target=\"_blank\" title=\"正直的上单(超级正直)\" style=\"color: rgb(34, 34, 34); background-color: transparent; text-decoration: none; outline: none; cursor: pointer; transition: color 0.3s; touch-action: manipulation; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"></a></p><p><a href=\"https://live.bilibili.com/10977892\" target=\"_blank\" title=\"正直的上单(超级正直)\" style=\"color: rgb(34, 34, 34); background-color: transparent; text-decoration: none; outline: none; cursor: pointer; transition: color 0.3s; touch-action: manipulation; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><em class=\"pl__icon--live\" style=\"margin: 0px 5px 0px 0px; padding: 0px; border: 0px; vertical-align: middle; display: inline-block; width: 14px; height: 14px; border-radius: 7px; background-color: rgb(242, 93, 142);\"></em><span class=\"pl__live__text\" style=\"margin: 0px; padding: 0px; border: 0px; font-size: 20px; vertical-align: middle; position: static; background-color: transparent; display: inline-block; font-family: Arial, Helvetica, sans-serif; font-weight: 700; line-height: 24px; color: rgb(255, 255, 255);\"></span></a></p><p><a href=\"https://live.bilibili.com/10977892\" target=\"_blank\" title=\"正直的上单(超级正直)\" style=\"color: rgb(34, 34, 34); background-color: transparent; text-decoration: none; outline: none; cursor: pointer; transition: color 0.3s; touch-action: manipulation; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><img alt=\"\" src=\"https://i0.hdslb.com/bfs/live/room_cover/d575c8b2c190146e880fd62df23803911d6994b1.jpg@338w_211h.webp\"/></a></p><p><a href=\"https://live.bilibili.com/10977892\" target=\"_blank\" title=\"正直的上单(超级正直)\" style=\"color: rgb(34, 34, 34); background-color: transparent; text-decoration: none; outline: none; cursor: pointer; transition: color 0.3s; touch-action: manipulation; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\"><img alt=\"\" src=\"https://i2.hdslb.com/bfs/face/9fdb95f87a0286842d667a87e0adf46f37970e72.jpg@48w_48h.webp\"/></a></p><p class=\"pl__title\" style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; border: 0px; font-size: 14px; vertical-align: baseline; text-overflow: ellipsis; white-space: nowrap; overflow: hidden;\"><a href=\"https://live.bilibili.com/10977892\" target=\"_blank\" title=\"正直的上单(超级正直)\" style=\"color: rgb(34, 34, 34); background-color: transparent; text-decoration: none; outline: none; cursor: pointer; transition: color 0.3s; touch-action: manipulation; margin: 0px; padding: 0px; border: 0px; vertical-align: baseline;\">正直的上单(超级正直)</a></p><p></p><p><br/></p>', 1, 0, 'B站', 'https://www.bilibili.com/video/av25357200?from=search&seid=9987368459503931436', 1558688320, 1, 1);
INSERT INTO `article` VALUES (5, '金克丝', '<p><img src=\"/ueditor/php/upload/image/20190524/1558689002494058.jpg\"/></p><br/>', 1, 0, '#湊-阿库娅##虚拟UP主#', 'https://h.bilibili.com/22948494', 1558689037, 2, 1);
INSERT INTO `article` VALUES (6, '简单粗暴，转发加关注即可参与', '<p><img src=\"/ueditor/php/upload/image/20190524/1558689065278639.jpg\"><img src=\"/ueditor/php/upload/image/20190524/1558689066155789.jpg\"><img src=\"/ueditor/php/upload/image/20190524/1558689066236176.jpg\"></p>', 1, 0, 'B站', 'https://h.bilibili.com/21444594', 1558689137, 1, 1);
INSERT INTO `article` VALUES (7, '萝卜酱生日快乐！！！', '<p><a href=\"https://h.bilibili.com/22863738\" target=\"_blank\" class=\"content\" style=\"text-decoration: none; outline: none; display: block; padding-right: 10px; font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" \"microsoft=\"\" yahei\",=\"\" \"hiragino=\"\" sans=\"\" gb\",=\"\" \"heiti=\"\" sc\",=\"\" \"wenquanyi=\"\" micro=\"\" hei\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" letter-spacing:=\"\" 0.5px;=\"\" white-space:=\"\" normal;=\"\" background-color:=\"\" rgb(244,=\"\" 245,=\"\" 247);\"=\"\"></a></p><p><a href=\"https://h.bilibili.com/22863738\" target=\"_blank\" class=\"content\" style=\"text-decoration: none; outline: none; display: block; padding-right: 10px; font-family: \" helvetica=\"\" neue\",=\"\" helvetica,=\"\" arial,=\"\" \"microsoft=\"\" yahei\",=\"\" \"hiragino=\"\" sans=\"\" gb\",=\"\" \"heiti=\"\" sc\",=\"\" \"wenquanyi=\"\" micro=\"\" hei\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" letter-spacing:=\"\" 0.5px;=\"\" white-space:=\"\" normal;=\"\" background-color:=\"\" rgb(244,=\"\" 245,=\"\" 247);\"=\"\">啊啊啊啊啊啊啊啊啊啊啊啊啊啊<br>终于三岁了哦哦哦哦哦哦哦哦哦啊啊啊啊啊<br>今后也会更加更加努力的！！！<br>还请多多关照！！！！！！！！！！！！</a></p><p><img src=\"/ueditor/php/upload/image/20190524/1558690708890656.jpg\"></p><p><br></p><p><img src=\"/static/upload/image/20190529\\07e72863308710e9c54a5b2c068f3b41.jpg\" alt=\"QQ图片20190507134505.jpg\"><br></p><p></p>', 1, 0, 'B站', 'https://h.bilibili.com/22863738', 1558690741, 1, 1);
INSERT INTO `article` VALUES (11, '说了句“呜呼”的镜头留下来了', '<p><a data-v-287b1c34=\"\" href=\"https://h.bilibili.com/23025082\" target=\"_blank\" class=\"content\"></a></p><div data-v-287b1c34=\"\" class=\"content-full\">说了句“呜呼”的镜头留下来了', 1, 0, 'B站', 'https://space.bilibili.com/20813493/dynamic', 1558776864, 1, 1);
INSERT INTO `article` VALUES (14, '谢谢❤️✨！', '<p>							</p><p><br></p><p><a href=\"https://space.bilibili.com/178683495/dynamic\" target=\"_blank\" class=\"username d-i-block\">@宇仁歌:</a></p><p><a href=\"https://h.bilibili.com/22920130\" target=\"_blank\" class=\"content\"></a></p><p><a href=\"https://h.bilibili.com/22920130\" target=\"_blank\" class=\"content\"></a><a href=\"https://t.bilibili.com/topic/name/%E8%90%9D%E5%8D%9C%E5%AD%90%E7%94%9F%E6%97%A5%E4%BC%9A2019/feed\" target=\"_blank\" class=\"dynamic-link-hover-bg\">#萝卜子生日会2019#</a><a href=\"https://space.bilibili.com/20813493/dynamic\" target=\"_blank\" class=\"dynamic-link-hover-bg\">@萝卜子Official</a><br>萝卜子前辈！！！！！！！<br>生日高性能！！！！！！！<br>赶稿在日本23日前提交，真是太好了！<br>铅笔画，真的菜，对不起！！！！</p><p><a class=\"expand-btn\">展开全文</a></p><p><br></p><p><br></p><ul class=\"zoom-list list-none zoom-1 list-paddingleft-2\" style=\"text-align: left;\"><li><p><img src=\"/ueditor/php/upload/image/20190527/1558927230230633.jpg\"></p></li><li><p><img src=\"/static/upload/image/20190529\\44c7550fdfc3e5a9a9cc15ca3d849498.jpg\" alt=\"QQ图片20190504223508.jpg\"><br></p></li></ul><p><br></p><p>						</p>', 1, 0, 'B站', 'https://space.bilibili.com/20813493/dynamic', 1558777571, 1, 1);

-- ----------------------------
-- Table structure for article_type
-- ----------------------------
DROP TABLE IF EXISTS `article_type`;
CREATE TABLE `article_type`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of article_type
-- ----------------------------
INSERT INTO `article_type` VALUES (1, '站内公告', 1558665977);
INSERT INTO `article_type` VALUES (2, '帮助中心', 1558677084);
INSERT INTO `article_type` VALUES (3, '新闻资讯', 1558677096);

-- ----------------------------
-- Table structure for bag
-- ----------------------------
DROP TABLE IF EXISTS `bag`;
CREATE TABLE `bag`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `goods_name` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称',
  `kg` float UNSIGNED NOT NULL COMMENT '重量',
  `time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT '处理状态 0 = 未导出 1 = 已导出 2 = 退单',
  `number` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递单号',
  `sname` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人名称',
  `sprovince` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人省份',
  `scity` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人市',
  `scounty` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人区',
  `saddress` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '详细地址',
  `sphone` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人电话',
  `spostcode` tinyint(6) UNSIGNED NULL DEFAULT 0 COMMENT '收货人邮编',
  `cost_price` double(10, 2) UNSIGNED NOT NULL COMMENT '成本价',
  `price` double(10, 2) UNSIGNED NOT NULL COMMENT '下单价格',
  `waybill` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递单号获取码',
  `onb` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '接口订单号',
  `show` tinyint(4) NOT NULL DEFAULT 1 COMMENT '用户后台是否显示',
  `kd_id` int(10) UNSIGNED NOT NULL COMMENT '快递类型id',
  `user_id` int(10) UNSIGNED NOT NULL COMMENT '会员id',
  `address_id` int(10) UNSIGNED NOT NULL COMMENT '地址id',
  PRIMARY KEY (`id`, `kd_id`, `user_id`, `address_id`) USING BTREE,
  UNIQUE INDEX `number_UNIQUE`(`number`) USING BTREE,
  INDEX `fk_bag_kd1_idx`(`kd_id`) USING BTREE,
  INDEX `fk_bag_user1_idx1`(`user_id`) USING BTREE,
  INDEX `fk_bag_address1_idx`(`address_id`) USING BTREE,
  CONSTRAINT `fk_bag_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bag_kd1` FOREIGN KEY (`kd_id`) REFERENCES `kd` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_bag_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 184 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bag
-- ----------------------------
INSERT INTO `bag` VALUES (2, '皮肤', 5.5, 1560310457, 1, '225011368940', '崔斯塔娜', '广东省', '广州市', '白云区', '岭南大道321号', '13866668888', 0, 1.70, 2.15, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (11, '皮肤', 6.1, 1560329175, 1, '225011368949', '锐雯', '江苏省', '无锡市', '宜兴市', '宜城街道北门巷巷61号新桃园客房4楼808公寓楼收', '13866668888', 0, 1.70, 2.15, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (12, '衣服', 6.1, 1560329309, 1, '225011368950', '金克丝', '江苏省', '无锡市', '宜兴市', '宜城街道北门巷巷61号新桃园客房4楼808公寓楼收', '13866668888', 0, 1.70, 2.15, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (13, '皮肤', 6.1, 1560329339, 1, '225011368951', '锐雯', '江苏省', '无锡市', '宜兴市', '宜城街道北门巷巷61号新桃园客房4楼808公寓楼收', '13866668888', 0, 1.70, 2.15, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (14, '皮肤', 6.1, 1560329429, 2, '225011368952', '锐雯', '江苏省', '无锡市', '宜兴市', '宜城街道北门巷巷61号新桃园客房4楼808公寓楼收', '13866668878', 0, 1.70, 2.15, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (15, '物品', 1, 1561369493, 1, '225011368958', '金克丝', '上海市', '上海市', '徐汇区', '老沪闵路68号天泰大厦', '13866668888', 0, 1.70, 2.30, NULL, NULL, 1, 17, 81, 3);
INSERT INTO `bag` VALUES (18, '物品', 1, 1561692137, 1, '225011368961', '张三', '重庆', '重庆市', '南川区', '水江镇江府壕城5栋2单元1203室', '15088888888', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (19, '物品', 1, 1561692137, 1, '225011368962', '李四', '浙江省', '宁波市', '慈溪市', '白沙路街道宏坚菜市场(快乐购超市)', '15077777777', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (20, '物品', 1, 1561692137, 1, '225011368963', '王五', '北京', '北京市', '海定区', '西四环北路110号', '15066666666', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (21, '物品', 1, 1561692279, 1, '225011368964', '张三', '重庆', '重庆市', '南川区', '水江镇江府壕城5栋2单元1203室', '15088888888', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (22, '物品', 1, 1561692279, 2, '225011368965', '李四', '浙江省', '宁波市', '慈溪市', '白沙路街道宏坚菜市场(快乐购超市)', '15077777777', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (23, '物品', 1, 1561692279, 2, '225011368966', '王五', '北京', '北京市', '海定区', '西四环北路110号', '15066666666', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (120, '物品', 1, 1561787177, 1, '225011369087', '张三', '广东省', '广州市', '白云区', ' 岭南大道321号 结合街道 艾欧尼亚', '13866668888', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (121, '物品', 1, 1561788442, 1, '225011369088', '安然', '河北省', '邯郸市', '邯山区', '河北省 邯郸市 邯山区 河北省邯郸市武安固镇', '19903307477', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (122, '物品', 1, 1561788442, 1, '225011369089', '白燿', '湖北省', '武汉市', '青山区', '湖北省 武汉市 青山区 和平大道987号', '15764382546', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (123, '物品', 1, 1561788442, 1, '225011369090', '贝贝', '四川省', '广元市', '利州区', '四川省 广元市 利州区 四川省广元市利州区宝轮镇', '13096115978', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (124, '物品', 1, 1561788442, 1, '225011369091', '卞永丽', '山西省', '临汾市', '洪洞县', '山西省 临汾市 洪洞县 大槐树镇秦壁村', '13453494635', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (125, '物品', 1, 1561788442, 1, '225011369092', '蔡双双', '江苏省', '常州市', '新北区', '江苏省 常州市 新北区 薛家镇嘉禾尚郡十栋。', '16657042767', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (126, '物品', 1, 1561788442, 1, '225011369093', '曹秀玲', '吉林省', '四平市', '铁西区', '吉林省 四平市 铁西区 十八栋十五号楼', '13089225583', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (127, '物品', 1, 1561788442, 1, '225011369094', '陈超', '江苏省', '镇江市', '京口区', '江苏省 镇江市 京口区 丁卯桥路371号红星美凯龙2楼', '15052940350', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (128, '物品', 1, 1561788442, 1, '225011369095', '陈春莲', '福建省', '厦门市', '思明区', '福建省 厦门市 思明区 洪文路石村', '18859258705', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (129, '物品', 1, 1561788442, 1, '225011369096', '陈会艳', '重庆市', '秀山土家族苗族自治县', '重庆市秀山县龙池镇农贸市场', '重庆市 秀山土家族苗族自治县 重庆市秀山县龙池镇农贸市场', '18290380956', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (130, '物品', 1, 1561788442, 1, '225011369097', '陈淑梅', '山东省', '青岛市', '市北区', '山东省 青岛市 市北区 敦化路38号2号楼1-501', '13589210351', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (131, '物品', 1, 1561788442, 1, '225011369098', '陈斯', '湖北省', '黄冈市', '罗田县', '湖北省 黄冈市 罗田县 大崎镇花河边村七组', '18827220208', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (132, '物品', 1, 1561788442, 1, '225011369099', '陈玉英', '福建省', '福州市', '长乐市', '福建省 福州市 长乐市 金峰镇华阳村福华印染厂', '13609545105', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (133, '物品', 1, 1561788442, 1, '225011369100', '丹丹', '江苏省', '淮安市', '淮安区', '江苏省 淮安市 淮安区 东长街24号金高子百货商行', '18752391551', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (134, '物品', 1, 1561788442, 1, '225011369101', '董静静', '山东省', '德州市', '德城区', '山东省 德州市 德城区 二塑宿舍五号楼', '15965977314', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (135, '物品', 1, 1561788442, 1, '225011369102', '董娜娜', '安徽省', '蚌埠市', '五河县', '安徽省 蚌埠市 五河县 金港湾2号楼', '13956345771', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (136, '物品', 1, 1561788442, 1, '225011369103', '段晓琴', '河北省', '廊坊市', '大城县', '河北省 廊坊市 大城县 旺村镇祖寺村', '15231604900', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (137, '物品', 1, 1561788442, 1, '225011369104', '冯海妹', '河北省', '沧州市', '吴桥县', '河北省 沧州市 吴桥县 河北省沧州市吴桥县桑园镇琦琦婴童店', '15532717136', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (138, '物品', 1, 1561788442, 1, '225011369105', '高钾淇', '河南省', '商丘市', '永城市', '河南省 商丘市 永城市 东方大道永乐花园', '18037733253', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (139, '物品', 1, 1561788442, 1, '225011369106', '宫倩倩', '山东省', '烟台市', '芝罘区', '山东省 烟台市 芝罘区 世裕路89', '18554030229', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (140, '物品', 1, 1561788442, 1, '225011369107', '巩丽', '湖南省', '长沙市', '开福区', '湖南省 长沙市 开福区 东风路77号', '15898566985', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (141, '物品', 1, 1561788442, 1, '225011369108', '韩雅麟', '广东省', '揭阳市', '揭西县', '广东省 揭阳市 揭西县 河婆镇新庙垅禾坪', '18998269010', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (142, '物品', 1, 1561788442, 1, '225011369109', '何禄兰', '四川省', '宜宾市', '宜宾县', '四川省 宜宾市 宜宾县 观音镇迎宾路73', '18224230756', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (143, '物品', 1, 1561788442, 1, '225011369110', '何素', '江苏省', '无锡市', '其他区', '江苏省 无锡市 其他区 南长区东门塘巷142号', '15006198201', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (144, '物品', 1, 1561788442, 1, '225011369111', '胡梅', '河南省', '商丘市', '柘城县', '河南省 商丘市 柘城县 河南省商丘市柘城县邵元乡小李楼村', '18238021527', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (145, '物品', 1, 1561788442, 1, '225011369112', '贾林林', '山西省', '吕梁市', '兴县', '山西省 吕梁市 兴县 原家坪村', '13753153095', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (146, '物品', 1, 1561788442, 1, '225011369113', '江琴', '广东省', '东莞市', '虎门镇', '广东省 东莞市 虎门镇 龙眼新村东三路二十七巷十三号', '15920249438', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (147, '物品', 1, 1561788442, 1, '225011369114', '黎媛清', '广东省', '东莞市', '虎门镇', '广东省 东莞市 虎门镇 赤岗西坊新区六巷六号', '18316510138', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (148, '物品', 1, 1561788442, 1, '225011369115', '李晨', '山东省', '临沂市', '兰山区', '山东省 临沂市 兰山区 北城新区朱夏社区a区8号楼', '18265111255', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (149, '物品', 1, 1561788442, 1, '225011369116', '李慧', '广东省', '东莞市', '长安镇', '广东省 东莞市 长安镇 锦厦社区锦厦新村绵华街12巷11号', '15817284126', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (150, '物品', 1, 1561788442, 1, '225011369117', '李俊卿', '山东省', '潍坊市', '潍城区', '山东省 潍坊市 潍城区 南关街道圣基金色领域', '13455656978', 0, 1.70, 2.10, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (151, '物品', 1, 1561788735, 1, 'B00115806061', '张三峰', '山东省', '临沂市', '兰山区', '山东省 临沂市 兰山区 山东省 临沂市 兰山区 北城新区朱夏社区a区8号楼', '13688888888', 0, 1.70, 2.20, NULL, NULL, 1, 2, 74, 1);
INSERT INTO `bag` VALUES (152, '物品', 1, 1561788857, 1, '336069930000', '张三峰', '山东省', '潍坊市', '潍城区', ' 南关街道圣基金色领域', '13688888888', 0, 1.60, 2.10, NULL, NULL, 1, 46, 74, 1);
INSERT INTO `bag` VALUES (153, '皮肤', 2.3, 1566991666, 3, '225107142006', '神织知更', '广东省', '广州市', '白云区', ' 岭南大道321号', '15119498976', 0, 1.50, 2.15, NULL, NULL, 1, 17, 74, 1);
INSERT INTO `bag` VALUES (154, '物品', 1, 1567482321, 1, '225107142007', '神织恋', '新疆', '阿勒泰地区', '福海县', ' 福海镇医药公司家属楼1楼物流园', '020-8378888', 0, 1.50, 2.15, NULL, NULL, 1, 17, 74, 2);
INSERT INTO `bag` VALUES (155, '砖头', 2.5, 1567752868, 1, '336093210000', '神织恋', '山东省', '济南市', '历城区', ' 华山街道华山珑城A区20号楼菜鸟驿站', '13866668888', 0, 1.50, 2.15, NULL, NULL, 1, 46, 74, 1);
INSERT INTO `bag` VALUES (156, '物品', 1, 1568104980, 1, '7639227500', '姜文才', '江苏省', '常州市', '武进区', ' 遥观镇勤新村工业集中区联翔机械有限公司', '18744206416', 0, 1.30, 1.90, NULL, '156810498071180', 1, 39, 74, 1);
INSERT INTO `bag` VALUES (157, '物品', 1.9, 1568108696, 1, '822801831764', '李永鑫', '广东省', '潮州市', '潮安县', ' 龙湖镇鹳巣鹳四路口鑫德烟行', '13553717046', 0, 1.50, 2.35, NULL, '156810869613523', 1, 2, 74, 1);
INSERT INTO `bag` VALUES (168, '物品', 1, 1568120538, 1, '781404690960646988', '张三', '上海市', '上海市', '宝山区', ' 淞南镇淞良路10号', '18616596467', 0, 0.90, 1.90, NULL, '156812053859624', 1, 31, 74, 1);
INSERT INTO `bag` VALUES (175, '物品', 1, 1568166908, 1, '7639227503', '欧龙龙', '江苏省', '常州市', '武进区', ' 遥观镇勤新村工业集中区联翔机械有限公司', '13394979960', 0, 1.30, 1.90, NULL, '156816690825255', 1, 39, 74, 1);
INSERT INTO `bag` VALUES (176, '物品', 1, 1568166908, 1, '7639227504', '姜文才', '吉林省', '吉林市', '昌邑区', ' 晨辉收购站', '18744206416', 0, 1.30, 1.90, NULL, '156816690825255', 1, 39, 74, 1);
INSERT INTO `bag` VALUES (177, '物品', 1, 1568166908, 2, '7639227505', '李永鑫', '广东省', '潮州市', '潮安县', ' 龙湖镇鹳巣鹳四路口鑫德烟行', '13553717046', 0, 1.30, 1.90, NULL, '156816690825255', 1, 39, 74, 1);
INSERT INTO `bag` VALUES (178, '物品', 1, 1568167145, 1, '224212990000', '任先生', '天津市', '天津市', '宁河区', ' 幸福广场七色花', '15602037423', 0, 0.90, 1.80, NULL, '156816714572000', 1, 44, 74, 1);
INSERT INTO `bag` VALUES (179, '物品', 1, 1568180891, 0, '224212987319', '代振艳', '天津市', '天津市', '静海区', ' 天津市静海县唐官屯镇渤海超市对面', '15222726268', 0, 0.90, 1.90, NULL, '156818089172189', 1, 32, 74, 1);
INSERT INTO `bag` VALUES (180, '物品', 1, 1568180891, 0, '224212987320', '张丙玲', '江西省', '九江市', '武宁县', ' 富安小区1期12栋601室', '15170930899', 0, 0.90, 1.90, NULL, '156818089172189', 1, 32, 74, 1);
INSERT INTO `bag` VALUES (181, '物品', 1, 1568180918, 0, '7929440010', '彭露', '广东省', '汕头市', '潮阳区', ' 新和新虹城虹中大道50号', '15817969398', 0, 1.00, 1.90, NULL, '156818091884338', 1, 22, 74, 1);
INSERT INTO `bag` VALUES (182, '物品', 1, 1568260012, 0, '822801831768', '张三', '广东省', '广州市', '白云区', ' 岭南大道321号', '13866668888', 0, 1.50, 2.35, NULL, '156826001246041', 1, 2, 74, 1);
INSERT INTO `bag` VALUES (183, '物品', 1, 1568260141, 0, '224212987321', '张三', '广东省', '广州市', '白云区', ' 岭南大道321号', '13866668888', 0, 0.90, 1.90, NULL, '156826014142490', 1, 32, 74, 1);

-- ----------------------------
-- Table structure for kd
-- ----------------------------
DROP TABLE IF EXISTS `kd`;
CREATE TABLE `kd`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递名称',
  `kd_api` tinyint(5) UNSIGNED NOT NULL COMMENT '快递api接口id',
  `explain` char(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '快递描述',
  `image` char(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递logo图片',
  `status` tinyint(2) UNSIGNED NOT NULL COMMENT '使用状态 1 = 正常 0 = 暂停',
  `api_pattern` tinyint(2) UNSIGNED NOT NULL COMMENT 'api 模式 1=普通模式 2=API模式',
  `apitype` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '接口标识',
  `ms` tinyint(2) UNSIGNED NOT NULL COMMENT '单个多个状态 1=单个 2=多个 3=都可以',
  `exp_id` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '导出模板ID',
  `sort_order` tinyint(3) UNSIGNED NULL DEFAULT NULL COMMENT '排序',
  `type` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '状态',
  `last_down_time` int(10) UNSIGNED NOT NULL COMMENT '上次导出单号时间',
  `level1` double(10, 2) UNSIGNED NOT NULL COMMENT '普通会员价格',
  `level2` double(10, 2) UNSIGNED NOT NULL COMMENT '黄金会员价格',
  `level3` double(10, 2) UNSIGNED NOT NULL COMMENT '铂金会员价格',
  `level4` double(10, 2) UNSIGNED NOT NULL COMMENT '钻石会员价格',
  `cost_price` double(10, 2) UNSIGNED NOT NULL COMMENT '成本价',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of kd
-- ----------------------------
INSERT INTO `kd` VALUES (2, '圆通快递(淘宝天猫)', 2, '圆通快递（支持淘宝/天猫）全国发全国，官网和淘宝都有物流记录，物流完美。', '/static/upload/image/20190531\\be0f7cb68f6be5f31cc6ab87844fa253.JPG', 1, 1, '淘宝圆通', 3, NULL, 2, 1, 0, 2.50, 2.40, 2.35, 2.20, 1.00, 1567751909);
INSERT INTO `kd` VALUES (11, '安能快递(淘宝天猫)', 11, '安能快递（支持淘宝天猫）全国发全国，官网和京东都有物流记录，物流完美。', '/static/upload/image/20190529\\8f51bb1fd1aea127b91c131b0f5943fa.png', 1, 0, '淘宝安能', 2, NULL, 88, 0, 0, 2.10, 2.00, 1.90, 1.80, 1.25, 1567752795);
INSERT INTO `kd` VALUES (17, '申通快递(淘宝天猫)', 17, '申通快递（支持淘宝/天猫）全国发全国，官网和淘宝都有物流记录，物流完美。', '/static/upload/image/20190529\\87ff826e8140c1b6742dd46ee6f65143.jpg', 1, 1, '淘宝申通', 3, NULL, 1, 1, 1559110049, 2.30, 2.20, 2.15, 2.10, 1.10, 1566205267);
INSERT INTO `kd` VALUES (22, '国通快递(京东)', 22, '国通快递（京东专用）全国发全国，官网和京东都有物流记录，物流完美。', '/static/upload/image/20190531\\9a79bcad1533149685fbdc874cf12fac.jpg', 1, 0, '京东国通', 3, NULL, 5, 1, 0, 2.10, 2.00, 1.90, 1.80, 0.67, 1567751941);
INSERT INTO `kd` VALUES (31, '圆通快递(拼多多电子单)', 31, '圆通快递（拼多多电子单）支持拼多多，官网和淘宝都有物流记录，物流完美。', '/static/upload/image/20190529\\c71316c3868467169a6e8a539007dde5.jpg', 1, 0, '拼多多圆通电子单', 3, NULL, 35, 1, 0, 2.10, 2.00, 1.90, 1.80, 1.10, 1567752831);
INSERT INTO `kd` VALUES (32, '申通快递(京东)', 32, '申通快递（京东专用）全国发全国，官网和京东都有物流记录，物流完美。', '/static/upload/image/20190531\\50d40cc22aa83e449626e84913295ec7.gif', 1, 0, '京东申通', 3, NULL, 4, 1, 0, 2.10, 2.00, 1.90, 1.80, 1.10, 1567751931);
INSERT INTO `kd` VALUES (39, '国通快递(淘宝天猫)', 39, '国通快递（淘宝/天猫/阿里）全国发全国，官网和淘宝都有物流记录，物流完美。', '/static/upload/image/20190529\\2ae74e0973d075a289950da6279c56a1.jpg', 1, 0, '淘宝国通', 3, NULL, 3, 1, 0, 2.10, 2.00, 1.90, 1.80, 1.52, 1567751919);
INSERT INTO `kd` VALUES (44, '申通快递(拼多多专用)', 44, '申通快递（拼多多专用）全国发全国，快递官网和拼多多都有物流记录，物流完美。', '/static/upload/image/20190531\\7af3fccb434631648ad582e5eb0366a7.jpg', 1, 0, '拼多多申通', 3, NULL, 6, 1, 0, 2.00, 1.90, 1.80, 1.70, 1.08, 1559292813);
INSERT INTO `kd` VALUES (45, '百世快递(拼多多电子单)', 45, '百世快递（拼多多电子单）全国发全国，快递官网和拼多多都有物流记录，物流完美。', '/static/upload/image/20190531\\d68006459b29547e50db05caecc20b19.jpg', 1, 0, '拼多多百世电子单', 3, NULL, 8, 1, 0, 1.50, 1.40, 1.30, 1.20, 0.55, 1567752517);
INSERT INTO `kd` VALUES (46, '百世快递(淘宝天猫)', 46, '百世快递（支持淘宝/天猫/阿里）全国发全国，官网和淘宝都有物流记录，物流完美。', '/static/upload/image/20190531\\d7166ea6bb5d6181f85f2d8fb9264cb0.jpg', 1, 1, '淘宝百世', 3, NULL, 2, 1, 0, 2.30, 2.20, 2.15, 2.10, 1.00, 1567751892);
INSERT INTO `kd` VALUES (47, '百世快递(拼多多专用)', 0, '百世快递（拼多多专用）全国发全国，快递官网和拼多多都有物流记录，物流完美。', '/static/upload/image/20190531\\5d64831803ea707644d95931d788e9f2.jpg', 1, 0, '拼多多百世', 3, NULL, 7, 1, 0, 2.00, 1.90, 1.80, 1.70, 0.62, 1567751963);

-- ----------------------------
-- Table structure for link
-- ----------------------------
DROP TABLE IF EXISTS `link`;
CREATE TABLE `link`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `url` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '地址',
  `weight` tinyint(3) UNSIGNED NOT NULL COMMENT '权重',
  `create_time` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of link
-- ----------------------------
INSERT INTO `link` VALUES (6, '11111', '22222', 1, 1559722924);
INSERT INTO `link` VALUES (7, '51kbao', 'www.baidu.com', 51, 1559722945);
INSERT INTO `link` VALUES (8, '1688', 'www.1688.com', 1, 1559724781);

-- ----------------------------
-- Table structure for mingxi
-- ----------------------------
DROP TABLE IF EXISTS `mingxi`;
CREATE TABLE `mingxi`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `money` double(10, 2) UNSIGNED NOT NULL COMMENT '金额',
  `status` tinyint(2) UNSIGNED NOT NULL COMMENT '状态 1=减 2=加',
  `type` tinyint(2) UNSIGNED NOT NULL COMMENT '类型 1= 买空包 其他类型请查看function',
  `zmoney` double(10, 2) UNSIGNED NOT NULL COMMENT '会员总金额',
  `ip` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建ip',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_mingxi_user1_idx1`(`user_id`) USING BTREE,
  CONSTRAINT `fk_mingxi_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 366 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of mingxi
-- ----------------------------
INSERT INTO `mingxi` VALUES (272, 500.00, 2, 3, 501.00, '127.0.0.1', 1559372968, 100);
INSERT INTO `mingxi` VALUES (273, 500.00, 2, 3, 1001.00, '127.0.0.1', 1559372971, 100);
INSERT INTO `mingxi` VALUES (274, 500.00, 2, 3, 1501.00, '127.0.0.1', 1559372974, 100);
INSERT INTO `mingxi` VALUES (275, 500.00, 2, 3, 2001.00, '127.0.0.1', 1559373106, 100);
INSERT INTO `mingxi` VALUES (276, 500.00, 2, 3, 501.00, '127.0.0.1', 1559374214, 100);
INSERT INTO `mingxi` VALUES (277, 501.00, 2, 3, 1002.00, '127.0.0.1', 1559374282, 100);
INSERT INTO `mingxi` VALUES (288, 21.00, 1, 4, 981.00, '127.0.0.1', 1559526154, 100);
INSERT INTO `mingxi` VALUES (289, 500.00, 1, 4, 460.00, '127.0.0.1', 1559534061, 100);
INSERT INTO `mingxi` VALUES (303, 50.00, 1, 4, 150.00, '127.0.0.1', 1559543823, 70);
INSERT INTO `mingxi` VALUES (304, 50.00, 1, 4, 100.00, '127.0.0.1', 1559544956, 70);
INSERT INTO `mingxi` VALUES (306, 10.00, 1, 4, 90.00, '127.0.0.1', 1559545512, 70);
INSERT INTO `mingxi` VALUES (308, 100.00, 2, 3, 100.00, '127.0.0.1', 1559610755, 100);
INSERT INTO `mingxi` VALUES (309, 501.00, 2, 3, 601.00, '127.0.0.1', 1559610775, 100);
INSERT INTO `mingxi` VALUES (310, 500.00, 2, 3, 1101.00, '127.0.0.1', 1559610778, 100);
INSERT INTO `mingxi` VALUES (311, 6.00, 2, 9, 682.00, '127.0.0.1', 1559720655, 70);
INSERT INTO `mingxi` VALUES (314, 2.15, 1, 1, 5255.95, '127.0.0.1', 1560329175, 74);
INSERT INTO `mingxi` VALUES (315, 2.15, 1, 1, 5253.80, '127.0.0.1', 1560329309, 74);
INSERT INTO `mingxi` VALUES (316, 2.15, 1, 1, 5251.65, '127.0.0.1', 1560329339, 74);
INSERT INTO `mingxi` VALUES (317, 2.15, 1, 1, 5249.50, '127.0.0.1', 1560329429, 74);
INSERT INTO `mingxi` VALUES (318, 2.15, 2, 10, 5251.65, '127.0.0.1', 1560420119, 74);
INSERT INTO `mingxi` VALUES (319, 2.15, 2, 10, 5253.80, '127.0.0.1', 1560420185, 74);
INSERT INTO `mingxi` VALUES (320, 2.15, 2, 10, 5255.95, '127.0.0.1', 1560420417, 74);
INSERT INTO `mingxi` VALUES (321, 4.30, 2, 10, 680.30, '127.0.0.1', 1561188244, 70);
INSERT INTO `mingxi` VALUES (322, 4.30, 2, 10, 5268.85, '127.0.0.1', 1561188444, 74);
INSERT INTO `mingxi` VALUES (323, 8.60, 2, 10, 5281.75, '127.0.0.1', 1561363850, 74);
INSERT INTO `mingxi` VALUES (324, 2.30, 1, 1, 17.70, '127.0.0.1', 1561369493, 81);
INSERT INTO `mingxi` VALUES (325, 2.30, 1, 1, 15.40, '127.0.0.1', 1561369505, 81);
INSERT INTO `mingxi` VALUES (326, 2.50, 1, 1, 12.90, '127.0.0.1', 1561370063, 81);
INSERT INTO `mingxi` VALUES (327, 4.80, 2, 10, 22.50, '127.0.0.1', 1561432202, 81);
INSERT INTO `mingxi` VALUES (328, 2.30, 2, 10, 20.00, '127.0.0.1', 1561433748, 81);
INSERT INTO `mingxi` VALUES (329, 2.30, 2, 10, 22.30, '127.0.0.1', 1561434073, 81);
INSERT INTO `mingxi` VALUES (330, 4.80, 2, 10, 31.90, '127.0.0.1', 1561434570, 81);
INSERT INTO `mingxi` VALUES (331, 2.50, 2, 10, 32.10, '127.0.0.1', 1561435061, 81);
INSERT INTO `mingxi` VALUES (332, 2.30, 2, 10, 34.20, '127.0.0.1', 1561435098, 81);
INSERT INTO `mingxi` VALUES (333, 2.30, 2, 10, 34.20, '127.0.0.1', 1561435212, 81);
INSERT INTO `mingxi` VALUES (334, 2.15, 2, 10, 202.15, '127.0.0.1', 1561449907, 74);
INSERT INTO `mingxi` VALUES (335, 2.15, 2, 10, 204.30, '127.0.0.1', 1561450240, 74);
INSERT INTO `mingxi` VALUES (336, 2.15, 2, 10, 206.45, '127.0.0.1', 1561451591, 74);
INSERT INTO `mingxi` VALUES (337, 4.30, 2, 10, 215.05, '127.0.0.1', 1561451650, 74);
INSERT INTO `mingxi` VALUES (338, 2.50, 2, 10, 36.70, '127.0.0.1', 1561451954, 81);
INSERT INTO `mingxi` VALUES (339, 4.60, 2, 10, 41.30, '127.0.0.1', 1561451999, 81);
INSERT INTO `mingxi` VALUES (340, 6.30, 1, 1, 204.45, '127.0.0.1', 1561692137, 74);
INSERT INTO `mingxi` VALUES (341, 6.30, 1, 1, 198.15, '127.0.0.1', 1561692279, 74);
INSERT INTO `mingxi` VALUES (342, 2.10, 1, 1, 196.05, '127.0.0.1', 1561787177, 74);
INSERT INTO `mingxi` VALUES (343, 63.00, 1, 1, 133.05, '127.0.0.1', 1561788442, 74);
INSERT INTO `mingxi` VALUES (344, 2.20, 1, 1, 130.85, '127.0.0.1', 1561788735, 74);
INSERT INTO `mingxi` VALUES (345, 2.10, 1, 1, 128.75, '127.0.0.1', 1561788857, 74);
INSERT INTO `mingxi` VALUES (346, 188.00, 1, 1, 4812.00, '127.0.0.1', 1562138105, 74);
INSERT INTO `mingxi` VALUES (347, 188.00, 1, 1, 4624.00, '127.0.0.1', 1562138120, 74);
INSERT INTO `mingxi` VALUES (348, 188.00, 1, 1, 4436.00, '127.0.0.1', 1562138153, 74);
INSERT INTO `mingxi` VALUES (349, 388.00, 1, 1, 4048.00, '127.0.0.1', 1562138437, 74);
INSERT INTO `mingxi` VALUES (350, 2.15, 1, 1, 4045.85, '127.0.0.1', 1566991666, 74);
INSERT INTO `mingxi` VALUES (351, 2.15, 1, 1, 4043.70, '127.0.0.1', 1567482321, 74);
INSERT INTO `mingxi` VALUES (352, 2.15, 1, 1, 4041.55, '127.0.0.1', 1567752868, 74);
INSERT INTO `mingxi` VALUES (353, 2.15, 2, 10, 4043.70, '127.0.0.1', 1567752903, 74);
INSERT INTO `mingxi` VALUES (354, 1.90, 1, 1, 4041.80, '127.0.0.1', 1568104980, 74);
INSERT INTO `mingxi` VALUES (355, 2.35, 1, 1, 4039.45, '127.0.0.1', 1568108697, 74);
INSERT INTO `mingxi` VALUES (357, 1.90, 1, 1, 4037.55, '127.0.0.1', 1568120538, 74);
INSERT INTO `mingxi` VALUES (359, 5.70, 1, 1, 4031.85, '127.0.0.1', 1568166908, 74);
INSERT INTO `mingxi` VALUES (360, 1.80, 1, 1, 4030.05, '127.0.0.1', 1568167145, 74);
INSERT INTO `mingxi` VALUES (361, 1.90, 2, 10, 4031.95, '127.0.0.1', 1568173461, 74);
INSERT INTO `mingxi` VALUES (362, 3.80, 1, 1, 4028.15, '127.0.0.1', 1568180892, 74);
INSERT INTO `mingxi` VALUES (363, 1.90, 1, 1, 4026.25, '127.0.0.1', 1568180918, 74);
INSERT INTO `mingxi` VALUES (364, 2.35, 1, 1, 4023.90, '127.0.0.1', 1568260013, 74);
INSERT INTO `mingxi` VALUES (365, 1.90, 1, 1, 4022.00, '127.0.0.1', 1568260141, 74);

-- ----------------------------
-- Table structure for node
-- ----------------------------
DROP TABLE IF EXISTS `node`;
CREATE TABLE `node`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `level` tinyint(3) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `show` tinyint(3) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL,
  `icon` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'layui图标名称',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name_UNIQUE`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 107 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of node
-- ----------------------------
INSERT INTO `node` VALUES (11, 'admin', '管理员管理', 1, 0, 1, 2, 'username');
INSERT INTO `node` VALUES (12, 'admin/node_add', '节点添加', 2, 11, 2, 9, '');
INSERT INTO `node` VALUES (13, 'admin/node', '节点列表', 2, 11, 1, 10, '');
INSERT INTO `node` VALUES (14, 'admin/node_edit', '节点修改', 2, 11, 2, 11, '');
INSERT INTO `node` VALUES (15, 'admin/node_del', '节点删除', 2, 11, 2, 12, '');
INSERT INTO `node` VALUES (16, 'user', '会员管理', 1, 0, 1, 3, 'user');
INSERT INTO `node` VALUES (17, 'user/index', '会员列表', 2, 16, 1, 1, '');
INSERT INTO `node` VALUES (18, 'pay/index', '会员充值', 2, 16, 1, 20, '');
INSERT INTO `node` VALUES (20, 'tixian/index', '会员提现', 2, 16, 1, 40, '');
INSERT INTO `node` VALUES (21, 'mingxi/index', '资金明细', 2, 16, 2, 50, '');
INSERT INTO `node` VALUES (22, 'bag', '空包', 1, 0, 1, 4, 'layouts');
INSERT INTO `node` VALUES (23, 'bag/index', '空包列表', 2, 22, 1, 1, '');
INSERT INTO `node` VALUES (25, 'order/index', '底单列表', 2, 22, 1, 3, '');
INSERT INTO `node` VALUES (26, 'Kd/index', '快递公司', 2, 22, 1, 40, '');
INSERT INTO `node` VALUES (28, 'article', '文章', 1, 0, 1, 5, 'list');
INSERT INTO `node` VALUES (29, 'article/index', '文章列表', 2, 28, 1, 2, '');
INSERT INTO `node` VALUES (30, 'article/add', '发布文章', 2, 28, 2, 1, '');
INSERT INTO `node` VALUES (31, 'operation', '运营', 1, 0, 1, 6, 'release');
INSERT INTO `node` VALUES (32, 'home', '主页', 1, 0, 1, 1, 'home');
INSERT INTO `node` VALUES (33, 'home/center', '数据中心', 2, 32, 1, 1, '');
INSERT INTO `node` VALUES (35, 'vip/index', '设置会员价格', 2, 31, 1, 1, '');
INSERT INTO `node` VALUES (36, 'link/index', '友情链接', 2, 31, 1, 20, '');
INSERT INTO `node` VALUES (37, 'Admin/index', '管理员列表', 2, 11, 1, 2, '');
INSERT INTO `node` VALUES (38, 'admin/admin_add', '管理员添加', 2, 11, 2, 1, '');
INSERT INTO `node` VALUES (39, 'admin/admin_edit', '管理员修改', 2, 11, 2, 3, '');
INSERT INTO `node` VALUES (40, 'amdin/admin_del', '管理员删除', 2, 11, 2, 4, '');
INSERT INTO `node` VALUES (41, 'admin/role', '角色列表', 2, 11, 1, 6, '');
INSERT INTO `node` VALUES (42, 'admin/role_add', '角色添加', 2, 11, 2, 5, '');
INSERT INTO `node` VALUES (43, 'admin/role_edit', '角色修改', 2, 11, 2, 7, '');
INSERT INTO `node` VALUES (44, 'admin/admin_del', '角色删除', 2, 11, 2, 8, '');
INSERT INTO `node` VALUES (45, 'admin/role_auth', '权限分配', 2, 11, 2, 13, '');
INSERT INTO `node` VALUES (49, 'vip/vip_update', '修改会员价格', 2, 31, 2, 2, '');
INSERT INTO `node` VALUES (51, 'kd/add', '快递添加', 2, 22, 2, 42, '');
INSERT INTO `node` VALUES (53, 'kd/edit', '快递修改', 2, 22, 2, 44, '');
INSERT INTO `node` VALUES (54, 'kd/del', '快递删除', 2, 22, 2, 45, '');
INSERT INTO `node` VALUES (55, 'link/link_add', '友情链接添加页面', 2, 31, 2, 21, '');
INSERT INTO `node` VALUES (56, 'link/link_adds', '友情链接添加', 2, 31, 2, 22, '');
INSERT INTO `node` VALUES (57, 'link/link_edit', '友情链接修改页面', 2, 31, 2, 23, '');
INSERT INTO `node` VALUES (58, 'link/link_update', '友情链接修改', 2, 31, 2, 24, '');
INSERT INTO `node` VALUES (59, 'link/link_del', '友情链接删除', 2, 31, 2, 25, '');
INSERT INTO `node` VALUES (61, 'user/add', '会员添加', 2, 16, 2, 3, '');
INSERT INTO `node` VALUES (63, 'user/edit', '会员修改', 2, 16, 2, 5, '');
INSERT INTO `node` VALUES (67, 'user/index_data', '会员数据', 2, 16, 2, 7, '');
INSERT INTO `node` VALUES (68, 'mingxi/index_data', '资金明细数据', 2, 16, 2, 51, '');
INSERT INTO `node` VALUES (70, 'article/type', '文章分类列表', 2, 28, 1, 22, '');
INSERT INTO `node` VALUES (71, 'article/type_add', '分类添加', 2, 28, 2, 21, '');
INSERT INTO `node` VALUES (72, 'article/type_edit', '文章分类修改', 2, 28, 2, 23, '');
INSERT INTO `node` VALUES (73, 'article/type_del', '文章分类删除', 2, 28, 2, 24, '');
INSERT INTO `node` VALUES (74, 'article/edit', '文章修改', 2, 28, 2, 3, '');
INSERT INTO `node` VALUES (75, 'article/del', '文章删除', 2, 28, 2, 4, '');
INSERT INTO `node` VALUES (77, 'reward/index', '邀请好友奖励', 2, 22, 1, 50, '');
INSERT INTO `node` VALUES (79, 'article/index_data', '文章数据', 2, 28, 2, 5, '');
INSERT INTO `node` VALUES (81, 'pay/index_data', '会员充值数据', 2, 16, 2, 21, '');
INSERT INTO `node` VALUES (82, 'pay/edit', '会员充值审核通过', 2, 16, 2, 22, '');
INSERT INTO `node` VALUES (84, 'upload', '上传文件', 1, 0, 2, 7, 'upload-circle');
INSERT INTO `node` VALUES (85, 'upload/upload_img', '上传单张图片', 2, 84, 2, 1, '');
INSERT INTO `node` VALUES (86, 'upload/upload_layui', 'layui富文本图片上传', 2, 84, 2, 3, '');
INSERT INTO `node` VALUES (87, 'upload/upload_imgs', '多张图片上传', 2, 84, 2, 2, '');
INSERT INTO `node` VALUES (88, 'reward/index_data', '邀请好友奖励数据', 2, 22, 2, 51, '');
INSERT INTO `node` VALUES (89, 'reward/edit', '邀请奖励审核发放', 2, 22, 2, 53, '');
INSERT INTO `node` VALUES (91, 'tixian/index_data', '会员提现数据', 2, 16, 2, 41, '');
INSERT INTO `node` VALUES (92, 'tixian/edit', '会员提现审核通过', 2, 16, 2, 42, '');
INSERT INTO `node` VALUES (97, 'tixian/tixian_edit', '会员提现审核不通过', 2, 16, 2, 43, '');
INSERT INTO `node` VALUES (98, 'pay/pay_edit', '会员充值审核不通过', 2, 16, 2, 23, '');
INSERT INTO `node` VALUES (102, 'pays/index', '支付宝充值记录', 2, 16, 1, 52, '');
INSERT INTO `node` VALUES (103, 'pays/index_data', '支付宝充值记录数据', 2, 16, 2, 53, '');
INSERT INTO `node` VALUES (104, 'link/index_data', '友情链接列表数据', 2, 31, 2, 21, '');
INSERT INTO `node` VALUES (105, 'home/info', '管理员信息', 2, 32, 1, 2, '');
INSERT INTO `node` VALUES (106, 'admin/node_tree', '节点树形图', 2, 11, 1, 10, '');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递单号',
  `kdname` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '快递名称',
  `fname` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发货人名称',
  `fphone` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发货人电话',
  `faddress` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发货人地址',
  `sname` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人名称',
  `sphone` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人电话',
  `saddress` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '收货人地址',
  `goods_name` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商铺名称',
  `kg` float UNSIGNED ZEROFILL NOT NULL COMMENT '重量',
  `image` char(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '降权截图',
  `status` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT '状态 1=未处理 2=已处理 3=拒绝',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '处理内容 - 例如上传的底单',
  `ftime` int(11) UNSIGNED ZEROFILL NOT NULL COMMENT '发货日期',
  `dispose_time` int(11) UNSIGNED ZEROFILL NULL DEFAULT NULL COMMENT '处理时间',
  `create_time` int(11) UNSIGNED ZEROFILL NOT NULL COMMENT '申请时间',
  `user_id` int(10) UNSIGNED NOT NULL,
  `kd_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`, `kd_id`) USING BTREE,
  UNIQUE INDEX `number_UNIQUE`(`number`) USING BTREE,
  INDEX `fk_order_user1_idx1`(`user_id`) USING BTREE,
  INDEX `fk_order_kd1_idx`(`kd_id`) USING BTREE,
  CONSTRAINT `fk_order_kd1` FOREIGN KEY (`kd_id`) REFERENCES `kd` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES (6, '336069930000', '百世快递(淘宝天猫)', '阿卡丽', '15119498976', '广东省阳江市江城区埠场镇山外东', '张三峰', '13688888888', ' 南关街道圣基金色领域', '物品', 000000000001, '/static/upload/image/20190702\\\\33293bbaebb262a72ef378514e2cd5f6.JPG', 02, '<img src=\"/static/upload/image/20190702\\8093bf2966ed6d81c43d4d3e3c2d4e02.JPG\" alt=\"革命机valvrave 3_2014821234720.JPG\">', 01561737600, 01562060746, 01562060411, 74, 46);
INSERT INTO `order` VALUES (7, 'B00115806061', '圆通快递(淘宝天猫)', '阿卡丽', '15119498976', '广东省阳江市江城区埠场镇山外东', '张三峰', '13688888888', '山东省 临沂市 兰山区 山东省 临沂市 兰山区 北城新区朱夏社区a区8号楼', '物品', 000000000001, '/static/upload/image/20190702\\6fe52cbf19fe2ffbc36b4618d5684add.jpg', 02, '<img src=\"/static/upload/order/20190702\\dd754bbc96f62d7c5dcdac6678108b12.jpg\" alt=\"\" />', 01561737600, NULL, 01562061039, 74, 2);
INSERT INTO `order` VALUES (8, '225011369117', '申通快递(淘宝天猫)', '阿卡丽', '15119498976', '广东省阳江市江城区埠场镇山外东', '李俊卿', '13455656978', '山东省 潍坊市 潍城区 南关街道圣基金色领域', '物品', 000000000001, '/static/upload/image/20190702\\e1160545957a93615db190f5c25a4b93.JPG', 02, '<img src=\"/static/upload/order/20190702\\f66cfa4bc4d1394eb54436651af070fa.jpg\" alt=\"\" />', 01561737600, NULL, 01562061083, 74, 17);

-- ----------------------------
-- Table structure for pay
-- ----------------------------
DROP TABLE IF EXISTS `pay`;
CREATE TABLE `pay`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1=未审核 2=审核 3=失败',
  `order` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `money` double(10, 2) UNSIGNED NOT NULL COMMENT '充值金额',
  `msg` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `check_time` int(10) UNSIGNED NULL DEFAULT NULL COMMENT '审核时间',
  `ip` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提交ip',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '充值时间',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  UNIQUE INDEX `order_UNIQUE`(`order`) USING BTREE,
  INDEX `fk_pay_user1_idx1`(`user_id`) USING BTREE,
  CONSTRAINT `fk_pay_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 87 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pay
-- ----------------------------
INSERT INTO `pay` VALUES (77, 1, '1234567890123456789012345679', 500.00, '', 1559368109, '127.0.0.1', 1559368101, 100);
INSERT INTO `pay` VALUES (78, 1, '1234567890123456789012345671', 500.00, '', 1559368305, '127.0.0.1', 1559368299, 100);
INSERT INTO `pay` VALUES (79, 1, '1234567890123456789012345672', 900.00, '', 1559368389, '127.0.0.1', 1559368385, 100);
INSERT INTO `pay` VALUES (80, 3, '1234567890123456789012345674', 1000.00, '', 1559705372, '127.0.0.1', 1559368441, 100);
INSERT INTO `pay` VALUES (81, 3, '1234567890123456789012345676', 500.00, '', 1559636874, '127.0.0.1', 1559368786, 100);
INSERT INTO `pay` VALUES (82, 3, '1234567890123456789012345678', 100.00, '', 1559636761, '127.0.0.1', 1559369068, 100);
INSERT INTO `pay` VALUES (83, 3, '1234567890123456789012345612', 100.00, '', 1559635491, '127.0.0.1', 1559369929, 70);
INSERT INTO `pay` VALUES (84, 3, '1234567890123456789012345698', 500.00, '', 1559610786, '127.0.0.1', 1559373074, 100);
INSERT INTO `pay` VALUES (85, 2, '7458965854784848458520202025', 500.00, '', 1559610778, '127.0.0.1', 1559374190, 100);
INSERT INTO `pay` VALUES (86, 2, '1234567890123456789012345611', 501.00, '', 1559610775, '127.0.0.1', 1559374273, 100);

-- ----------------------------
-- Table structure for pays
-- ----------------------------
DROP TABLE IF EXISTS `pays`;
CREATE TABLE `pays`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1=未认领 2=已认领',
  `order` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '订单号',
  `money` double(10, 2) UNSIGNED NOT NULL COMMENT '充值金额',
  `explain` char(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '说明',
  `ps` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '备注',
  `ip` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '提交ip',
  `create_time` int(11) NOT NULL COMMENT '充值时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_UNIQUE`(`order`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of pays
-- ----------------------------
INSERT INTO `pays` VALUES (1, 1, '20190605170040', 200.00, '', '速度审核', '127.0.0.1', 1559541576);
INSERT INTO `pays` VALUES (2, 1, '2019060522001495561041678047', 50.00, NULL, NULL, '223.88.236.2', 1559541572);

-- ----------------------------
-- Table structure for reward
-- ----------------------------
DROP TABLE IF EXISTS `reward`;
CREATE TABLE `reward`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `xuid` int(10) UNSIGNED NOT NULL COMMENT '下线会员ID',
  `consume_money` double(10, 2) UNSIGNED NOT NULL COMMENT '需要消费金额',
  `jd_money` double(10, 2) UNSIGNED NOT NULL COMMENT '解冻所需金额',
  `pay_money` double(10, 2) UNSIGNED NOT NULL COMMENT '充值金额',
  `status` tinyint(2) UNSIGNED NOT NULL COMMENT '状态 1=未处理 2=已经处理',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `dispose_time` int(10) UNSIGNED NOT NULL COMMENT '处理时间',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_reward_user1_idx1`(`user_id`) USING BTREE,
  CONSTRAINT `fk_reward_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 134 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of reward
-- ----------------------------
INSERT INTO `reward` VALUES (125, 70, 500.00, 41.00, 500.00, 1, 1559372968, 1559376610, 100);
INSERT INTO `reward` VALUES (126, 70, 500.00, 41.00, 500.00, 1, 1559372971, 1559376581, 100);
INSERT INTO `reward` VALUES (127, 70, 500.00, 1.00, 500.00, 2, 1559372974, 1559376885, 100);
INSERT INTO `reward` VALUES (128, 70, 500.00, 1.00, 500.00, 2, 1559373106, 1559376844, 100);
INSERT INTO `reward` VALUES (129, 70, 500.00, 1.00, 500.00, 2, 1559374214, 1559376807, 100);
INSERT INTO `reward` VALUES (130, 70, 501.00, 1.00, 501.00, 2, 1559374282, 1559376741, 100);
INSERT INTO `reward` VALUES (131, 70, 100.00, 0.00, 100.00, 2, 1559610755, 1559720655, 100);
INSERT INTO `reward` VALUES (132, 70, 501.00, 40.00, 501.00, 1, 1559610775, 0, 100);
INSERT INTO `reward` VALUES (133, 70, 500.00, 40.00, 500.00, 1, 1559610778, 0, 100);

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `explain` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (9, '超级管理员', '拥有所有权限');
INSERT INTO `role` VALUES (30, '雅儿贝德', '拥有管理大坟墓第二层权限 - 大坟墓主护者');
INSERT INTO `role` VALUES (31, '迪米乌哥斯', '管理人间牧场');
INSERT INTO `role` VALUES (32, '塞巴斯·蒂安', '纳萨力克地下大坟墓管家');
INSERT INTO `role` VALUES (33, '管理猪', '拥有普通管理权限');

-- ----------------------------
-- Table structure for role_has_admin
-- ----------------------------
DROP TABLE IF EXISTS `role_has_admin`;
CREATE TABLE `role_has_admin`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `admin_id`) USING BTREE,
  INDEX `fk_role_has_admin_admin1_idx`(`admin_id`) USING BTREE,
  INDEX `fk_role_has_admin_role_idx`(`role_id`) USING BTREE,
  CONSTRAINT `fk_role_has_admin_admin1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_has_admin_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for role_node
-- ----------------------------
DROP TABLE IF EXISTS `role_node`;
CREATE TABLE `role_node`  (
  `role_id` int(10) UNSIGNED NOT NULL,
  `node_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `node_id`) USING BTREE,
  INDEX `fk_role_has_node_node1_idx`(`node_id`) USING BTREE,
  INDEX `fk_role_has_node_role1_idx`(`role_id`) USING BTREE,
  CONSTRAINT `fk_role_has_node_node1` FOREIGN KEY (`node_id`) REFERENCES `node` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_has_node_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of role_node
-- ----------------------------
INSERT INTO `role_node` VALUES (9, 11);
INSERT INTO `role_node` VALUES (9, 12);
INSERT INTO `role_node` VALUES (9, 13);
INSERT INTO `role_node` VALUES (9, 14);
INSERT INTO `role_node` VALUES (9, 15);
INSERT INTO `role_node` VALUES (9, 16);
INSERT INTO `role_node` VALUES (30, 16);
INSERT INTO `role_node` VALUES (33, 16);
INSERT INTO `role_node` VALUES (9, 17);
INSERT INTO `role_node` VALUES (30, 17);
INSERT INTO `role_node` VALUES (9, 18);
INSERT INTO `role_node` VALUES (30, 18);
INSERT INTO `role_node` VALUES (9, 20);
INSERT INTO `role_node` VALUES (30, 20);
INSERT INTO `role_node` VALUES (9, 21);
INSERT INTO `role_node` VALUES (30, 21);
INSERT INTO `role_node` VALUES (9, 22);
INSERT INTO `role_node` VALUES (31, 22);
INSERT INTO `role_node` VALUES (9, 23);
INSERT INTO `role_node` VALUES (31, 23);
INSERT INTO `role_node` VALUES (9, 25);
INSERT INTO `role_node` VALUES (31, 25);
INSERT INTO `role_node` VALUES (9, 26);
INSERT INTO `role_node` VALUES (31, 26);
INSERT INTO `role_node` VALUES (9, 28);
INSERT INTO `role_node` VALUES (31, 28);
INSERT INTO `role_node` VALUES (32, 28);
INSERT INTO `role_node` VALUES (9, 29);
INSERT INTO `role_node` VALUES (31, 29);
INSERT INTO `role_node` VALUES (32, 29);
INSERT INTO `role_node` VALUES (9, 30);
INSERT INTO `role_node` VALUES (32, 30);
INSERT INTO `role_node` VALUES (9, 31);
INSERT INTO `role_node` VALUES (32, 31);
INSERT INTO `role_node` VALUES (9, 32);
INSERT INTO `role_node` VALUES (9, 33);
INSERT INTO `role_node` VALUES (9, 35);
INSERT INTO `role_node` VALUES (32, 35);
INSERT INTO `role_node` VALUES (9, 36);
INSERT INTO `role_node` VALUES (32, 36);
INSERT INTO `role_node` VALUES (9, 37);
INSERT INTO `role_node` VALUES (9, 38);
INSERT INTO `role_node` VALUES (9, 39);
INSERT INTO `role_node` VALUES (9, 40);
INSERT INTO `role_node` VALUES (9, 41);
INSERT INTO `role_node` VALUES (9, 42);
INSERT INTO `role_node` VALUES (9, 43);
INSERT INTO `role_node` VALUES (9, 44);
INSERT INTO `role_node` VALUES (9, 45);
INSERT INTO `role_node` VALUES (9, 49);
INSERT INTO `role_node` VALUES (9, 51);
INSERT INTO `role_node` VALUES (9, 53);
INSERT INTO `role_node` VALUES (9, 54);
INSERT INTO `role_node` VALUES (9, 55);
INSERT INTO `role_node` VALUES (9, 56);
INSERT INTO `role_node` VALUES (9, 57);
INSERT INTO `role_node` VALUES (9, 58);
INSERT INTO `role_node` VALUES (9, 59);
INSERT INTO `role_node` VALUES (9, 61);
INSERT INTO `role_node` VALUES (33, 61);
INSERT INTO `role_node` VALUES (9, 63);
INSERT INTO `role_node` VALUES (9, 67);
INSERT INTO `role_node` VALUES (9, 68);
INSERT INTO `role_node` VALUES (9, 70);
INSERT INTO `role_node` VALUES (9, 71);
INSERT INTO `role_node` VALUES (9, 72);
INSERT INTO `role_node` VALUES (9, 73);
INSERT INTO `role_node` VALUES (9, 74);
INSERT INTO `role_node` VALUES (9, 75);
INSERT INTO `role_node` VALUES (9, 77);
INSERT INTO `role_node` VALUES (9, 79);
INSERT INTO `role_node` VALUES (9, 81);
INSERT INTO `role_node` VALUES (9, 82);
INSERT INTO `role_node` VALUES (9, 84);
INSERT INTO `role_node` VALUES (9, 85);
INSERT INTO `role_node` VALUES (9, 86);
INSERT INTO `role_node` VALUES (9, 87);
INSERT INTO `role_node` VALUES (9, 88);
INSERT INTO `role_node` VALUES (9, 89);
INSERT INTO `role_node` VALUES (9, 91);
INSERT INTO `role_node` VALUES (9, 92);
INSERT INTO `role_node` VALUES (9, 97);
INSERT INTO `role_node` VALUES (9, 98);
INSERT INTO `role_node` VALUES (9, 102);
INSERT INTO `role_node` VALUES (9, 103);
INSERT INTO `role_node` VALUES (9, 104);
INSERT INTO `role_node` VALUES (9, 105);

-- ----------------------------
-- Table structure for tixian
-- ----------------------------
DROP TABLE IF EXISTS `tixian`;
CREATE TABLE `tixian`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `money` double(10, 2) UNSIGNED NOT NULL COMMENT '提现金额',
  `ip` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '提现IP',
  `status` tinyint(2) UNSIGNED NOT NULL COMMENT '状态1=未处理 2=成功 3=失败',
  `name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '真实姓名',
  `alipay` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付账户',
  `dispose_time` int(10) UNSIGNED NOT NULL COMMENT '操作时间',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '提现时间',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_tixian_user1_idx1`(`user_id`) USING BTREE,
  CONSTRAINT `fk_tixian_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 83 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tixian
-- ----------------------------
INSERT INTO `tixian` VALUES (47, 11.00, '127.0.0.1', 1, '阿卡丽', '1131271533@qq.com', 1559634539, 1558590043, 74);
INSERT INTO `tixian` VALUES (49, 20.00, '127.0.0.1', 1, '阿卡丽', '1131271533@qq.com', 1559634213, 1558590995, 74);
INSERT INTO `tixian` VALUES (50, 15.00, '127.0.0.1', 1, '阿卡丽', '1131271533@qq.com', 1559633677, 1558591107, 74);
INSERT INTO `tixian` VALUES (51, 32.00, '127.0.0.1', 1, '阿卡丽', '1131271533@qq.com', 1559633671, 1558591131, 74);
INSERT INTO `tixian` VALUES (52, 11.00, '127.0.0.1', 1, '阿卡丽', '1131271533@qq.com', 1559634505, 1558591196, 74);
INSERT INTO `tixian` VALUES (54, 11.00, '127.0.0.1', 1, '阿卡丽', '1131271533@qq.com', 1559635080, 1559196051, 74);
INSERT INTO `tixian` VALUES (63, 200.00, '127.0.0.1', 2, '朱震', '17600321369', 1559790237, 1558592843, 70);
INSERT INTO `tixian` VALUES (64, 100.00, '127.0.0.1', 3, '朱震', '17600321369', 1559715754, 1558594550, 70);
INSERT INTO `tixian` VALUES (65, 12.00, '127.0.0.1', 2, '阿卡丽', '1131271533@qq.com', 1559644033, 1558595985, 74);
INSERT INTO `tixian` VALUES (79, 50.00, '127.0.0.1', 3, '朱震', '17600321369', 1559635937, 1559544956, 70);
INSERT INTO `tixian` VALUES (80, 10.00, '127.0.0.1', 3, '朱震', '17600321369', 1559635398, 1559545512, 70);
INSERT INTO `tixian` VALUES (82, 11.00, '127.0.0.1', 3, 'hu', '1', 0, 0, 70);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户名',
  `name` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '支付宝姓名',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `password_m` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '明文密码',
  `email` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '邮箱地址',
  `phone` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '联系电话',
  `qq` bigint(19) UNSIGNED NULL DEFAULT NULL COMMENT '用户QQ号',
  `image` char(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '头像',
  `sex` tinyint(2) UNSIGNED NULL DEFAULT NULL COMMENT '性别',
  `level` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '用户级别1-默认普通会员',
  `isvalid` tinyint(2) UNSIGNED NOT NULL COMMENT '是否有效 1-有效 2-待审 0-无效',
  `money` double(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '用户当前可用金额',
  `frost_money` double(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '用户冻结金额',
  `expense_money` double(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '消费金额',
  `award_money` double(10, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '消费金额2-用于发放奖励统计',
  `alipay` char(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '支付宝账户',
  `recommend_id` int(10) UNSIGNED NOT NULL COMMENT '推荐人ID',
  `last_login_ip` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '上次登录IP',
  `last_login_time` int(10) UNSIGNED NOT NULL COMMENT '上次登录时间',
  `login_counts` int(10) UNSIGNED NOT NULL COMMENT '登录次数',
  `qqopenid` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'qq登陆唯一标示',
  `apiid` int(11) NOT NULL COMMENT 'apiid',
  `create_ip` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '注册IP',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (70, 'zhuzhen', '朱震', '14e1b600b1fd579f47433b88e8d85291', '', '2467107934@qq.com', '', 1491066595, '', 0, 1, 1, 676.00, 100.00, 0.00, 0.00, '17600321369', 1, '127.0.0.1', 1559541576, 4, '', 0, '127.0.0.1', 1557988248);
INSERT INTO `user` VALUES (74, '艾丝缇布兰雪', '刘卡修', '9dacfd9d9dc2a13eba6f791419600693', '', '1131271533@qq.com', '15119498976', 1131271533, '', 0, 3, 1, 4022.00, 0.00, 1088.50, 1088.50, '15119498976', 0, '127.0.0.1', 1568250044, 63, '', 0, '127.0.0.1', 1558084893);
INSERT INTO `user` VALUES (80, 'ying-akali', '樱之节', '9dacfd9d9dc2a13eba6f791419600693', '', '1252838725@qq.com', '', 453543, '', 0, 1, 1, 50.00, 0.00, 50.00, 50.00, '', 74, '127.0.0.1', 1558403056, 1, '', 0, '192.168.0.38', 1558084893);
INSERT INTO `user` VALUES (81, 'ruiwen', '锐雯', '9dacfd9d9dc2a13eba6f791419600693', '', '932046899@qq.com', '', 44335, '', 0, 1, 1, 41.30, 0.00, 13.30, 13.30, '', 0, '127.0.0.1', 1561365872, 2, '', 0, '192.168.0.33', 1558084893);
INSERT INTO `user` VALUES (82, 'aisiti', '', '9dacfd9d9dc2a13eba6f791419600693', '', '115735467@qq.com', '', 3535353, '', 0, 1, 1, 30.00, 0.00, 0.00, 50.00, '', 70, '127.0.0.1', 1558420444, 1, '', 0, '127.0.0.1', 1558420444);
INSERT INTO `user` VALUES (95, '465465465', '崔斯塔娜', '8ab0ae9cd516b9811a237b09991d9abc', '', '546564545@qq.com', '', 0, '', 0, 1, 2, 15.00, 0.00, 0.00, 0.00, '', 0, '127.0.0.1', 1558683085, 1, '', 0, '127.0.0.1', 1558683085);
INSERT INTO `user` VALUES (100, '123456789', '朱震啊', '70873e8580c9900986939611618d7b1e', '', '123456789@qq.com', '', 0, '', 0, 4, 1, 1101.00, 294.00, 0.00, 399.00, '17600321369', 70, '127.0.0.1', 1559352515, 2, '', 0, '127.0.0.1', 1559295953);

-- ----------------------------
-- Table structure for user_api
-- ----------------------------
DROP TABLE IF EXISTS `user_api`;
CREATE TABLE `user_api`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `webname` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `webid` char(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `web` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_user_ip_user1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_user_ip_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for vip
-- ----------------------------
DROP TABLE IF EXISTS `vip`;
CREATE TABLE `vip`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `level2` double(10, 2) UNSIGNED NOT NULL COMMENT '升级黄金会员价格',
  `level3` double(10, 2) UNSIGNED NOT NULL COMMENT '升级铂金会员价格',
  `level4` double(10, 2) UNSIGNED NOT NULL COMMENT '升级钻石会员价格',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of vip
-- ----------------------------
INSERT INTO `vip` VALUES (1, 188.00, 388.00, 588.00);

-- ----------------------------
-- Table structure for vipdh
-- ----------------------------
DROP TABLE IF EXISTS `vipdh`;
CREATE TABLE `vipdh`  (
  `id` int(10) UNSIGNED NOT NULL,
  `lingla` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '领啦商家帐号',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `stype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '兑换平台',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_vipdh_bag1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_vipdh_bag1` FOREIGN KEY (`user_id`) REFERENCES `bag` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for white
-- ----------------------------
DROP TABLE IF EXISTS `white`;
CREATE TABLE `white`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` char(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '会员名称',
  `create_time` int(10) UNSIGNED NOT NULL COMMENT '创建时间',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `user_id`) USING BTREE,
  INDEX `fk_white_user1_idx`(`user_id`) USING BTREE,
  CONSTRAINT `fk_white_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
