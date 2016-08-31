-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 31-08-2016 a las 00:24:05
-- Versión del servidor: 5.0.51
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `sanpatricio_avisosytareas`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `administradores`
-- 

CREATE TABLE `administradores` (
  `id_administrador` int(11) NOT NULL auto_increment,
  `nombre` varchar(200) NOT NULL,
  `apaterno` varchar(200) NOT NULL,
  `amaterno` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefonos` varchar(200) NOT NULL,
  `tipo` varchar(1) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_administrador`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `administradores`
-- 

INSERT INTO `administradores` VALUES (3, 'adminsid', 'admin', '', '', '', '', 'cema', 'a957e0ee1275a0948fb7034ccf432fdd');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos`
-- 

CREATE TABLE `alumnos` (
  `id_alumno` int(11) NOT NULL auto_increment,
  `matricula` varchar(30) NOT NULL,
  `nombre` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apellido_p` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apellido_m` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `fecha_nac` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `user` varchar(5) NOT NULL,
  `pass` varchar(5) NOT NULL,
  `curp` varchar(40) default NULL,
  `direccion` varchar(200) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `fecha_alta` date NOT NULL,
  `foto` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `elaboro` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_alumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos`
-- 

INSERT INTO `alumnos` VALUES (1, '1620101', 'GABRIEL', 'REGALADO', 'SANCHEZ', '2012-04-06', 'M', 'resg', 'c1py0', 'RESG921226HYNGNB00', 'C14 NO.205 POR 3 DIAG Y 5 DIAG, COL.JUAN B. SOSA', '1234567890', '2016-04-01', '', 'isc.resg92@gmail.com,isc_resg@outlook.com', '');
INSERT INTO `alumnos` VALUES (2, '', 'ANDRES', 'KITUC', 'CHAN', '2016-04-07', 'M', '', '', '', '', '', '2016-04-07', '', 'andres@solucionesid.com', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_casa`
-- 

CREATE TABLE `alumnos_datos_casa` (
  `id_personas` int(11) NOT NULL auto_increment,
  `id_familia` int(11) NOT NULL,
  `mama` int(1) NOT NULL,
  `papa` int(1) NOT NULL,
  `hermanos` varchar(15) character set latin1 collate latin1_spanish_ci NOT NULL,
  `h_quienes` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `abuelitos_p` int(2) NOT NULL,
  `abuelitos_m` int(2) NOT NULL,
  `num_tias` int(3) NOT NULL,
  `num_tios` int(3) NOT NULL,
  `nom_tias` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `nom_tios` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `otros` text character set latin1 collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_personas`),
  KEY `idAlumno` (`id_familia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_casa`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_detalles`
-- 

CREATE TABLE `alumnos_datos_detalles` (
  `id_detalle` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `R1` varchar(255) character set latin1 collate latin1_spanish_ci NOT NULL,
  `R2` varchar(255) character set latin1 collate latin1_spanish_ci NOT NULL,
  `cual` text character set latin1 collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_detalle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_detalles`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_familia`
-- 

CREATE TABLE `alumnos_datos_familia` (
  `id_familia` int(11) NOT NULL auto_increment,
  `tutor` enum('1','2') NOT NULL COMMENT '1-padre, 2-madre',
  `nombre_t` varchar(200) NOT NULL,
  `direccion_t` varchar(200) NOT NULL,
  `trabajo_t` varchar(150) NOT NULL,
  `tel_trabajo_t` varchar(20) NOT NULL,
  `cel_t` varchar(20) NOT NULL,
  `cel_compania_t` enum('1','2') NOT NULL COMMENT '1-Telcel, 2-IUSA',
  `email_t` varchar(150) NOT NULL,
  `tel_t` varchar(30) NOT NULL,
  `profesion_t` varchar(100) NOT NULL,
  `puesto_t` varchar(50) NOT NULL,
  `direccion_trabajo_t` varchar(150) NOT NULL,
  `horario_t` varchar(100) NOT NULL,
  `nombre_m` varchar(200) NOT NULL,
  `direccion_m` varchar(200) NOT NULL,
  `trabajo_m` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `tel_trabajo_m` varchar(20) NOT NULL,
  `cel_m` varchar(20) NOT NULL,
  `cel_compania_m` enum('1','2') NOT NULL COMMENT '1-Telcel, 2-IUSA',
  `email_m` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `tel_m` varchar(30) NOT NULL,
  `profesion_m` varchar(100) NOT NULL,
  `puesto_m` varchar(100) NOT NULL,
  `direccion_trabajo_m` varchar(150) NOT NULL,
  `horario_m` varchar(100) NOT NULL,
  `nombre_p` varchar(200) character set latin1 collate latin1_spanish_ci NOT NULL,
  `direccion_p` varchar(200) character set latin1 collate latin1_spanish_ci NOT NULL,
  `trabajo_p` varchar(150) NOT NULL,
  `tel_trabajo_p` varchar(20) NOT NULL,
  `cel_p` varchar(20) character set latin1 collate latin1_spanish_ci NOT NULL,
  `cel_compania_p` enum('1','2') NOT NULL COMMENT '1-Telcel, 2-IUSA',
  `email_p` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `tel_p` varchar(30) NOT NULL,
  `profesion_p` varchar(100) NOT NULL,
  `puesto_p` varchar(50) NOT NULL,
  `direccion_trabajo_p` varchar(150) NOT NULL,
  `horario_p` varchar(100) NOT NULL,
  `nombre_fam` varchar(200) NOT NULL,
  `cel_fam` varchar(20) character set latin1 collate latin1_spanish_ci NOT NULL,
  `cel_compania_fam` enum('1','2') NOT NULL COMMENT '1-Telcel, 2-Iusa',
  `parentesco_fam` varchar(100) NOT NULL,
  `tel_fam` varchar(150) NOT NULL,
  `trabajo_fam` varchar(100) NOT NULL,
  `user` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  PRIMARY KEY  (`id_familia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_familia`
-- 

INSERT INTO `alumnos_datos_familia` VALUES (1, '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
INSERT INTO `alumnos_datos_familia` VALUES (2, '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_fiscales`
-- 

CREATE TABLE `alumnos_datos_fiscales` (
  `id_fiscales` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `rfc` varchar(100) NOT NULL,
  `direccion_fiscal` varchar(255) NOT NULL,
  `calle_fiscal` varchar(100) NOT NULL,
  `nexterior_fiscal` varchar(100) NOT NULL,
  `ninterior_fiscal` varchar(100) NOT NULL,
  `colonia_fiscal` varchar(150) NOT NULL,
  `referencia_fiscal` varchar(200) NOT NULL,
  `municipio_fiscal` varchar(150) NOT NULL,
  `pais_fiscal` varchar(150) NOT NULL,
  `localidad_fiscal` varchar(150) NOT NULL,
  `email_fiscal` varchar(150) NOT NULL,
  `cp_fiscal` varchar(100) NOT NULL,
  `ciudad_fiscal` varchar(150) NOT NULL,
  `estado_fiscal` varchar(150) NOT NULL,
  `prestacion` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_fiscales`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_fiscales`
-- 

INSERT INTO `alumnos_datos_fiscales` VALUES (1, 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `alumnos_datos_fiscales` VALUES (2, 2, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_hermanos`
-- 

CREATE TABLE `alumnos_datos_hermanos` (
  `id_hermano` int(11) NOT NULL auto_increment,
  `nombre` varchar(60) NOT NULL,
  `edad` varchar(4) NOT NULL,
  `id_familia` int(11) NOT NULL,
  PRIMARY KEY  (`id_hermano`),
  KEY `idAlumno` (`id_familia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_hermanos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_personas`
-- 

CREATE TABLE `alumnos_datos_personas` (
  `id_persona` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `nombre` varchar(60) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apellido_p` varchar(60) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apellido_m` varchar(60) character set latin1 collate latin1_spanish_ci NOT NULL,
  `direccion` varchar(70) character set latin1 collate latin1_spanish_ci NOT NULL,
  `parentesco` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `foto` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_persona`),
  KEY `idAlumno` (`id_alumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_personas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_procedencia`
-- 

CREATE TABLE `alumnos_datos_procedencia` (
  `id_procedencia` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `escuela_proc` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `practica` varchar(2) character set latin1 collate latin1_spanish_ci NOT NULL,
  `cuales` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `horario` varchar(255) character set latin1 collate latin1_spanish_ci NOT NULL,
  `observaciones` text character set latin1 collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (`id_procedencia`),
  KEY `id_alumno` (`id_alumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_procedencia`
-- 

INSERT INTO `alumnos_datos_procedencia` VALUES (1, 1, '', '', '', '', '');
INSERT INTO `alumnos_datos_procedencia` VALUES (2, 2, '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_salud`
-- 

CREATE TABLE `alumnos_datos_salud` (
  `id_expediente` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `tipo_sangre` varchar(5) NOT NULL,
  `limitaciones` varchar(100) character set latin1 collate latin1_spanish_ci NOT NULL,
  `alergias` varchar(100) character set latin1 collate latin1_spanish_ci NOT NULL,
  `padecimiento` varchar(100) character set latin1 collate latin1_spanish_ci NOT NULL,
  `observaciones` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `medico` varchar(200) NOT NULL,
  `cel_medico` varchar(20) NOT NULL,
  `trabajo_medico` varchar(100) NOT NULL,
  `tel_medico` varchar(30) NOT NULL,
  PRIMARY KEY  (`id_expediente`),
  KEY `idAlumno` (`id_alumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_salud`
-- 

INSERT INTO `alumnos_datos_salud` VALUES (1, 1, '', '', '', '', '', '', '', '', '');
INSERT INTO `alumnos_datos_salud` VALUES (2, 2, '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_yuc`
-- 

CREATE TABLE `alumnos_datos_yuc` (
  `id_datos_yuc` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `situacion_padres` enum('1','2','3','4','5') NOT NULL COMMENT '1-CASADOS, 2-SEPARADOS, 3-DIVORCIADOS, 4-UNION LIBRE, 5-OTROS ',
  `situacion_otros` varchar(50) NOT NULL,
  `lugar_familia` varchar(50) NOT NULL,
  `num_her_h` int(11) NOT NULL,
  `num_her_m` int(11) NOT NULL,
  `vive_con` enum('1','2','3','4') NOT NULL COMMENT '1-PADRES, 2-ABUELOS, 3-MADRE, 4-OTROS',
  `vive_otros` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_datos_yuc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_yuc`
-- 

INSERT INTO `alumnos_datos_yuc` VALUES (1, 1, '', '', '', 0, 0, '', '');
INSERT INTO `alumnos_datos_yuc` VALUES (2, 2, '', '', '', 0, 0, '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_yuc_estatus`
-- 

CREATE TABLE `alumnos_datos_yuc_estatus` (
  `id_estatus` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `nuevo` enum('0','1') NOT NULL,
  `reingreso` enum('0','1') NOT NULL,
  `repetidor` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_estatus`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_yuc_estatus`
-- 

INSERT INTO `alumnos_datos_yuc_estatus` VALUES (1, 1, '0', '0', '0');
INSERT INTO `alumnos_datos_yuc_estatus` VALUES (2, 2, '0', '0', '0');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_yuc_servicios`
-- 

CREATE TABLE `alumnos_datos_yuc_servicios` (
  `id_servicio_alumno` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) default NULL,
  `estancia` enum('1','2','3') default NULL COMMENT '1-HASTA 3PM, 2-HASTA 4 PM, 3-HASTA 5PM',
  `transporte` enum('1','2') default NULL COMMENT '1-MEDIO, 2-COMPLETO',
  PRIMARY KEY  (`id_servicio_alumno`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_yuc_servicios`
-- 

INSERT INTO `alumnos_datos_yuc_servicios` VALUES (1, 1, '', '');
INSERT INTO `alumnos_datos_yuc_servicios` VALUES (2, 2, '', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_datos_yuc_transporte`
-- 

CREATE TABLE `alumnos_datos_yuc_transporte` (
  `id_transporte_alumno` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `calle` varchar(50) default NULL,
  `numero` varchar(20) default NULL,
  `cruzamientos` varchar(50) default NULL,
  `colonia` varchar(50) default NULL,
  `cp` int(10) default NULL,
  `referencia` text,
  `cuota_inicial` float default NULL,
  `fecha_inicio` date default NULL,
  PRIMARY KEY  (`id_transporte_alumno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_datos_yuc_transporte`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_documentos`
-- 

CREATE TABLE `alumnos_documentos` (
  `id_doc` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `documento` int(2) NOT NULL COMMENT '1-ACT.NAC., 2-CALIF.ANT, 3-CERT, 4-CARTA, 5-CARTILLA, 6-FOTOS, 7-DOMIC, 8-CURP, 9-CERT.PARCIAL, 10-CONST.ESTUDIOS, 11-NO ADEUDO, 12-OTROS',
  `op1` enum('0','1') NOT NULL,
  `op2` enum('0','1') NOT NULL,
  `otro` tinytext NOT NULL,
  PRIMARY KEY  (`id_doc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_documentos`
-- 

INSERT INTO `alumnos_documentos` VALUES (1, 1, 1, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (2, 1, 2, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (3, 1, 3, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (4, 1, 4, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (5, 1, 5, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (6, 1, 6, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (7, 1, 7, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (8, 1, 8, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (9, 1, 9, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (10, 1, 10, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (11, 1, 11, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (12, 1, 12, '0', '0', '');
INSERT INTO `alumnos_documentos` VALUES (13, 2, 1, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (14, 2, 2, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (15, 2, 3, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (16, 2, 4, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (17, 2, 5, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (18, 2, 6, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (19, 2, 7, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (20, 2, 8, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (21, 2, 9, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (22, 2, 10, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (23, 2, 11, '', '', '');
INSERT INTO `alumnos_documentos` VALUES (24, 2, 12, '0', '0', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_familia`
-- 

CREATE TABLE `alumnos_familia` (
  `id_relacion` int(11) NOT NULL auto_increment,
  `id_familia` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  PRIMARY KEY  (`id_relacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_familia`
-- 

INSERT INTO `alumnos_familia` VALUES (1, 1, 1);
INSERT INTO `alumnos_familia` VALUES (2, 2, 2);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumnos_preguntas_detalles`
-- 

CREATE TABLE `alumnos_preguntas_detalles` (
  `id_pregunta` int(11) NOT NULL auto_increment,
  `pregunta` varchar(255) NOT NULL,
  `tipo` int(1) NOT NULL,
  PRIMARY KEY  (`id_pregunta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `alumnos_preguntas_detalles`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `alumno_grupo`
-- 

CREATE TABLE `alumno_grupo` (
  `id_relacion` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `fecha_inscribe` date NOT NULL,
  `estado` enum('0','1') NOT NULL COMMENT '0-Activo, 1-Baja',
  `fecha_baja` date NOT NULL,
  `usuario_activa_baja` varchar(150) NOT NULL,
  `ingreso` enum('1','2') NOT NULL COMMENT '1-Nvo. Ingreso, 2-Reingreso',
  `repetidor` enum('1','2') NOT NULL COMMENT '1-No Repetidor, 2-Repetidor',
  PRIMARY KEY  (`id_relacion`),
  UNIQUE KEY `id_alumno` (`id_alumno`,`id_grupo`,`estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `alumno_grupo`
-- 

INSERT INTO `alumno_grupo` VALUES (1, 1, 2, '2016-04-01', '0', '0000-00-00', '', '', '');

-- --------------------------------------------------------

-- 
-- Estructura Stand-in para la vista `alumno_grupo_ciclo`
-- 
CREATE TABLE `alumno_grupo_ciclo` (
`id_alumno_grupo` null
,`id_alumno` null
,`id_grupo` null
,`grado` null
,`letra` null
,`id_ciclo` null
,`id_nivel` null
,`grupo` varbinary(9)
,`nivel` null
,`ingreso` null
,`repetidor` null
,`estado` null
,`fecha_inscribe` null
);
-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `avisos`
-- 

CREATE TABLE `avisos` (
  `idAviso` int(11) NOT NULL auto_increment,
  `aviso` text NOT NULL,
  `fecha` date NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `id_ciclo` int(11) default NULL,
  `id_nivel` int(11) default NULL,
  `id_grupo` int(11) default NULL,
  `id_alumno` int(11) default NULL,
  `id_maestro` int(11) default NULL,
  `fecha_creacion` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`idAviso`),
  KEY `id_ciclo` (`id_ciclo`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_maestro` (`id_maestro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `avisos`
-- 

INSERT INTO `avisos` VALUES (1, 'ESTE ES UN AVISO QUE PUEDE VER CUALQUIERA ESTE ES UN AVISO QUE PUEDE VER CUALQUIERA ESTE ES UN AVISO QUE PUEDE VER CUALQUIERA ESTE ES UN AVISO QUE PUEDE VER CUALQUIERA ESTE ES UN AVISO QUE PUEDE VER CUALQUIERA ESTE ES UN AVISO QUE PUEDE VER CUALQUIERA.', '2016-04-01', 1, 'UN AVISO PARA TODOS', 1, NULL, NULL, NULL, NULL, '2016-04-01 18:13:29');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `boleta_pago`
-- 

CREATE TABLE `boleta_pago` (
  `id_inscripcion` int(11) NOT NULL auto_increment,
  `id_alumno_grupo` int(11) default NULL,
  `id_alumno` int(11) default NULL,
  `id_grupo` int(11) default NULL,
  `inscrip` enum('0','1') default NULL,
  `Jan` int(1) default NULL,
  `Feb` int(1) default NULL,
  `Mar` int(1) default NULL,
  `Apr` int(1) default NULL,
  `May` int(1) default NULL,
  `Jun` int(1) default NULL,
  `Jul` int(1) default NULL,
  `Aug` int(1) default NULL,
  `Sep` int(1) default NULL,
  `Oct` int(1) default NULL,
  `Nov` int(1) default NULL,
  `Dec` int(1) default NULL,
  PRIMARY KEY  (`id_inscripcion`),
  UNIQUE KEY `id_alumno` (`id_alumno`,`id_grupo`,`id_alumno_grupo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `boleta_pago`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `caja_inicial`
-- 

CREATE TABLE `caja_inicial` (
  `id_caja` int(11) NOT NULL auto_increment,
  `edificio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `importe` decimal(12,2) NOT NULL,
  `elaboro` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_caja`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `caja_inicial`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `calificaciones`
-- 

CREATE TABLE `calificaciones` (
  `id_calificacion` int(11) NOT NULL auto_increment,
  `id_mat_alumno` int(11) NOT NULL,
  `u1` float(9,2) default NULL,
  `u2` float(9,2) default NULL,
  `u3` float(9,2) default NULL,
  `u4` float(9,2) default NULL,
  `u5` float(9,2) default NULL,
  `promedio` float(9,2) default NULL,
  `id_ciclo` int(11) default NULL,
  `id_nivel` int(11) default NULL,
  `id_grupo` int(11) default NULL,
  `id_alumno` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  PRIMARY KEY  (`id_calificacion`),
  KEY `id_mat_alumno` (`id_mat_alumno`),
  KEY `id_ciclo` (`id_ciclo`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_alumno` (`id_alumno`),
  KEY `id_materia` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `calificaciones`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `califica_alumno`
-- 

CREATE TABLE `califica_alumno` (
  `id_califica` int(11) NOT NULL auto_increment,
  `id_periodo` varchar(20) collate utf8_unicode_ci NOT NULL,
  `id_mat_alumno` int(11) NOT NULL,
  `id_mat_sub` int(11) NOT NULL,
  `califica` varchar(3) collate utf8_unicode_ci NOT NULL,
  `observ` text collate utf8_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id_califica`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `califica_alumno`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `califica_publicar`
-- 

CREATE TABLE `califica_publicar` (
  `id_publica` int(11) NOT NULL auto_increment,
  `id_periodo` varchar(20) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `publicar` int(1) NOT NULL,
  `bloquear` enum('0','1') NOT NULL COMMENT '0-Desbloqueado(puede modificar las calif)  1-Bloqueado(Ya no puede modificar las calif)',
  PRIMARY KEY  (`id_publica`),
  UNIQUE KEY `idCiclo` (`id_periodo`,`id_grupo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `califica_publicar`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `categorias`
-- 

CREATE TABLE `categorias` (
  `id_categoria` int(10) unsigned NOT NULL auto_increment,
  `descripcion` varchar(60) NOT NULL,
  PRIMARY KEY  (`id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `categorias`
-- 

INSERT INTO `categorias` VALUES (1, 'admin');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ciclos`
-- 

CREATE TABLE `ciclos` (
  `id_ciclo` int(11) NOT NULL auto_increment,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `nombre_ciclo` varchar(150) NOT NULL,
  `activo` enum('0','1','2') NOT NULL,
  PRIMARY KEY  (`id_ciclo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `ciclos`
-- 

INSERT INTO `ciclos` VALUES (1, '2016-03-30', '2016-03-30', 'Ciclo Escolar General 2015-2016', '1');
INSERT INTO `ciclos` VALUES (2, '2016-03-30', '2016-03-30', 'Ciclo Escolar General 2016-2017', '0');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `ciclo_niveles`
-- 

CREATE TABLE `ciclo_niveles` (
  `id_relacion` int(11) NOT NULL auto_increment,
  `id_ciclo` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  PRIMARY KEY  (`id_relacion`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_ciclo` (`id_ciclo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `ciclo_niveles`
-- 

INSERT INTO `ciclo_niveles` VALUES (1, 1, 1);
INSERT INTO `ciclo_niveles` VALUES (2, 1, 2);
INSERT INTO `ciclo_niveles` VALUES (3, 1, 3);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `com_archivos`
-- 

CREATE TABLE `com_archivos` (
  `id_archivo` int(11) NOT NULL auto_increment,
  `id_grupo` int(11) NOT NULL,
  `archivo` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_archivo`),
  KEY `idGrupo` (`id_grupo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `com_archivos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos`
-- 

CREATE TABLE `conceptos` (
  `id_concepto` int(11) NOT NULL auto_increment,
  `descrip` tinytext NOT NULL,
  `tipo` enum('C','D','DE','O','B') NOT NULL COMMENT 'C-cargo,D-descuento,B-Beca',
  `importe` float(12,2) NOT NULL,
  `tipo_importe` enum('pesos','porcentaje') NOT NULL,
  `descuento_total` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_concepto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `conceptos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos_alumnos`
-- 

CREATE TABLE `conceptos_alumnos` (
  `id` int(11) NOT NULL auto_increment,
  `id_concepto_nivel` int(11) default NULL,
  `id_alumno` int(11) default NULL,
  `id_alumno_grupo` int(11) default NULL,
  `estatus` enum('0','1') default NULL COMMENT '0-Activo, 1-Cancelado',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id_concepto_nivel` (`id_concepto_nivel`,`id_alumno`,`id_alumno_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `conceptos_alumnos`
-- 

INSERT INTO `conceptos_alumnos` VALUES (1, 0, 1, 1, NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos_alumnos_mes`
-- 

CREATE TABLE `conceptos_alumnos_mes` (
  `id_conce_mes` int(11) NOT NULL auto_increment,
  `id_concepto_alumno` int(11) default NULL,
  `mes` int(11) default NULL,
  `estatus` enum('0','1') default NULL COMMENT '0-Nopagado 1-Pagado',
  PRIMARY KEY  (`id_conce_mes`),
  UNIQUE KEY `id_concepto_alumno` (`id_concepto_alumno`,`mes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `conceptos_alumnos_mes`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos_categoria_otros`
-- 

CREATE TABLE `conceptos_categoria_otros` (
  `id_catego` int(11) NOT NULL auto_increment,
  `descrip` varchar(200) NOT NULL,
  PRIMARY KEY  (`id_catego`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `conceptos_categoria_otros`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos_configurables`
-- 

CREATE TABLE `conceptos_configurables` (
  `id_config` int(11) NOT NULL auto_increment,
  `id_ciclo` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `grado` int(11) NOT NULL COMMENT '0-todos los grados',
  `dia_ini` int(11) NOT NULL,
  `dia_fin` int(11) NOT NULL,
  `aplicar_por` enum('0','1','2','3') NOT NULL COMMENT '0-por periodo(C,D), 1-Mes sig.(C) 2-Pago de varios meses(D), 3-mes especifico(C)',
  `tipo_espe` enum('1','2','3') NOT NULL COMMENT '1-FIJO, 2-OPORTUNO, 3-MES ATRASADO',
  `mes_aplica` int(11) NOT NULL COMMENT 'MES ESCPECIFICO',
  `N` int(11) NOT NULL COMMENT 'aplicar_por=1 N=dias de espera, aplicar_por=2 N=Numero de meses',
  `tipo_c` enum('D','C') NOT NULL COMMENT 'D-descuento, C-cargo',
  `concepto` varchar(150) NOT NULL,
  `importe` decimal(12,2) NOT NULL,
  `importe_acumulable` int(1) NOT NULL,
  `tipo_imp` enum('pesos','porcentaje') NOT NULL,
  PRIMARY KEY  (`id_config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `conceptos_configurables`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos_nivel`
-- 

CREATE TABLE `conceptos_nivel` (
  `id_concepto_nivel` int(11) NOT NULL auto_increment,
  `id_ciclo` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `tipo_c` enum('01','02','03','04') NOT NULL COMMENT '01-Inscrip,02-ConceptosCole,03-Cuota,04-MenCole',
  `grado` int(11) NOT NULL,
  `aplica` enum('0','1') NOT NULL COMMENT '0-no aplica, 1-aplica',
  `posicion` int(11) NOT NULL,
  `aplica_recibo` enum('0','1') NOT NULL COMMENT '0-No aplica, 1- Aplica a Recibo',
  PRIMARY KEY  (`id_concepto_nivel`),
  KEY `id_nivel` (`id_nivel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `conceptos_nivel`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `conceptos_otros`
-- 

CREATE TABLE `conceptos_otros` (
  `id_conce` int(11) NOT NULL auto_increment,
  `id_catego` int(11) NOT NULL,
  `descrip` varchar(150) NOT NULL,
  `importe` decimal(12,2) NOT NULL,
  PRIMARY KEY  (`id_conce`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `conceptos_otros`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `config_califica`
-- 

CREATE TABLE `config_califica` (
  `id_config` int(11) NOT NULL auto_increment,
  `id_nivel` int(11) NOT NULL,
  `base` enum('10','100') NOT NULL,
  `calif_minima` int(11) NOT NULL,
  PRIMARY KEY  (`id_config`),
  UNIQUE KEY `id_nivel` (`id_nivel`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `config_califica`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `escuela`
-- 

CREATE TABLE `escuela` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(200) NOT NULL,
  `direccion` text NOT NULL,
  `telefonos` tinytext NOT NULL,
  `email` varchar(150) NOT NULL,
  `logo_pagina` varchar(150) NOT NULL,
  `logo_reporte` varchar(150) NOT NULL,
  `cabecera` tinytext NOT NULL,
  `pie` tinytext NOT NULL,
  `no_edificios` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `escuela`
-- 

INSERT INTO `escuela` VALUES (1, 'INSTITUTO SAN PATRICIO', 'C. 5-C No. 320 x 20-B y 20-C Diag. Col. Xcumpich. Mérida, Yucatán.', '(999) 981-6111', 'oficinasanpatricio@hotmail.com', 'logo_pagina.png', '', 'Mi bebe Genio', '', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fe_configuracion`
-- 

CREATE TABLE `fe_configuracion` (
  `id_configuracion` int(10) unsigned NOT NULL auto_increment,
  `campo` varchar(35) NOT NULL,
  `valor` varchar(300) NOT NULL,
  `img` longblob,
  PRIMARY KEY  (`id_configuracion`),
  KEY `campo_UNIQUE` (`campo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `fe_configuracion`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fe_estados`
-- 

CREATE TABLE `fe_estados` (
  `id_estado` int(11) NOT NULL auto_increment,
  `estado` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `fe_estados`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fe_facturas`
-- 

CREATE TABLE `fe_facturas` (
  `id_factura` int(10) unsigned NOT NULL auto_increment,
  `fecha_creacion` date NOT NULL,
  `folio` varchar(20) default NULL,
  `serie` varchar(5) default NULL,
  `fecha` varchar(19) NOT NULL,
  `moneda` varchar(15) NOT NULL,
  `forma_pago` varchar(60) NOT NULL,
  `metodo_pago` varchar(60) NOT NULL,
  `tipo_cambio` varchar(15) NOT NULL,
  `condiciones_pago` varchar(120) NOT NULL,
  `emisor_rfc` varchar(13) NOT NULL,
  `emisor_razon_social` varchar(200) NOT NULL,
  `emisor_calle` varchar(20) NOT NULL,
  `emisor_no_exterior` varchar(20) NOT NULL,
  `emisor_no_interior` varchar(20) NOT NULL,
  `emisor_colonia` varchar(120) NOT NULL,
  `emisor_referencia` varchar(120) NOT NULL,
  `emisor_estado` varchar(60) NOT NULL,
  `emisor_cp` varchar(15) NOT NULL,
  `emisor_municipio` varchar(120) NOT NULL,
  `emisor_localidad` varchar(120) NOT NULL,
  `emisor_pais` varchar(20) NOT NULL,
  `id_receptor` int(10) unsigned NOT NULL,
  `importe` double NOT NULL,
  `descuento_porcentaje` double NOT NULL,
  `descuento_importe` double NOT NULL,
  `iva_porcentaje` double NOT NULL,
  `subtotal` double NOT NULL,
  `iva` double NOT NULL,
  `total` double NOT NULL,
  `descuento_motivo` varchar(100) NOT NULL,
  `importe_letras` varchar(200) NOT NULL,
  `ruta_local_xml` varchar(300) NOT NULL,
  `ruta_local_pdf` varchar(300) NOT NULL,
  `ruta_ftp_xml` varchar(300) NOT NULL,
  `ruta_ftp_pdf` varchar(300) NOT NULL,
  `estatus` tinyint(1) NOT NULL default '1',
  `uuid_certificacion` varchar(20) NOT NULL,
  `fecha_certificacion` varchar(19) NOT NULL,
  `lugar_expedicion` varchar(300) default ' ',
  `num_cta_pago` varchar(300) default ' ',
  `original_folio` varchar(20) default ' ',
  `original_serie` varchar(5) default ' ',
  `original_fecha` varchar(19) default ' ',
  `original_monto` double default '0',
  `emisor_regimen` varchar(300) default ' ',
  `tipo_comprobante` varchar(60) NOT NULL default 'ingreso',
  PRIMARY KEY  (`id_factura`),
  KEY `FK_fe_facturas_fe_receptores` (`id_receptor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `fe_facturas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fe_facturas_detalle`
-- 

CREATE TABLE `fe_facturas_detalle` (
  `id_factura_detalle` int(10) unsigned NOT NULL auto_increment,
  `id_factura` int(10) unsigned NOT NULL,
  `cantidad` int(10) unsigned NOT NULL,
  `unidad` varchar(120) default NULL,
  `no_identificacion` varchar(120) default NULL,
  `descripcion` text NOT NULL,
  `valor_unitario` double NOT NULL,
  `importe` double NOT NULL,
  `nombreAlumno` varchar(255) default '',
  `curp` varchar(20) default '',
  `nivel` varchar(160) default '',
  `rvoe` varchar(20) default '',
  `rfcPago` varchar(13) default NULL,
  PRIMARY KEY  (`id_factura_detalle`),
  KEY `FK_fe_facturas_detalle_fe_facturas` (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `fe_facturas_detalle`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fe_facturas_recibos`
-- 

CREATE TABLE `fe_facturas_recibos` (
  `id_factura_recibo` int(10) unsigned NOT NULL auto_increment,
  `id_factura` int(10) unsigned NOT NULL,
  `id_factura_detalle` int(10) unsigned NOT NULL,
  `id_recibo` int(10) unsigned NOT NULL,
  `id_conce` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_factura_recibo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `fe_facturas_recibos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `fe_receptores`
-- 

CREATE TABLE `fe_receptores` (
  `id_receptor` int(10) unsigned NOT NULL auto_increment,
  `rfc` varchar(13) NOT NULL,
  `razon_social` varchar(200) NOT NULL,
  `calle` varchar(20) NOT NULL,
  `no_exterior` varchar(20) NOT NULL,
  `no_interior` varchar(20) NOT NULL,
  `colonia` varchar(120) NOT NULL,
  `referencia` varchar(120) NOT NULL,
  `estado` varchar(60) NOT NULL,
  `cp` varchar(15) NOT NULL,
  `municipio` varchar(120) NOT NULL,
  `localidad` varchar(120) NOT NULL,
  `pais` varchar(20) NOT NULL,
  `email` varchar(120) NOT NULL,
  `borrado` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_receptor`),
  UNIQUE KEY `rfc_UNICO` (`rfc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `fe_receptores`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `foliador_fiscal`
-- 

CREATE TABLE `foliador_fiscal` (
  `id_folio` int(11) NOT NULL auto_increment,
  `folio` varchar(30) NOT NULL,
  `serie` varchar(30) NOT NULL,
  `folio_final` varchar(30) NOT NULL,
  `aprobacion` varchar(30) NOT NULL,
  `fecha_aprobo` datetime NOT NULL,
  PRIMARY KEY  (`id_folio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `foliador_fiscal`
-- 

INSERT INTO `foliador_fiscal` VALUES (1, '1', '', '1000000', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `foliador_matricula`
-- 

CREATE TABLE `foliador_matricula` (
  `id_folio` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  PRIMARY KEY  (`id_folio`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `foliador_matricula`
-- 

INSERT INTO `foliador_matricula` VALUES (1, 91);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `foliador_recibos`
-- 

CREATE TABLE `foliador_recibos` (
  `id_folio` int(11) NOT NULL,
  `folio` int(11) NOT NULL,
  PRIMARY KEY  (`id_folio`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `foliador_recibos`
-- 

INSERT INTO `foliador_recibos` VALUES (1, 544);
INSERT INTO `foliador_recibos` VALUES (2, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `grupos`
-- 

CREATE TABLE `grupos` (
  `id_grupo` int(11) NOT NULL auto_increment,
  `grado` int(2) NOT NULL,
  `letra` varchar(30) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `estatus` enum('0','1') NOT NULL,
  `plan_estudio` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_grupo`),
  UNIQUE KEY `grado` (`grado`,`letra`,`id_nivel`,`id_ciclo`),
  KEY `id_nivel` (`id_nivel`),
  KEY `id_ciclo` (`id_ciclo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Volcar la base de datos para la tabla `grupos`
-- 

INSERT INTO `grupos` VALUES (1, 1, 'A', 1, 1, '0', '');
INSERT INTO `grupos` VALUES (2, 1, 'A', 2, 1, '0', '');
INSERT INTO `grupos` VALUES (3, 1, 'A', 3, 1, '0', '');
INSERT INTO `grupos` VALUES (4, 2, 'A', 3, 1, '0', '');
INSERT INTO `grupos` VALUES (5, 3, 'A', 3, 1, '0', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `grupo_maestro`
-- 

CREATE TABLE `grupo_maestro` (
  `id_grupo_maestro` int(11) NOT NULL auto_increment,
  `id_grupo` int(11) NOT NULL,
  `id_maestro` int(11) NOT NULL,
  PRIMARY KEY  (`id_grupo_maestro`),
  UNIQUE KEY `idGrupo_2` (`id_maestro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `grupo_maestro`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `maestros`
-- 

CREATE TABLE `maestros` (
  `id_maestro` int(11) NOT NULL auto_increment,
  `tipo_personal` enum('1','2') character set latin1 collate latin1_spanish_ci NOT NULL COMMENT '1-Maestro, 2-Administrativo',
  `edificio` enum('1','2') NOT NULL COMMENT '1-Edificio1,  2-Edificio2',
  `nivel` varchar(20) NOT NULL,
  `nombre` varchar(60) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apellido_p` varchar(70) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apellido_m` varchar(70) character set latin1 collate latin1_spanish_ci NOT NULL,
  `user` varchar(20) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `fecha_nac` date NOT NULL,
  `sexo` varchar(15) NOT NULL,
  `sangre` varchar(20) NOT NULL,
  `domicilio` varchar(60) character set latin1 collate latin1_spanish_ci NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `lugar_nac` varchar(150) NOT NULL,
  `estado_civil` varchar(20) NOT NULL,
  `dependientes` varchar(20) character set latin1 collate latin1_spanish_ci NOT NULL,
  `parentesco` varchar(30) character set latin1 collate latin1_spanish_ci NOT NULL,
  `otro_trabajo` varchar(5) character set latin1 collate latin1_spanish_ci NOT NULL,
  `cual` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `habilidades` varchar(100) character set latin1 collate latin1_spanish_ci NOT NULL,
  `pasatiempos` varchar(100) character set latin1 collate latin1_spanish_ci NOT NULL,
  `meta` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `que_esperas` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `que_ofreces` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `rfc` varchar(30) NOT NULL,
  `curp` varchar(30) NOT NULL,
  `ife` varchar(30) NOT NULL,
  `fing` date NOT NULL,
  `fllena` date NOT NULL,
  `alta_imss` varchar(30) NOT NULL,
  `num_afil` varchar(30) NOT NULL,
  `comunicarse_con` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `c_parentesco` varchar(30) character set latin1 collate latin1_spanish_ci NOT NULL,
  `telefono_p` varchar(30) NOT NULL,
  `nombre_conyugue` varchar(50) character set latin1 collate latin1_spanish_ci NOT NULL,
  `apaterno_conyugue` varchar(30) character set latin1 collate latin1_spanish_ci NOT NULL,
  `amaterno_conyugue` varchar(30) character set latin1 collate latin1_spanish_ci NOT NULL,
  `direccion_conyugue` varchar(70) character set latin1 collate latin1_spanish_ci NOT NULL,
  `tel_conyugue` varchar(30) NOT NULL,
  `cel_conyugue` varchar(30) NOT NULL,
  `tel_trabajo` varchar(30) NOT NULL,
  `lugar_trabajo` varchar(40) character set latin1 collate latin1_spanish_ci NOT NULL,
  `puesto` varchar(60) character set latin1 collate latin1_spanish_ci NOT NULL,
  `hijos` varchar(10) character set latin1 collate latin1_spanish_ci NOT NULL,
  `nombres_edades` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `foto` varchar(150) NOT NULL,
  `otra_persona` varchar(255) NOT NULL,
  `o_parentesco` varchar(255) NOT NULL,
  `telefono_o` varchar(255) NOT NULL,
  `estatus` enum('0','1') NOT NULL COMMENT '0-Activo, 1-Baja',
  PRIMARY KEY  (`id_maestro`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `maestros`
-- 

INSERT INTO `maestros` VALUES (1, '1', '1', 'Kinder', 'LARRISA', 'PENICHE', 'RUIZ', 'larissa', 'larissa', '0000-00-00', 'M', '', 'RDTFYGUHJ', '234567890', '234567890', 'isc.resg92@gmail.com', '', '', '', '', '', '', '', '', '', '', '', 'T FVNBIBFV4E65678', 'XCFVGG3546567789', '', '2016-04-01', '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `maestros_yuc`
-- 

CREATE TABLE `maestros_yuc` (
  `id_datos` int(11) NOT NULL auto_increment,
  `id_maestro` int(11) NOT NULL,
  `preparacion` tinytext NOT NULL,
  `docto` varchar(150) NOT NULL,
  `ultimo_estudios` varchar(100) NOT NULL,
  `escuela_estudios` varchar(100) NOT NULL,
  `exp_puesto` int(11) NOT NULL,
  `puesto_actual` varchar(150) NOT NULL,
  `nivel_actual` varchar(50) NOT NULL,
  `grado_actual` varchar(30) NOT NULL,
  `puesto1` varchar(150) NOT NULL,
  `puesto_de1` varchar(30) NOT NULL,
  `puesto_a1` varchar(30) NOT NULL,
  `puesto2` varchar(150) NOT NULL,
  `puesto_de2` varchar(30) NOT NULL,
  `puesto_a2` varchar(30) NOT NULL,
  `puesto3` varchar(150) NOT NULL,
  `puesto_de3` varchar(30) NOT NULL,
  `puesto_a3` varchar(30) NOT NULL,
  `instituto1` tinytext NOT NULL,
  `puesto_inst1` varchar(150) NOT NULL,
  `periodo_inst1` varchar(150) NOT NULL,
  `instituto2` tinytext NOT NULL,
  `puesto_inst2` varchar(150) NOT NULL,
  `periodo_inst2` varchar(150) NOT NULL,
  `forma_pago` enum('1','2') NOT NULL COMMENT '1-Efectivo, 2-Tarjeta',
  `num_tarjeta` varchar(50) NOT NULL,
  `observ` text NOT NULL,
  PRIMARY KEY  (`id_datos`),
  KEY `id_maestro` (`id_maestro`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

-- 
-- Volcar la base de datos para la tabla `maestros_yuc`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `maestro_avisos`
-- 

CREATE TABLE `maestro_avisos` (
  `id_aviso` int(11) NOT NULL auto_increment,
  `id_maestro` int(11) NOT NULL,
  `tipo_maestro` varchar(20) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `titulo_aviso` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `aviso` text character set latin1 collate latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `tipo_aviso` varchar(10) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `publicar` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_aviso`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- Volcar la base de datos para la tabla `maestro_avisos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `maestro_tareas`
-- 

CREATE TABLE `maestro_tareas` (
  `id_tarea` int(11) NOT NULL auto_increment,
  `id_maestro` int(11) NOT NULL,
  `tipo_maestro` varchar(20) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `titulo_tarea` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `tarea` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `observ` text NOT NULL,
  `fecha` date NOT NULL,
  `fecha_entrega` date NOT NULL,
  `publicar` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_tarea`),
  KEY `id_maestro` (`id_maestro`),
  KEY `id_ciclo` (`id_ciclo`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_materia` (`id_materia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `maestro_tareas`
-- 

INSERT INTO `maestro_tareas` VALUES (1, 1, '', 1, 2, 1, 'TAREA DE ARTE', '', '<p>ELABORAR UNA MAQUETA DE PLASTILINA</p>\r\n', '2016-04-01', '2016-04-01', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias`
-- 

CREATE TABLE `materias` (
  `id_materia` int(11) NOT NULL auto_increment,
  `materia` varchar(150) character set latin1 collate latin1_spanish_ci NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `optativa` enum('0','1') NOT NULL,
  `promedio` enum('1','0') NOT NULL,
  `oficial` enum('0','1') NOT NULL,
  `indispensable` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_materia`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `materias`
-- 

INSERT INTO `materias` VALUES (1, 'ARTE', 2, '0', '1', '0', '0');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias_alumnos`
-- 

CREATE TABLE `materias_alumnos` (
  `id_mat_alumno` int(11) NOT NULL auto_increment,
  `id_materia_grupo` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_alumno_grupo` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  PRIMARY KEY  (`id_mat_alumno`),
  UNIQUE KEY `idCiclo` (`id_materia_grupo`,`id_alumno`,`id_alumno_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `materias_alumnos`
-- 

INSERT INTO `materias_alumnos` VALUES (1, 1, 1, 1, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias_grupo`
-- 

CREATE TABLE `materias_grupo` (
  `id_materia_grupo` int(11) NOT NULL auto_increment,
  `id_materia` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  PRIMARY KEY  (`id_materia_grupo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `materias_grupo`
-- 

INSERT INTO `materias_grupo` VALUES (1, 1, 2, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias_maestro`
-- 

CREATE TABLE `materias_maestro` (
  `id_materia_maestro` int(11) NOT NULL auto_increment,
  `id_maestro` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  PRIMARY KEY  (`id_materia_maestro`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `materias_maestro`
-- 

INSERT INTO `materias_maestro` VALUES (1, 1, 1, 2, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias_periodos`
-- 

CREATE TABLE `materias_periodos` (
  `id_mat_periodo` int(11) NOT NULL auto_increment,
  `id_materia_grupo` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `posicion` int(11) NOT NULL,
  PRIMARY KEY  (`id_mat_periodo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `materias_periodos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materias_sub`
-- 

CREATE TABLE `materias_sub` (
  `id_sub` int(11) NOT NULL auto_increment,
  `id_materia` int(11) NOT NULL,
  `materia` text NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `optativa` enum('0','1') NOT NULL,
  `promedio` enum('1','0') NOT NULL,
  `oficial` enum('0','1') NOT NULL,
  `indispensable` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id_sub`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `materias_sub`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `meses_pagar`
-- 

CREATE TABLE `meses_pagar` (
  `id` int(11) NOT NULL auto_increment,
  `mes` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `meses_pagar`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modulos`
-- 

CREATE TABLE `modulos` (
  `id_modulo` int(10) unsigned NOT NULL auto_increment,
  `titulo` varchar(60) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `icono` varchar(255) default NULL,
  `target` varchar(255) NOT NULL,
  `es_movil` tinyint(1) default '0',
  PRIMARY KEY  (`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- 
-- Volcar la base de datos para la tabla `modulos`
-- 

INSERT INTO `modulos` VALUES (1, 'Registro', '', NULL, '', 0);
INSERT INTO `modulos` VALUES (2, 'Finanzas', '', NULL, '', 0);
INSERT INTO `modulos` VALUES (3, 'Configuracion', '', NULL, '', 0);
INSERT INTO `modulos` VALUES (4, 'Reportes', '', NULL, '', 0);
INSERT INTO `modulos` VALUES (5, 'Usuarios', '', NULL, '', 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modulo_opcion`
-- 

CREATE TABLE `modulo_opcion` (
  `id_modulo` int(10) unsigned NOT NULL,
  `opcion` varchar(45) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `target` varchar(255) NOT NULL,
  `en_menu` tinyint(1) default '1',
  PRIMARY KEY  (`id_modulo`,`opcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `modulo_opcion`
-- 

INSERT INTO `modulo_opcion` VALUES (1, 'Alta_Calificaciones', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (1, 'Avisos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (1, 'Expedientes', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (1, 'Registro_Alumno', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (1, 'Reinscripcion_Alumno', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (1, 'Tareas', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (1, 'Trans_Grupos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Alta_Concepto', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Caja', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Caja_Colegiatura', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Config_Caja', 'Configuracion de Caja', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Costo_Ins_Cole', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Egresos', 'Egresos', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Formas_Pago', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Otros_Pagos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (2, 'Recibos_Pagos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Ciclos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Config_Calificaciones', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Config_Reportes', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Datos_Escuela', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Grupos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Niveles', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Personal', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Registro_Materias', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (3, 'Registro_Periodos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Alumnos_Descuentos', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Alumnos_Para_Seguro_Escolar', 'Alumno para Seguro Escolar', 'Alumno Para Seguro Escolar', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Alumnos_x_Genero', 'Alumnos por Genero', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Contrasena', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Datos_Familiares', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Listado_Plan_Estudios', 'Listado de Plan de Estudios', 'Listado de Plan de Estudios', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Listas_Asistencia', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Lista_Total', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Reportes_Pago', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (4, 'Salud', '', '', 1);
INSERT INTO `modulo_opcion` VALUES (5, 'Usuarios', 'Control_Usuarios', '', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `movimientos_egresos`
-- 

CREATE TABLE `movimientos_egresos` (
  `id_mov` int(11) NOT NULL auto_increment,
  `tipo_r` varchar(2) NOT NULL,
  `id_conce` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `fecha_baja` date NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `importe` decimal(12,2) NOT NULL,
  `tipo_mov` enum('E','I') NOT NULL COMMENT 'E-Egreso, I-Ingreso',
  `estatus` enum('0','1') NOT NULL COMMENT '0-Activo, 1-Inactivo',
  `edificio` int(11) NOT NULL,
  PRIMARY KEY  (`id_mov`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `movimientos_egresos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `niveles`
-- 

CREATE TABLE `niveles` (
  `id_nivel` int(11) NOT NULL auto_increment,
  `descrip` varchar(50) NOT NULL,
  `semestres` int(11) NOT NULL,
  `ordinario` int(11) NOT NULL,
  `extraordinario` enum('0','1') NOT NULL,
  `estatus` enum('0','1') NOT NULL COMMENT '0-Activo, 1-Eliminado',
  PRIMARY KEY  (`id_nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `niveles`
-- 

INSERT INTO `niveles` VALUES (1, 'Maternal', 0, 0, '0', '0');
INSERT INTO `niveles` VALUES (2, 'Kinder', 0, 0, '0', '0');
INSERT INTO `niveles` VALUES (3, 'Primaria', 0, 0, '0', '0');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `periodos_escolares`
-- 

CREATE TABLE `periodos_escolares` (
  `id_periodo` int(11) NOT NULL auto_increment,
  `nombre_periodo` varchar(20) NOT NULL,
  `periodo` varchar(50) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  PRIMARY KEY  (`id_periodo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `periodos_escolares`
-- 

INSERT INTO `periodos_escolares` VALUES (1, '1', '09-10', 3, 0);
INSERT INTO `periodos_escolares` VALUES (2, '2', '11-12', 3, 0);
INSERT INTO `periodos_escolares` VALUES (3, '3', '01-02', 3, 0);
INSERT INTO `periodos_escolares` VALUES (4, '4', '03-04', 3, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permisos_categoria`
-- 

CREATE TABLE `permisos_categoria` (
  `id_categoria` int(10) unsigned NOT NULL,
  `id_modulo` int(10) unsigned NOT NULL,
  `opcion` varchar(45) NOT NULL,
  `permiso` tinyint(1) unsigned NOT NULL default '0',
  `administra` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id_categoria`,`id_modulo`,`opcion`),
  KEY `FK_permisos_categoria_modulo_opcion` (`id_modulo`,`opcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `permisos_categoria`
-- 

INSERT INTO `permisos_categoria` VALUES (1, 1, 'Alta_Calificaciones', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 1, 'Avisos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 1, 'Expedientes', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 1, 'Registro_Alumno', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 1, 'Reinscripcion_Alumno', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 1, 'Tareas', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 1, 'Trans_Grupos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Alta_Concepto', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Caja', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Caja_Colegiatura', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Costo_Ins_Cole', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Formas_Pago', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Otros_Pagos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 2, 'Recibos_Pagos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Ciclos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Config_Calificaciones', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Config_Reportes', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Datos_Escuela', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Grupos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Niveles', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Personal', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Registro_Materias', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 3, 'Registro_Periodos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Alumnos_Descuentos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Alumnos_Para_Seguro_Escolar', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Alumnos_x_Genero', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Contrasena', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Datos_Familiares', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Listado_Plan_Estudios', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Listas_Asistencia', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Lista_Total', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Reportes_Pago', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 4, 'Salud', 3, 0);
INSERT INTO `permisos_categoria` VALUES (1, 5, 'Usuarios', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 1, 'Expedientes', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 1, 'Registro_Alumno', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 1, 'Reinscripcion_Alumno', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 1, 'Trans_Grupos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 2, 'Caja', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 2, 'Caja_Colegiatura', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 2, 'Recibos_Pagos', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 3, 'Personal', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 3, 'Registro_Materias', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 3, 'Registro_Periodos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Alumnos_Descuentos', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Alumnos_Para_Seguro_Escolar', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Alumnos_x_Genero', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Contrasena', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Datos_Familiares', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Listado_Plan_Estudios', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Listas_Asistencia', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Lista_Total', 1, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Reportes_Pago', 0, 0);
INSERT INTO `permisos_categoria` VALUES (3, 4, 'Salud', 1, 0);
INSERT INTO `permisos_categoria` VALUES (6, 1, 'Alta_Calificaciones', 2, 0);
INSERT INTO `permisos_categoria` VALUES (6, 1, 'Avisos', 3, 0);
INSERT INTO `permisos_categoria` VALUES (6, 1, 'Expedientes', 1, 0);
INSERT INTO `permisos_categoria` VALUES (6, 1, 'Tareas', 3, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `permisos_usuario`
-- 

CREATE TABLE `permisos_usuario` (
  `id_usuario` int(10) unsigned NOT NULL,
  `id_modulo` int(10) unsigned NOT NULL,
  `opcion` varchar(45) NOT NULL,
  `permiso` tinyint(1) unsigned NOT NULL,
  `administra` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id_usuario`,`id_modulo`,`opcion`),
  KEY `FK_permisos_usuario_modulo_opcion` (`id_modulo`,`opcion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `permisos_usuario`
-- 

INSERT INTO `permisos_usuario` VALUES (1, 1, 'Alta_Calificaciones', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 1, 'Avisos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 1, 'Expedientes', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 1, 'Registro_Alumno', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 1, 'Reinscripcion_Alumno', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 1, 'Tareas', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 1, 'Trans_Grupos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Alta_Concepto', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Caja', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Caja_Colegiatura', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Config_Caja', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Costo_Ins_Cole', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Egresos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Formas_Pago', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Otros_Pagos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 2, 'Recibos_Pagos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Ciclos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Config_Calificaciones', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Config_Reportes', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Datos_Escuela', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Grupos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Niveles', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Personal', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Registro_Materias', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 3, 'Registro_Periodos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Alumnos_Descuentos', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Contrasena', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Datos_Familiares', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Listas_Asistencia', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Lista_Total', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Reportes_Pago', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 4, 'Salud', 3, 0);
INSERT INTO `permisos_usuario` VALUES (1, 5, 'Usuarios', 3, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `pers_autorizadas_transp_alumno_yuc`
-- 

CREATE TABLE `pers_autorizadas_transp_alumno_yuc` (
  `id_persona_autorizada` int(11) NOT NULL auto_increment,
  `id_transporte_alumno` int(11) NOT NULL,
  `nombre_completo` varchar(100) character set latin1 collate latin1_spanish_ci default NULL,
  `parentesco` varchar(50) character set latin1 collate latin1_spanish_ci default NULL,
  `telefono_casa` varchar(50) default NULL,
  `telefono_trabajo` varchar(50) default NULL,
  `telefono_celular` varchar(50) default NULL,
  PRIMARY KEY  (`id_persona_autorizada`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- 
-- Volcar la base de datos para la tabla `pers_autorizadas_transp_alumno_yuc`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `profiles`
-- 

CREATE TABLE `profiles` (
  `user_id` int(11) NOT NULL auto_increment,
  `lastname` varchar(50) NOT NULL default '',
  `firstname` varchar(50) NOT NULL default '',
  `id_tipo` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY  (`user_id`),
  KEY `id_alumno` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `profiles`
-- 

INSERT INTO `profiles` VALUES (1, 'Admin', 'Administrator', 3, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `profiles_fields`
-- 

CREATE TABLE `profiles_fields` (
  `id` int(10) NOT NULL auto_increment,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL default '0',
  `field_size_min` varchar(15) NOT NULL default '0',
  `required` int(1) NOT NULL default '0',
  `match` varchar(255) NOT NULL default '',
  `range` varchar(255) NOT NULL default '',
  `error_message` varchar(255) NOT NULL default '',
  `other_validator` varchar(5000) NOT NULL default '',
  `default` varchar(255) NOT NULL default '',
  `widget` varchar(255) NOT NULL default '',
  `widgetparams` varchar(5000) NOT NULL default '',
  `position` int(3) NOT NULL default '0',
  `visible` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `profiles_fields`
-- 

INSERT INTO `profiles_fields` VALUES (1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3);
INSERT INTO `profiles_fields` VALUES (2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `publicidad_ficha`
-- 

CREATE TABLE `publicidad_ficha` (
  `id_publicidad` int(11) NOT NULL auto_increment,
  `texto` text,
  PRIMARY KEY  (`id_publicidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `publicidad_ficha`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `recibos`
-- 

CREATE TABLE `recibos` (
  `id_factura` int(11) NOT NULL auto_increment,
  `id_alumno` int(11) NOT NULL,
  `id_ciclo` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_cobro` date NOT NULL,
  `tipo_r` enum('01','02','03','04') NOT NULL COMMENT '01-Inscrip, 02-Colegiaturas, 03-Derechos',
  `id_tipo` int(11) NOT NULL,
  `referencia` text NOT NULL,
  `fecha_cancela` date NOT NULL,
  `estado` enum('P','C') NOT NULL COMMENT 'P-pagado, C-cancelado',
  `edificio` int(11) NOT NULL,
  `elaboro` varchar(100) NOT NULL,
  `id_banco` int(11) NOT NULL,
  `folio_factura` varchar(30) default NULL,
  `tipo_folio` enum('1','2') NOT NULL COMMENT '1-Fiscal, 2-No fiscal',
  `observaciones` text NOT NULL,
  `id_folio_ref` int(11) NOT NULL,
  `rfc_pago` varchar(30) NOT NULL,
  `UUID` text NOT NULL,
  `pdf` varchar(150) NOT NULL,
  PRIMARY KEY  (`id_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `recibos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `recibos_conceptos`
-- 

CREATE TABLE `recibos_conceptos` (
  `id_conce` int(11) NOT NULL auto_increment,
  `id_factura` int(11) NOT NULL,
  `id_conce_mes` int(11) NOT NULL,
  `descrip` varchar(150) NOT NULL,
  `unidad_medida` varchar(100) NOT NULL,
  `importe` decimal(12,2) NOT NULL,
  `monto` decimal(12,2) NOT NULL COMMENT 'IMPORTE SOLO INFORMATIVO',
  `tipo` varchar(2) NOT NULL,
  `importe_fiscal` decimal(12,2) NOT NULL,
  `facturado` int(1) NOT NULL,
  `iva` decimal(12,2) NOT NULL,
  PRIMARY KEY  (`id_conce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `recibos_conceptos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `recibos_detalles`
-- 

CREATE TABLE `recibos_detalles` (
  `id_mov` int(11) NOT NULL auto_increment,
  `id_factura` int(11) NOT NULL,
  `descrip` text NOT NULL,
  `importe` float(12,2) NOT NULL,
  PRIMARY KEY  (`id_mov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `recibos_detalles`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `recibos_formas_pago`
-- 

CREATE TABLE `recibos_formas_pago` (
  `id_rec_fp` int(11) NOT NULL auto_increment,
  `id_factura` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL COMMENT 'FORMA PAGO',
  `importe` decimal(12,2) NOT NULL,
  `cargo` decimal(12,2) NOT NULL,
  `referencia` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_rec_fp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `recibos_formas_pago`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `recibos_mes`
-- 

CREATE TABLE `recibos_mes` (
  `id_factura` int(11) NOT NULL,
  `mes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `recibos_mes`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `reportes`
-- 

CREATE TABLE `reportes` (
  `id_reporte` int(11) NOT NULL auto_increment,
  `tipo` varchar(100) NOT NULL,
  `txt_tipo` varchar(155) NOT NULL,
  `descripcion` text NOT NULL,
  `activo` int(1) NOT NULL,
  PRIMARY KEY  (`id_reporte`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- 
-- Volcar la base de datos para la tabla `reportes`
-- 

INSERT INTO `reportes` VALUES (1, 'asistencia', 'Lista de Asistencia', 'Lista de las asistencias de los alumnos.', 1);
INSERT INTO `reportes` VALUES (2, 'salud', 'Salud', 'Datos de Salud de los Alumnos', 1);
INSERT INTO `reportes` VALUES (3, 'contrasena', 'Contraseñas', 'Lista de los Datos de Seguridad del Alumno', 1);
INSERT INTO `reportes` VALUES (4, 'lista_total', 'Lista Total', 'Reporte de la lista total de alumnos', 1);
INSERT INTO `reportes` VALUES (5, 'familia', 'Datos de la Familia', 'Reporte de los Datos de la Familia', 1);
INSERT INTO `reportes` VALUES (6, 'finanzas', 'Reportes de Pagos', 'Reportes de Pagos realizados', 1);
INSERT INTO `reportes` VALUES (7, 'alumnos_x_descuentos', 'Alumnos por Conceptos', 'Reporte de Alumnos por Conceptos', 1);
INSERT INTO `reportes` VALUES (8, 'alumnos_x_genero', 'Alumnos por Genero', 'Alumnos por Genero', 1);
INSERT INTO `reportes` VALUES (9, 'alumnos_seguro_escolar', 'Alumnos para Seguro Escolar', 'Alumnos para Seguro Escolar', 1);
INSERT INTO `reportes` VALUES (10, 'listado_plan_estudios', 'Listado de Plan de Estudios', 'Listado de Plan de Estudios', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `reportes_edificio`
-- 

CREATE TABLE `reportes_edificio` (
  `id_rep_ed` int(11) NOT NULL auto_increment,
  `id_reporte` int(11) NOT NULL,
  `edificio` int(11) NOT NULL,
  PRIMARY KEY  (`id_rep_ed`),
  UNIQUE KEY `id_reporte` (`id_reporte`,`edificio`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

-- 
-- Volcar la base de datos para la tabla `reportes_edificio`
-- 

INSERT INTO `reportes_edificio` VALUES (72, 1, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `reportes_pie_cabecera`
-- 

CREATE TABLE `reportes_pie_cabecera` (
  `id` int(11) NOT NULL auto_increment,
  `edificio` int(11) NOT NULL,
  `logo_reporte` varchar(255) NOT NULL,
  `logo_zona` varchar(1) NOT NULL COMMENT 'C - Cabecera, P - Pie, A - Ambos',
  `logo_alineacion` varchar(5) NOT NULL COMMENT 'I - Izq, D - Derecha, C - Centro',
  `cabecera` text NOT NULL,
  `cabecera_alineacion` varchar(1) NOT NULL COMMENT 'I - Izq, D - Derecha, C - Centro',
  `pie` text NOT NULL,
  `pie_alineacion` varchar(1) NOT NULL COMMENT 'I - Izq, D - Derecha, C - Centro',
  `pag_zona` varchar(1) NOT NULL COMMENT 'C-Cabecera, P-Pie',
  `pag_alineacion` varchar(1) NOT NULL COMMENT 'I-Izq, D-Derecha, C-Centro',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `reportes_pie_cabecera`
-- 

INSERT INTO `reportes_pie_cabecera` VALUES (1, 1, 'logo_reporte.jpg', 'C', 'I', 'COMPROMETIDOS CON LA CALIDAD EN LA EDUCACIÓN', 'C', 'C. 5-C No. 320 x 20-B y 20-C Diag. Col. Xcumpich. Mérida, Yucatán.\r\nTels: (999) 981-6111', 'C', 'P', 'I');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tareas_archivos`
-- 

CREATE TABLE `tareas_archivos` (
  `id` int(11) NOT NULL auto_increment,
  `id_tarea` int(11) NOT NULL,
  `archivo` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_tarea` (`id_tarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `tareas_archivos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo`
-- 

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(200) NOT NULL,
  `fecha` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `tipo`
-- 

INSERT INTO `tipo` VALUES (1, 'Maestro', '2016-01-29 19:22:22');
INSERT INTO `tipo` VALUES (2, 'Alumno', '2016-01-29 19:22:22');
INSERT INTO `tipo` VALUES (3, 'Administrador', '2016-01-29 19:23:06');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipos_recibos`
-- 

CREATE TABLE `tipos_recibos` (
  `id_tipo_recibo` int(11) NOT NULL auto_increment,
  `nombre` varchar(100) NOT NULL,
  `folio` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_tipo_recibo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `tipos_recibos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_banco`
-- 

CREATE TABLE `tipo_banco` (
  `id_banco` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_banco`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `tipo_banco`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_listas`
-- 

CREATE TABLE `tipo_listas` (
  `id_tipo` int(11) NOT NULL auto_increment,
  `descrip` varchar(30) NOT NULL,
  PRIMARY KEY  (`id_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `tipo_listas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `tipo_pago`
-- 

CREATE TABLE `tipo_pago` (
  `id_tipo` int(11) NOT NULL auto_increment,
  `descripcion` text NOT NULL,
  `comision` decimal(12,2) NOT NULL,
  `tipo_monto` enum('pesos','porcentaje') NOT NULL,
  PRIMARY KEY  (`id_tipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- 
-- Volcar la base de datos para la tabla `tipo_pago`
-- 

INSERT INTO `tipo_pago` VALUES (17, 'EFECTIVO', 0.00, 'pesos');
INSERT INTO `tipo_pago` VALUES (18, 'CHEQUE', 0.00, 'pesos');
INSERT INTO `tipo_pago` VALUES (20, 'TARJETA DE CRÉDITO', 4.00, 'porcentaje');
INSERT INTO `tipo_pago` VALUES (21, 'TARJETA DE DÉBITO', 3.00, 'porcentaje');
INSERT INTO `tipo_pago` VALUES (19, 'TRANSFERENCIA BANCARIA', 0.00, 'pesos');
INSERT INTO `tipo_pago` VALUES (22, 'NO IDENTIFICADO', 0.00, 'pesos');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL default '',
  `create_at` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL default '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL default '0',
  `status` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `users`
-- 

INSERT INTO `users` VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'jorge.vadillo@solucionesid.com', '21232f297a57a5a743894a0e4a801fc3', '2016-04-01 17:40:52', '2016-04-07 22:42:20', 1, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id_usuario` int(10) unsigned NOT NULL auto_increment,
  `usuario` varchar(20) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `max_sesiones` tinyint(1) unsigned default '3',
  `sesiones` tinyint(1) unsigned default '0',
  `acceso` tinyint(1) default '1',
  `contrasena` varchar(32) default NULL,
  `idOrganigrama` int(10) unsigned default '0',
  `acceso_panel` tinyint(1) default '0',
  `crea_requisicion` tinyint(1) default '0',
  `nivel_requisicion` int(10) unsigned default '1',
  `edificio` int(11) NOT NULL,
  `id_maestro` int(11) NOT NULL,
  PRIMARY KEY  (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (1, 'cema', '', 3, 0, 1, 'cema2015', 0, 1, 0, 1, 1, 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario_categoria`
-- 

CREATE TABLE `usuario_categoria` (
  `id_usuario` int(10) unsigned NOT NULL,
  `id_categoria` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id_usuario`,`id_categoria`),
  KEY `FK_usuario_categoria_categorias` (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `usuario_categoria`
-- 

INSERT INTO `usuario_categoria` VALUES (2, 0);
INSERT INTO `usuario_categoria` VALUES (3, 0);
INSERT INTO `usuario_categoria` VALUES (4, 0);
INSERT INTO `usuario_categoria` VALUES (1, 1);

-- --------------------------------------------------------

-- 
-- Estructura para la vista `alumno_grupo_ciclo`
-- 
DROP TABLE IF EXISTS `alumno_grupo_ciclo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`cemaedu`@`localhost` SQL SECURITY DEFINER VIEW `sanpatricio_avisosytareas`.`alumno_grupo_ciclo` AS select `ag`.`id_relacion` AS `id_alumno_grupo`,`ag`.`id_alumno` AS `id_alumno`,`ag`.`id_grupo` AS `id_grupo`,`g`.`grado` AS `grado`,`g`.`letra` AS `letra`,`g`.`id_ciclo` AS `id_ciclo`,`g`.`id_nivel` AS `id_nivel`,concat(`g`.`grado`,_utf8'-',`g`.`letra`) AS `grupo`,`n`.`descrip` AS `nivel`,`ag`.`ingreso` AS `ingreso`,`ag`.`repetidor` AS `repetidor`,`ag`.`estado` AS `estado`,`ag`.`fecha_inscribe` AS `fecha_inscribe` from ((`sanpatricio_avisosytareas`.`alumno_grupo` `ag` left join `sanpatricio_avisosytareas`.`grupos` `g` on(((`g`.`id_grupo` = `ag`.`id_grupo`) and (`ag`.`estado` = _utf8'0')))) left join `sanpatricio_avisosytareas`.`niveles` `n` on((`n`.`id_nivel` = `g`.`id_nivel`)));

-- 
-- Filtros para las tablas descargadas (dump)
-- 

-- 
-- Filtros para la tabla `avisos`
-- 
ALTER TABLE `avisos`
  ADD CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`),
  ADD CONSTRAINT `avisos_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`),
  ADD CONSTRAINT `avisos_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `avisos_ibfk_4` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `avisos_ibfk_5` FOREIGN KEY (`id_maestro`) REFERENCES `maestros` (`id_maestro`);

-- 
-- Filtros para la tabla `calificaciones`
-- 
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_5` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclo_niveles` (`id_ciclo`),
  ADD CONSTRAINT `calificaciones_ibfk_6` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`),
  ADD CONSTRAINT `calificaciones_ibfk_7` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`);

-- 
-- Filtros para la tabla `ciclo_niveles`
-- 
ALTER TABLE `ciclo_niveles`
  ADD CONSTRAINT `ciclo_niveles_ibfk_1` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ciclo_niveles_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `conceptos_nivel`
-- 
ALTER TABLE `conceptos_nivel`
  ADD CONSTRAINT `conceptos_nivel_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON UPDATE CASCADE;

-- 
-- Filtros para la tabla `grupos`
-- 
ALTER TABLE `grupos`
  ADD CONSTRAINT `grupos_ibfk_1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON UPDATE CASCADE;
