-- -------------------------------------------------------------
-- TablePlus 6.0.0(550)
--
-- https://tableplus.com/
--
-- Database: file_manager
-- Generation Time: 2025-02-27 03:23:00.4020
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
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

CREATE TABLE `file_favorites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `file_manager_id` bigint unsigned NOT NULL,
  `type` enum('favorite','unfavorite') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_favorites_uuid_unique` (`uuid`),
  KEY `file_favorites_user_id_index` (`user_id`),
  KEY `file_favorites_file_manager_id_index` (`file_manager_id`),
  CONSTRAINT `file_favorites_file_manager_id_foreign` FOREIGN KEY (`file_manager_id`) REFERENCES `file_managers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `file_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_remove_id` bigint unsigned DEFAULT NULL,
  `user_edit_id` bigint unsigned DEFAULT NULL,
  `file_manager_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_infos_uuid_unique` (`uuid`),
  KEY `file_infos_user_remove_id_foreign` (`user_remove_id`),
  KEY `file_infos_user_edit_id_foreign` (`user_edit_id`),
  KEY `file_infos_user_id_index` (`user_id`),
  KEY `file_infos_file_manager_id_index` (`file_manager_id`),
  CONSTRAINT `file_infos_file_manager_id_foreign` FOREIGN KEY (`file_manager_id`) REFERENCES `file_managers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_infos_user_edit_id_foreign` FOREIGN KEY (`user_edit_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_infos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_infos_user_remove_id_foreign` FOREIGN KEY (`user_remove_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `file_managers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_clasification` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_edit_id` bigint unsigned DEFAULT NULL,
  `user_remove_id` bigint unsigned DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ext` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paths` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `size` bigint DEFAULT NULL,
  `type` enum('file','folder') COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` enum('public','private') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `visit` bigint NOT NULL DEFAULT '0',
  `download` bigint NOT NULL DEFAULT '0',
  `share` bigint NOT NULL DEFAULT '0',
  `like` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_managers_uuid_unique` (`uuid`),
  KEY `file_managers_code_clasification_index` (`code_clasification`),
  KEY `file_managers_user_id_index` (`user_id`),
  KEY `file_managers_user_edit_id_index` (`user_edit_id`),
  KEY `file_managers_user_remove_id_index` (`user_remove_id`),
  KEY `file_managers_parent_id_index` (`parent_id`),
  CONSTRAINT `file_managers_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `file_managers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_managers_user_edit_id_foreign` FOREIGN KEY (`user_edit_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_managers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_managers_user_remove_id_foreign` FOREIGN KEY (`user_remove_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `file_shares` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_remove_id` bigint unsigned DEFAULT NULL,
  `user_share_id` bigint unsigned NOT NULL,
  `file_manager_id` bigint unsigned NOT NULL,
  `type` enum('view','edit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_shares_uuid_unique` (`uuid`),
  KEY `file_shares_user_remove_id_foreign` (`user_remove_id`),
  KEY `file_shares_user_id_index` (`user_id`),
  KEY `file_shares_user_share_id_index` (`user_share_id`),
  KEY `file_shares_file_manager_id_index` (`file_manager_id`),
  CONSTRAINT `file_shares_file_manager_id_foreign` FOREIGN KEY (`file_manager_id`) REFERENCES `file_managers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_shares_user_remove_id_foreign` FOREIGN KEY (`user_remove_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `file_shares_user_share_id_foreign` FOREIGN KEY (`user_share_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `file_viewrs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `file_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_viewrs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('super-admin','admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `file_favorites` (`id`, `uuid`, `user_id`, `file_manager_id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(4, 'a5add12f-903c-4e2f-88bc-9832e009c5f2', 1, 4, 'favorite', '2025-02-25 18:28:07', '2025-02-25 18:33:57', '2025-02-25 18:33:57'),
(5, '848fc63b-3c23-4940-9e42-f13327ae8e1a', 1, 1, 'favorite', '2025-02-25 18:34:01', '2025-02-25 18:34:06', '2025-02-25 18:34:06'),
(6, '45592b1b-0c85-4848-b308-810692927ba1', 3, 3, 'favorite', '2025-02-26 18:51:42', '2025-02-26 18:51:52', '2025-02-26 18:51:52'),
(7, '0ce08270-b0a0-4d67-96ad-7859f2b35183', 3, 3, 'favorite', '2025-02-26 18:51:53', '2025-02-26 18:51:54', '2025-02-26 18:51:54'),
(8, 'c13f5d40-d78b-48ea-ae5d-5453f15534d5', 3, 3, 'favorite', '2025-02-26 18:51:55', '2025-02-26 18:51:55', '2025-02-26 18:51:55'),
(9, 'c6eeb554-a68f-43f5-9f17-a87037afbce0', 3, 3, 'favorite', '2025-02-26 18:51:56', '2025-02-26 18:51:57', '2025-02-26 18:51:57'),
(10, '84db271b-ab89-4bb1-b98e-59ec8ae817a5', 3, 3, 'favorite', '2025-02-26 18:52:01', '2025-02-26 18:52:54', '2025-02-26 18:52:54'),
(11, 'a73ab643-dfc3-4a4c-becd-ba98772f8417', 3, 3, 'favorite', '2025-02-26 18:52:55', '2025-02-26 18:53:13', '2025-02-26 18:53:13'),
(12, 'f60fd1fb-2b20-4e50-90f4-6086d03554cf', 3, 3, 'favorite', '2025-02-26 18:53:16', '2025-02-26 18:53:17', '2025-02-26 18:53:17'),
(13, '8278f9ef-1525-4ac7-a579-e78ab3ec49d2', 3, 3, 'favorite', '2025-02-26 18:53:26', '2025-02-26 18:54:02', '2025-02-26 18:54:02'),
(14, 'd2d335db-0768-4f9b-ad71-2720754daede', 3, 3, 'favorite', '2025-02-26 18:54:11', '2025-02-26 18:54:23', '2025-02-26 18:54:23'),
(15, 'ec35d580-108f-4ddf-b5c8-6d2a3e9bcd15', 3, 3, 'favorite', '2025-02-26 18:54:24', '2025-02-26 18:55:14', '2025-02-26 18:55:14'),
(16, '4cdb1307-ec97-40c1-8a3b-5a9777cda9ce', 3, 3, 'favorite', '2025-02-26 18:55:17', '2025-02-26 18:55:20', '2025-02-26 18:55:20'),
(17, 'cd8788a3-e6bd-4f2c-b4fc-b18279d9c7af', 3, 3, 'favorite', '2025-02-26 18:55:21', '2025-02-26 18:56:32', '2025-02-26 18:56:32'),
(18, '0ccae92c-e31e-42fd-bc16-5735603724f5', 3, 3, 'favorite', '2025-02-26 18:56:33', '2025-02-26 18:56:58', '2025-02-26 18:56:58'),
(19, '867bc5fd-e19a-4ffd-9bff-4913349397b5', 3, 3, 'favorite', '2025-02-26 18:56:59', '2025-02-26 18:58:00', '2025-02-26 18:58:00'),
(20, '5d64c2f9-34f9-4721-9b60-3730f4cfb00c', 3, 3, 'favorite', '2025-02-26 18:58:01', '2025-02-26 18:58:03', '2025-02-26 18:58:03'),
(21, 'f38479d1-e274-49e1-8558-5d2fa7144fd3', 3, 3, 'favorite', '2025-02-26 18:58:04', '2025-02-26 19:01:48', '2025-02-26 19:01:48');

INSERT INTO `file_infos` (`id`, `uuid`, `user_id`, `user_remove_id`, `user_edit_id`, `file_manager_id`, `name`, `type`, `value`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '51a433d9-1c40-411d-b54d-448f9b726bb6', 1, NULL, NULL, 4, 'test', 'text', '12', '2025-02-25 12:12:05', '2025-02-25 12:12:05', NULL),
(2, '0d00ffec-7f29-4eb8-abf9-083d76bf79bf', 2, NULL, NULL, 6, 'x', 'text', '89', '2025-02-25 18:38:50', '2025-02-25 18:38:50', NULL);

INSERT INTO `file_managers` (`id`, `uuid`, `code_clasification`, `user_id`, `user_edit_id`, `user_remove_id`, `password`, `name`, `icon`, `ext`, `mime`, `paths`, `url`, `parent_id`, `size`, `type`, `visibility`, `status`, `visit`, `download`, `share`, `like`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'b42079d0-96a4-4821-87af-72dd4e195771', NULL, 1, NULL, NULL, NULL, '.gitignore', NULL, NULL, NULL, '.gitignore', NULL, NULL, 14, 'file', 'private', 'active', 0, 0, 0, 0, '2025-02-24 21:52:10', '2025-02-24 21:52:10', NULL),
(2, 'fccfee0c-98e4-4188-9803-db6420999dfc', '000', 1, NULL, NULL, NULL, 'Umum', NULL, NULL, NULL, 'Umum', NULL, NULL, NULL, 'folder', 'private', 'active', 0, 0, 0, 0, '2025-02-24 21:55:01', '2025-02-24 21:55:01', NULL),
(3, '223f497c-b60f-4596-a374-6578062f3b78', 'ppx', 1, NULL, NULL, NULL, 'Art photo book .pptx', NULL, 'pptx', NULL, 'Umum/Art photo book .pptx', NULL, 2, 2023193, 'file', 'private', 'active', 0, 0, 0, 0, '2025-02-24 21:57:38', '2025-02-24 21:57:38', NULL),
(4, 'f41650e3-4d09-4ebc-a67c-5d94baae7526', '9698789', 1, NULL, NULL, NULL, '1. Konsep Basis Data.pdf', NULL, 'pdf', NULL, 'Umum/1. Konsep Basis Data.pdf', NULL, 2, 875672, 'file', 'private', 'active', 0, 0, 0, 0, '2025-02-25 12:12:05', '2025-02-25 12:12:05', NULL),
(5, 'd504c3c6-7f6b-45ac-885d-31cf672a596f', '14', 1, NULL, NULL, NULL, 'x', NULL, NULL, NULL, 'Umum/x', NULL, 2, NULL, 'folder', 'private', 'active', 0, 0, 0, 0, '2025-02-25 18:28:03', '2025-02-25 18:28:03', NULL),
(6, '1d49ced2-4822-4678-bab1-68d58ff0ada9', '7656', 2, NULL, NULL, NULL, 'CamScanner 14-02-2025 17.02.pdf', NULL, 'pdf', NULL, 'Umum/CamScanner 14-02-2025 17.02.pdf', NULL, 2, 442936, 'file', 'private', 'active', 0, 0, 0, 0, '2025-02-25 18:38:50', '2025-02-25 18:38:50', NULL);

INSERT INTO `file_shares` (`id`, `uuid`, `user_id`, `user_remove_id`, `user_share_id`, `file_manager_id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, '0c5ecc2b-3016-42a1-b086-0e2f74aa1108', 3, NULL, 2, 3, 'view', '2025-02-26 18:44:26', '2025-02-26 18:45:34', '2025-02-26 18:45:34'),
(6, 'cb2c6bbb-dc15-449c-815b-770ca4eba449', 3, NULL, 2, 3, 'view', '2025-02-26 18:45:40', '2025-02-26 18:46:12', '2025-02-26 18:46:12'),
(7, '614a810e-afa7-4c17-8c67-c1c3cdc75a52', 3, NULL, 2, 3, 'view', '2025-02-26 18:49:52', '2025-02-26 18:49:58', '2025-02-26 18:49:58'),
(8, 'a910e7c8-59dc-4f8b-ae97-a5f8bfaad8c1', 3, NULL, 2, 3, 'view', '2025-02-26 18:50:38', '2025-02-26 18:50:41', '2025-02-26 18:50:41'),
(9, 'b16cf77a-6841-46be-8eb2-975a7dcddf63', 3, NULL, 2, 3, 'view', '2025-02-26 18:50:55', '2025-02-26 18:50:57', '2025-02-26 18:50:57'),
(10, '682ce858-6371-4331-8115-20a030ac9dbb', 3, NULL, 2, 3, 'view', '2025-02-26 18:50:59', '2025-02-26 18:50:59', NULL);

INSERT INTO `file_viewrs` (`id`, `uuid`, `user_id`, `file_id`, `created_at`, `updated_at`) VALUES
(1, '04af1626-2024-4d13-899d-4227f3e0df14', 1, 3, '2025-02-24 21:57:39', '2025-02-24 21:57:39'),
(2, '79035499-bd18-4877-923a-76bc2395cc1d', 1, 3, '2025-02-25 12:11:44', '2025-02-25 12:11:44'),
(3, '60f08f7a-05b2-4797-80c6-481a1f1b8bac', 1, 4, '2025-02-25 12:12:08', '2025-02-25 12:12:08'),
(4, '3b6c3869-a750-4dba-98c2-0e7ab15be42d', 2, 6, '2025-02-25 18:40:00', '2025-02-25 18:40:00'),
(5, 'bb05fc3f-3081-4364-ac45-8b423cb02b88', 2, 4, '2025-02-26 19:30:24', '2025-02-26 19:30:24');

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_18_210113_create_file_managers_table', 1),
(5, '2025_02_18_210201_create_permission_tables', 1),
(6, '2025_02_18_210646_create_file_info_table', 1),
(7, '2025_02_18_211050_create_file_shares_table', 1),
(8, '2025_02_18_211846_create_file_favorites_table', 1),
(9, '2025_02_24_181516_create_file_viewrs_table', 1);

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 3);

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, '000', 'web', '2025-02-24 21:55:01', '2025-02-24 21:55:01'),
(2, 'ppx', 'web', '2025-02-24 21:57:38', '2025-02-24 21:57:38'),
(3, '9698789', 'web', '2025-02-25 12:12:05', '2025-02-25 12:12:05'),
(4, '14', 'web', '2025-02-25 18:28:03', '2025-02-25 18:28:03'),
(5, '7656', 'web', '2025-02-25 18:38:50', '2025-02-25 18:38:50');

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 2),
(3, 1);

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'MX', 'web', '2025-02-25 18:38:03', '2025-02-25 18:38:03'),
(2, 'usx', 'web', '2025-02-25 18:41:02', '2025-02-25 18:41:02');

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aUfqOF8Dc3oVRFIoPCSAx8q1bJV909gAXzRJqV0m', 2, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMXdBYWR1dEZ0TDBDWlRaV3NTWURRNkZoTGRxN0h3b2NuekNmV284dCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTA5OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvZmlsZS1tYW5hZ2VyL2ZjY2ZlZTBjLTk4ZTQtNDE4OC05ODAzLWRiNjQyMDk5OWRmYz9zZWFyY2g9MS4lMjBLb25zZXAlMjBCYXNpcyUyMERhdGEucGRmIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9', 1740598634),
('dFlxyxZUsCtML8NeWZyv1VMFnyjBOATItPA5opKm', 3, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaTd3dFFyMGx2eDVMSW1Od2tQY1pad1JydEViT0IyYXRmTXdRSlJnZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9maWxlLW1hbmFnZXIvZmNjZmVlMGMtOThlNC00MTg4LTk4MDMtZGI2NDIwOTk5ZGZjIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1740600221);

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin', 'super@storage.com', '2025-02-24 21:51:42', '$2y$12$MVHf8YP6SsbSuNsJgRyVqueuKNxh0WpOtw6A3h5Dvg6pYQjawd4s6', 'super-admin', 'FGpuWI44xt', '2025-02-24 21:51:42', '2025-02-24 21:51:42'),
(2, 'ego', 'egooktafanda', 'egooktafanda@mail.com', NULL, '$2y$12$eVZmMWUZ50xr.jsHvMfWCOqTtzK8dyxDRqI9Lq9ous9Oa8TubX.Qq', 'user', NULL, '2025-02-25 18:37:48', '2025-02-25 18:37:48'),
(3, 'igo', 'igo', 'igo@mail.com', NULL, '$2y$12$wuXimDrvGbdJW5VPfwLbMOldfE/7SJDjnkXms5IXxn9XrBv.ORFmC', 'user', NULL, '2025-02-25 18:40:52', '2025-02-25 18:40:52');



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;