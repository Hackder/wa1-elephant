-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `sportcar_auta`
--

CREATE TABLE IF NOT EXISTS `sportcar_auta` (
  `idc` smallint(6) NOT NULL AUTO_INCREMENT,
  `nazov` varchar(50) COLLATE utf8_slovak_ci NOT NULL,
  `vykon` smallint(6) NOT NULL,
  `rychlost` smallint(6) NOT NULL,
  PRIMARY KEY (`idc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=7 ;

--
-- Sťahujem dáta pre tabuľku `sportcar_cars`
--

INSERT INTO `sportcar_auta` (`idc`, `nazov`, `vykon`, `rychlost`) VALUES
(1, 'Aston Martin DBS Coupe', 380, 350),
(2, 'Bugatti Veyron 16.4', 736, 407),
(3, 'Ferrari 599 GTB Fiorano', 456, 331),
(4, 'Lamborghini Aventador LP 700-4', 515, 350),
(5, 'Maserati GranTurismo MC Stradale', 331, 301),
(6, 'Porsche 911 Carrera S', 283, 302);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `sportcar_hodnotenie`
--

CREATE TABLE IF NOT EXISTS `sportcar_hodnotenie` (
  `idc` smallint(6) NOT NULL,
  `uid` smallint(6) NOT NULL,
  `body` tinyint(4) NOT NULL,
  PRIMARY KEY (`idc`,`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci;

--
-- Sťahujem dáta pre tabuľku `sportcar_hodnotenie`
--

INSERT INTO `sportcar_hodnotenie` (`idc`, `uid`, `body`) VALUES
(1, 2, 5),
(1, 4, 4),
(3, 4, 5);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `sportcar_terminy`
--

CREATE TABLE IF NOT EXISTS `sportcar_terminy` (
  `idt` smallint(6) NOT NULL AUTO_INCREMENT,
  `idc` smallint(6) NOT NULL,
  `datum` date NOT NULL,
  `uid` smallint(6) NOT NULL,
  PRIMARY KEY (`idt`),
  UNIQUE KEY `car_terms` (`idc`,`datum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=46 ;

--
-- Sťahujem dáta pre tabuľku `sportcar_terminy`
--

INSERT INTO `sportcar_terminy` (`idt`, `idc`, `datum`, `uid`) VALUES
(2, 1, '2021-06-17', 0),
(4, 1, '2021-06-28', 0),
(6, 2, '2021-06-23', 0),
(7, 2, '2021-06-22', 0),
(12, 1, '2021-06-21', 0),
(13, 1, '2021-06-23', 0),
(16, 1, '2021-06-26', 0),
(17, 3, '2021-06-25', 0),
(18, 4, '2021-06-26', 0),
(20, 4, '2021-07-01', 0),
(21, 6, '2021-06-25', 0),
(22, 6, '2021-06-26', 0),
(23, 6, '2021-07-02', 0),
(24, 1, '2021-06-20', 0),
(25, 1, '2021-06-07', 0),
(28, 1, '2021-06-08', 0),
(29, 1, '2021-06-09', 0),
(30, 1, '2021-06-10', 0),
(37, 1, '2021-07-11', 0),
(38, 1, '2021-07-12', 2),
(39, 1, '2021-07-18', 0),
(40, 1, '2021-07-19', 0),
(41, 3, '2021-05-02', 0),
(42, 3, '2021-07-12', 0),
(45, 3, '2021-07-11', 4);

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `sportcar_pouzivatelia`
--

CREATE TABLE IF NOT EXISTS `sportcar_pouzivatelia` (
  `uid` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `heslo` varchar(50) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `meno` varchar(20) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `priezvisko` varchar(30) COLLATE utf8_slovak_ci NOT NULL DEFAULT '',
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_slovak_ci AUTO_INCREMENT=7 ;

--
-- Sťahujem dáta pre tabuľku `sportcar_pouzivatelia`
--

INSERT INTO `sportcar_pouzivatelia` (`uid`, `username`, `heslo`, `meno`, `priezvisko`, `admin`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrátor', 'systému', 1),
(2, 'uwa', '78f0f32c08873cfdba57f17c855943c0', 'predmet', 'UWA', 0),
(3, 'ferrari', '0911054d8ad47cc256400031197f3e97', 'Enzo', 'Ferrari', 1),
(4, 'roman', 'b179a9ec0777eae19382c14319872e1b', 'Roman', 'Hrušecký', 0),
(5, 'jozko', '256f035bd7cf72238fad007fb9199c66', 'Jožko', 'Púčik', 0),
(6, 'mrkva', 'bfd7d9c62540ed72de0f32932077bef7', 'Janko', 'Mrkvička', 0);

