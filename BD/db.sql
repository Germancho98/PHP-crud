-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-08-2021 a las 18:07:30
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `users_sistem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ud_articles`
--

CREATE TABLE `ud_articles` (
  `id_article` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `url` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `description_a` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `images` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `videos` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `ahutor` int(11) NOT NULL,
  `visitors` int(11) NOT NULL,
  `comments` int(11) NOT NULL,
  `like_points` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ud_comments`
--

CREATE TABLE `ud_comments` (
  `id` int(11) NOT NULL,
  `idarticle` int(11) NOT NULL,
  `ahutor` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ud_like`
--

CREATE TABLE `ud_like` (
  `id` int(11) NOT NULL,
  `idarticle` int(11) NOT NULL,
  `ahutor` int(11) NOT NULL,
  `like_point` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ud_notifications`
--

CREATE TABLE `ud_notifications` (
  `id_notification` int(11) NOT NULL,
  `idarticle` int(11) NOT NULL,
  `ahutor_comment` int(11) NOT NULL,
  `ahutor_article` int(11) NOT NULL,
  `status_notifications` int(11) NOT NULL,
  `token_status` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ud_users`
--

CREATE TABLE `ud_users` (
  `id` int(11) NOT NULL,
  `user_name` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `password` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `description` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `picture` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `banner` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `token` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ud_visitors`
--

CREATE TABLE `ud_visitors` (
  `id` int(11) NOT NULL,
  `idarticle` int(11) NOT NULL,
  `ip_location` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;



--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ud_articles`
--
ALTER TABLE `ud_articles`
  ADD PRIMARY KEY (`id_article`);

--
-- Indices de la tabla `ud_comments`
--
ALTER TABLE `ud_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ud_like`
--
ALTER TABLE `ud_like`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ud_notifications`
--
ALTER TABLE `ud_notifications`
  ADD PRIMARY KEY (`id_notification`);

--
-- Indices de la tabla `ud_users`
--
ALTER TABLE `ud_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ud_visitors`
--
ALTER TABLE `ud_visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ud_articles`
--
ALTER TABLE `ud_articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `ud_comments`
--
ALTER TABLE `ud_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ud_like`
--
ALTER TABLE `ud_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ud_notifications`
--
ALTER TABLE `ud_notifications`
  MODIFY `id_notification` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ud_users`
--
ALTER TABLE `ud_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ud_visitors`
--
ALTER TABLE `ud_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
