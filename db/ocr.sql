/*
 Navicat Premium Data Transfer

 Source Server         : dockermysql-master
 Source Server Type    : MySQL
 Source Server Version : 80025
 Source Host           : 120.78.144.133:3306
 Source Schema         : openapi_init

 Target Server Type    : MySQL
 Target Server Version : 80025
 File Encoding         : 65001

 Date: 21/07/2023 16:46:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '配置编码',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '说明',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '配置值',
  `is_show` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '是否可见（预留字段，暂时没用到）',
  `created_at` bigint unsigned NOT NULL DEFAULT '0',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `config_code_index` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置表';

-- ----------------------------
-- Records of config
-- ----------------------------
BEGIN;
INSERT INTO `config` VALUES (54, 'ip_white_list', 'ip白名单', '*', 0, 0, 0, NULL);
INSERT INTO `config` VALUES (55, 'check_in_integral', '签到积分', '5', 0, 0, 0, NULL);
INSERT INTO `config` VALUES (56, 'invite_integral', '邀请积分', '20', 0, 0, 0, NULL);
COMMIT;

-- ----------------------------
-- Table structure for integral_log
-- ----------------------------
DROP TABLE IF EXISTS `integral_log`;
CREATE TABLE `integral_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `io` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 收入  2 支出',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型; 0调用接口; 1签到; 2邀请用户',
  `before_integral` bigint NOT NULL DEFAULT '1' COMMENT '改变前积分',
  `change_integral` bigint NOT NULL DEFAULT '1' COMMENT '改变积分',
  `current_integral` bigint NOT NULL DEFAULT '1' COMMENT '改变后积分',
  `relation_uid` bigint NOT NULL DEFAULT '0' COMMENT '关联用户',
  `remarks` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '备注',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Table structure for openapi_product
-- ----------------------------
DROP TABLE IF EXISTS `openapi_product`;
CREATE TABLE `openapi_product` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '说明',
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标识',
  `integral` bigint DEFAULT NULL COMMENT '积分',
  `created_at` bigint unsigned NOT NULL DEFAULT '0',
  `updated_at` bigint unsigned NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `config_code_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='配置表';

-- ----------------------------
-- Records of openapi_product
-- ----------------------------
BEGIN;
INSERT INTO `openapi_product` VALUES (58, 'OCR标准', 'baidu api', 'BaiduController@ocrGeneralBasic', 0, 0, 0, NULL);
INSERT INTO `openapi_product` VALUES (59, '音视频转文本', 'openai api', 'OpenaiController@audioTranscriptions', 5, 0, 0, NULL);
INSERT INTO `openapi_product` VALUES (60, 'AI作图', 'openai api', 'OpenaiController@imagesGenerations', 2, 0, 0, NULL);
COMMIT;

-- ----------------------------
-- Table structure for user_secret
-- ----------------------------
DROP TABLE IF EXISTS `user_secret`;
CREATE TABLE `user_secret` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `access_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'access key',
  `secret_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'secret key',
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'token',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of user_secret
-- ----------------------------
BEGIN;
INSERT INTO `user_secret` VALUES (26, 54275, '27a7ab7b0adb95b7', 'fed37e761735ba8d08955a6589bd28d98da504c8', 'YzQyN2M2NDc0OTg3MWU2Y2ViZWZmMzljYmY0MjQ4ZjE=', '2023-05-11 15:58:28', '2023-05-11 15:58:28', NULL);
COMMIT;

-- ----------------------------
-- Table structure for user_token
-- ----------------------------
DROP TABLE IF EXISTS `user_token`;
CREATE TABLE `user_token` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` bigint unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `token` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '用户登录token',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ----------------------------
-- Records of user_token
-- ----------------------------
BEGIN;
INSERT INTO `user_token` VALUES (5, 54275, 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdmF0YXIiOiJodHRwczovL2Jhc2VyYW4yLm9zcy1jbi1zaGVuemhlbi5hbGl5dW5jcy5jb20vaW0vc3RhdGljL2RlZmF1bHRfYXZhdGFyX3dvbWFuLnBuZyIsImV4cCI6MTY4MDI1NjU0NCwiaWF0IjoxNjc5NjUxNzQ0LCJuaWNrbmFtZSI6IjU0Mjc1IiwicGhvbmUiOiIxNTAxMzA3MDc5NiIsInVzZXJfaWQiOjU0Mjc1fQ.b2s01rDOWp5ZaCHe3socPtBTyukW_ykmKgWacxYVmJg', '2022-10-26 10:31:01', '2022-10-26 10:31:01', NULL);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `nick_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT '用户昵称',
  `we_chat_code` varchar(255) DEFAULT NULL COMMENT '微信号',
  `sex` int unsigned DEFAULT '0' COMMENT '性别 0男1女',
  `salt` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '密码盐',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '密码',
  `phone` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '手机',
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '邮箱',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '头像',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_online_time` datetime DEFAULT NULL COMMENT '最后在线时间',
  `city_code` varchar(11) DEFAULT '' COMMENT '城市编码，新增',
  `status` int NOT NULL DEFAULT '0' COMMENT '用户状态 0正常 1禁用',
  `integral` bigint NOT NULL DEFAULT '0' COMMENT '积分',
  `longitude` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '经度',
  `latitude` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '纬度',
  `qq_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'qq登录的唯一id',
  `we_chat_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '微信登录的id',
  `invite_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '邀请码',
  `online_status` int DEFAULT NULL COMMENT '用户在线状态 0：离线 1：在线 2：忙碌',
  `other_invite_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '填入的别人的邀请码',
  `remarks` varchar(100) DEFAULT NULL COMMENT '备注,如封号等操作',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否管理员',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `channel_sex` (`sex`) USING BTREE,
  KEY `idx_sex_totalcurrency` (`sex`) USING BTREE,
  KEY `invite_code` (`invite_code`) USING BTREE,
  KEY `last_login_time_index` (`last_login_time`) USING BTREE,
  KEY `latitude_index` (`latitude`) USING BTREE,
  KEY `longtitude_index` (`longitude`) USING BTREE,
  KEY `online_status` (`online_status`) USING BTREE,
  KEY `other_invite_code` (`other_invite_code`) USING BTREE,
  KEY `phone` (`phone`) USING BTREE,
  KEY `sex` (`sex`,`status`) USING BTREE,
  KEY `status` (`status`) USING BTREE,
  KEY `wchatid` (`we_chat_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=54289 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC COMMENT='用户表 @wx';

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (54275, '54275', '', 1, '0hy4', 'd4f8b49d119431462965d31c50ca9fd6', '13012341234', '', 'https://baseran2.oss-cn-shenzhen.aliyuncs.com/im/static/default_avatar_woman.png', '2022-10-26 10:31:01', NULL, '', 0, 0, '', '', '', '', '', 0, '', '备注1234', 0, '2022-10-26 10:31:01', '2022-10-26 10:31:01', NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
