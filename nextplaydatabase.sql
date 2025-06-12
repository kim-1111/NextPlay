-- --------------------------------------------------------
-- Host:                         nextplay-nextplay.l.aivencloud.com
-- Versión del servidor:         8.0.35 - Source distribution
-- SO del servidor:              Linux
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para nextplay
CREATE DATABASE IF NOT EXISTS `nextplay` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `nextplay`;

-- Volcando estructura para tabla nextplay.asociar
CREATE TABLE IF NOT EXISTS `asociar` (
  `noticia_id_noticia` int NOT NULL,
  `juegos_id_juego` int NOT NULL,
  PRIMARY KEY (`noticia_id_noticia`,`juegos_id_juego`),
  KEY `fk_noticia_has_juegos_juegos1_idx` (`juegos_id_juego`),
  KEY `fk_noticia_has_juegos_noticia1_idx` (`noticia_id_noticia`),
  CONSTRAINT `fk_noticia_has_juegos_juegos1` FOREIGN KEY (`juegos_id_juego`) REFERENCES `juegos` (`id_juego`),
  CONSTRAINT `fk_noticia_has_juegos_noticia1` FOREIGN KEY (`noticia_id_noticia`) REFERENCES `noticia` (`id_noticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.asociar: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.categoria: ~4 rows (aproximadamente)
INSERT IGNORE INTO `categoria` (`id_categoria`, `nombre`) VALUES
	(1, 'Conferencia'),
	(2, 'ESport'),
	(3, 'Expo'),
	(4, 'Encuentro Social');

-- Volcando estructura para tabla nextplay.comentarios
CREATE TABLE IF NOT EXISTS `comentarios` (
  `id_comentario` int NOT NULL AUTO_INCREMENT,
  `usuarios_id_usuario` int NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `id_hilos` int NOT NULL,
  PRIMARY KEY (`id_comentario`,`usuarios_id_usuario`,`id_hilos`),
  KEY `fk_comentarios_usuarios1_idx` (`usuarios_id_usuario`),
  KEY `fk_comentarios_comentarios1_idx` (`id_hilos`),
  CONSTRAINT `fk_comentarios_comentarios1` FOREIGN KEY (`id_hilos`) REFERENCES `comentarios` (`id_comentario`),
  CONSTRAINT `fk_comentarios_usuarios1` FOREIGN KEY (`usuarios_id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.comentarios: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.eventos
CREATE TABLE IF NOT EXISTS `eventos` (
  `id_evento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `hora` varchar(45) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `enlace_streaming` varchar(200) DEFAULT NULL,
  `categoria_id_categoria` int NOT NULL,
  `juegos_id_juego` int NOT NULL,
  `promotores_id_promotor` int DEFAULT NULL,
  PRIMARY KEY (`id_evento`,`categoria_id_categoria`,`juegos_id_juego`),
  KEY `fk_eventos_categoria1_idx` (`categoria_id_categoria`),
  KEY `fk_eventos_promotor` (`promotores_id_promotor`),
  CONSTRAINT `fk_eventos_categoria1` FOREIGN KEY (`categoria_id_categoria`) REFERENCES `categoria` (`id_categoria`),
  CONSTRAINT `fk_eventos_promotor` FOREIGN KEY (`promotores_id_promotor`) REFERENCES `promotores` (`id_promotor`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.eventos: ~8 rows (aproximadamente)
INSERT IGNORE INTO `eventos` (`id_evento`, `nombre`, `fecha`, `hora`, `descripcion`, `enlace_streaming`, `categoria_id_categoria`, `juegos_id_juego`, `promotores_id_promotor`) VALUES
	(4, 'New Year Special Event', '2025-07-18', '12:00', 'New Year Special Event', '', 3, 3, 1),
	(5, 'Valentine\'s Day Challenge', '2025-10-16', '23:00', 'Valentine\'s Day Challenge', '', 4, 1, 1),
	(6, 'VALORANT VCT GAME CHANGERS', '2025-09-16', '23:00', 'valoranht', '', 2, 5, 1),
	(7, 'Elden Ring Event', '2025-09-20', '12:00', 'elkden bring', 'https://youtube.com', 4, 1, 1),
	(8, 'IEM KATOWIZE', '2025-06-19', '12:00', 'Epic event from counter strike', 'https://twitch.tv/s1mple', 2, 3, 1),
	(9, 'Cat Cafe event', '2025-05-31', '09:00', 'Cafe wit cats', '', 4, 5, 1),
	(10, 'Last Class', '2025-05-29', '', 'This is the last class', '', 3, 0, 1),
	(12, 'Valorant event cool', '2025-05-30', '12:00', 'Cool valorant event', '', 4, 5, 1);

-- Volcando estructura para tabla nextplay.juegos
CREATE TABLE IF NOT EXISTS `juegos` (
  `id_juego` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `desarollador` varchar(45) NOT NULL,
  `editor` varchar(45) DEFAULT NULL,
  `fecha_lanzamiento` date DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT 'No description',
  `link` varchar(500) DEFAULT 'google.com',
  `image` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_juego`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.juegos: ~4 rows (aproximadamente)
INSERT IGNORE INTO `juegos` (`id_juego`, `nombre`, `desarollador`, `editor`, `fecha_lanzamiento`, `descripcion`, `link`, `image`) VALUES
	(0, 'None', 'None', 'None', '2020-02-20', 'No description', 'None.com', NULL),
	(1, 'Elden Ring', 'FromSoft', 'FromSoft', '2025-05-13', 'Embark on an epic journey in a vast open world filled with mystery and danger.', 'https://es.bandainamcoent.eu/elden-ring/elden-ring', 'https://static1.dualshockersimages.com/wordpress/wp-content/uploads/2024/01/222-1.jpg'),
	(3, 'Counter Strike', 'Valve', 'Valve', '2025-05-09', 'Objective-based, multiplayer tactical first-person shooter', 'google.com', 'https://lh3.googleusercontent.com/proxy/QTj_E3u2w0iThPqkXmxVFufDvOTFtq6olvjRJHHKNU-xzLjKYYmeGq67bZUe7SNF-msPg4qdjhnQBeE8lDi4vaKN3C833oANLQIwbZ57DeOkOcczkAXk'),
	(5, 'Valorant', 'Riot Games', 'Riot Games', '2025-05-27', 'A team-based first-person tactical hero shooter set in the near future', 'google.com', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqEJcsyEWxiLe_Fv5dOyYAK1tWOAjjPcMlvg&s');

-- Volcando estructura para tabla nextplay.noticia
CREATE TABLE IF NOT EXISTS `noticia` (
  `id_noticia` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  PRIMARY KEY (`id_noticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.noticia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.notificaciones
CREATE TABLE IF NOT EXISTS `notificaciones` (
  `eventos_id_notificacion` int NOT NULL,
  `usuarios_id_usuario` int NOT NULL,
  `contenido` varchar(45) NOT NULL,
  PRIMARY KEY (`eventos_id_notificacion`,`usuarios_id_usuario`),
  KEY `fk_eventos_has_usuarios_usuarios2_idx` (`usuarios_id_usuario`),
  KEY `fk_eventos_has_usuarios_eventos1_idx` (`eventos_id_notificacion`),
  CONSTRAINT `fk_eventos_has_usuarios_eventos1` FOREIGN KEY (`eventos_id_notificacion`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `fk_eventos_has_usuarios_usuarios2` FOREIGN KEY (`usuarios_id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.notificaciones: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.organiza
CREATE TABLE IF NOT EXISTS `organiza` (
  `promotores_id_promotor` int NOT NULL,
  `eventos_id_evento` int NOT NULL,
  PRIMARY KEY (`promotores_id_promotor`,`eventos_id_evento`),
  KEY `fk_promotores_has_eventos_eventos1_idx` (`eventos_id_evento`),
  KEY `fk_promotores_has_eventos_promotores1_idx` (`promotores_id_promotor`),
  CONSTRAINT `fk_promotores_has_eventos_eventos1` FOREIGN KEY (`eventos_id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `fk_promotores_has_eventos_promotores1` FOREIGN KEY (`promotores_id_promotor`) REFERENCES `promotores` (`id_promotor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.organiza: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.participa
CREATE TABLE IF NOT EXISTS `participa` (
  `eventos_id_participa` int NOT NULL,
  `usuarios_id_usuario` int NOT NULL,
  PRIMARY KEY (`eventos_id_participa`,`usuarios_id_usuario`),
  KEY `fk_eventos_has_usuarios_usuarios1_idx` (`usuarios_id_usuario`),
  KEY `fk_eventos_has_usuarios_eventos_idx` (`eventos_id_participa`),
  CONSTRAINT `fk_eventos_has_usuarios_eventos` FOREIGN KEY (`eventos_id_participa`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `fk_eventos_has_usuarios_usuarios1` FOREIGN KEY (`usuarios_id_usuario`) REFERENCES `usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.participa: ~7 rows (aproximadamente)
INSERT IGNORE INTO `participa` (`eventos_id_participa`, `usuarios_id_usuario`) VALUES
	(5, 1),
	(6, 1),
	(8, 1),
	(10, 1),
	(5, 12),
	(6, 12),
	(9, 14);

-- Volcando estructura para tabla nextplay.promotores
CREATE TABLE IF NOT EXISTS `promotores` (
  `id_promotor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(90) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `contrasena` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `contacto` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_promotor`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.promotores: ~10 rows (aproximadamente)
INSERT IGNORE INTO `promotores` (`id_promotor`, `nombre`, `correo`, `contrasena`, `contacto`) VALUES
	(1, 'promotor1', 'promotor1@gmail.com', '1234', '920478267'),
	(2, 'fyyh', 'guqwd@diu.com', '123', NULL),
	(3, 'johndoe', 'johndoe@gmail.com', 'Hola123!', NULL),
	(4, 'sara143', 'sara143@gmail.com', 'Sara1434', NULL),
	(5, 'yixin', 'yx@gmail.com', 'Wjsn022516', NULL),
	(6, 'PromotorJ', 'promotorJ@gmail.com', 'P12345678', NULL),
	(8, 'gamer1', 'gamer@gmail.com', 'Gamer123', NULL),
	(9, 'promotor2', 'asde@asda.as', 'Pro12345', NULL),
	(10, 'gamer13', 'user1@gmail.com', 'Gamer123', NULL),
	(11, 'asdaw', 'sdasd@dasd.com', 'Q1234567890', NULL);

-- Volcando estructura para tabla nextplay.relacionar
CREATE TABLE IF NOT EXISTS `relacionar` (
  `noticia_id_noticia` int NOT NULL,
  `eventos_id_evento` int NOT NULL,
  PRIMARY KEY (`noticia_id_noticia`,`eventos_id_evento`),
  KEY `fk_noticia_has_eventos_eventos1_idx` (`eventos_id_evento`),
  KEY `fk_noticia_has_eventos_noticia1_idx` (`noticia_id_noticia`),
  CONSTRAINT `fk_noticia_has_eventos_eventos1` FOREIGN KEY (`eventos_id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `fk_noticia_has_eventos_noticia1` FOREIGN KEY (`noticia_id_noticia`) REFERENCES `noticia` (`id_noticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.relacionar: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.tiene
CREATE TABLE IF NOT EXISTS `tiene` (
  `eventos_id_evento` int NOT NULL,
  `juegos_id_juego` int NOT NULL,
  PRIMARY KEY (`eventos_id_evento`,`juegos_id_juego`),
  KEY `fk_eventos_has_juegos_juegos1_idx` (`juegos_id_juego`),
  KEY `fk_eventos_has_juegos_eventos1_idx` (`eventos_id_evento`),
  CONSTRAINT `fk_eventos_has_juegos_eventos1` FOREIGN KEY (`eventos_id_evento`) REFERENCES `eventos` (`id_evento`),
  CONSTRAINT `fk_eventos_has_juegos_juegos1` FOREIGN KEY (`juegos_id_juego`) REFERENCES `juegos` (`id_juego`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.tiene: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nextplay.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `correo` varchar(90) DEFAULT NULL,
  `contrasena` varchar(45) DEFAULT NULL,
  `estadisticas` varchar(200) DEFAULT NULL,
  `img` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla nextplay.usuarios: ~11 rows (aproximadamente)
INSERT IGNORE INTO `usuarios` (`id_usuario`, `nombre`, `surname`, `correo`, `contrasena`, `estadisticas`, `img`) VALUES
	(1, 'user1', '', 'user21@gmail.com', '1234567', NULL, NULL),
	(2, 'awd', '', 'asde@asda.as', '12345', NULL, NULL),
	(3, 'UsuarioJustin', '', 'usuariojustin@nextplay.com', 'Hola123!', NULL, NULL),
	(5, 'userpdo', '', 'dsgfsdg@gmail.com', 'P12345678do', NULL, NULL),
	(6, 'userpdo', '', 'dsgfsdg@gmail.com', 'P12345678do', NULL, NULL),
	(11, 'amanda1', '', 'amanda1@gmail.com', 'Amanda1234', NULL, NULL),
	(12, 'justincool', '', 'justincool@gmail.com', 'Justin123', NULL, NULL),
	(13, 'coolperson123', '', 'coolperson123@gmail.com', 'Cool12345', NULL, NULL),
	(14, 'supercoolguy', '', 'asd@gmail.com', 'Hola12345', NULL, NULL),
	(24, 'user2asd', 'asd', '906242124@qq.com', 'Q123456789', NULL, NULL),
	(25, 'user2asdw', 'asdaw', 'em.chen.junxi@gmail.com', 'Q123456789', NULL, NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
