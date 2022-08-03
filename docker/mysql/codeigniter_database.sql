-- Adminer 4.8.1 MySQL 8.0.28 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `characteristics`;
CREATE TABLE `characteristics` (
  `charID` int NOT NULL AUTO_INCREMENT,
  `charName` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title1` varchar(30) NOT NULL,
  `title2` varchar(30) NOT NULL,
  `title3` varchar(30) NOT NULL,
  PRIMARY KEY (`charID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `characteristics` (`charID`, `charName`, `title1`, `title2`, `title3`) VALUES
(1,	'Pronunciación',	'Rasgo',	'Ejemplo',	'Descripción'),
(2,	'Gramatica',	'Rasgo',	'Ejemplo',	'Descripción'),
(3,	'Vocabulario',	'Lema',	'Forma',	'Significado');

DROP TABLE IF EXISTS `compound`;
CREATE TABLE `compound` (
  `resID` int NOT NULL,
  `charID` int NOT NULL,
  `valID` int NOT NULL,
  PRIMARY KEY (`charID`,`valID`,`resID`),
  KEY `resID` (`resID`),
  CONSTRAINT `compound_ibfk_1` FOREIGN KEY (`resID`) REFERENCES `resource` (`resourceID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `compound_ibfk_2` FOREIGN KEY (`charID`, `valID`) REFERENCES `values` (`charID`, `valID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `compound` (`resID`, `charID`, `valID`) VALUES
(5,	3,	2),
(6,	3,	14),
(9,	1,	2),
(9,	1,	6),
(9,	1,	7),
(9,	1,	10),
(9,	2,	7),
(10,	1,	5),
(10,	2,	7),
(13,	1,	5),
(13,	2,	8),
(13,	3,	3),
(28,	2,	7),
(28,	3,	1),
(29,	1,	1),
(29,	1,	5),
(29,	1,	8),
(29,	2,	2),
(29,	2,	3),
(29,	2,	7),
(35,	1,	6),
(35,	1,	10),
(35,	2,	2),
(35,	2,	8),
(36,	1,	5),
(36,	2,	1),
(36,	2,	6),
(36,	3,	1),
(37,	1,	4),
(37,	1,	9),
(37,	2,	3),
(37,	3,	1),
(37,	3,	4),
(37,	3,	5),
(38,	1,	6),
(38,	1,	9),
(38,	2,	4),
(38,	2,	8),
(51,	1,	1),
(51,	1,	3),
(51,	2,	2),
(51,	2,	4),
(51,	3,	1),
(51,	3,	7),
(51,	3,	11),
(51,	3,	12),
(52,	1,	2),
(52,	1,	4),
(52,	2,	1),
(52,	2,	3),
(52,	3,	11),
(53,	1,	1),
(53,	2,	2),
(53,	3,	11),
(54,	1,	2),
(54,	2,	3),
(54,	3,	12),
(55,	1,	3),
(55,	2,	4),
(58,	3,	15),
(59,	3,	16);

DROP TABLE IF EXISTS `resource`;
CREATE TABLE `resource` (
  `resourceID` int NOT NULL AUTO_INCREMENT,
  `author` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `publisher` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `state` int NOT NULL,
  `source` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `format` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `format2` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `variety` int DEFAULT NULL,
  `spanishlvl` int NOT NULL,
  `file` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `link` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `expComment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `publishDate` date DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`resourceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `resource` (`resourceID`, `author`, `publisher`, `title`, `description`, `state`, `source`, `format`, `format2`, `variety`, `spanishlvl`, `file`, `link`, `expComment`, `publishDate`, `created_at`, `updated_at`) VALUES
(5,	'ana@correo.ugr.es',	'edu@correo.ugr.es',	'Rec1 en julio',	'Rec1',	5,	'Rec1',	'',	'',	10,	1,	NULL,	NULL,	'',	'2022-06-11',	'2022-06-06',	'2022-07-13'),
(6,	'edu@correo.ugr.es',	'edu@correo.ugr.es',	'Rec2',	'Rec2',	5,	'Rec2',	'',	'',	1,	6,	NULL,	NULL,	NULL,	'2022-06-06',	'2022-06-06',	'2022-07-15'),
(7,	'ana@correo.ugr.es',	'edu@correo.ugr.es',	'Rec3 ',	'Rec3',	5,	'Rec3',	'',	'',	1,	1,	NULL,	NULL,	NULL,	'2022-06-11',	'2022-06-06',	'2022-06-11'),
(9,	'lopez@correo.ugr.es',	'edu@correo.ugr.es',	'Rec4',	'Rec4',	2,	'Rec4',	'',	'',	3,	6,	NULL,	NULL,	'no me gusta 3',	NULL,	'2022-06-06',	'2022-06-30'),
(10,	'ana@correo.ugr.es',	'rodriguez@correo.ugr.es',	'Rec5',	'Rec5 cambiado',	5,	'Rec5',	'',	'',	1,	1,	NULL,	NULL,	NULL,	'2022-06-23',	'2022-06-08',	'2022-06-23'),
(11,	'lopez@correo.ugr.es',	'',	'Rec6 ',	'Rec6',	1,	'Rec6',	'',	'',	1,	6,	NULL,	NULL,	NULL,	NULL,	'2022-06-10',	'2022-06-11'),
(13,	'luisa@correo.ugr.es',	'rodriguez@correo.ugr.es',	'Rec7',	'Rec7',	5,	'Una pagina en la que',	'',	'',	10,	4,	NULL,	NULL,	NULL,	'2022-07-22',	'2022-06-13',	'2022-07-22'),
(14,	'ana@correo.ugr.es',	'',	'Recurso de prueba',	'fyyjujjjklhlihhñhrwgvwrbvrbwr',	2,	'wikipedia',	'',	'',	7,	1,	NULL,	NULL,	NULL,	'2022-06-13',	'2022-06-13',	'2022-06-13'),
(28,	'nacho@correo.ugr.es',	'nacho@correo.ugr.es',	'Segunda Prueba',	'A ver si funciona',	5,	'Batallas',	'',	'',	4,	2,	NULL,	NULL,	NULL,	'2022-06-28',	'2022-06-28',	'2022-06-28'),
(29,	'nacho@correo.ugr.es',	'nacho@correo.ugr.es',	'Tercera prueba',	'A ver si funciona la pronunciación',	5,	'Nose',	'',	'',	8,	2,	NULL,	NULL,	NULL,	'2022-06-28',	'2022-06-28',	'2022-06-28'),
(35,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Prueba 3',	'cambio en los valores',	5,	'nose',	'',	'',	8,	6,	NULL,	NULL,	NULL,	'2022-06-30',	'2022-06-30',	'2022-06-30'),
(36,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Cuarta prueba',	'Debe de funcionar',	5,	'Ahora si',	'',	'',	3,	6,	NULL,	NULL,	NULL,	'2022-06-30',	'2022-06-30',	'2022-06-30'),
(37,	'luisa@correo.ugr.es',	'',	'Prueba definitiva',	'Antes de la revision 2',	1,	'Wikipedia',	'',	'',	2,	4,	NULL,	NULL,	NULL,	'2022-07-13',	'2022-07-01',	'2022-07-13'),
(38,	'luisa@correo.ugr.es',	'',	'prueba1',	'prueba1 para revisar',	1,	'wikipedia',	'',	'',	8,	4,	NULL,	NULL,	NULL,	'2022-07-15',	'2022-07-01',	'2022-07-15'),
(48,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Prueba con vocabulario funcion',	'a ver que pasa',	5,	'que salga bien',	'',	'',	2,	6,	NULL,	NULL,	NULL,	'2022-07-07',	'2022-07-07',	'2022-07-07'),
(49,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Recurso 7/6/22',	'Recurso 7/6/22',	5,	'Recurso 7/6/22',	'',	'',	2,	6,	NULL,	NULL,	NULL,	'2022-07-07',	'2022-07-07',	'2022-07-07'),
(51,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Ultima prueba 6/7',	'1,2,7 Vocabulario',	5,	'',	'',	'',	6,	6,	NULL,	NULL,	NULL,	'2022-07-07',	'2022-07-07',	'2022-07-15'),
(52,	'luisa@correo.ugr.es',	'nacho@correo.ugr.es',	'Prueba 11-7',	'Probaremos a crear vocabulario',	5,	'wikipedia',	'',	'',	2,	6,	NULL,	NULL,	NULL,	'2022-07-27',	'2022-07-11',	'2022-07-27'),
(53,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Foto Luffy',	'En este recurso esta la foto de Luffy ',	5,	'Grand Line',	'image',	'jpg',	3,	6,	'1657817253_c20d8eff0c8ebeb81396.jpg',	NULL,	NULL,	'2022-07-14',	'2022-07-14',	'2022-07-14'),
(54,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Curriculum',	'Prueba de PDF',	5,	'Universidad',	'application',	'pdf',	1,	6,	'1657817536_8d21eec275f3f446b75a.pdf',	NULL,	NULL,	'2022-07-14',	'2022-07-14',	'2022-07-14'),
(55,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Video de la playa',	'Prueba de videos',	5,	'La playa',	'video',	'mp4',	4,	6,	'1657817406_a34cc0d5bd89f33f90ef.mp4',	NULL,	NULL,	'2022-07-14',	'2022-07-14',	'2022-07-14'),
(56,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Zoro',	'Wenardo',	5,	'Nuevo Mundo',	'image',	'jpeg',	4,	6,	'1657817741_7566055eda9864443c6b.jpeg',	NULL,	NULL,	'2022-07-14',	'2022-07-14',	'2022-07-14'),
(57,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Video movil',	'prueba .mov',	5,	'movil',	'video',	'mov',	1,	6,	'1657877387_74d415118d7a48a39ba9.mov',	NULL,	NULL,	'2022-07-15',	'2022-07-15',	'2022-07-15'),
(58,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Prueba doc',	'',	5,	'Youtube',	'video',	'',	1,	6,	NULL,	'https://www.youtube.com/results?search_query=.doc',	NULL,	'2022-07-22',	'2022-07-22',	'2022-07-22'),
(59,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'ROCIO',	'prueba para Rocio',	5,	'Youtube',	'video',	'',	6,	6,	NULL,	'https://www.youtube.com/watch?v=_ybgWmSCAu8',	NULL,	'2022-07-22',	'2022-07-22',	'2022-07-22'),
(61,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Prueba youtube',	'',	5,	'Youtube',	'video',	'',	1,	1,	NULL,	'https://www.youtube.com/watch?v=4kDXgyPXPZM',	NULL,	'2022-07-24',	'2022-07-24',	'2022-07-24'),
(62,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Prueba kahoot',	'',	5,	'Kahoot',	'application',	'',	2,	5,	NULL,	'https://kahoot.it/',	NULL,	'2022-07-24',	'2022-07-24',	'2022-07-24'),
(64,	'josemigueljs@correo.ugr.es',	'josemigueljs@correo.ugr.es',	'Prueba .docx',	'',	5,	'drive',	'application',	'docx',	2,	3,	'1659084841_d80bc49d5ccee17ec229.docx',	'',	NULL,	'2022-07-29',	'2022-07-29',	'2022-07-29');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `role` int NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `spanishlvl` int DEFAULT NULL,
  `university` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `birthPlace` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `respMail` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` date NOT NULL,
  `updated_at` date DEFAULT NULL,
  `tempId` int NOT NULL,
  PRIMARY KEY (`email`),
  UNIQUE KEY `id` (`id`),
  KEY `email` (`email`),
  KEY `respMail` (`respMail`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`respMail`) REFERENCES `users` (`email`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`email`, `id`, `password`, `nombre`, `apellidos`, `role`, `activo`, `spanishlvl`, `university`, `birthPlace`, `respMail`, `created_at`, `updated_at`, `tempId`) VALUES
('acid@decsai.ugr.es',	106,	NULL,	'Silvia',	'Acid Carrillo',	1,	0,	NULL,	NULL,	NULL,	'edu@correo.ugr.es',	'2022-06-03',	'2022-06-03',	9534),
('alfredo@correo.ugr.es',	42,	'$2y$10$8mZpHaOquO.hajFMazHG6uExbBUptoBXMDCyLzNZ6J91Nz2nczw..',	'Alfredo',	'Garcia',	1,	1,	6,	'Granada',	'Granada',	'nacho@correo.ugr.es',	'2022-05-27',	'2022-05-31',	0),
('ana@correo.ugr.es',	95,	'$2y$10$hDYez8jNzhoDTDhozSiHhuEHAWvr5bCSdszjxQ9IQoYyQkviazlyS',	'Ana',	'Jerónimo',	1,	1,	1,	'Italia',	'Italia',	'rodriguez@correo.ugr.es',	'2022-06-01',	'2022-07-09',	0),
('antoniop@correo.ugr.es',	28,	'$2y$10$wzxF2if79Dse73JDW1FbpeamCXpmPHIY3sggl6kQBT8aa1q/CohRu',	'Antonio',	'Lopez',	1,	1,	4,	'Rusia',	'Japon',	'nacho@correo.ugr.es',	'2022-05-18',	'2022-07-09',	0),
('chema172839@gmail.com',	104,	NULL,	'Ernesto',	'Gutierrez',	1,	0,	NULL,	NULL,	NULL,	'edu@correo.ugr.es',	'2022-06-03',	'2022-06-03',	5005),
('claudia@correo.ugr.es',	94,	'$2y$10$FmjxYEHFeFq8BXfW1i4Vs.IInUsiptvHlYCKtjfnlyqvuFsYzBYFy',	'Claudia',	'Jimenez',	1,	0,	6,	'Alemania',	'Alemania',	'rodriguez@correo.ugr.es',	'2022-06-01',	'2022-06-03',	0),
('edu@correo.ugr.es',	97,	'$2y$10$J5eToPMQ8HKcZmPzMzQowee7WdOAslBNqGAI5O6hQIHAgi9saLU2.',	'Eduardo',	'Barez Navarro',	2,	0,	6,	'Granada',	'Granada',	'josemigueljs@correo.ugr.es',	'2022-06-01',	'2022-06-03',	0),
('eduardobarezn@gmail.com',	99,	NULL,	'Eduardo ',	'Barez Navarro',	1,	0,	NULL,	NULL,	NULL,	'josemigueljs@correo.ugr.es',	'2022-06-02',	'2022-06-02',	4091),
('ernesto@correo.ugr.es',	102,	'$2y$10$kxE/5R.zTgAh6s1qCZA7GuOoAsPOtmnO/1FUgFaa8VN5ppyn/Qega',	'Ernesto',	'Gutierrez',	1,	1,	1,	'Granada',	'Granada',	'josemigueljs@correo.ugr.es',	'2022-06-02',	'2022-06-02',	0),
('jmfluna@decsai.ugr.es',	105,	NULL,	'Juan Manuel',	'Fernandez Luna',	1,	0,	NULL,	NULL,	NULL,	'edu@correo.ugr.es',	'2022-06-03',	'2022-06-03',	963),
('jorge@correo.ugr.es',	29,	'$2y$10$qbuuEa4eDOAVXJrirPyYaO.bWt5dEw57LMw6m3nHOmAan/8NCDyAO',	'Jorge',	'Alfredo',	1,	1,	5,	'Granada',	'Granada',	'nacho@correo.ugr.es',	'2022-05-18',	'2022-07-09',	0),
('josemigueljs@correo.ugr.es',	13,	'$2y$10$4xtCcFImb8rTslB/t3JU9uIN/ug.HqAxoVMJMjBllmXOWDPb5XiR2',	'José Miguel ',	'Jerónimo Soriano',	3,	1,	6,	'Granada',	'Granada',	NULL,	'2022-05-02',	'2022-05-21',	0),
('lopez@correo.ugr.es',	31,	'$2y$10$i5Iq38i9kSFuoi.HnWCEIeTaulSL/98L6dUyk/jR6QDWWvO6glFbK',	'Alberto',	'Lopez',	1,	1,	6,	'Granada',	'Cordoba',	'edu@correo.ugr.es',	'2022-05-26',	'2022-05-31',	0),
('luisa@correo.ugr.es',	96,	'$2y$10$Mu6SmX7sE8fWWlsKJb..heuoZ8yJBwPwkMzDDgPFZsF9eqTCHmDUi',	'Luisa',	'Jaen',	1,	0,	4,	'Croacia',	'Croacia',	'rodriguez@correo.ugr.es',	'2022-06-01',	'2022-06-03',	0),
('manu@correo.ugr.es',	32,	'$2y$10$jpM9vhzoEvYKKrrVtpZSqudTaQf7dlVLiFgav69.ckoEiHvRtz.x2',	'Manuel',	'Jimenez',	1,	1,	1,	'Granada',	'Padul',	'edu@correo.ugr.es',	'2022-05-26',	'2022-05-31',	0),
('nacho@correo.ugr.es',	15,	'$2y$10$i5Iq38i9kSFuoi.HnWCEIeTaulSL/98L6dUyk/jR6QDWWvO6glFbK',	'Nacho',	'Perez',	2,	1,	2,	'Granada',	'Cordoba',	'josemigueljs@correo.ugr.es',	'2022-05-04',	'2022-05-18',	0),
('rodrigo@correo.ugr.es',	93,	'$2y$10$yyUOlntV0QBJjSZ.875PZuNiIpsAfumMTj4dXC.SeUk2lk0pd0Hdy',	'Jose',	'Rodriguez',	1,	1,	4,	'Francia',	'Francia',	'rodriguez@correo.ugr.es',	'2022-06-01',	'2022-06-01',	0),
('rodriguez@correo.ugr.es',	33,	'$2y$10$iqDRDpQYQnM0a.Ab42Iuqe4yotfsE16yEH/Kuirf0apkLtCUt4jVy',	'Alfredo',	'Rodriguez',	3,	1,	6,	'Granada',	'Granada',	'josemigueljs@correo.ugr.es',	'2022-05-27',	'2022-05-27',	0);

DROP TABLE IF EXISTS `values`;
CREATE TABLE `values` (
  `charID` int NOT NULL,
  `valID` int NOT NULL,
  `at1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `at2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `at3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`valID`,`charID`),
  KEY `charID` (`charID`),
  CONSTRAINT `values_ibfk_1` FOREIGN KEY (`charID`) REFERENCES `characteristics` (`charID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `values` (`charID`, `valID`, `at1`, `at2`, `at3`) VALUES
(1,	1,	'Seseo',	'',	''),
(2,	1,	'Tuteo',	'',	''),
(3,	1,	'Pololear',	'pololeando, pololeaba',	'“Mantener relaciones amorosas de cierto nivel de formalidad” (DLE, s.v.)\r\n\r\n'),
(1,	2,	'Ceceo',	'',	''),
(2,	2,	'Voseo',	'',	''),
(3,	2,	'Gato',	'',	'm. y f. Mamífero de la familia de los félidos, digitígrado, doméstico, de unos 50 cm de largo desde la cabeza hasta el arranque de la cola'),
(1,	3,	'Distinción s/θ',	'',	''),
(2,	3,	'Uso de vosotros',	'',	''),
(3,	3,	'Falcado',	'',	'Que tiene una curvatura similar a la de una hoz'),
(1,	4,	'Yeísmo',	'',	''),
(2,	4,	'Uso de ustedes (familiar o informal)',	'',	''),
(3,	4,	'Ful',	'',	'Faso, fallido, que posee poco valor'),
(1,	5,	'Rehilamiento',	'',	''),
(2,	5,	'Uso del pretérito indefinido (‘pasado actual’)',	'',	''),
(3,	5,	'Isagoge',	'',	'Introducción, preambulo'),
(1,	6,	'Distinción entre y /ǰ / y ll /ʎ/',	'',	''),
(2,	6,	'Queísmo',	'',	''),
(3,	6,	'Melifluo',	'',	'Sonido excesivamente dulce, suave o delicado'),
(1,	7,	'Aspiración de /–x–/ > [–h–]',	'',	''),
(2,	7,	'Dequeísmo',	'',	''),
(3,	7,	'Esternocleidomastoideo',	'',	'Del lat. cient. sternocleidomastoideus, y este del gr. στέρνον stérnon \'esternón\', κλείς, κλειδός kleís, kleidós \'clavícula\', μαστοειδής mastoeidḗs \'mastoides\' y el lat. -eus \'-eo2\'.'),
(1,	8,	'Pronunciación tensa de /–x–/',	'',	''),
(2,	8,	'Duplicación de pronombres clíticos',	'',	''),
(3,	8,	'Tibia',	'',	'f. Hueso principal y anterior de la pierna, que se articula con el fémur, el peroné y el astrágalo.'),
(1,	9,	'Debilitamiento/elisión de /–d–/',	'',	''),
(2,	9,	'Pronombre le enclítico intensificador',	'',	''),
(3,	9,	'Peroné',	'',	'm. Hueso largo y delgado de la pierna, situado detrás de la tibia, con la cual se articula.'),
(1,	10,	'Neutralización de /–r/ y /–l/',	'',	''),
(2,	10,	'Uso etimológico de los pronombres le, la y lo',	'',	''),
(3,	10,	'Fémur',	'',	'm. Hueso que forma el esqueleto del muslo, que se articula por arriba con el hueso ilíaco y por abajo con la tibia y la rótula.'),
(1,	11,	'Debilitamiento/elisión de consonantes finales',	'',	''),
(2,	11,	'Pluralización del verbo haber impersonal',	'',	''),
(3,	11,	'Luffy ',	'Dios',	'One Piece'),
(1,	12,	'Conservación de consonantes finales',	'',	''),
(3,	12,	'Curriculum',	'',	'Pa encontrar trabajo'),
(3,	13,	'Playa ',	'UwU',	'Fresquito'),
(3,	14,	'Enchufe',	'',	'cargar movil'),
(3,	15,	'Doc',	'',	'Tipo de archivo como pdf'),
(3,	16,	'Gato',	'Sustantivo',	'El del coche'),
(3,	17,	'Pollera',	'Sustantivo',	'Falda');

-- 2022-07-31 16:33:45