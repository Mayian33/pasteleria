-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-05-2025 a las 13:39:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `brollin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `fecha_carrito` varchar(100) NOT NULL,
  `usuario_carrito` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `personalizacion_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `fecha_carrito`, `usuario_carrito`, `producto_id`, `personalizacion_id`) VALUES
(67, '2025-05-10 12:48:38', 3, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categ` int(11) NOT NULL,
  `nombre_categ` varchar(255) NOT NULL,
  `descripcion_categ` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categ`, `nombre_categ`, `descripcion_categ`) VALUES
(1, 'tarta', 'pura delicia'),
(2, 'bizcocho', 'bocado perfecto'),
(3, 'ponche', 'sabor casero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `decoracion`
--

CREATE TABLE `decoracion` (
  `id_decoracion` int(11) NOT NULL,
  `nombre_decoracion` varchar(100) NOT NULL,
  `precio_decoracion` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `decoracion`
--

INSERT INTO `decoracion` (`id_decoracion`, `nombre_decoracion`, `precio_decoracion`) VALUES
(1, 'cumpleaños', 2),
(2, 'navidad', 1),
(3, 'san valentin', 2),
(4, 'bautismo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `personalizacion_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id_detalle`, `pedido_id`, `producto_id`, `personalizacion_id`, `cantidad`) VALUES
(6, 17, 2, NULL, 1),
(7, 17, 14, NULL, 1),
(8, 17, NULL, 56, 1),
(9, 18, 4, NULL, 1),
(10, 23, 3, NULL, 4),
(11, 23, 1, NULL, 2),
(12, 24, 12, NULL, 2),
(13, 24, NULL, 57, 1),
(14, 25, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id_donacion` int(11) NOT NULL,
  `fecha_donacion` varchar(255) NOT NULL,
  `descripcion_donacion` varchar(500) NOT NULL,
  `monto` double NOT NULL,
  `usuario_donacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `nombre_estado`) VALUES
(1, 'recibido'),
(2, 'pendiente👌'),
(3, 'preparando💫'),
(4, 'enviando🚀'),
(5, 'archivar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `masa`
--

CREATE TABLE `masa` (
  `id_masa` int(11) NOT NULL,
  `nombre_masa` varchar(100) NOT NULL,
  `precio_masa` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `masa`
--

INSERT INTO `masa` (`id_masa`, `nombre_masa`, `precio_masa`) VALUES
(1, 'quebrada', 1),
(2, 'hojaldre', 1),
(3, 'galleta', 1),
(4, 'integral', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `opcion_id` int(11) NOT NULL,
  `nombre_opcion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`opcion_id`, `nombre_opcion`) VALUES
(1, 'Sin gluten'),
(2, 'Sin lácteos'),
(3, 'Sin frutos secos'),
(4, 'Vegano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones_adicionales`
--

CREATE TABLE `opciones_adicionales` (
  `opc_adcional_id` int(11) NOT NULL,
  `id_personalizacion` int(11) NOT NULL,
  `id_opcion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opciones_adicionales`
--

INSERT INTO `opciones_adicionales` (`opc_adcional_id`, `id_personalizacion`, `id_opcion`) VALUES
(6, 47, 1),
(7, 48, 1),
(8, 49, 1),
(9, 50, 1),
(10, 51, 1),
(11, 52, 3),
(12, 52, 4),
(13, 53, 1),
(14, 53, 3),
(15, 54, 2),
(16, 54, 3),
(17, 57, 1),
(18, 57, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `pedido_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_pedido` varchar(255) NOT NULL,
  `total_pedido` double NOT NULL,
  `estado_pedido` int(11) NOT NULL,
  `nombre_pedido` varchar(100) NOT NULL,
  `email_pedido` varchar(100) NOT NULL,
  `telefono_pedido` int(20) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `direccion_pedido` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`pedido_id`, `usuario_id`, `fecha_pedido`, `total_pedido`, `estado_pedido`, `nombre_pedido`, `email_pedido`, `telefono_pedido`, `ciudad`, `cp`, `direccion_pedido`) VALUES
(17, 1, '2025-05-14', 33, 4, 'Pedido de mai', 'mai@gmail.com', 123456786, 'Valencia', '46183', '5'),
(18, 13, '2025-05-14', 10, 4, 'Pedido de leonor', 'leo@gmail.com', 123456781, 'Valencia', '46183', '2'),
(19, 1, '2025-05-14', 50, 1, 'Pedido de mai', 'mai@gmail.com', 123456786, 'Valencia', '46183', '6'),
(20, 1, '2025-05-14 17:43:25', 50, 1, 'Pedido de mai', 'mai@gmail.com', 123456786, 'Valencia', '46183', '6'),
(21, 1, '2025-05-14 17:53:15', 50, 1, 'Pedido de mai', 'mai@gmail.com', 123456786, 'Valencia', '46183', '6'),
(23, 1, '2025-05-14 17:56:53', 50, 4, 'Pedido de mai', 'mai@gmail.com', 123456786, 'Valencia', '46183', '6'),
(24, 1, '2025-05-15 13:31:21', 36, 2, 'Pedido de Maina', 'mainaboza@gmail.com', 682574341, 'Valencia', '46183', 'Calle Derechos, La Eliana'),
(25, 1, '2025-05-15 18:57:56', 5, 1, 'Pedido de liam', 'liam@gmail.com', 123456786, 'Valencia', '46183', 'calle');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personalizacion`
--

CREATE TABLE `personalizacion` (
  `id_personalizacion` int(11) NOT NULL,
  `sabor_personalizacion` int(11) NOT NULL,
  `masa_personalizacion` int(11) NOT NULL,
  `tamano_personalizacion` int(11) NOT NULL,
  `decoracion_personalizacion` int(11) NOT NULL,
  `usuario_personalizacion` int(11) NOT NULL,
  `fecha_personalizacion` varchar(100) NOT NULL,
  `precio_personalizacion` double NOT NULL,
  `imagen_personalizacion` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personalizacion`
--

INSERT INTO `personalizacion` (`id_personalizacion`, `sabor_personalizacion`, `masa_personalizacion`, `tamano_personalizacion`, `decoracion_personalizacion`, `usuario_personalizacion`, `fecha_personalizacion`, `precio_personalizacion`, `imagen_personalizacion`) VALUES
(47, 6, 3, 1, 1, 1, '2025-05-13 20:15:42', 6, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(48, 5, 1, 1, 2, 1, '2025-05-13 20:58:22', 5, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(49, 5, 1, 1, 2, 1, '2025-05-13 20:59:39', 5, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(50, 5, 1, 1, 2, 1, '2025-05-13 20:59:47', 5, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(51, 5, 1, 1, 2, 1, '2025-05-13 21:02:41', 5, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(52, 6, 3, 1, 1, 1, '2025-05-13 21:02:59', 6, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(53, 6, 3, 1, 1, 1, '2025-05-14 12:15:41', 6, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(54, 3, 2, 2, 4, 13, '2025-05-14 16:41:32', 7, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(55, 2, 1, 1, 1, 13, '2025-05-14 16:41:42', 6, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(56, 6, 3, 2, 3, 1, '2025-05-14 16:46:21', 8, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg'),
(57, 6, 3, 1, 1, 1, '2025-05-15 13:29:01', 6, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/personalizacion/personalizacion.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_prod` int(11) NOT NULL,
  `nombre_prod` varchar(255) NOT NULL,
  `descripcion_prod` varchar(500) NOT NULL,
  `descripcion_detallada_prod` varchar(500) NOT NULL,
  `precio` double NOT NULL,
  `categoria` int(11) NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_prod`, `nombre_prod`, `descripcion_prod`, `descripcion_detallada_prod`, `precio`, `categoria`, `imagen`) VALUES
(1, 'pistacho', 'dulce', '¡Delicioso, cremoso y único!\r\nPreparado con pistache natural, leche y el dulzor perfecto. Ideal para compartir en reuniones, regalar o disfrutar bien frío.\r\n🩷 100% casero, sin conservadores\r\n🩷 Textura suave y sabor irresistible\r\n🩷 Botellas decoradas listas para regalar\r\n\r\n¡Haz tu pedido y consiéntete con lo mejor! ', 5, 3, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/ponche/pistacho.jpeg'),
(2, 'nutella', 'cremoso', '¡Pura tentación en una botella!\r\nCremoso, dulce y con el inconfundible sabor a Nutella que enamora. Perfecto para los amantes del chocolate y avellana.\r\n🩷 100% casero, sin conservadores\r\n🩷 Textura suave y sabor intenso\r\n🩷 Ideal para fiestas, regalos o consentirte\r\n\r\n¡No te quedes sin probarlo! ', 5, 3, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/ponche/nutella.jpeg'),
(3, 'zanahoria', 'esponjoso', '¡Esponjoso, húmedo y lleno de sabor!\r\nHecho con zanahorias frescas, nueces y un toque de canela. Coronado con un cremoso glaseado de queso que lo hace irresistible.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para acompañar el café, regalar o disfrutar en familia\r\n🩷 Sabor casero que conquista a todos\r\n\r\n¡Pruébalo y enamórate del verdadero sabor casero! ', 10, 2, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/bizcocho/zanahoria.jpeg'),
(4, 'chocolate', 'dulce', '¡Esponjoso, húmedo y lleno de Nutella!\r\nUn bizcocho suave con el inconfundible sabor a avellanas y chocolate, perfecto para los amantes del dulce.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para desayunos, meriendas o sorprender a alguien especial\r\n🩷 Sabor intenso y textura irresistible\r\n\r\n¡Un pedacito y te conquista! ', 10, 2, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/bizcocho/chocolate.jpeg'),
(8, 'chocolate', 'intenso', '¡Pura delicia para los amantes del chocolate!\r\nUna base esponjosa con intenso sabor a cacao, cubierta con ganache cremosa y un toque de amor casero.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para cumpleaños, reuniones o un antojo especial\r\n🩷 Sabor profundo y textura suave\r\n\r\n¡Disfrútala y déjate llevar por el placer del chocolate!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/chocolate.jpeg'),
(9, 'oreo', 'galletosa', '¡Cremosa, crujiente y deliciosa!\r\nBase de galleta Oreo, relleno suave de crema y trocitos de Oreo por dentro y por encima.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Perfecta para cumpleaños, postres o darte un capricho\r\n🩷 Sabor irresistible para fans de las galletas\r\n\r\n¡Prueba la combinación perfecta de crema y galleta!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/oreo.jpeg'),
(10, 'queso', 'sabroso', '¡Suave, cremosa y simplemente deliciosa!\r\nHecha con queso crema de calidad, base de galleta crujiente y el equilibrio perfecto entre dulzor y frescura.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para celebraciones, postres o un antojo especial\r\n🩷 Sabor clásico que nunca falla\r\n\r\n¡Una cucharada y te conquista!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/queso.jpeg'),
(11, 'tiramisu', 'exquisito', '¡El auténtico sabor italiano en cada bocado!\r\nCapas de bizcocho suave empapado en café, cremoso mascarpone y un toque de cacao. Un postre que conquista desde el primer sabor.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para sorprender en ocasiones especiales o disfrutar en familia\r\n🩷 Sabor auténtico y textura irresistible\r\n\r\n¡Haz de cualquier momento una celebración con esta deliciosa tarta!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/tiramisu.jpeg'),
(12, 'tres leches', 'dulzón', '¡Suave, esponjosa y súper jugosa!\r\nUn bizcocho empapado en tres tipos de leche, cubierto con una capa cremosa y ligera que te hará querer más.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para celebraciones, postres o un capricho dulce\r\n🩷 Sabor auténtico y textura única\r\n\r\n¡Disfruta del sabor que te hará sentir como en casa! ', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/tres_leches.jpeg'),
(13, 'vainilla', 'suave', '¡El sabor clásico que nunca falla!\r\nBizcocho esponjoso de vainilla, suave y lleno de sabor, cubierto con un glaseado cremoso que te enamorará desde el primer bocado.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Perfecta para cualquier ocasión, desde cumpleaños hasta meriendas\r\n🩷 Sabor delicado y textura irresistible\r\n\r\n¡Haz que cada momento sea especial con esta deliciosa tarta de vainilla!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/vainilla.jpeg'),
(14, 'zanahoria', 'especiado', '¡Una combinación perfecta de sabor y textura!\r\nBizcocho de zanahoria, suave y húmedo, con un toque de especias y cubierto con un delicioso glaseado de queso crema.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Ideal para postres, meriendas o celebraciones\r\n🩷 Sabor fresco y natural que te conquistará\r\n\r\n¡Disfruta de la suavidad y frescura de esta tarta única!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/zanahoria.jpeg'),
(21, 'vainilla', 'suave', '¡El sabor clásico que nunca falla!\r\nBizcocho esponjoso de vainilla, suave y lleno de sabor, cubierto con un glaseado cremoso que te enamorará desde el primer bocado.\r\n🩷 100% artesanal, sin conservadores\r\n🩷 Perfecta para cualquier ocasión, desde cumpleaños hasta meriendas\r\n🩷 Sabor delicado y textura irresistible\r\n\r\n¡Haz que cada momento sea especial con esta deliciosa tarta de vainilla!', 15, 1, 'http://localhost/PROYECTO/pasteleria/assets/img/catalogue/tartas/vainilla.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'admin'),
(2, 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sabor`
--

CREATE TABLE `sabor` (
  `id_sabor` int(11) NOT NULL,
  `nombre_sabor` varchar(100) NOT NULL,
  `precio_sabor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sabor`
--

INSERT INTO `sabor` (`id_sabor`, `nombre_sabor`, `precio_sabor`) VALUES
(1, 'tarta de chocolate', 1),
(2, 'tarta de vainilla', 1),
(3, 'tarta de zanahoria', 1),
(4, 'tarta tres leches', 1),
(5, 'tarta de oreo', 1),
(6, 'tarta de queso', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tamano`
--

CREATE TABLE `tamano` (
  `id_tamano` int(11) NOT NULL,
  `nombre_tamano` varchar(100) NOT NULL,
  `precio_tamano` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tamano`
--

INSERT INTO `tamano` (`id_tamano`, `nombre_tamano`, `precio_tamano`) VALUES
(1, 'pequeño', 2),
(2, 'mediano', 4),
(3, 'grande', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `telefono_usuario` int(11) NOT NULL,
  `direccion_usuario` varchar(500) NOT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `foto_usuario` varchar(100) NOT NULL,
  `rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `telefono_usuario`, `direccion_usuario`, `email_usuario`, `foto_usuario`, `rol`) VALUES
(1, 'Maïna Boza', 682574341, 'Calle DeMiCasa 3', 'mainaboza@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKyyYoimUFp-thR_2AEcUTQTNX6h3yXqZ7kiwoH--cavAVhLoTp=s96-c', 2),
(2, 'maina boza', 0, '', 'bozamaina@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocJPPmZWDfaGRQo8-AZ9p5frzJobvNwD6wD8-vqothSURzm7eYk=s96-c', 1),
(3, 'mayian', 0, '', 'mayian3333@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocLoY089IPUN-8QCMvVHX7cHenWjiJN6zHwKJ36HBoPj0SCJoQ=s96-c', 2),
(13, 'Leonor', 0, '', 'leonorgame33@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocJqTzVFoRVM_kXKtPkZXcMpDWGSKqQwhQUGCfjBotCk8wJIZQc=s96-c', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD KEY `fk_producto_id` (`producto_id`),
  ADD KEY `fk_personalizacion_id` (`personalizacion_id`),
  ADD KEY `fk_usuario` (`usuario_carrito`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categ`);

--
-- Indices de la tabla `decoracion`
--
ALTER TABLE `decoracion`
  ADD PRIMARY KEY (`id_decoracion`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_producto` (`producto_id`),
  ADD KEY `fk_personalizacion` (`personalizacion_id`),
  ADD KEY `fk_pedido` (`pedido_id`);

--
-- Indices de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`id_donacion`),
  ADD KEY `fk_usuario_donacion` (`usuario_donacion`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `masa`
--
ALTER TABLE `masa`
  ADD PRIMARY KEY (`id_masa`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`opcion_id`);

--
-- Indices de la tabla `opciones_adicionales`
--
ALTER TABLE `opciones_adicionales`
  ADD PRIMARY KEY (`opc_adcional_id`),
  ADD KEY `fk_id_opcion` (`id_opcion`),
  ADD KEY `fk_id_personalizacion` (`id_personalizacion`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `fk_estado_pedido` (`estado_pedido`),
  ADD KEY `fk_usuario_id` (`usuario_id`);

--
-- Indices de la tabla `personalizacion`
--
ALTER TABLE `personalizacion`
  ADD PRIMARY KEY (`id_personalizacion`),
  ADD KEY `fk_masa_personalization` (`masa_personalizacion`),
  ADD KEY `fk_sabor_personalization` (`sabor_personalizacion`),
  ADD KEY `fk_decoracion_personalization` (`decoracion_personalizacion`),
  ADD KEY `fk_usuario_personalizacion` (`usuario_personalizacion`),
  ADD KEY `fk_tamano_personalization` (`tamano_personalizacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `fk_categoria` (`categoria`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `sabor`
--
ALTER TABLE `sabor`
  ADD PRIMARY KEY (`id_sabor`);

--
-- Indices de la tabla `tamano`
--
ALTER TABLE `tamano`
  ADD PRIMARY KEY (`id_tamano`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_id_rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `decoracion`
--
ALTER TABLE `decoracion`
  MODIFY `id_decoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `masa`
--
ALTER TABLE `masa`
  MODIFY `id_masa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `opcion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `opciones_adicionales`
--
ALTER TABLE `opciones_adicionales`
  MODIFY `opc_adcional_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `personalizacion`
--
ALTER TABLE `personalizacion`
  MODIFY `id_personalizacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sabor`
--
ALTER TABLE `sabor`
  MODIFY `id_sabor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tamano`
--
ALTER TABLE `tamano`
  MODIFY `id_tamano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_personalizacion_id` FOREIGN KEY (`personalizacion_id`) REFERENCES `personalizacion` (`id_personalizacion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto_id` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_prod`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_carrito`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `fk_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`pedido_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_personalizacion` FOREIGN KEY (`personalizacion_id`) REFERENCES `personalizacion` (`id_personalizacion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_prod`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD CONSTRAINT `fk_usuario_donacion` FOREIGN KEY (`usuario_donacion`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `opciones_adicionales`
--
ALTER TABLE `opciones_adicionales`
  ADD CONSTRAINT `fk_id_opcion` FOREIGN KEY (`id_opcion`) REFERENCES `opciones` (`opcion_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_personalizacion` FOREIGN KEY (`id_personalizacion`) REFERENCES `personalizacion` (`id_personalizacion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_estado_pedido` FOREIGN KEY (`estado_pedido`) REFERENCES `estados` (`id_estado`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `personalizacion`
--
ALTER TABLE `personalizacion`
  ADD CONSTRAINT `fk_decoracion_personalization` FOREIGN KEY (`decoracion_personalizacion`) REFERENCES `decoracion` (`id_decoracion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_masa_personalization` FOREIGN KEY (`masa_personalizacion`) REFERENCES `masa` (`id_masa`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sabor_personalization` FOREIGN KEY (`sabor_personalizacion`) REFERENCES `sabor` (`id_sabor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tamano_personalization` FOREIGN KEY (`tamano_personalizacion`) REFERENCES `tamano` (`id_tamano`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_personalizacion` FOREIGN KEY (`usuario_personalizacion`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id_categ`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_id_rol` FOREIGN KEY (`rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
