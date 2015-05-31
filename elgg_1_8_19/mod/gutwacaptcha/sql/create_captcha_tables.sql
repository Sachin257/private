--CREATE TABLE IF NOT EXISTS `elgg_captcha_codes` (

--) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `elgg_captcha_codes`
--

CREATE TABLE IF NOT EXISTS `elgg_captcha_codes` (
  `id` varchar(40) NOT NULL,
  `namespace` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `code_display` varchar(32) NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`,`namespace`),
  KEY `created` (`created`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;