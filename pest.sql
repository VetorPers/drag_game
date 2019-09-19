INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`)
VALUES
	(2, 0, 8, 'Admin', 'fa-tasks', '', NULL, NULL, '2019-09-19 11:57:27'),
	(3, 2, 9, 'Users', 'fa-users', 'auth/users', NULL, NULL, '2019-09-19 11:57:27'),
	(4, 2, 10, 'Roles', 'fa-user', 'auth/roles', NULL, NULL, '2019-09-19 11:57:27'),
	(5, 2, 11, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL, '2019-09-19 11:57:27'),
	(6, 2, 12, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL, '2019-09-19 11:57:27'),
	(7, 2, 13, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, '2019-09-19 11:57:27'),
	(8, 0, 2, '用户', 'fa-user-secret', NULL, NULL, '2019-08-13 18:04:27', '2019-09-19 11:57:27'),
	(9, 0, 5, '游戏', 'fa-credit-card', NULL, NULL, '2019-08-13 18:04:51', '2019-09-19 11:57:27'),
	(10, 9, 7, '作答情况', 'fa-file-word-o', '/records', NULL, '2019-08-13 18:25:17', '2019-09-19 11:57:27'),
	(11, 8, 3, '用户列表', 'fa-user', '/users', NULL, '2019-08-13 20:51:16', '2019-09-19 11:57:27'),
	(13, 8, 4, '班级列表', 'fa-graduation-cap', '/grades', NULL, '2019-08-13 22:04:07', '2019-09-19 11:57:27'),
	(15, 0, 1, '首页', 'fa-bar-chart', '/', NULL, '2019-08-14 11:05:58', '2019-09-19 11:55:38'),
	(16, 9, 6, '游戏列表', 'fa-gamepad', '/pests', NULL, '2019-08-19 21:15:07', '2019-09-19 11:57:27');


INSERT INTO `pests` (`id`, `name`, `img`, `order`, `ascore`, `pass_score`, `created_at`, `updated_at`, `time`)
VALUES
	(1, '游戏一', 'images/57c.jpg', 255, 1, 6, '2019-09-19 11:12:33', '2019-09-19 11:26:40', 50),
	(2, '游戏二', 'images/20150713235634_UKdLB.jpeg', 2, 1, 7, '2019-09-19 11:28:13', '2019-09-19 11:28:13', 40);


INSERT INTO `answers` (`id`, `pest_id`, `title`, `is_right`, `created_at`, `updated_at`)
VALUES
	(1, 2, '答案1', 0, '2019-09-19 11:47:29', '2019-09-19 11:47:29'),
	(2, 2, '答案2', 0, '2019-09-19 11:47:29', '2019-09-19 11:47:29'),
	(3, 2, '答案3', 0, '2019-09-19 11:47:29', '2019-09-19 11:47:29'),
	(4, 2, '答案4', 1, '2019-09-19 11:47:29', '2019-09-19 11:47:29'),
	(5, 2, '答案5', 1, '2019-09-19 11:47:29', '2019-09-19 11:47:29');
