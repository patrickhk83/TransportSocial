-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 68.178.216.119
-- Generation Time: Oct 07, 2013 at 05:57 PM
-- Server version: 5.0.96
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `transportsocial`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL auto_increment,
  `country_code` varchar(45) default NULL,
  `country_name` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=230 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` VALUES(1, 'US', 'United States');
INSERT INTO `countries` VALUES(2, 'AF', 'Afghanistan');
INSERT INTO `countries` VALUES(3, 'AL', 'Albania');
INSERT INTO `countries` VALUES(4, 'DZ', 'Algeria');
INSERT INTO `countries` VALUES(5, 'AS', 'American Samoa Samoa');
INSERT INTO `countries` VALUES(6, 'AD', 'Andorra');
INSERT INTO `countries` VALUES(7, 'AO', 'Angola');
INSERT INTO `countries` VALUES(8, 'AI', 'Anguilla');
INSERT INTO `countries` VALUES(9, 'AQ', 'Antarctica');
INSERT INTO `countries` VALUES(10, 'AG', 'Antigua And Barbuda And Barbuda');
INSERT INTO `countries` VALUES(11, 'AR', 'Argentina');
INSERT INTO `countries` VALUES(12, 'AM', 'Armenia');
INSERT INTO `countries` VALUES(13, 'AW', 'Aruba');
INSERT INTO `countries` VALUES(14, 'AU', 'Australia');
INSERT INTO `countries` VALUES(15, 'AT', 'Austria');
INSERT INTO `countries` VALUES(16, 'AZ', 'Azerbaijan');
INSERT INTO `countries` VALUES(17, 'BS', 'Bahamas');
INSERT INTO `countries` VALUES(18, 'BH', 'Bahrain');
INSERT INTO `countries` VALUES(19, 'BD', 'Bangladesh');
INSERT INTO `countries` VALUES(20, 'BB', 'Barbados');
INSERT INTO `countries` VALUES(21, 'BE', 'Belgium');
INSERT INTO `countries` VALUES(22, 'BZ', 'Belize');
INSERT INTO `countries` VALUES(23, 'BJ', 'Benin');
INSERT INTO `countries` VALUES(24, 'BM', 'Bermuda');
INSERT INTO `countries` VALUES(25, 'BT', 'Bhutan');
INSERT INTO `countries` VALUES(26, 'BO', 'Bolivia');
INSERT INTO `countries` VALUES(27, 'BA', 'Bosnia and Herzegovina and Herzegovina');
INSERT INTO `countries` VALUES(28, 'BW', 'Botswana');
INSERT INTO `countries` VALUES(29, 'BV', 'Bouvet Island Island');
INSERT INTO `countries` VALUES(30, 'BR', 'Brazil');
INSERT INTO `countries` VALUES(31, 'IO', 'British Indian Ocean Territory Indian Ocean Territory');
INSERT INTO `countries` VALUES(32, 'BN', 'Brunei Darussalam Darussalam');
INSERT INTO `countries` VALUES(33, 'BG', 'Bulgaria');
INSERT INTO `countries` VALUES(34, 'BF', 'Burkina Faso Faso');
INSERT INTO `countries` VALUES(35, 'BI', 'Burundi');
INSERT INTO `countries` VALUES(36, 'KH', 'Cambodia');
INSERT INTO `countries` VALUES(37, 'CM', 'Cameroon');
INSERT INTO `countries` VALUES(38, 'CA', 'Canada');
INSERT INTO `countries` VALUES(39, 'CV', 'Cape Verde Verde');
INSERT INTO `countries` VALUES(40, 'KY', 'Cayman Islands Islands');
INSERT INTO `countries` VALUES(41, 'CF', 'Central African Republic African Republic');
INSERT INTO `countries` VALUES(42, 'TD', 'Chad');
INSERT INTO `countries` VALUES(43, 'CL', 'Chile');
INSERT INTO `countries` VALUES(44, 'CN', 'China');
INSERT INTO `countries` VALUES(45, 'CX', 'Christmas Island Island');
INSERT INTO `countries` VALUES(46, 'CC', 'Cocos (Keeling) Islands (Keeling) Islands');
INSERT INTO `countries` VALUES(47, 'CO', 'Colombia');
INSERT INTO `countries` VALUES(48, 'KM', 'Comoros');
INSERT INTO `countries` VALUES(49, 'CK', 'Cook Islands Islands');
INSERT INTO `countries` VALUES(50, 'CR', 'Costa Rica Rica');
INSERT INTO `countries` VALUES(51, 'HR', 'Croatia (Hrvatska) (Hrvatska)');
INSERT INTO `countries` VALUES(52, 'CY', 'Cyprus');
INSERT INTO `countries` VALUES(53, 'CZ', 'Czech Republic Republic');
INSERT INTO `countries` VALUES(54, 'DK', 'Denmark');
INSERT INTO `countries` VALUES(55, 'DJ', 'Djibouti');
INSERT INTO `countries` VALUES(56, 'DM', 'Dominica');
INSERT INTO `countries` VALUES(57, 'DO', 'Dominican Republic Republic');
INSERT INTO `countries` VALUES(58, 'TP', 'East Timor Timor');
INSERT INTO `countries` VALUES(59, 'EC', 'Ecuador');
INSERT INTO `countries` VALUES(60, 'EG', 'Egypt');
INSERT INTO `countries` VALUES(61, 'SV', 'El Salvador Salvador');
INSERT INTO `countries` VALUES(62, 'GQ', 'Equatorial Guinea Guinea');
INSERT INTO `countries` VALUES(63, 'ER', 'Eritrea');
INSERT INTO `countries` VALUES(64, 'EE', 'Estonia');
INSERT INTO `countries` VALUES(65, 'ET', 'Ethiopia');
INSERT INTO `countries` VALUES(66, 'FK', 'Falkland Islands (Malvinas) Islands (Malvinas)');
INSERT INTO `countries` VALUES(67, 'FO', 'Faroe Islands Islands');
INSERT INTO `countries` VALUES(68, 'FJ', 'Fiji');
INSERT INTO `countries` VALUES(69, 'FI', 'Finland');
INSERT INTO `countries` VALUES(70, 'FR', 'France');
INSERT INTO `countries` VALUES(71, 'FX', 'France, Metropolitan');
INSERT INTO `countries` VALUES(72, 'GF', 'French Guiana Guiana');
INSERT INTO `countries` VALUES(73, 'PF', 'French Polynesia Polynesia');
INSERT INTO `countries` VALUES(74, 'TF', 'French Southern Territories Southern Territories');
INSERT INTO `countries` VALUES(75, 'GA', 'Gabon');
INSERT INTO `countries` VALUES(76, 'GM', 'Gambia');
INSERT INTO `countries` VALUES(77, 'GE', 'Georgia');
INSERT INTO `countries` VALUES(78, 'DE', 'Germany');
INSERT INTO `countries` VALUES(79, 'GH', 'Ghana');
INSERT INTO `countries` VALUES(80, 'GI', 'Gibraltar');
INSERT INTO `countries` VALUES(81, 'GR', 'Greece');
INSERT INTO `countries` VALUES(82, 'GL', 'Greenland');
INSERT INTO `countries` VALUES(83, 'GD', 'Grenada');
INSERT INTO `countries` VALUES(84, 'GP', 'Guadeloupe');
INSERT INTO `countries` VALUES(85, 'GU', 'Guam');
INSERT INTO `countries` VALUES(86, 'GT', 'Guatemala');
INSERT INTO `countries` VALUES(87, 'GN', 'Guinea');
INSERT INTO `countries` VALUES(88, 'GW', 'Guinea-Bissau-Bissau');
INSERT INTO `countries` VALUES(89, 'GY', 'Guyana');
INSERT INTO `countries` VALUES(90, 'HT', 'Haiti');
INSERT INTO `countries` VALUES(91, 'HM', 'Heard And Mc Donald Islands And Mc Donald Islands');
INSERT INTO `countries` VALUES(92, 'VA', 'Holy See (Vatican City State)');
INSERT INTO `countries` VALUES(93, 'HN', 'Honduras');
INSERT INTO `countries` VALUES(94, 'HK', 'Hong Kong SAR, PRC');
INSERT INTO `countries` VALUES(95, 'HU', 'Hungary');
INSERT INTO `countries` VALUES(96, 'IS', 'Iceland');
INSERT INTO `countries` VALUES(97, 'IN', 'India');
INSERT INTO `countries` VALUES(98, 'ID', 'Indonesia');
INSERT INTO `countries` VALUES(99, 'IE', 'Ireland');
INSERT INTO `countries` VALUES(100, 'IL', 'Israel');
INSERT INTO `countries` VALUES(101, 'IT', 'Italy');
INSERT INTO `countries` VALUES(102, 'JM', 'Jamaica');
INSERT INTO `countries` VALUES(103, 'JP', 'Japan');
INSERT INTO `countries` VALUES(104, 'JO', 'Jordan');
INSERT INTO `countries` VALUES(105, 'KZ', 'Kazakhstan');
INSERT INTO `countries` VALUES(106, 'KE', 'Kenya');
INSERT INTO `countries` VALUES(107, 'KI', 'Kiribati');
INSERT INTO `countries` VALUES(108, 'KR', 'Korea, Republic of');
INSERT INTO `countries` VALUES(109, 'KW', 'Kuwait');
INSERT INTO `countries` VALUES(110, 'KG', 'Kyrgyzstan');
INSERT INTO `countries` VALUES(111, 'LA', 'Lao, People''s Dem, Rep,');
INSERT INTO `countries` VALUES(112, 'LV', 'Latvia');
INSERT INTO `countries` VALUES(113, 'LB', 'Lebanon');
INSERT INTO `countries` VALUES(114, 'LS', 'Lesotho');
INSERT INTO `countries` VALUES(115, 'LY', 'Libya');
INSERT INTO `countries` VALUES(116, 'LI', 'Liechtenstein');
INSERT INTO `countries` VALUES(117, 'LT', 'Lithuania');
INSERT INTO `countries` VALUES(118, 'LU', 'Luxembourg');
INSERT INTO `countries` VALUES(119, 'MO', 'Macau');
INSERT INTO `countries` VALUES(120, 'MK', 'Macedonia');
INSERT INTO `countries` VALUES(121, 'MG', 'Madagascar');
INSERT INTO `countries` VALUES(122, 'MW', 'Malawi');
INSERT INTO `countries` VALUES(123, 'MY', 'Malaysia');
INSERT INTO `countries` VALUES(124, 'MV', 'Maldives');
INSERT INTO `countries` VALUES(125, 'ML', 'Mali');
INSERT INTO `countries` VALUES(126, 'MT', 'Malta');
INSERT INTO `countries` VALUES(127, 'MH', 'Marshall Islands Islands');
INSERT INTO `countries` VALUES(128, 'MQ', 'Martinique');
INSERT INTO `countries` VALUES(129, 'MR', 'Mauritania');
INSERT INTO `countries` VALUES(130, 'MU', 'Mauritius');
INSERT INTO `countries` VALUES(131, 'YT', 'Mayotte');
INSERT INTO `countries` VALUES(132, 'MX', 'Mexico');
INSERT INTO `countries` VALUES(133, 'FM', 'Micronesia, Federated States Of');
INSERT INTO `countries` VALUES(134, 'MD', 'Moldova, Republic Of');
INSERT INTO `countries` VALUES(135, 'MC', 'Monaco');
INSERT INTO `countries` VALUES(136, 'MN', 'Mongolia');
INSERT INTO `countries` VALUES(137, 'ME', 'Montenegro');
INSERT INTO `countries` VALUES(138, 'MS', 'Montserrat');
INSERT INTO `countries` VALUES(139, 'MA', 'Morocco');
INSERT INTO `countries` VALUES(140, 'MZ', 'Mozambique');
INSERT INTO `countries` VALUES(141, 'NA', 'Namibia');
INSERT INTO `countries` VALUES(142, 'NR', 'Nauru');
INSERT INTO `countries` VALUES(143, 'NP', 'Nepal');
INSERT INTO `countries` VALUES(144, 'NL', 'Netherlands');
INSERT INTO `countries` VALUES(145, 'AN', 'Netherlands Antilles Antilles');
INSERT INTO `countries` VALUES(146, 'NC', 'New Caledonia Caledonia');
INSERT INTO `countries` VALUES(147, 'NZ', 'New Zealand Zealand');
INSERT INTO `countries` VALUES(148, 'NI', 'Nicaragua');
INSERT INTO `countries` VALUES(149, 'NE', 'Niger');
INSERT INTO `countries` VALUES(150, 'NG', 'Nigeria');
INSERT INTO `countries` VALUES(151, 'NU', 'Niue');
INSERT INTO `countries` VALUES(152, 'NF', 'Norfolk Island Island');
INSERT INTO `countries` VALUES(153, 'MP', 'Northern Mariana Islands Mariana Islands');
INSERT INTO `countries` VALUES(154, 'NO', 'Norway');
INSERT INTO `countries` VALUES(155, 'OM', 'Oman');
INSERT INTO `countries` VALUES(156, 'OT', 'Others');
INSERT INTO `countries` VALUES(157, 'PK', 'Pakistan');
INSERT INTO `countries` VALUES(158, 'PW', 'Palau');
INSERT INTO `countries` VALUES(159, 'PS', 'Palestine');
INSERT INTO `countries` VALUES(160, 'PA', 'Panama');
INSERT INTO `countries` VALUES(161, 'PG', 'Papua New Guinea New Guinea');
INSERT INTO `countries` VALUES(162, 'PY', 'Paraguay');
INSERT INTO `countries` VALUES(163, 'PE', 'Peru');
INSERT INTO `countries` VALUES(164, 'PH', 'Philippines');
INSERT INTO `countries` VALUES(165, 'PN', 'Pitcairn');
INSERT INTO `countries` VALUES(166, 'PL', 'Poland');
INSERT INTO `countries` VALUES(167, 'PT', 'Portugal');
INSERT INTO `countries` VALUES(168, 'PR', 'Puerto Rico Rico');
INSERT INTO `countries` VALUES(169, 'QA', 'Qatar');
INSERT INTO `countries` VALUES(170, 'RE', 'Reunion');
INSERT INTO `countries` VALUES(171, 'RO', 'Romania');
INSERT INTO `countries` VALUES(172, 'RU', 'Russia');
INSERT INTO `countries` VALUES(173, 'RW', 'Rwanda');
INSERT INTO `countries` VALUES(174, 'GS', 'S, Georgia &amp; S, Sandwich Isls,');
INSERT INTO `countries` VALUES(175, 'KN', 'Saint Kitts And Nevis Kitts And Nevis');
INSERT INTO `countries` VALUES(176, 'LC', 'Saint Lucia Lucia');
INSERT INTO `countries` VALUES(177, 'VC', 'Saint Vincent And the Grenadines Vincent And the Grenadines');
INSERT INTO `countries` VALUES(178, 'WS', 'Samoa');
INSERT INTO `countries` VALUES(179, 'SM', 'San Marino Marino');
INSERT INTO `countries` VALUES(180, 'ST', 'Sao Tome And Principe Tome And Principe');
INSERT INTO `countries` VALUES(181, 'SA', 'Saudi Arabia Arabia');
INSERT INTO `countries` VALUES(182, 'SN', 'Senegal');
INSERT INTO `countries` VALUES(183, 'RS', 'Serbia');
INSERT INTO `countries` VALUES(184, 'SC', 'Seychelles');
INSERT INTO `countries` VALUES(185, 'SL', 'Sierra Leone Leone');
INSERT INTO `countries` VALUES(186, 'SG', 'Singapore');
INSERT INTO `countries` VALUES(187, 'SK', 'Slovak Republic Republic');
INSERT INTO `countries` VALUES(188, 'SI', 'Slovenia');
INSERT INTO `countries` VALUES(189, 'SB', 'Solomon Islands Islands');
INSERT INTO `countries` VALUES(190, 'SO', 'Somalia');
INSERT INTO `countries` VALUES(191, 'ZA', 'South Africa Africa');
INSERT INTO `countries` VALUES(192, 'ES', 'Spain');
INSERT INTO `countries` VALUES(193, 'LK', 'Sri Lanka Lanka');
INSERT INTO `countries` VALUES(194, 'SH', 'St, Helena, Helena');
INSERT INTO `countries` VALUES(195, 'PM', 'St, Pierre And Miquelon, Pierre And Miquelon');
INSERT INTO `countries` VALUES(196, 'SR', 'Suriname');
INSERT INTO `countries` VALUES(197, 'SJ', 'Svalbard And Jan Mayen Islands And Jan Mayen Islands');
INSERT INTO `countries` VALUES(198, 'SZ', 'Swaziland');
INSERT INTO `countries` VALUES(199, 'SE', 'Sweden');
INSERT INTO `countries` VALUES(200, 'CH', 'Switzerland');
INSERT INTO `countries` VALUES(201, 'TW', 'Taiwan');
INSERT INTO `countries` VALUES(202, 'TJ', 'Tajikistan');
INSERT INTO `countries` VALUES(203, 'TZ', 'Tanzania, United Republic Of');
INSERT INTO `countries` VALUES(204, 'TH', 'Thailand');
INSERT INTO `countries` VALUES(205, 'TG', 'Togo');
INSERT INTO `countries` VALUES(206, 'TK', 'Tokelau');
INSERT INTO `countries` VALUES(207, 'TO', 'Tonga');
INSERT INTO `countries` VALUES(208, 'TT', 'Trinidad And Tobago And Tobago');
INSERT INTO `countries` VALUES(209, 'TN', 'Tunisia');
INSERT INTO `countries` VALUES(210, 'TR', 'Turkey');
INSERT INTO `countries` VALUES(211, 'TM', 'Turkmenistan');
INSERT INTO `countries` VALUES(212, 'TC', 'Turks And Caicos Islands And Caicos Islands');
INSERT INTO `countries` VALUES(213, 'TV', 'Tuvalu');
INSERT INTO `countries` VALUES(214, 'UG', 'Uganda');
INSERT INTO `countries` VALUES(215, 'UA', 'Ukraine');
INSERT INTO `countries` VALUES(216, 'AE', 'United Arab Emirates Arab Emirates');
INSERT INTO `countries` VALUES(217, 'GB', 'United Kingdom Kingdom');
INSERT INTO `countries` VALUES(218, 'UM', 'United States Minor Outlying Island,');
INSERT INTO `countries` VALUES(219, 'UY', 'Uruguay');
INSERT INTO `countries` VALUES(220, 'UZ', 'Uzbekistan');
INSERT INTO `countries` VALUES(221, 'VU', 'Vanuatu');
INSERT INTO `countries` VALUES(222, 'VE', 'Venezuela');
INSERT INTO `countries` VALUES(223, 'VN', 'Vietnam');
INSERT INTO `countries` VALUES(224, 'VG', 'Virgin Islands (British)');
INSERT INTO `countries` VALUES(225, 'VI', 'Virgin Islands (US)');
INSERT INTO `countries` VALUES(226, 'WF', 'Wallis And Futuna Islands And Futuna Islands');
INSERT INTO `countries` VALUES(227, 'EH', 'Western Sahara Sahara');
INSERT INTO `countries` VALUES(228, 'YE', 'Yemen');
INSERT INTO `countries` VALUES(229, 'ZM', 'Zambia');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) default NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) default NULL,
  `forgotten_password_code` varchar(40) default NULL,
  `forgotten_password_time` int(11) unsigned default NULL,
  `remember_code` varchar(40) default NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned default NULL,
  `active` tinyint(1) unsigned default NULL,
  `first_name` varchar(50) default NULL,
  `last_name` varchar(50) default NULL,
  `company` varchar(100) default NULL,
  `phone` varchar(20) default NULL,
  `country` varchar(255) NOT NULL,
  `birthday` varchar(45) default NULL,
  `about_me` text,
  `hobbies` varchar(255) default NULL,
  `musics` varchar(255) default NULL,
  `movies` varchar(255) default NULL,
  `books` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, '9d029802e28cd9c768e8e62277c0df49ec65c48c', 1268889823, 1381046281, 1, 'Admin', 'istrator', 'ADMIN', '0', '', NULL, NULL, NULL, NULL, NULL, NULL);

