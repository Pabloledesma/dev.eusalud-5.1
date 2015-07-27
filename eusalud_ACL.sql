-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-07-2015 a las 18:44:51
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `eusalud`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_06_20_103622_create_roles_table', 1),
('2015_06_20_104928_create_permissions_table', 1),
('2015_06_20_105232_create_permission_role_table', 1),
('2015_07_17_113017_create_ruaf_table', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL,
  `permission_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permission_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permission_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `permission_title`, `permission_slug`, `permission_description`, `created_at`, `updated_at`) VALUES
(1, 'Ver usuarios', 'ver_usuarios', 'El usuario podrá ver la tabla de usuarios registrados.', '2015-07-18 16:15:38', '2015-07-24 12:47:05'),
(2, 'Editar Usuarios', 'editar_usuarios', 'El usuario podrá editar los datos de otros usuarios\r\n', '2015-07-18 16:16:26', '2015-07-24 14:52:04'),
(3, 'Crear Usuarios', 'crear_usuarios', 'El usuario podrá crear usuarios.', '2015-07-18 16:17:00', '2015-07-18 16:17:00'),
(4, 'Eliminar Usuarios', 'eliminar_usuarios', 'El usuario podrá eliminar otros usuarios', '2015-07-18 16:17:31', '2015-07-18 16:17:31'),
(5, 'Certificado de pagos profesionales', 'pagos_profesionales', 'El usuario puede general el certificado de pago a profesionales', '2015-07-18 16:33:00', '2015-07-18 16:33:00'),
(6, 'Informe de pago a proveedores', 'pago_proveedores', 'El usuario puede generar el informe de pago a proveedores', '2015-07-18 16:34:13', '2015-07-18 16:34:13'),
(7, 'Certificado de retención, industria y comercio (ICA)', 'ica', 'El usuario puede generar el certificado de retención, industria y comercio (ICA)', '2015-07-18 16:35:16', '2015-07-18 16:35:16'),
(8, 'Censo', 'censo', 'El usuario podrá generar el censo', '2015-07-18 16:36:13', '2015-07-18 16:36:13'),
(9, 'Certificado de pagos a profesionales para administrador', 'pagos_profesionales_administrador', 'Puede generar el certificado de pagos de todos los profesionales', '2015-07-22 21:45:39', '2015-07-22 21:45:39'),
(10, 'Crear permisos', 'crear_permisos', 'puede crear permisos', '2015-07-24 12:22:13', '2015-07-24 12:22:13'),
(11, 'Ver los permisos creados', 'ver_permisos', 'puede ver los permisos creados', '2015-07-24 12:23:21', '2015-07-24 12:23:21'),
(12, 'Editar permisos', 'editar_permisos', 'puede editar los permisos.', '2015-07-24 12:24:19', '2015-07-24 12:24:19'),
(13, 'Eliminar permisos', 'eliminar_permisos', 'puede eliminar permisos', '2015-07-24 12:24:49', '2015-07-24 12:24:49'),
(14, 'Crear Roles', 'crear_roles', 'puede crear roles', '2015-07-24 12:25:21', '2015-07-24 12:25:21'),
(15, 'Ver roles', 'ver_roles', 'puede ver los roles', '2015-07-24 12:25:44', '2015-07-24 12:25:44'),
(16, 'Editar Roles', 'editar_roles', 'puede editar roles.', '2015-07-24 12:26:10', '2015-07-24 12:26:10'),
(17, 'Eliminar roles', 'eliminar_roles', 'Puede eliminar roles', '2015-07-24 12:26:36', '2015-07-24 13:58:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2015-07-18 17:15:59', '2015-07-18 17:15:59'),
(2, 1, '2015-07-22 17:05:04', '2015-07-22 17:05:04'),
(3, 1, '2015-07-22 20:11:48', '2015-07-22 20:11:48'),
(4, 1, '2015-07-22 20:11:48', '2015-07-22 20:11:48'),
(5, 1, '2015-07-22 20:11:48', '2015-07-22 20:11:48'),
(5, 2, '2015-07-24 13:38:25', '2015-07-24 13:38:25'),
(5, 3, '2015-07-22 20:12:59', '2015-07-22 20:12:59'),
(6, 1, '2015-07-22 20:11:48', '2015-07-22 20:11:48'),
(6, 2, '2015-07-24 13:57:26', '2015-07-24 13:57:26'),
(6, 3, '2015-07-22 20:12:59', '2015-07-22 20:12:59'),
(6, 4, '2015-07-24 15:04:46', '2015-07-24 15:04:46'),
(6, 5, '2015-07-24 15:05:00', '2015-07-24 15:05:00'),
(7, 1, '2015-07-22 20:11:48', '2015-07-22 20:11:48'),
(7, 3, '2015-07-22 20:12:59', '2015-07-22 20:12:59'),
(7, 4, '2015-07-24 15:04:46', '2015-07-24 15:04:46'),
(8, 1, '2015-07-22 20:11:48', '2015-07-22 20:11:48'),
(8, 3, '2015-07-24 14:54:39', '2015-07-24 14:54:39'),
(8, 4, '2015-07-24 15:04:46', '2015-07-24 15:04:46'),
(9, 1, '2015-07-24 13:05:40', '2015-07-24 13:05:40'),
(9, 3, '2015-07-24 14:54:39', '2015-07-24 14:54:39'),
(9, 4, '2015-07-24 15:04:46', '2015-07-24 15:04:46'),
(10, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(11, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(12, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(13, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(14, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(15, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(16, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52'),
(17, 1, '2015-07-24 13:28:52', '2015-07-24 13:28:52');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL,
  `role_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role_title`, `role_slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrador del sistema', 'admin_sis', '2015-07-18 16:11:02', '2015-07-18 16:11:02'),
(2, 'Médico Profesional', 'medico_profesional', '2015-07-18 16:11:23', '2015-07-18 16:11:23'),
(3, 'Administrador Financiero', 'admin_financiero', '2015-07-18 16:12:15', '2015-07-18 16:12:15'),
(4, 'Jefe Administrativo', 'jefe_administrativo', '2015-07-18 16:13:38', '2015-07-18 16:13:38'),
(5, 'Auditor', 'auditor', '2015-07-18 16:14:07', '2015-07-18 16:14:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruaf`
--

CREATE TABLE IF NOT EXISTS `ruaf` (
  `id` int(11) NOT NULL,
  `numero_certificado` int(11) NOT NULL,
  `departamento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `municipio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `area_nacimiento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inspeccion_corregimiento_o_caserio_nacimiento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sitio_nacimiento` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codigo_institucion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_institucion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sexo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `peso_gramos` int(11) NOT NULL,
  `talla_centimetros` int(11) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `hora_nacimiento` time NOT NULL,
  `parto_atendido_por` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tiempo_de_gestacion` int(11) NOT NULL,
  `numero_consultas_prenatales` int(11) NOT NULL,
  `tipo_parto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `multiplicidad_embarazo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apgar1` int(11) NOT NULL,
  `apgar2` int(11) NOT NULL,
  `grupo_sanguineo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `factor_rh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pertenencia_etnica` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grupo_indigena` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombres_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_documento_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero_documento_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edad_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `estado_conyugal_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nive_educativo_madre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ultimo_ano_aprovado_madre` int(11) NOT NULL,
  `pais_residencia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departamento_residencia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `municipio_residencia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `area_residencia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `localidad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `barrio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `centro_poblado` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rural_disperso` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_hijos_nacidos_vivos` int(11) NOT NULL,
  `fecha_anterior_hijo_nacido_vivo` date DEFAULT NULL,
  `numero_embarazos` int(11) NOT NULL,
  `regimen_seguridad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_administradora` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_administradora` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `edad_padre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nivel_educativo_padre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ultimo_ano_aprovado_padre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombres_y_apellidos_certificador` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero_documento_certificador` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `departamento_expedicion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `municipio_expedicion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_expedicion` date NOT NULL,
  `estado_certificado` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `num_id` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `num_id`, `name`, `email`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '80099493', 'Pablo Ledesma', 'pablo.ledesma@eusalud.com', '$2y$10$LPUH5IXGZUemZuliYFKBke478mdFQarSaC0HieDhHgDVH7pykXO2G', 1, 'ZumaeB42FQJsvYS0QWQeDDqxM8gh4MkEcmk6NwoP1w7SU8gXMKeb9821hRWy', '2015-07-18 15:38:04', '2015-07-27 14:37:45'),
(2, '123456789', 'Rosalyn Runolfsdottir', 'Reilly70@hotmail.com', '$2y$10$PhXmgbmwRhNghmhvBXcSsOdkMYbrLKc8lQZaxbjO/gwRP1tWumXqm', 2, 'JRy1X7TVxDCpEducKiRVx4Xo3tdBhrr5582yMXzCa0UyOTY7oGPnJfwzIPxE', '2015-07-18 15:44:26', '2015-07-24 14:01:16'),
(3, '9150340', 'Vincent Trantow', 'Stefanie.Legros@hotmail.com', '$2y$10$r55sWqovhSsoNHzxUJQQUeh.GrXqBod0gc8Vd/vAjzsi8dHkZm68K', 3, 'VYJ0CY8kdu9quu3uoxHNz39GzPZnXO3J7MTldfCivbIqoCpeo11PPQvI4XKZ', '2015-07-22 20:31:29', '2015-07-24 14:57:20'),
(4, '629000996', 'Vilma Mosciski', 'Erik96@yahoo.com', '$2y$10$fKBq3Mj6lFMZE3ikyk9Vm.HjMAzRd9l/wo.tDGURRg5XUiLCOB2QO', 5, 'YcCp1CxapF', '2015-07-22 20:31:29', '2015-07-24 15:11:06'),
(5, '1054795814', 'Jace Marquardt', 'Katheryn94@Moen.org', '$2y$10$ynn9iPMNstqcvxffkZG.g.qcgN0o6Xze7jTWtOWRMeWD5gsMz9Z4m', NULL, 'EUCvZ8Vi3i', '2015-07-22 20:31:29', '2015-07-22 20:31:29'),
(6, '55822469', 'Toby Hudson', 'Jerrold.Feeney@Cremin.net', '$2y$10$EZ0QXX0v2Ogw/5QpEgJ6xuZCChRGUkQt2nfsQQ9wzT4Jp1L21cCyS', NULL, '7H3z0bcSaq', '2015-07-22 20:31:29', '2015-07-22 20:31:29'),
(7, '2047064583', 'Cristina Schuster', 'Giles95@gmail.com', '$2y$10$pypPeDJqKJUfys6gsyUGC.s22Z.4euxzEciCaI271OQ2sruZTjxrO', NULL, 'jz73S2f9Eo', '2015-07-22 20:31:29', '2015-07-22 20:31:29'),
(8, '1111111111', 'Yimmy Saenz', 'yimmy.saenz@eusalud.com', '$2y$10$iPv.eU6njEN029ev0m1bYO5IZ9adu9PkyyA7/GMfK3wuI7RR2Yvwa', 1, NULL, '2015-07-24 15:13:24', '2015-07-24 15:13:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`), ADD KEY `password_resets_token_index` (`token`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
