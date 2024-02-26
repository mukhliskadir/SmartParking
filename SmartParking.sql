-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table softui.e_wallets
CREATE TABLE IF NOT EXISTS `e_wallets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `e_wallets_user_id_unique` (`user_id`),
  CONSTRAINT `e_wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.e_wallets: ~1 rows (approximately)
INSERT INTO `e_wallets` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
	(1, 1, 1323.62, '2024-02-23 04:04:32', '2024-02-25 10:28:17'),
	(2, 4, 10.00, '2024-02-25 04:33:47', '2024-02-25 04:33:47'),
	(3, 6, 10.00, '2024-02-25 10:33:41', '2024-02-25 10:33:41');

-- Dumping structure for table softui.e_wallet_transactions
CREATE TABLE IF NOT EXISTS `e_wallet_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `e_wallet_id` bigint unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('out','in') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'out',
  `reservation_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `e_wallet_transactions_e_wallet_id_foreign` (`e_wallet_id`),
  KEY `e_wallet_transactions_reservation_id_foreign` (`reservation_id`),
  CONSTRAINT `e_wallet_transactions_e_wallet_id_foreign` FOREIGN KEY (`e_wallet_id`) REFERENCES `e_wallets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `e_wallet_transactions_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.e_wallet_transactions: ~7 rows (approximately)
