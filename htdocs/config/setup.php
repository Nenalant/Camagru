<?php

include('database.php');

try {
	$db_set = new PDO($DB_DNS_HOST, $DB_USER, $DB_PASSWO, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

	$data_base_creation = "
	SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));

	SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

	SET time_zone = '+00:00';

	DROP DATABASE IF EXISTS $DB_NAME;

	CREATE DATABASE IF NOT EXISTS $DB_NAME;

	USE $DB_NAME;

	SET NAMES 'utf8'";

	$db_set->exec($data_base_creation);

	$user = <<< 'EOF'
	CREATE TABLE `user` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`login` varchar(15) NOT NULL,
	`email` varchar(30) NOT NULL,
	`password` varchar(255) NOT NULL,
	`verified` int(11) NOT NULL DEFAULT '0',
	`token` varchar(255) DEFAULT NULL,
	`tstime` int(255) NOT NULL,
	`like_email` int(11) DEFAULT '1',
	`com_email` int(11) DEFAULT '1',
	KEY (id)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `user` (`id`, `login`, `email`, `password`, `verified`, `token`, `tstime`, `like_email`, `com_email`) VALUES
(1, 'hello', 'hello@hello.fr', '$2y$10$R45M0O7FrDPfGI7uon80iupeZBdJn03hMSbiANjQZB0LU4DXR/6Vm', 0, NULL, 0, 1, 1),
(2, 'lola_la_', 'lola@lola.fr', '$2y$10$ruZ4pETp69dR3G76nwVEaeUwbWARXxBCrdSQsGCqnaN61JCOT5v4m', 0, NULL, 0, 1, 1),
(4, 'manolo', 'manolo@manolo.fr', '$2y$10$6uj4P97F33lHFCigxoVer.dWVysppnLh/kcTdjQLU16ojCh3R5oEG', 0, NULL, 0, 1, 1),
(5, 'alanteri', 'alanteri@student.42.fr', '$2y$10$IyeE9hLT8gM7DdwYFPxo/.XVhyyCX4cfiMrs/GgJXPv7OTI7eyMvq', 0, NULL, 0, 1, 1),
(6, 'annita', 'annita@gmail.com', '$2y$10$np2FB5qtO0sB7dLYyaLUeu3dnfd6xbxweORLx1IYXsHtPiJZIAU0m', 0, NULL, 0, 1, 1),
(21, 'paco', 'dudul@gmail.com', '$2y$10$i/xV39eaTa2mzoiW8o7CdOhXf8tPE6QJVOBRiiN7WU7IqaO/jqmLa', 1, NULL, 0, 1, 1),
(23, 'jojo', 'yoooo@gmail.com', '$2y$10$FT9A9N3UH9GWLWOOtrTaweeFzz0U3MEq7cdVzx2qlKogy/QcFvJSy', 1, NULL, 0, 0, 0),
(29, 'toto', 'toto@toto.com', '$2y$10$GwV8i3hUL/ILAwS1kf9c1esSMZx.M0Gv1yD/FP6Eiko/P06RTlM/G', 0, NULL, 0, 1, 1),
(31, 'toti', 'toto@toto.com', '$2y$10$HNcZQah1JEfHBkvrj5LowO.2BL1f77EZZpiEPYnyplMLDhujKAHdC', 0, NULL, 0, 1, 1),
(33, 'fanfan', 'yoooo@gmail.com', '$2y$10$FT9A9N3UH9GWLWOOtrTaweeFzz0U3MEq7cdVzx2qlKogy/QcFvJSy', 1, 0, 1526913268, 1, 1);

EOF;

	$db_set->exec($user);

	$img = "CREATE TABLE `photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `src` varchar(255) NOT NULL,
  `login` varchar(15) NOT NULL,
  `img_date` datetime NOT NULL,
	KEY (id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `photos` (`id`, `src`, `login`, `img_date`) VALUES
(7, 'fanfan_0', 'fanfan', '0000-00-00 00:00:00'),
(10, 'fanfan_2', 'fanfan', '2018-06-26 16:19:20'),
(11, 'fanfan_3', 'fanfan', '2018-06-28 17:35:43'),
(12, 'fanfan_4', 'fanfan', '2018-06-28 19:08:20'),
(16, 'jojo_0', 'jojo', '2018-07-04 22:15:59'),
(17, 'jojo_1', 'jojo', '2018-07-23 18:34:54'),
(20, 'jojo_4', 'jojo', '2018-07-27 18:40:04'),
(22, 'jojo_5', 'jojo', '2018-08-01 17:09:46'),
(23, 'jojo_6', 'jojo', '2018-08-02 23:03:00'),
(26, 'jojo_7', 'jojo', '2018-08-04 18:08:30'),
(30, 'fanfan_5', 'fanfan', '2018-06-28 19:08:22'),
(154, 'jojo_8', 'jojo', '2018-10-11 18:45:01'),
(156, 'jojo_10', 'jojo', '2018-10-11 18:49:58'),
(204, 'jojo_49', 'jojo', '2018-10-15 18:43:21'),
(208, 'jojo_53', 'jojo', '2018-10-15 18:49:51');";

	$db_set->exec($img);

	$likes = "CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture_src` varchar(255) NOT NULL,
  `liker_login` varchar(8) NOT NULL,
	KEY (id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `likes` (`id`, `picture_src`, `liker_login`) VALUES
(5, 'fanfan_3', 'fanfan'),
(37, 'fanfan_2', 'jojo'),
(46, 'fanfan_2', 'fanfan'),
(48, 'fanfan_4', 'jojo'),
(59, 'jojo_4', 'jojo'),
(61, 'jojo_5', 'jojo'),
(64, 'jojo_6', 'jojo'),
(66, 'jojo_10', 'jojo');";

	$db_set->exec($likes);

	$comment = "CREATE TABLE `coments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic_name` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `coment` text NOT NULL,
  `com_date` datetime NOT NULL,
	KEY (id) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `coments` (`id`, `pic_name`, `login`, `coment`, `com_date`) VALUES
(2, 'jojo_4', 'jojo', 'Beau gosse !', '2018-07-30 19:38:19'),
(5, 'jojo_4', 'fanfan', 'Mdr t es trop moche !', '2018-07-30 19:39:53'),
(10, 'jojo_4', 'jojo', 'Trop mignon Jeremy !', '2018-08-01 17:14:57'),
(14, 'jojo_4', 'Vanvan', 'Tu es tres moche et con comme a ton habitude', '2018-08-01 17:21:30'),
(15, 'jojo_5', 'fanfan', 'Lol ces lunettes !', '2018-08-01 17:33:45'),
(16, 'jojo_5', 'jojo', 'Trop mimi !', '2018-08-01 17:35:58'),
(18, 'jojo_5', 'jojo', 'Hey you !', '2018-08-01 17:37:13'),
(19, 'jojo_4', 'jojo', 'Ololo ! Quelle divine deesse', '2018-08-01 19:48:02'),
(21, 'jojo_5', 'jojo', 'lol', '2018-08-01 21:23:53'),
(22, 'jojo_6', 'jojo', 'Trop des beau gosses !!!', '2018-08-02 23:03:11'),
(23, 'jojo_7', 'jojo', 'lol', '2018-08-30 16:37:13'),
(24, 'jojo_6', 'jojo', 'Dont believe what I just watch', '2018-09-14 19:16:46'),
(25, 'jojo_10', 'jojo', 'Tu est magnifik ma chewui', '2018-10-11 18:50:22');";

	$db_set->exec($comment);
}
catch (PDOException $e) {
	die("DB ERROR: ". $e->getMessage());
}

?>