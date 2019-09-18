INSERT INTO `users` (`id`, `name`, `number`, `grade_id`, `created_at`, `updated_at`)
VALUES
	(1, 'vv', '123', '2', '2019-08-13 17:52:03', '2019-08-13 18:14:56'),
	(2, 'vtr', '456', '5', '2019-08-15 22:47:20', '2019-08-15 22:47:20'),
	(3, '游客', NULL, NULL, '2019-08-16 21:10:40', '2019-08-16 21:10:40');


INSERT INTO `records` (`id`, `user_id`, `score`, `created_at`, `updated_at`)
VALUES
	(1, 1, 80, '2019-08-13 18:14:56', '2019-08-13 18:14:56'),
	(2, 1, 60, '2019-08-13 18:14:56', '2019-08-13 18:14:56');


INSERT INTO `record_details` (`id`, `record_id`, `user_id`, `question_id`, `answer_ids`, `created_at`, `updated_at`, `is_right`, `score`)
VALUES
	(1, 1, 1, 1, '1', '2019-08-13 18:14:56', '2019-08-13 18:14:56', 0, 0),
	(2, 1, 1, 2, '5;6', '2019-08-13 18:14:56', '2019-08-13 18:14:56', 0, 0),
	(3, 2, 1, 1, '2', '2019-08-13 18:14:56', '2019-08-13 18:14:56', 0, 0),
	(4, 2, 1, 2, '2', '2019-08-13 18:14:56', '2019-08-13 18:14:56', 0, 0);


INSERT INTO `grades` (`id`, `name`, `created_at`, `updated_at`)
VALUES
	(1, '一年级', '2019-08-13 17:52:03', '2019-08-13 17:52:03'),
	(2, '二年级', '2019-08-13 17:52:03', '2019-08-13 17:52:03');


INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1, 'admin', '$2y$10$nHghNzb8kgntTQNFgIVgCuA3iHzBmt32kpxEppIWuuNrse4pcU8l.', 'Administrator', NULL, 'Pdo3mKqcwPLulkwVjOTSlRAALePpnuSveoXdOKHNyGeNOuU66pl0taJ2dMds', '2019-08-13 18:03:29', '2019-08-13 18:03:29');


INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`)
VALUES
	(1, 'Administrator', 'administrator', '2019-08-13 18:03:29', '2019-08-13 18:03:29');


INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1, 1, NULL, NULL);


INSERT INTO `admin_role_permissions` (`role_id`, `permission_id`, `created_at`, `updated_at`)
VALUES
	(1, 1, NULL, NULL);


INSERT INTO `admin_role_menu` (`role_id`, `menu_id`, `created_at`, `updated_at`)
VALUES
	(1, 2, NULL, NULL);


INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `created_at`, `updated_at`)
VALUES
	(1, 'All permission', '*', '', '*', NULL, NULL),
	(2, 'Dashboard', 'dashboard', 'GET', '/', NULL, NULL),
	(3, 'Login', 'auth.login', '', '/auth/login\r\n/auth/logout', NULL, NULL),
	(4, 'User setting', 'auth.setting', 'GET,PUT', '/auth/setting', NULL, NULL),
	(5, 'Auth management', 'auth.management', '', '/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs', NULL, NULL);

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `permission`, `created_at`, `updated_at`)
VALUES
	(2, 0, 1, 'Admin', 'fa-tasks', '', NULL, NULL, '2019-08-14 11:03:29'),
	(3, 2, 2, 'Users', 'fa-users', 'auth/users', NULL, NULL, '2019-08-14 11:03:29'),
	(4, 2, 3, 'Roles', 'fa-user', 'auth/roles', NULL, NULL, '2019-08-14 11:03:29'),
	(5, 2, 4, 'Permission', 'fa-ban', 'auth/permissions', NULL, NULL, '2019-08-14 11:03:29'),
	(6, 2, 5, 'Menu', 'fa-bars', 'auth/menu', NULL, NULL, '2019-08-14 11:03:29'),
	(7, 2, 6, 'Operation log', 'fa-history', 'auth/logs', NULL, NULL, '2019-08-14 11:03:29'),
	(8, 0, 8, '用户', 'fa-user-secret', NULL, NULL, '2019-08-13 18:04:27', '2019-08-14 11:06:18'),
	(9, 0, 11, '题库', 'fa-credit-card', NULL, NULL, '2019-08-13 18:04:51', '2019-08-14 11:06:18'),
	(10, 9, 13, '作答情况', 'fa-file-word-o', '/records', NULL, '2019-08-13 18:25:17', '2019-08-14 11:06:18'),
	(11, 8, 9, '用户列表', 'fa-user', '/users', NULL, '2019-08-13 20:51:16', '2019-08-14 11:06:18'),
	(12, 9, 12, '题目列表', 'fa-question-circle', '/questions', NULL, '2019-08-13 20:52:51', '2019-08-14 11:06:18'),
	(13, 8, 10, '班级列表', 'fa-graduation-cap', '/grades', NULL, '2019-08-13 22:04:07', '2019-08-14 11:06:18'),
	(15, 0, 7, '首页', 'fa-bar-chart', '/charts', NULL, '2019-08-14 11:05:58', '2019-08-14 11:06:18');
	(16, 9, 6, '虫害列表', 'fa-fire-extinguisher', '/pests', NULL, '2019-08-19 21:15:07', '2019-08-20 11:49:43');