INSERT INTO `e_wallet_transactions` (`id`, `e_wallet_id`, `amount`, `payment_method`, `type`, `reservation_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 1.00, NULL, 'out', 1, '2024-02-23 16:01:54', '2024-02-23 16:01:54'),
	(2, 1, 1.00, NULL, 'out', 1, '2024-02-23 16:02:49', '2024-02-23 16:02:49'),
	(3, 1, 100.00, NULL, 'in', NULL, '2024-02-25 03:58:42', '2024-02-25 03:58:42'),
	(4, 1, 100.00, NULL, 'in', NULL, '2024-02-25 04:01:04', '2024-02-25 04:01:04'),
	(5, 1, 10.00, NULL, 'in', NULL, '2024-02-25 04:32:39', '2024-02-25 04:32:39'),
	(6, 2, 10.00, NULL, 'in', NULL, '2024-02-25 04:33:47', '2024-02-25 04:33:47'),
	(7, 1, 10.00, NULL, 'in', NULL, '2024-02-25 04:40:39', '2024-02-25 04:40:39'),
	(8, 1, 0.10, NULL, 'out', 2, '2024-02-25 07:37:20', '2024-02-25 07:37:20'),
	(9, 1, 0.10, NULL, 'out', 2, '2024-02-25 07:37:49', '2024-02-25 07:37:49'),
	(10, 1, 0.10, 'e-Wallet', 'out', 2, '2024-02-25 07:41:08', '2024-02-25 07:41:08'),
	(11, 1, 5.00, 'Paypal', 'in', NULL, '2024-02-25 07:44:03', '2024-02-25 07:44:03'),
	(12, 1, 1.20, 'e-Wallet', 'out', 3, '2024-02-25 07:53:21', '2024-02-25 07:53:21'),
	(13, 1, 0.60, 'e-Wallet', 'out', 5, '2024-02-25 07:56:10', '2024-02-25 07:56:10'),
	(14, 1, 0.28, 'e-Wallet', 'out', 6, '2024-02-25 10:26:00', '2024-02-25 10:26:00'),
	(15, 1, 5.00, 'Paypal', 'in', NULL, '2024-02-25 10:28:17', '2024-02-25 10:28:17'),
	(16, 3, 10.00, 'Paypal', 'in', NULL, '2024-02-25 10:33:41', '2024-02-25 10:33:41');

-- Dumping structure for table softui.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table softui.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.migrations: ~9 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2024_02_23_030213_create_permission_tables', 2),
	(5, '2024_02_23_031656_create_parking_spots_table', 3),
	(6, '2024_02_23_031850_create_reservations_table', 3),
	(7, '2024_02_23_031909_create_e_wallets_table', 3),
	(8, '2024_02_23_031924_create_e_wallet_transactions_table', 4),
	(9, '2024_02_23_153630_create_user_has_cars_table', 5);

-- Dumping structure for table softui.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.model_has_permissions: ~0 rows (approximately)

-- Dumping structure for table softui.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.model_has_roles: ~4 rows (approximately)
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(3, 'App\\Models\\User', 3),
	(3, 'App\\Models\\User', 4),
	(2, 'App\\Models\\User', 6);

-- Dumping structure for table softui.parking_spots
CREATE TABLE IF NOT EXISTS `parking_spots` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `price_per_ten_min` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.parking_spots: ~5 rows (approximately)
INSERT INTO `parking_spots` (`id`, `name`, `size`, `created_at`, `updated_at`, `price_per_ten_min`) VALUES
	(2, 'Gound Floor - 1', 'Large', '2024-02-22 19:57:00', '2024-02-25 10:14:51', 0.30),
	(4, '2', 'Medium', '2024-02-22 22:31:22', '2024-02-22 22:31:22', 0.20),
	(5, '3', 'Medium', '2024-02-22 22:31:44', '2024-02-22 22:31:44', 0.20),
	(6, '4', 'Small', '2024-02-22 22:32:32', '2024-02-22 22:32:32', 0.10),
	(7, '5', 'Small', '2024-02-22 22:36:32', '2024-02-22 22:36:32', 0.10),
	(8, '3rd Floor', 'Medium', '2024-02-25 10:16:37', '2024-02-25 10:16:37', 0.20);

-- Dumping structure for table softui.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.password_resets: ~0 rows (approximately)

-- Dumping structure for table softui.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.permissions: ~2 rows (approximately)

-- Dumping structure for table softui.reservations
CREATE TABLE IF NOT EXISTS `reservations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `parking_spot_id` bigint unsigned NOT NULL,
  `reserved_at` datetime NOT NULL,
  `reserved_until` datetime NOT NULL,
  `duration` int NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `status` enum('reserved','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reserved',
  `payment_status` enum('pending','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_plate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservations_user_id_foreign` (`user_id`),
  KEY `reservations_parking_spot_id_foreign` (`parking_spot_id`),
  CONSTRAINT `reservations_parking_spot_id_foreign` FOREIGN KEY (`parking_spot_id`) REFERENCES `parking_spots` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.reservations: ~1 rows (approximately)
INSERT INTO `reservations` (`id`, `user_id`, `parking_spot_id`, `reserved_at`, `reserved_until`, `duration`, `cost`, `status`, `payment_status`, `payment_method`, `car_model`, `car_plate`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 6, '2024-02-24 09:00:00', '2024-02-24 10:00:00', 60, 1.00, 'cancelled', 'pending', NULL, 'Tesla', 'NKV 1232', '2024-02-23 10:47:28', '2024-02-23 16:49:12', '2024-02-23 16:49:12'),
	(2, 1, 6, '2024-02-26 15:00:00', '2024-02-26 16:00:00', 60, 0.10, 'reserved', 'paid', NULL, 'Myvi', 'Test1234', '2024-02-25 07:26:08', '2024-02-25 07:41:08', NULL),
	(3, 1, 5, '2024-02-27 15:00:00', '2024-02-27 16:00:00', 60, 1.20, 'reserved', 'paid', NULL, 'Test', 'Test123', '2024-02-25 07:53:06', '2024-02-25 07:53:21', NULL),
	(4, 1, 6, '2024-02-28 15:00:00', '2024-02-28 16:00:00', 60, 0.60, 'cancelled', 'pending', NULL, 'Test', 'Test123', '2024-02-25 07:55:15', '2024-02-25 07:57:12', '2024-02-25 07:57:12'),
	(5, 1, 7, '2024-02-29 15:00:00', '2024-02-29 16:00:00', 60, 0.60, 'reserved', 'paid', NULL, 'Tesla', 'Test1234', '2024-02-25 07:56:01', '2024-02-25 07:56:10', NULL),
	(6, 1, 4, '2024-02-26 15:00:00', '2024-02-26 15:14:00', 14, 0.28, 'reserved', 'paid', NULL, 'Test', 'Test125', '2024-02-25 10:22:18', '2024-02-25 10:26:00', NULL);

-- Dumping structure for table softui.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.roles: ~3 rows (approximately)
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'super_admin', 'web', '2024-02-24 09:44:35', '2024-02-24 09:44:37'),
	(2, 'guest', 'web', '2024-02-24 09:44:53', '2024-02-24 09:44:54'),
	(3, 'admin', 'web', '2024-02-24 10:25:19', '2024-02-24 10:25:20');

-- Dumping structure for table softui.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.role_has_permissions: ~0 rows (approximately)

-- Dumping structure for table softui.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table softui.users: ~5 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `phone`, `location`, `about`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', 'admin@softui.com', '2024-02-22 07:24:22', '$2y$10$tHCCyHjTrESrX3uDw0LVVOOlkBeI6zKl9s7tR2J4.Ak7YllTfnDcm', '0111332761', 'Machang,Kelantan', NULL, '4aopudar31lYNSGMWFaru8mQx5Gqwzqd9zGZgWVyLfqPOFg1q6j08LhrzjkN', 'Active', '2024-02-22 07:24:22', '2024-02-25 11:11:34'),
	(2, 'Guest1', 'guest@gmail.com', NULL, '$2y$10$tHCCyHjTrESrX3uDw0LVVOOlkBeI6zKl9s7tR2J4.Ak7YllTfnDcm', NULL, NULL, NULL, NULL, 'Active', '2024-02-24 10:12:25', '2024-02-24 10:12:25'),
	(3, 'admin2', 'admin2@test.com', NULL, '$2y$10$tHCCyHjTrESrX3uDw0LVVOOlkBeI6zKl9s7tR2J4.Ak7YllTfnDcm', NULL, NULL, NULL, NULL, 'Active', '2024-02-24 10:24:49', '2024-02-24 10:24:49'),
	(4, 'admin3', 'admin3@gmail.com', NULL, '$2y$10$tHCCyHjTrESrX3uDw0LVVOOlkBeI6zKl9s7tR2J4.Ak7YllTfnDcm', NULL, NULL, NULL, NULL, 'Active', '2024-02-25 03:18:26', '2024-02-25 03:18:26'),
	(6, 'test2', 'test2@gmail.com', NULL, '$2y$10$tHCCyHjTrESrX3uDw0LVVOOlkBeI6zKl9s7tR2J4.Ak7YllTfnDcm', NULL, NULL, NULL, NULL, 'Active', '2024-02-25 10:33:04', '2024-02-25 10:33:04');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
