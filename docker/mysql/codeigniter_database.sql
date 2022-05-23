-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 14-03-2022 a las 16:16:37
-- Versión del servidor: 8.0.28
-- Versión de PHP: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vde_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `characteristics`
--

CREATE TABLE `characteristics` (
  `charID` int NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `charCompound`
--

CREATE TABLE `charCompound` (
  `charID` int NOT NULL,
  `resID` int NOT NULL,
  `valID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resource`
--

CREATE TABLE `resource` (
  `resourceID` int NOT NULL,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text NOT NULL,
  `state` int NOT NULL,
  `font` varchar(20) NOT NULL,
  `format` varchar(20) NOT NULL,
  `format2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `variety` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spanishlvl` int DEFAULT NULL,
  `autor` varchar(35) NOT NULL,
  `editor` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `file` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `link` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `expComment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `proposerMail` varchar(40) NOT NULL,
  `publisherMail` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `proposeDate` date NOT NULL,
  `publishDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (x
  `email` varchar(40) NOT NULL,
  `password` varchar(35) NOT NULL,
  `fullName` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` int NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `spanishlvl` int DEFAULT NULL,
  `university` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `birthPlace` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `respMail` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `createDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `values`
--

CREATE TABLE `values` (
  `valueID` int NOT NULL,
  `word` varchar(20) NOT NULL,
  `example` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `characteristics`
--
ALTER TABLE `characteristics`
  ADD PRIMARY KEY (`charID`);

--
-- Indices de la tabla `charCompound`
--
ALTER TABLE `charCompound`
  ADD PRIMARY KEY (`charID`),
  ADD KEY `resID` (`resID`),
  ADD KEY `valID` (`valID`);

--
-- Indices de la tabla `resource`
--
ALTER TABLE `resource`
  ADD PRIMARY KEY (`resourceID`),
  ADD KEY `proposerMail` (`proposerMail`),
  ADD KEY `publisherMail` (`publisherMail`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD KEY `respMail` (`respMail`);

--
-- Indices de la tabla `values`
--
ALTER TABLE `values`
  ADD PRIMARY KEY (`valueID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `characteristics`
--
ALTER TABLE `characteristics`
  MODIFY `charID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resource`
--
ALTER TABLE `resource`
  MODIFY `resourceID` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `values`
--
ALTER TABLE `values`
  MODIFY `valueID` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `charCompound`
--
ALTER TABLE `charCompound`
  ADD CONSTRAINT `charCompound_ibfk_1` FOREIGN KEY (`charID`) REFERENCES `characteristics` (`charID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `charCompound_ibfk_2` FOREIGN KEY (`resID`) REFERENCES `resource` (`resourceID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `charCompound_ibfk_3` FOREIGN KEY (`valID`) REFERENCES `values` (`valueID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `resource`
--
ALTER TABLE `resource`
  ADD CONSTRAINT `resource_ibfk_1` FOREIGN KEY (`proposerMail`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `resource_ibfk_2` FOREIGN KEY (`publisherMail`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`respMail`) REFERENCES `users` (`email`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
