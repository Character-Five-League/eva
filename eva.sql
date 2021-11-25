/*
 Navicat Premium Data Transfer

 Source Server         : linux
 Source Server Type    : MariaDB
 Source Server Version : 100512
 Source Host           : 10.0.2.2:3306
 Source Schema         : eva

 Target Server Type    : MariaDB
 Target Server Version : 100512
 File Encoding         : 65001

 Date: 23/11/2021 14:29:57
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for class
-- ----------------------------
DROP TABLE IF EXISTS `class`;
CREATE TABLE `class`  (
  `class_id` int(32) NOT NULL,
  `grade` enum('g1','g2','g3') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT 'g1',
  `class_name` varchar(64) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT '未名班级',
  PRIMARY KEY (`class_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course`  (
  `course_id` int(10) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(200) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT '未命名课程',
  PRIMARY KEY (`course_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for form_data
-- ----------------------------
DROP TABLE IF EXISTS `form_data`;
CREATE TABLE `form_data`  (
  `form_id` int(64) NOT NULL,
  `student_id` int(32) NOT NULL,
  `work_attitude` enum('很满意','满意','不满意','很不满意') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  `teaching_level` enum('很满意','满意','不满意','很不满意') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  `answer_attitude` enum('很满意','满意','不满意','很不满意') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  `course_atmosphere` enum('很满意','满意','不满意','很不满意') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  INDEX `form_id`(`form_id`) USING BTREE,
  INDEX `student_id`(`student_id`) USING BTREE,
  CONSTRAINT `form_data_ibfk_1` FOREIGN KEY (`form_id`) REFERENCES `form_list` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form_data_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for form_list
-- ----------------------------
DROP TABLE IF EXISTS `form_list`;
CREATE TABLE `form_list`  (
  `form_id` int(64) NOT NULL AUTO_INCREMENT,
  `teacher_id` int(32) NOT NULL,
  `class_id` int(32) NOT NULL,
  `course_id` int(10) NOT NULL,
  `status_post` enum('yes','no') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  PRIMARY KEY (`form_id`) USING BTREE,
  INDEX `teacher_id`(`teacher_id`) USING BTREE,
  INDEX `class_id`(`class_id`) USING BTREE,
  INDEX `course_id`(`course_id`) USING BTREE,
  CONSTRAINT `form_list_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher_info` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form_list_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `form_list_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for student_info
-- ----------------------------
DROP TABLE IF EXISTS `student_info`;
CREATE TABLE `student_info`  (
  `user_id` int(32) NOT NULL,
  `user_name` varchar(64) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT '匿名学生',
  `class_id` int(32) NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE,
  INDEX `class_id`(`class_id`) USING BTREE,
  CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `student_info_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `class` (`class_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for teacher_info
-- ----------------------------
DROP TABLE IF EXISTS `teacher_info`;
CREATE TABLE `teacher_info`  (
  `user_id` int(32) NOT NULL,
  `user_name` varchar(64) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT '匿名教师',
  `user_phone` varchar(11) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT 'no number',
  `user_email` varchar(50) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL DEFAULT 'no@email',
  PRIMARY KEY (`user_id`) USING BTREE,
  CONSTRAINT `teacher_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `user_id` int(32) NOT NULL,
  `uid` enum('admin','tea','stu') CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  `password` varchar(64) CHARACTER SET gb2312 COLLATE gb2312_chinese_ci NOT NULL,
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = gb2312 COLLATE = gb2312_chinese_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- View structure for form
-- ----------------------------
DROP VIEW IF EXISTS `form`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `form` AS select `form_list`.`form_id` AS `表单序列`,`teacher_info`.`user_name` AS `教师`,`class`.`class_name` AS `班级`,`course`.`course_name` AS `课程`,`form_list`.`status_post` AS `发布状态` from (((`teacher_info` join `class`) join `course`) join `form_list`) where `form_list`.`teacher_id` = `teacher_info`.`user_id` and `form_list`.`class_id` = `class`.`class_id` and `form_list`.`course_id` = `course`.`course_id`;

-- ----------------------------
-- View structure for students
-- ----------------------------
DROP VIEW IF EXISTS `students`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `students` AS select `student_info`.`user_id` AS `用户序列`,`student_info`.`user_name` AS `学生名`,`class`.`grade` AS `年级`,`class`.`class_name` AS `所在班级` from (`student_info` join `class`) where `class`.`class_id` = `student_info`.`class_id`;

-- ----------------------------
-- View structure for teachers
-- ----------------------------
DROP VIEW IF EXISTS `teachers`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `teachers` AS select `teacher_info`.`user_id` AS `用户序列`,`teacher_info`.`user_name` AS `教师名`,`teacher_info`.`user_phone` AS `教师电话`,`teacher_info`.`user_email` AS `教师电子邮箱` from `teacher_info`;

SET FOREIGN_KEY_CHECKS = 1;
