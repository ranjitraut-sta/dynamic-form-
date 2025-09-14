-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 05:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amdsoft_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `dashboardmanagement`
--

CREATE TABLE `dashboardmanagement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `example_field` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2024_11_21_064731_create_roles_table', 1),
(8, '2024_11_21_064732_create_users_table', 1),
(9, '2024_11_21_072115_create_permissions_table', 1),
(10, '2024_11_21_075339_create_role_has_permission_table', 1),
(11, '2025_02_27_095955_create_settings_table', 1),
(15, '2025_07_02_035732_create_password_resets_table', 1),
(28, '2025_07_21_101732_create_dashboardmanagement_table', 2),
(29, '2025_08_22_113414_add_social_fields_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `action`, `controller`, `group_name`, `created_at`, `updated_at`) VALUES
(1, 'View Admin Dashboard', 'AdminLayout', 'DashboardManagementController', 'dashboard', '2025-07-10 00:40:08', '2025-08-22 01:25:12'),
(2, 'View Roles', 'index', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(3, 'Create Role', 'create', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(4, 'Store Role', 'store', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(5, 'Edit Role', 'edit', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(6, 'Update Role', 'update', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(7, 'Delete Role', 'delete', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(8, 'Show Role Details', 'show', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(9, 'Assign Permission to Role', 'addPermission', 'RoleController', 'role', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(10, 'View Permissions', 'index', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(11, 'Create Permission', 'create', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(12, 'Store Permission', 'store', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(13, 'Edit Permission', 'edit', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(14, 'Update Permission', 'update', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(15, 'Delete Permission', 'delete', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(16, 'Show Permission Details', 'show', 'PermissionController', 'permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(17, 'Assign Permissions to Roles', 'store', 'RoleHasPermissionController', 'role_permission', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(18, 'View Users', 'index', 'UserController', 'user', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(19, 'Create User', 'create', 'UserController', 'user', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(20, 'Store User', 'store', 'UserController', 'user', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(21, 'Edit User', 'edit', 'UserController', 'user', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(22, 'Update User', 'update', 'UserController', 'user', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(23, 'Delete User', 'delete', 'UserController', 'user', '2025-07-10 00:40:08', '2025-07-10 00:40:08'),
(32, 'drag order', 'updateOrder', 'RoleController', 'role', '2025-08-12 04:28:50', '2025-08-12 04:29:28'),
(33, 'drag order', 'updateOrder', 'UserController', 'user', '2025-08-12 05:43:56', '2025-08-12 05:43:56'),
(35, 'bul delete', 'bulkDelete', 'UserController', 'user', '2025-08-13 23:58:22', '2025-08-13 23:58:22'),
(36, 'bulk delete', 'bulkDelete', 'PermissionController', 'permission', '2025-08-14 01:05:45', '2025-08-14 01:05:45'),
(37, 'bulk delete', 'bulkDelete', 'RoleController', 'role', '2025-08-14 01:06:20', '2025-08-14 01:06:20'),
(45, 'profile', 'userProfile', 'UserController', 'user', '2025-08-22 02:43:53', '2025-08-22 02:58:34'),
(47, 'update profile', 'updateProfile', 'UserController', 'user', '2025-08-22 04:25:01', '2025-08-22 04:25:01');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 1, '2025-07-10 00:40:07', '2025-07-20 03:31:42'),
(3, 'author', 3, '2025-07-10 00:40:07', '2025-07-10 00:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permission`
--

CREATE TABLE `role_has_permission` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permission`
--

INSERT INTO `role_has_permission` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 32),
(1, 33),
(1, 35),
(1, 37),
(1, 36),
(1, 45),
(1, 47),
(3, 1),
(3, 45),
(3, 47);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `site_name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `default_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `logo`, `favicon`, `address`, `phone`, `email`, `default_image`, `created_at`, `updated_at`) VALUES
(1, 'Software House', NULL, NULL, 'Kathamandu Nepal', '9810203040', 'superadmin@gmail.com', NULL, '2025-07-10 00:40:08', '2025-07-10 00:40:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email_verification_token` varchar(64) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT 0,
  `is_superadmin` int(11) DEFAULT 0,
  `last_login` datetime DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `full_name`, `email`, `email_verified_at`, `email_verification_token`, `password`, `provider`, `provider_id`, `avatar`, `role_id`, `is_superadmin`, `last_login`, `profile_image`, `status`, `display_order`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ranjit', 'Ranjit Raut', 'ranjitraut877@mail.com', '2025-07-10 00:40:07', NULL, '$2y$12$f.xsSU3x5OGH6L5mkZHi/.EDeMmelq8mTwYQam26EvSJlRBr1i8wG', NULL, NULL, NULL, 1, 0, '2025-08-25 03:57:06', '1755858654_image_68a846de14785.jpg', 1, 1, NULL, '2025-07-10 00:40:07', '2025-08-22 04:50:45'),
(8, 'bidan', NULL, 'bahaqaji@mailinator.com', NULL, NULL, '$2y$12$5GxDUP7ybG5uGIsFrWB.M.NPEnsRdpZdMBDa0sEXhvPTPzrH5PiLC', NULL, NULL, NULL, 3, 0, '2025-08-22 11:13:34', '1755861236_image_68a850f412ecc.jpg', 1, 5, NULL, '2025-07-20 06:09:40', '2025-08-22 05:28:56'),
(34, 'Audra', NULL, 'xaqacobom@mailinator.com', NULL, NULL, '$2y$12$M2kazJ9irXmMleMu64PToeuG2AGkdFiS6g47v.R/QkDf3UfUMFph.', NULL, NULL, NULL, 3, 0, NULL, NULL, 1, 0, NULL, '2025-08-22 05:42:29', '2025-08-22 05:42:29'),
(35, 'amd soft', NULL, 'amdsoft75@gmail.com', NULL, NULL, '$2y$12$x16pXUL.vX.A65jpqxLVr.V2xEc3qqhmfABdwy8ln1P7zMbJeNyY2', 'google', '114561052740043450292', 'https://lh3.googleusercontent.com/a/ACg8ocKw7qWrGPbvKn2p-9e6lmJDzeWIxR9B6s93TZ6HZYNf8nf8XA=s96-c', 3, 0, NULL, NULL, 1, 0, NULL, '2025-08-22 06:12:03', '2025-08-22 06:12:03'),
(36, 'amdsoft sales', NULL, 'sales.amdsoft@gmail.com', NULL, NULL, '$2y$12$z7hp6MbyG3nJlQb0g8yJO.5Go07E1eiEZ9FPpwSbaDFwmYSWFzT26', 'google', '105264364562760521270', 'https://lh3.googleusercontent.com/a/ACg8ocIH_3j2lcMNXx_Q79tjGk2FoT3Vky1MCk0eZn2Ty18xU3oBXw=s96-c', 3, 0, NULL, NULL, 1, 0, NULL, '2025-08-23 23:37:58', '2025-08-23 23:37:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dashboardmanagement`
--
ALTER TABLE `dashboardmanagement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD KEY `role_has_permission_role_id_foreign` (`role_id`),
  ADD KEY `role_has_permission_permission_id_foreign` (`permission_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dashboardmanagement`
--
ALTER TABLE `dashboardmanagement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_has_permission`
--
ALTER TABLE `role_has_permission`
  ADD CONSTRAINT `role_has_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_has_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
