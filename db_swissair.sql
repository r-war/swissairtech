-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_swissair
CREATE DATABASE IF NOT EXISTS `db_swissair` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `db_swissair`;

-- Dumping structure for table db_swissair.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type_id` int(10) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text,
  `extra` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`),
  KEY `admin_FI_1` (`type_id`),
  CONSTRAINT `admin_FK_1` FOREIGN KEY (`type_id`) REFERENCES `admin_type` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.admin: ~0 rows (approximately)
DELETE FROM `admin`;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`id`, `type_id`, `date`, `username`, `password`, `name`, `email`, `phone`, `address`, `extra`) VALUES
	(1, 1, '2018-05-14 00:00:00', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table db_swissair.admin_type
CREATE TABLE IF NOT EXISTS `admin_type` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `privileges` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.admin_type: ~0 rows (approximately)
DELETE FROM `admin_type`;
/*!40000 ALTER TABLE `admin_type` DISABLE KEYS */;
INSERT INTO `admin_type` (`id`, `name`, `privileges`) VALUES
	(1, 'Super Admin', '["AdminType","Admin","Testimonial","Menu","Page","Content","News","Seo","Banner","Gallery","Configuration"]');
/*!40000 ALTER TABLE `admin_type` ENABLE KEYS */;

-- Dumping structure for table db_swissair.banner
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `group` varchar(255) DEFAULT NULL,
  `index` int(10) DEFAULT NULL,
  `picture` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `new_tab` tinyint(1) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Banner Table';

-- Dumping data for table db_swissair.banner: ~3 rows (approximately)
DELETE FROM `banner`;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` (`id`, `language`, `group`, `index`, `picture`, `url`, `new_tab`, `name`, `description`) VALUES
	(5, '', 'news', 0, 'carousel-01.jpg', NULL, 0, NULL, NULL),
	(6, '', 'service', 0, 'carousel-02.jpg', NULL, 0, NULL, NULL),
	(7, 'en', 'slider', 1, 'images-1.jpg', 'FOR LIFE', 0, 'CLEAN AIR', '<p>The UNECE â€“ Switzerland</p>\n\n<p>Air pollution harms human health, affect food security, hinders economic development, contributes to climate change and degrades the environment upon which our very livelihoods depend.</p>\n\n<p>With no political boundaries: pollution from sources in one country can be transported and deposited in neighbouring countries, sometimes even thousands of kilometres away.</p>\n');
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;

-- Dumping structure for table db_swissair.configuration
CREATE TABLE IF NOT EXISTS `configuration` (
  `configuration_id` int(10) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `key_name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`configuration_id`),
  UNIQUE KEY `unique_configuration` (`domain`,`key_name`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.configuration: ~27 rows (approximately)
DELETE FROM `configuration`;
/*!40000 ALTER TABLE `configuration` DISABLE KEYS */;
INSERT INTO `configuration` (`configuration_id`, `domain`, `key_name`, `value`) VALUES
	(1, 'www', 'content_home', '<div class="col-md-5 wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".8s">\r\n<div class="section-head text-center">\r\n<h2>SwissAir Technology AG</h2>\r\n\r\n<p>was founded on the firm belief that the freedom to breathe Clear and Healthy Air is The Greatest Gift. Using the micron mesh filter to effectively block 2.5mm fibrous particulate matter, the air can be cleaned easily by ten of thousands times. Preventing large particles such as pet fur, dander, and coarse dust, etc. In technical ways, it can increase the life of the following filters.</p>\r\n</div>\r\n</div>\r\n<!-- /.col-md-4 -->\r\n\r\n<div class="col-md-7 wow fadeInUp" data-wow-delay=".8s" data-wow-duration=".8s">\r\n<div class="big-sale-img"><img alt="" class="img-responsive" src="/contents/images/technology.jpg" /></div>\r\n</div>\r\n<!-- /.col-md-8 -->'),
	(2, 'www', 'web_logo', 'swissair-logo.png'),
	(3, 'www', 'web_title', 'Swiss Air Technology'),
	(4, 'www', 'copyright_en', NULL),
	(5, 'www', 'meta_name_description', NULL),
	(6, 'www', 'meta_name_keywords', NULL),
	(7, 'www', 'address', '<div class="contact-widget contact-widget-1">\r\n<div class="icon-box icon-box-1">\r\n<div class="icon"><i class="icon_phone">&nbsp;</i></div>\r\n\r\n<div class="content">\r\n<p>+62 21 5020 8178</p>\r\n\r\n<p>contact@fsholdings.co.id</p>\r\n</div>\r\n</div>\r\n\r\n<div class="icon-box icon-box-1">\r\n<div class="icon"><i class="icon_pin">&nbsp;</i></div>\r\n\r\n<div class="content">\r\n<p>Gold Coast Office Tower LT. 15 E</p>\r\n\r\n<p>Pantai Indah Kapuk</p>\r\n</div>\r\n</div>\r\n\r\n<div class="icon-box icon-box-1">\r\n<div class="icon"><i class="icon_clock">&nbsp;</i></div>\r\n\r\n<div class="content">\r\n<p>08:00 am &ndash; 05:00 pm</p>\r\n\r\n<p>Monday - Saturday</p>\r\n</div>\r\n</div>\r\n</div>\r\n'),
	(8, 'www', 'youtube_link', NULL),
	(9, 'www', 'facebook_link', 'https://www.facebook.com'),
	(10, 'www', 'twitter_link', 'https://www.twitter.com'),
	(11, 'www', 'instagram_link', NULL),
	(12, 'www', 'linkedin_link', NULL),
	(13, 'www', 'mail_link', 'contact@swissairtechnology.com'),
	(14, 'www', 'contact_map', '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15868.83287661418!2d106.7401008!3d-6.1026383!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x7bf18422ba371c19!2sGold%20Coast%20Office!5e0!3m2!1sid!2sid!4v1630725363657!5m2!1sid!2sid" style="border:0" allowfullscreen="true" height="630" width="100%"></iframe>'),
	(15, 'www', 'contact', '				<h2>SWISSAIR TECHNOLOGY AG.</h2>\r\n				<p>Zugerstrasse 32, 6340 Baar</p>\r\n				<p>Switzerland</p>\r\n				<h2>CONTACT</h2>\r\n				<p>Gold Coast Office Eiffel Tower Lt. 15F</p>\r\n				<p>Pantai Indah Kapuk, Jakarta Utara - 14470. Indonesia.</p>'),
	(16, 'www', 'email_from', 'noreply@swissairtechnology.com'),
	(17, 'www', 'email_enquiry', 'rivaldi@itconcept.sg'),
	(18, 'www', 'smtp_host', 'mail.swissairtechnology.com'),
	(19, 'www', 'smtp_port', '587'),
	(20, 'www', 'smtp_user', 'noreply@swissairtechnology.com'),
	(21, 'www', 'smtp_password', 'Passw0rd1234$'),
	(22, 'www', 'web_ico', 'swissair-logo_1.png'),
	(23, 'www', 'news', 'background-product_2.jpg'),
	(24, 'www', 'page', 'carousel-04_1.png'),
	(25, 'www', 'testimonial', 'carousel-02_3.jpg'),
	(26, 'www', 'header_motto', 'We are experts in consulting services and solutions'),
	(27, 'www', 'web_logo_footer', 'fs-holdings-logo-white-s.png'),
	(28, 'www', 'social', '<ul>\r\n					<li class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".3s">\r\n						<a href="#" title="(+62) 21 5020 8178">\r\n							<i class="fa fa-phone"></i>\r\n						</a>\r\n						<span>(+62) 21 5020 8178</span>\r\n					</li>\r\n					<li class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".7s">\r\n						<a href="#">\r\n							<i class="fa fa-whatsapp"></i>\r\n						</a>\r\n						<span>(+62) 812 5228 1702</span>\r\n					</li>\r\n					<li class="wow fadeInUp" data-wow-duration=".8s" data-wow-delay=".9s">\r\n						<a href="#">\r\n							<i class="fa fa-instagram" aria-hidden="true"></i>\r\n\r\n						</a>\r\n						<span>@swissair_official</span>\r\n					</li>\r\n				</ul>'),
	(29, 'www', 'home1', 'background.jpg'),
	(30, 'www', 'product', 'background-product.jpg'),
	(31, 'www', 'content_home_protect', '<div class="section-head padding-bottom55 text-center wow fadeInUp" data-wow-duration=".8s"\r\n				data-wow-delay=".3s">\r\n				<h2>7 SHIELD PROTECTION</h2>\r\n			</div>\r\n			<div class="section-content">\r\n<div class="col-md-4">\r\n<div class="colmd4 wow fadeInUp" data-wow-delay=".6s" data-wow-duration=".8s"><img alt="" class="img-responsive" src="/contents/images/produk-3.jpg" /></div>\r\n</div>\r\n<!-- /.col-md-4 -->\r\n\r\n<div class="col-md-8 d-grid grid-column-2 grid-column-xs">\r\n<div class="wow fadeInUp" data-wow-delay=".9s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>1st: Pre-filter</h4>\r\n\r\n<p>Made of white nylon to be washed repeatedly</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n\r\n<div class="wow fadeInUp" data-wow-delay="1s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>2nd: HEPA filter</h4>\r\n\r\n<p>HEPA filter widely used for medical use, to strongly absord particles PM 2.5</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n\r\n<div class="wow fadeInUp" data-wow-delay="1.1s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>3rd: Antibacterial Filter</h4>\r\n\r\n<p>5-10 Times powerful than traditional carbon filter</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n\r\n<div class="wow fadeInUp" data-wow-delay="1.2s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>4th: Activated Carbon</h4>\r\n\r\n<p>5-10 Times powerful than traditional carbon filter</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n\r\n<div class="wow fadeInUp" data-wow-delay="1.3s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>5th: Photocatalyst filter</h4>\r\n\r\n<p>Nano TIO2 as representative materials</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n\r\n<div class="wow fadeInUp" data-wow-delay="1.4s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>6th: Ion Generator</h4>\r\n\r\n<p>Produce Large Amount of Negative ION</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n\r\n<div class="wow fadeInUp" data-wow-delay="1.4s" data-wow-duration=".8s">\r\n<div class="single-item">\r\n<div class="mm-small-box">\r\n<h4>7th: UV Light</h4>\r\n\r\n<p>Cold cathode ultraviolet lamp with a wavelength of 235.7nm can effectively kill a variety of common bacteria and viruses</p>\r\n</div>\r\n</div>\r\n<!-- /.single-service --></div>\r\n</div>\r\n<!-- /.col-md-8 -->\r\n</div>');
/*!40000 ALTER TABLE `configuration` ENABLE KEYS */;

-- Dumping structure for table db_swissair.gallery
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` char(2) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `index` int(10) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `mode` varchar(100) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_unique` (`language`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.gallery: ~0 rows (approximately)
DELETE FROM `gallery`;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;

-- Dumping structure for table db_swissair.gallery_picture
CREATE TABLE IF NOT EXISTS `gallery_picture` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(10) NOT NULL,
  `index` int(10) DEFAULT NULL,
  `picture` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.gallery_picture: ~0 rows (approximately)
DELETE FROM `gallery_picture`;
/*!40000 ALTER TABLE `gallery_picture` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_picture` ENABLE KEYS */;

-- Dumping structure for table db_swissair.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `parent_id` int(10) DEFAULT NULL,
  `group` varchar(255) DEFAULT NULL,
  `index` int(10) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `value` varchar(255) DEFAULT NULL,
  `new_tab` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `menu_FI_1` (`parent_id`),
  CONSTRAINT `menu_FK_1` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Menu Table';

-- Dumping data for table db_swissair.menu: ~4 rows (approximately)
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `language`, `parent_id`, `group`, `index`, `name`, `type`, `value`, `new_tab`) VALUES
	(1, '', NULL, 'main', 0, '{"en":"Home"}', 1, '/', 0),
	(3, '', NULL, 'main', 5, '{"en":"Contact"}', 3, 'ContactUs', 0),
	(4, '', NULL, 'main', 1, '{"en":"About"}', 2, '1', 0),
	(5, 'en', NULL, 'main', 2, '{"en":"Products"}', 1, 'product', 0),
	(6, 'en', NULL, 'main', 3, '{"en":"News"}', 3, 'News', 0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- Dumping structure for table db_swissair.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `type` varchar(30) NOT NULL DEFAULT 'news',
  `code` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `description` text,
  `short_description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_news` (`language`,`code`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.news: ~7 rows (approximately)
DELETE FROM `news`;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`id`, `language`, `type`, `code`, `date`, `name`, `picture`, `description`, `short_description`) VALUES
	(1, '', 'service', 'pt-filtration-specialist', '2018-05-16', 'PT FILTRATION SPECIALIST ', NULL, '<p>PT Filtration Specialist was founded in 2009 to provide filtration solutions for all industries and sectors. We distribute quality filters to give you effective and efficient filtration solutions. We have experienced in a board spectrum of filtration products wo we can provide the perfect filtration solution for your needs. Because we buy direct from manufactures, we can provide the perfect, most reliable product at the very best prices.</p>\r\n\r\n<p>We have a complete range of products, from air filter, oil filter, fuel filter until hydraulic filter to meet the highest demands and needs of modern engine.</p>\r\n\r\n<p>Wide range of application, such as trucks and buses, heavy equipments, industrials, marines, clean room, etc.</p>\r\n\r\n<p>Our Products are made by manufactures of outstanding quality and adhering to the ISO/TS Quality Management Standard.</p>\r\n\r\n<p>We are sole agent for Sure Filter and retailer of world class filters such as : Fleetguard, Donaldson, Mann Filter, Sakura Filter, Racor</p>\r\n', '<p>One stop filtration solutions</p>\r\n'),
	(2, '', 'service', 'fs-health', '2018-05-16', 'FS HEALTH', 'runners-635906_640.jpg', '<p>FS Health Specializes in marketing and distribution of a wide range of healthcare solutions to improve human life quality. We eant to be the fist choice supplier to our key customers by providing them with the best products and a personal services.</p>\r\n\r\n<p>We have an experienced sales team and a robust logistics network to ensure optimal marketing and distribution of our customers products.</p>\r\n\r\n<p>Our Product :</p>\r\n\r\n<p>Air Purifier, Water Filter Hidrogen Water, Etc</p>\r\n', '<p>Brings quality to Your Life</p>\r\n'),
	(3, '', 'service', 'fs-capital', '2018-05-16', 'FS CAPITAL', 'action-2277292_640.jpg', '<p>FS Capital is a venture capital which supports promising startups. We love to parner with passionate entrepreneurs showing maximum enthusiasm in pushing the venture idea. We are always excited to meet interesting personalities and their ideas to growth promising business concepts.We are actively expanding our network members. Experienced businessmen and serious investors are invited to join. FS Capital strives to provide tools and resources to assist in evaluating investments, and the opportunity to collaborate with other investor.</p>\r\n\r\n<p>We invest in early stage companies across sectors Architecture, Information Technology, Healthcare, E-Commerce, Consumer, etc</p>\r\n', '<p>Creates Entrepreneurs of Tomorrow</p>\r\n'),
	(4, '', 'service', 'fs-work', '2018-05-16', 'FS WORK', 'landing_1.jpg', '<p>We offer business space and flexible offices tailored to the needs of new and growing companies. We are cmmited to finding you the best available office space to help you achieve your business goals.</p>\r\n\r\n<p>Â </p>\r\n\r\n<p>You will enjoy :</p>\r\n\r\n<p>Flexibility : we donâ€™t put limits on the type or flexibility of the space you need-whether youâ€™re looking for one desk or an office, ,weâ€™ve got a space htat fits our needs.</p>\r\n\r\n<p>Fun Working environment</p>\r\n\r\n<p>Office Furnishings : We equipped your office with high quality and comfortable furniture so you can have a productive and enjoyable environment.</p>\r\n\r\n<p>Seper-Fast Wifi : We also improve how you work by continual investment in the best connectivity to support your future goals.</p>\r\n\r\n<p>Community : You will be connected to our fast-growing networks to share ideas, grow and collaborate.</p>\r\n', '<p>Community though Office Space</p>\r\n'),
	(7, 'en', 'sliding', 'swissair', '2021-09-14', 'SWISSAIR', NULL, 'We Protect The Air You Breathe', 'AIR PURIFIER'),
	(8, 'en', 'Products', 'sa0500pro', '2021-09-14', 'SA0500PRO', 'produk-1.jpg', '							<div class="feature-lsit">\n								<ul>\n									<li>CADR (Particle) 410m3/h</li>\n									<li>application area 50m2</li>\n									<li>Fan Speed Adjustment levels : low - middle - high</li>\n									<li>Timing level : 1h - 4h - 8h</li>\n									<li>Reset Button</li>\n									<li>Dust Sensor + 4 colors Air quality indicator</li>\n									<li>PM2.5 digital display</li>\n									<li>Auto & Sleep mode</li>\n									<li>Temperature and Humidity Display</li>\n								</ul>\n							</div>', NULL),
	(9, 'en', 'Products', 'sa0700pro-gold', '2021-09-14', 'SA0700PRO GOLD', 'produk-2.jpg', '<div class="feature-lsit">\n								<ul>\n									<li>CADR (Particle) 610m3/h</li>\n									<li>application area 70m2</li>\n									<li>Fan Speed Adjustment levels : low - middle - high</li>\n									<li>Timing level : 1h - 4h - 8h</li>\n									<li>Reset Button</li>\n									<li>Dust Sensor + 4 colors Air quality indicator</li>\n									<li>PM2.5 digital display</li>\n									<li>Auto & Sleep mode</li>\n									<li>Temperature and Humidity Display</li>\n								</ul>\n							</div>', NULL),
	(10, 'en', 'news', 'swissair-air-purifier', '2021-09-16', 'SwissAir Air Purifier', 'articles_6.jpg', '<p>Â With UV Light, the use of a cold cathode ultraviolet lamp with a wavelength of 235.7nm can effectively kill a variety of common bacteria and viruses, and inhibit the reproduction and production of bacteria and viruses. Also with HEPA Filter, the rate of removing the minor particles small to 0.3 Micron from the air flow can rise up to 99%. To prevent and stop the spread of allergens and bacteria in the air flow, such as pollen, smog, and viruses.</p>\n\n<p>Â </p>\n\n<p class="font8" style="line-height:16.8pt"><span lang="IN">Releasing Anion to stop the virus growth<o:p></o:p></span></p>\n\n<p class="font8" style="line-height:16.8pt"><span lang="IN">Bacterial & Mold Protection<o:p></o:p></span></p>\n\n<p class="font8" style="line-height:16.8pt"><span lang="IN">Odor Barrier<o:p></o:p></span></p>\n\n<p class="font8" style="line-height:16.8pt"><span lang="IN">PM 2.5 Indikator<o:p></o:p></span></p>\n\n<p class="font5"><span lang="IN">TOVC Removal<o:p></o:p></span></p>\n\n<p class="font5"><span lang="IN">UV Light<o:p></o:p></span></p>\n', '<p>With UV Light, the use of a cold cathode ultraviolet lamp with a wavelength of 235.7nmÂ </p>\n');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;

-- Dumping structure for table db_swissair.page
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sort_order` int(10) DEFAULT '0',
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `type` varchar(20) NOT NULL DEFAULT 'page',
  `date` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `short_desc` text,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.page: ~0 rows (approximately)
DELETE FROM `page`;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` (`id`, `sort_order`, `language`, `type`, `date`, `code`, `name`, `picture`, `short_desc`, `description`) VALUES
	(1, 0, 'en', 'page', '2021-09-14 18:00:00', 'about', 'About', 'background-product_1.jpg', NULL, '<section class="best-service-section padding-top100 padding-bottom55" id="best-service">\n<div class="container">\n<div class="section-head padding-bottom55 text-center wow fadeInUp animated" data-wow-delay="0.3s" data-wow-duration=".8s">\n<h2>THE BEST <span>LIMO SErVICE</span> IN N.Y CITY</h2>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, trud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\n</div>\n\n<div class="section-content text-center">\n<div class="col-md-4 wow fadeInUp animated" data-wow-delay="0.5s" data-wow-duration=".8s">\n<div class="colmd4">\n<div class="single-item">\n<div class="icon"><img alt="Best Service Image" src="images/about/best-service/1.png" /></div>\n\n<div class="mm-small-box">\n<h4>Safety first</h4>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque</p>\n</div>\n</div>\n<!-- /.single-service --></div>\n</div>\n<!-- /.col-md-4 -->\n\n<div class="col-md-4 wow fadeInUp animated" data-wow-delay="0.7s" data-wow-duration=".8s">\n<div class="colmd4">\n<div class="single-item single-item-middle">\n<div class="icon"><img alt="Best Service Image" src="images/about/best-service/2.png" /></div>\n\n<div class="mm-small-box">\n<h4>30 day guarantee</h4>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque</p>\n</div>\n</div>\n<!-- /.single-service --></div>\n</div>\n<!-- /.col-md-4 -->\n\n<div class="col-md-4 wow fadeInUp animated" data-wow-delay="0.9s" data-wow-duration=".8s">\n<div class="colmd4">\n<div class="single-item">\n<div class="icon"><img alt="Best Service Image" src="images/about/best-service/3.png" /></div>\n\n<div class="mm-small-box">\n<h4>money back</h4>\n\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque</p>\n</div>\n</div>\n<!-- /.single-service --></div>\n</div>\n<!-- /.col-md-4 --></div>\n<!-- /.section-content --></div>\n</section>\n<!-- End Of Best Service Section --><!-- History Section -->\n\n<section id="history">\n<div class="history-container section-padding">\n<div class="container">\n<div class="col-md-6">\n<div class="row">\n<div class="title">\n<h2>42</h2>\n\n<p>Years and<br />\n<span class="base">counting</span></p>\n</div>\n<!-- /.title -->\n\n<div class="col-md-3 col-sm-6">\n<div class="colmd3">\n<h3 class="black counter">80</h3>\n<img alt="Counter" src="images/about/counter1.png" /></div>\n<!-- /.our-member --></div>\n<!-- /.col-md-3 -->\n\n<div class="col-md-3 col-sm-6">\n<div class="colmd3">\n<h3 class="black counter">154</h3>\n<img alt="Counter" src="images/about/counter2.png" /></div>\n<!-- /.our-member --></div>\n<!-- /.col-md-3 -->\n\n<div class="col-md-3 col-sm-6">\n<div class="colmd3 black">\n<h3 class="counter">318</h3>\n<img alt="Counter" src="images/about/counter3.png" /></div>\n<!-- /.our-member --></div>\n<!-- /.col-md-3 -->\n\n<div class="col-md-3 col-sm-6">\n<div class="colmd3 black">\n<h3 class="counter">17</h3>\n<img alt="Counter" src="images/about/counter4.png" /></div>\n<!-- /.our-member --></div>\n<!-- /.col-md-3 --></div>\n</div>\n<!-- Accordion Widget -->\n\n<div class="col-md-6">\n<div class="accordion-widget">\n<div aria-multiselectable="true" class="panel-group" id="accordion" role="tablist">\n<div class="panel panel-default">\n<div class="panel-heading" id="headingOne" role="tab">\n<h4 class="panel-title"><a aria-controls="collapseOne" aria-expanded="true" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseOne">Bibendum Porta Fermentum? </a><!-- /.collapsed --></h4>\n<!-- /.panel-title --></div>\n<!-- /.panel-heading -->\n\n<div aria-labelledby="headingOne" class="panel-collapse collapse" id="collapseOne" role="tabpanel">\n<div class="panel-body">\n<p>Donec sed odio dui. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec id elit non mi porta gravida at eget metus.</p>\n</div>\n<!-- /.panel-body --></div>\n<!-- /.panel-collapse collapse --></div>\n<!-- /.panel panel-default -->\n\n<div class="panel panel-default">\n<div class="panel-heading" id="headingTwo" role="tab">\n<h4 class="panel-title"><a aria-controls="collapseTwo" aria-expanded="false" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">Praesent commodo cursus magna,e nisl consectetur et? </a><!-- /.collapsed --></h4>\n<!-- /.panel-title --></div>\n<!-- /.panel-heading -->\n\n<div aria-labelledby="headingTwo" class="panel-collapse collapse" id="collapseTwo" role="tabpanel">\n<div class="panel-body">\n<p>Donec sed odio dui. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec id elit non mi porta gravida at eget metus.t amet, consectetur adipiscing elit. Praesent vehicula sapien orci, ac lobortis turpis. Sed justo neque, imperdiet</p>\n</div>\n<!-- /.panel-body --></div>\n<!-- /.panel-collapse collapse --></div>\n<!-- /.panel panel-default -->\n\n<div class="panel panel-default">\n<div class="panel-heading" id="headingThree" role="tab">\n<h4 class="panel-title"><a aria-controls="collapseThree" aria-expanded="false" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">Commodo cursus magna,e nisl consectetur et? </a><!-- /.collapsed --></h4>\n<!-- /.panel-title --></div>\n<!-- /.panel-heading -->\n\n<div aria-labelledby="headingThree" class="panel-collapse collapse in" id="collapseThree" role="tabpanel">\n<div class="panel-body">\n<p>Donec sed odio dui. Maecenas sed diam eget risus varius blandit sit amet non magna. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Donec id elit non mi porta gravida at eget metus.</p>\n</div>\n<!-- /.panel-body --></div>\n<!-- /.panel-collapse collapse --></div>\n<!-- /.panel panel-default --></div>\n<!-- /.panel-group --></div>\n<!-- /.accordion-widget --></div>\n<!-- /.col-md-5 --><!-- Accordion Widget --></div>\n</div>\n<!-- /.history-container --></section>\n<!-- End of History Section -->');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;

-- Dumping structure for table db_swissair.page_tab
CREATE TABLE IF NOT EXISTS `page_tab` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) NOT NULL,
  `index` int(10) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `page_tab_FI_1` (`page_id`),
  CONSTRAINT `page_tab_FK_1` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.page_tab: ~5 rows (approximately)
DELETE FROM `page_tab`;
/*!40000 ALTER TABLE `page_tab` DISABLE KEYS */;
INSERT INTO `page_tab` (`id`, `page_id`, `index`, `name`, `description`) VALUES
	(1, 1, 0, 'Company', '<div class="page-content p-b-50">\n<div class="container">\n<div class="row">\n<div class="col-md-9">\n<section class="section post-section-1 m-b-30 p-r-15">\n<div class="post-image owl-carousel dark nav-style-3 dots-style-1 m-b-35" data-carousel-autoplay="true" data-carousel-dots="true" data-carousel-items="1" data-carousel-lg="1" data-carousel-loop="true" data-carousel-md="1" data-carousel-nav="true" data-carousel-sm="1" data-carousel-xs="1">Â </div>\n\n<div class="post-content">\n<h4 class="text-block text-bold text-black text-med-large m-b-20">Who We Are</h4>\n\n<p class="text-block m-b-30">FS Holdings is a holding company that provides services in architecture, information technology (IT), health-care and biotechnology industries. We were established in 2009 with vision to become the world class company in architecture, information technology (IT), health-care, biotechnology and create one million start ups in these sectors. Given the aggressiveness of our company goals, it will take a collective effort to achieve these objectives.</p>\n\n<div class="row">\n<div class="col-md-6">\n<h4 class="text-block text-bold text-black text-med-sm m-b-20">Our Vision</h4>\n\n<p class="text-block m-b-30">To improve human lifes for ten billion people in the worlds and create one million new entrepreneurs in the world 2040.</p>\n\n<h4 class="text-block text-bold text-black text-med-sm m-b-20">Our Core Value</h4>\n\n<ol>\n	<li class="text-block">Everyone is Assets</li>\n	<li class="text-block">Team Work</li>\n	<li class="text-block">Fun & Sharing Work Environment</li>\n	<li class="text-block">Customers are Partners</li>\n	<li class="text-block">Love At Work</li>\n</ol>\n</div>\n</div>\n</div>\n</section>\n</div>\n</div>\n</div>\n</div>\n'),
	(2, 1, 1, 'History', '<div class="page-content p-b-50">\n<div class="container">\n<div class="row">\n<div class="col-md-9">\n<section class="section post-section-1 m-b-30 p-r-15">\n<div class="post-image owl-carousel dark nav-style-3 dots-style-1 m-b-35" data-carousel-autoplay="true" data-carousel-dots="true" data-carousel-items="1" data-carousel-lg="1" data-carousel-loop="true" data-carousel-md="1" data-carousel-nav="true" data-carousel-sm="1" data-carousel-xs="1">Â </div>\n\n<div class="post-content">\n<h4 class="text-block text-bold text-black text-med-large m-b-20">Our History</h4>\n\n<p class="text-block m-b-30"><span style="color: rgb(85, 85, 85); font-family: Roboto, Helvetica, Arial, sans-serif; font-size: 15px; background-color: rgb(255, 255, 255);">We were established in 2009 with vision to become the world class company in architecture, information technology (IT), health-care, biotechnology and create one million start ups in these sectors. Given the aggressiveness of our company goals, it will take a collective effort to achieve these objectives.</span></p>\n\n<ul class="au-timeline p-t-50">\n	<li class="timeline-block p-b-30">\n	<div class="icon-dot">Â </div>\n\n	<div class="content">\n	<h4 class="text-block text-bold text-black text-med-sm m-b-20">Founded Consulting</h4>\n\n	<p class="text-block m-b-5">Our company established.</p>\n\n	<p class="date text-block text-bold m-b-30">2009</p>\n	</div>\n	</li>\n	<li class="timeline-block p-b-30">\n	<div class="icon-dot">Â </div>\n\n	<div class="content">\n	<h4 class="text-block text-bold text-black text-med-sm m-b-20">Launched WordPress Theme</h4>\n\n	<p class="text-block m-b-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam finibus venenatis ipsum, a vulputate velit cursus sed. Vestibulum bibendum mi et sapien ultrices vehicula. Aenean sodales, purus id viverra aliquam, sapien eros sagittis ligula, a tempor diam quam in justo. Etiam tristique rutrum dui, vel condimentum quam finibus id. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>\n\n	<p class="date text-block text-bold m-b-30">2013</p>\n	</div>\n	</li>\n	<li class="timeline-block p-b-30">\n	<div class="icon-dot">Â </div>\n\n	<div class="content">\n	<h4 class="text-block text-bold text-black text-med-sm m-b-20">Consulting Award Winning</h4>\n\n	<p class="text-block m-b-5">Donec laoreet ultrices neque et commodo. Vivamus vehicula nec mauris et interdum. Nulla pretium sit amet quam vel sollicitudin. Donec tellus nibh, egestas quis varius et, pulvinar et libero. Suspendisse eu justo elementum, aliquam ipsum ut, tempor arcu.</p>\n\n	<p class="date text-block text-bold m-b-30">2015</p>\n	</div>\n	</li>\n	<li class="timeline-block">\n	<div class="icon-dot">Â </div>\n\n	<div class="content">\n	<h4 class="text-block text-bold text-black text-med-sm m-b-20">Web: Best Designed Site</h4>\n\n	<p class="text-block m-b-5">Donec laoreet ultrices neque et commodo. Vivamus vehicula nec mauris et interdum. Nulla pretium sit amet quam vel sollicitudin. Donec tellus nibh, egestas quis varius et, pulvinar et libero. Sed dapibus viverra orci, vel ultrices arcu porttitor nec.<br />\n	Â </p>\n\n	<p class="date text-block text-bold m-b-30">2017</p>\n	</div>\n	</li>\n	<li class="timeline-block">\n	<div class="icon-dot">Â </div>\n\n	<div class="content">\n	<h4 class="text-block text-bold text-black text-med-sm m-b-20">Web: Best Designed Site</h4>\n\n	<p class="text-block m-b-5">Donec laoreet ultrices neque et commodo. Vivamus vehicula nec mauris et interdum. Nulla pretium sit amet quam vel sollicitudin. Donec tellus nibh, egestas quis varius et, pulvinar et libero. Sed dapibus viverra orci, vel ultrices arcu porttitor nec.<br />\n	Â </p>\n\n	<p class="date text-block text-bold m-b-30">2017</p>\n\n	<p class="date text-block text-bold m-b-30">Â </p>\n\n	<p class="date text-block text-bold m-b-30">Â </p>\n	</div>\n	</li>\n	<li class="timeline-block p-b-30">\n	<div class="icon-dot">Â </div>\n\n	<div class="content">\n	<h4 class="text-block text-bold text-black text-med-sm m-b-20">Founded Consulting</h4>\n\n	<p class="text-block m-b-5">This is Made. Proin gravida nibh vel velit auctor aliquet. Aenean sollic, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ut ipsum velit.</p>\n\n	<p class="date text-block text-bold m-b-30">2019</p>\n	</div>\n	</li>\n</ul>\n</div>\n</section>\n</div>\n</div>\n</div>\n</div>\n'),
	(3, 1, 2, 'Partnership', '<div class="page-content p-b-50">\n<div class="container">\n<div class="row">\n<div class="col-md-9">\n<section class="section post-section-1 m-b-30 p-r-15">\n<div class="post-image owl-carousel dark nav-style-3 dots-style-1 m-b-35" data-carousel-autoplay="true" data-carousel-dots="true" data-carousel-items="1" data-carousel-lg="1" data-carousel-loop="true" data-carousel-md="1" data-carousel-nav="true" data-carousel-sm="1" data-carousel-xs="1">Â </div>\n\n<div class="post-content">\n<h4 class="text-block text-bold text-black text-med-large m-b-20">Our Partnerships</h4>\n\n<p class="text-block m-b-30"><span style="font-size:16px;"><span style="font-family:times new roman,times,serif;"><span style="color: rgb(51, 71, 91);">"Great things in business are never done by one person; they\'re done by a team of people." â€“ Steve </span></span></span><span style="color: rgb(51, 71, 91); font-family: AvenirNext, "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 18px;"><span style="font-size:16px;"><span style="font-family:times new roman,times,serif;">Jobs</span></span></span></p>\n</div>\n\n<ul class="partnerships">\n	<li class="partnership">\n	<div class="partnership-logo"><a href="https://envato.com/"><img alt="partner ship" src="/contents//images/partner-1.jpg" style="height: 50px; width: 200px;" /> </a></div>\n\n	<div class="partnership-content">\n	<h4 class="text-block text-bold text-med-sm m-b-20"><a class="text-black" href="https://envato.com/">Donaldson</a></h4>\n\n	<p class="text-block m-b-5">Â </p>\n	</div>\n	</li>\n	<li class="partnership">\n	<div class="partnership-logo"><a href="#"><img alt="partner ship" src="/contents//images/partner-2.jpg" style="height: 145px; width: 200px;" /> </a></div>\n\n	<div class="partnership-content">\n	<h4 class="text-block text-bold text-med-sm m-b-20"><a class="text-black" href="#">Fleetguard</a></h4>\n	</div>\n	</li>\n	<li class="partnership">\n	<div class="partnership-logo"><a href="#"><img alt="partner ship" src="/contents//images/partner-4.jpg" style="height: 87px; width: 200px;" /> </a></div>\n\n	<div class="partnership-content">\n	<h4 class="text-block text-bold text-med-sm m-b-20"><a class="text-black" href="#">Parker Racor</a></h4>\n\n	<p class="text-block m-b-5">Â </p>\n	</div>\n	</li>\n	<li class="partnership">\n	<div class="partnership-logo"><a href="#"><img alt="partner ship" src="/contents//images/partnet-3.jpg" style="width: 200px; height: 100px;" /> </a></div>\n\n	<div class="partnership-content">\n	<h4 class="text-block text-bold text-med-sm m-b-20"><a class="text-black" href="#">Mann Filter</a></h4>\n\n	<p class="text-block m-b-5">Â </p>\n	</div>\n	</li>\n	<li class="partnership">\n	<div class="partnership-logo"><a href="#"><img alt="partner ship" src="/contents//images/partner-6.jpg" style="height: 88px; width: 200px;" /> </a></div>\n\n	<div class="partnership-content">\n	<h4 class="text-block text-bold text-med-sm m-b-20"><a class="text-black" href="#">Sakura</a></h4>\n\n	<p class="text-block m-b-5">Â </p>\n	</div>\n	</li>\n</ul>\n</section>\n</div>\n</div>\n</div>\n</div>\n'),
	(4, 1, 3, 'Leadership', '<div class="page-content p-b-50">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-9">\r\n<section class="section post-section-1 m-b-30 p-r-15">\r\n<div class="post-image owl-carousel dark nav-style-3 dots-style-1 m-b-35" data-carousel-autoplay="true" data-carousel-dots="true" data-carousel-items="1" data-carousel-lg="1" data-carousel-loop="true" data-carousel-md="1" data-carousel-nav="true" data-carousel-sm="1" data-carousel-xs="1">Â </div>\r\n\r\n<div class="post-content">\r\n<h4 class="text-block text-bold text-black text-med-large m-b-20">Our Leadership</h4>\r\n\r\n<p class="text-block m-b-30">Nulla commodo iaculis ligula, ac dapibus quam ornare ut. Praesent ac hendrerit sem, et tempus sem. Donec sit amet elit a felis tristique eleifend. Aliquam erat volutpat . Cras metus ipsum, tincidunt in bibendum vitae, fringilla ac ipsum. Sed at eros quis mi pulvinar lacinia eget sed ex. Vestibulum eget ipsum porttitor, cursus urna nec, ultrices enim. Sed eget dignissim nulla, non facilisis augue. Fusce nec dictum nunc. Maecenas hendrerit tempus magna eu ultricies. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>\r\n\r\n<ul class="leaderships p-t-20">\r\n	<li class="leadership">\r\n	<div class="leadership-logo"><a href="about-teammember.html"><img alt="partner ship" src="/contents//images/article-4.jpg" style="height: 200px; width: 200px;" /> </a></div>\r\n\r\n	<div class="leadership-content">\r\n	<h4 class="text-block text-bold text-med-sm m-b-15"><a class="text-black" href="about-teammember.html">Philip Barnett</a></h4>\r\n\r\n	<p class="text-block m-b-20 text-grey">Chief Executive Officer</p>\r\n\r\n	<p class="text-block m-b-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras cursus metus vel urna feugiat, vitae pharetra magna rhoncus. Nullam a lacus elit. Pellentesque eu metus eu enim eleifend elementum eu sit amet urna</p>\r\n	</div>\r\n	</li>\r\n	<li class="leadership">\r\n	<div class="leadership-logo"><a href="about-teammember.html"><img alt="partner ship" src="images/leadership-02.jpg" /> </a></div>\r\n\r\n	<div class="leadership-content">\r\n	<h4 class="text-block text-bold text-med-sm m-b-15"><a class="text-black" href="about-teammember.html">Rose Lewis</a></h4>\r\n\r\n	<p class="text-block m-b-20 text-grey">Chief Marketing Officer</p>\r\n\r\n	<p class="text-block m-b-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras cursus metus vel urna feugiat, vitae pharetra magna rhoncus. Nullam a lacus elit. Pellentesque eu metus eu enim eleifend elementum eu sit amet urna</p>\r\n	</div>\r\n	</li>\r\n	<li class="leadership">\r\n	<div class="leadership-logo"><a href="about-teammember.html"><img alt="partner ship" src="images/leadership-03.jpg" /> </a></div>\r\n\r\n	<div class="leadership-content">\r\n	<h4 class="text-block text-bold text-med-sm m-b-15"><a class="text-black" href="about-teammember.html">Kevin Gardner</a></h4>\r\n\r\n	<p class="text-block m-b-20 text-grey">Chief Financial Officer</p>\r\n\r\n	<p class="text-block m-b-30">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras cursus metus vel urna feugiat, vitae pharetra magna rhoncus. Nullam a lacus elit. Pellentesque eu metus eu enim eleifend elementum eu sit amet urna</p>\r\n	</div>\r\n	</li>\r\n</ul>\r\n</div>\r\n</section>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n'),
	(5, 1, 4, 'Careers', '<div class="page-content p-b-50">\r\n<div class="container">\r\n<div class="row">\r\n<div class="col-md-9">\r\n<section class="section post-section-1 m-b-30 p-r-15">\r\n<div class="post-image owl-carousel dark nav-style-3 dots-style-1 m-b-35" data-carousel-autoplay="true" data-carousel-dots="true" data-carousel-items="1" data-carousel-lg="1" data-carousel-loop="true" data-carousel-md="1" data-carousel-nav="true" data-carousel-sm="1" data-carousel-xs="1">Â </div>\r\n\r\n<div class="post-content">\r\n<h4 class="text-block text-bold text-black text-med-large m-b-50">Open Positions</h4>\r\n\r\n<ul class="careers">\r\n	<li class="career"><span class="text-block m-b-20">ENGINEERING</span>\r\n\r\n	<h4 class="text-block text-bold text-black text-med m-t-0 m-b-20">Project Management</h4>\r\n	<span class="text-block text-grey m-b-20">NEW YORK CITY - FULL TIME</span>\r\n\r\n	<p class="text-block m-b-30">Praesent feugiat cursus diam eget fringilla. Ut a sollicitudin magna. Sed luctus, augue id placerat vehicula, tortor nibh pretium sem, condimentum efficitur lacus leo sed lorem. Donec consectetur leo eros, a vehicula odio vestibulum nec. Phasellus tristique justo vitae justo ultricies consectetur. Suspendisse in pellentesque quam. Donec sed molestie tortor. Curabitur non pellentesque nulla, sit amet auctor tortor. Fusce scelerisque, quam ac efficitur porttitor, neque eros egestas justo, semper porttitor quam leo sit amet massa.</p>\r\n\r\n	<div class="au-toggle"><span class="btn-toggle text-block text-bold text-black text-underline m-b-30" data-target="#detail1" data-toggle="collapse">LESS DETAILS</span>\r\n\r\n	<div class="collapse in" id="detail1">\r\n	<p class="text-block m-b-20">You will:</p>\r\n\r\n	<ul class="post-list m-b-30">\r\n		<li>Integer in elementum risus. Fusce nec metus leo.</li>\r\n		<li>Quisque vel pretium neque. Proin hendrerit, ante molestie eleifend mattis, tellus nunc elementum felis</li>\r\n		<li>Sollicitudin sapien magna quis est. Quisque non vestibulum libero</li>\r\n		<li>Aenean et enim nec libero vulputate feugiat. Suspendisse ac varius diam</li>\r\n		<li>Aenean lorem ligula, egestas et magna eu, viverra bibendum enim.</li>\r\n	</ul>\r\n\r\n	<p class="text-block m-b-20">Requirements/Experience:</p>\r\n\r\n	<ul class="post-list m-b-30">\r\n		<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>\r\n		<li>Fusce dignissim tortor et elit dapibus cursus. Aenean lorem ligula, egestas et magna</li>\r\n		<li>Nunc sed vulputate velit quis luctus lectus</li>\r\n		<li>Aenean lectus mauris, fermentum sed turpis eget, condimentum molestie leo</li>\r\n		<li>Proin suscipit, justo sit amet tristique ultrices, ex magna efficitur lectus, at rutrum dui ex id nulla</li>\r\n		<li>Integer in elementum risus. Fusce nec metus leo.</li>\r\n		<li>Quisque vel pretium neque. Proin hendrerit, ante molestie eleifend mattis, tellus nunc elementum felis</li>\r\n		<li>Sollicitudin sapien magna quis est. Quisque non vestibulum libero</li>\r\n	</ul>\r\n	</div>\r\n	</div>\r\n	</li>\r\n	<li class="career"><span class="text-block m-b-20">OPERATIONS</span>\r\n	<h4 class="text-block text-bold text-black text-med m-t-0 m-b-20">Marketing & Sale</h4>\r\n	<span class="text-block text-grey m-b-20">BERLIN - FULL TIME</span>\r\n\r\n	<p class="text-block m-b-30">Mauris consectetur mauris a eros tincidunt, non interdum sapien mollis. Proin suscipit, justo sit amet tristique ultrices, ex magna efficitur lectus, at rutrum dui ex id nulla. Praesent erat leo, sollicitudin nec porttitor vel, blandit sed est. In hac habitasse platea dictumst. Nulla feugiat, ipsum et fringilla pellentesque, dui risus convallis orci, non lobortis libero arcu ut ante. Maecenas sollicitudin tortor commodo ipsum elementum, sit amet gravida elit fringilla. Quisque et mi turpis. Fusce sed vestibulum mi, nec dapibus justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque eget sapien nec lacus.</p>\r\n\r\n	<div class="au-toggle"><span class="btn-toggle text-block text-bold text-black text-underline m-b-30" data-target="#detail2" data-toggle="collapse">MORE DETAILS</span>\r\n\r\n	<div class="collapse" id="detail2">\r\n	<p class="text-block m-b-20">You will:</p>\r\n\r\n	<ul class="post-list m-b-30">\r\n		<li>Integer in elementum risus. Fusce nec metus leo.</li>\r\n		<li>Quisque vel pretium neque. Proin hendrerit, ante molestie eleifend mattis, tellus nunc elementum felis</li>\r\n		<li>Sollicitudin sapien magna quis est. Quisque non vestibulum libero</li>\r\n		<li>Aenean et enim nec libero vulputate feugiat. Suspendisse ac varius diam</li>\r\n		<li>Aenean lorem ligula, egestas et magna eu, viverra bibendum enim.</li>\r\n	</ul>\r\n\r\n	<p class="text-block m-b-20">Requirements/Experience:</p>\r\n\r\n	<ul class="post-list m-b-30">\r\n		<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>\r\n		<li>Fusce dignissim tortor et elit dapibus cursus. Aenean lorem ligula, egestas et magna</li>\r\n		<li>Nunc sed vulputate velit quis luctus lectus</li>\r\n		<li>Aenean lectus mauris, fermentum sed turpis eget, condimentum molestie leo</li>\r\n		<li>Proin suscipit, justo sit amet tristique ultrices, ex magna efficitur lectus, at rutrum dui ex id nulla</li>\r\n		<li>Integer in elementum risus. Fusce nec metus leo.</li>\r\n		<li>Quisque vel pretium neque. Proin hendrerit, ante molestie eleifend mattis, tellus nunc elementum felis</li>\r\n		<li>Sollicitudin sapien magna quis est. Quisque non vestibulum libero</li>\r\n	</ul>\r\n	</div>\r\n	</div>\r\n	</li>\r\n	<li class="career"><span class="text-block m-b-20">OPERATIONS</span>\r\n	<h4 class="text-block text-bold text-black text-med m-t-0 m-b-20">Junior Data Analyst</h4>\r\n	<span class="text-block text-grey m-b-20">BERLIN - FULL TIME</span>\r\n\r\n	<p class="text-block m-b-30">Mauris consectetur mauris a eros tincidunt, non interdum sapien mollis. Proin suscipit, justo sit amet tristique ultrices, ex magna efficitur lectus, at rutrum dui ex id nulla. Praesent erat leo, sollicitudin nec porttitor vel, blandit sed est. In hac habitasse platea dictumst. Nulla feugiat, ipsum et fringilla pellentesque, dui risus convallis orci, non lobortis libero arcu ut ante. Maecenas sollicitudin tortor commodo ipsum elementum, sit amet gravida elit fringilla. Quisque et mi turpis. Fusce sed vestibulum mi, nec dapibus justo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque eget sapien nec lacus.</p>\r\n\r\n	<div class="au-toggle"><span class="btn-toggle text-block text-bold text-black text-underline m-b-30" data-target="#detail3" data-toggle="collapse">MORE DETAILS</span>\r\n\r\n	<div class="collapse" id="detail3">\r\n	<p class="text-block m-b-20">You will:</p>\r\n\r\n	<ul class="post-list m-b-30">\r\n		<li>Integer in elementum risus. Fusce nec metus leo.</li>\r\n		<li>Quisque vel pretium neque. Proin hendrerit, ante molestie eleifend mattis, tellus nunc elementum felis</li>\r\n		<li>Sollicitudin sapien magna quis est. Quisque non vestibulum libero</li>\r\n		<li>Aenean et enim nec libero vulputate feugiat. Suspendisse ac varius diam</li>\r\n		<li>Aenean lorem ligula, egestas et magna eu, viverra bibendum enim.</li>\r\n	</ul>\r\n\r\n	<p class="text-block m-b-20">Requirements/Experience:</p>\r\n\r\n	<ul class="post-list m-b-30">\r\n		<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit</li>\r\n		<li>Fusce dignissim tortor et elit dapibus cursus. Aenean lorem ligula, egestas et magna</li>\r\n		<li>Nunc sed vulputate velit quis luctus lectus</li>\r\n		<li>Aenean lectus mauris, fermentum sed turpis eget, condimentum molestie leo</li>\r\n		<li>Proin suscipit, justo sit amet tristique ultrices, ex magna efficitur lectus, at rutrum dui ex id nulla</li>\r\n		<li>Integer in elementum risus. Fusce nec metus leo.</li>\r\n		<li>Quisque vel pretium neque. Proin hendrerit, ante molestie eleifend mattis, tellus nunc elementum felis</li>\r\n		<li>Sollicitudin sapien magna quis est. Quisque non vestibulum libero</li>\r\n	</ul>\r\n	</div>\r\n	</div>\r\n	</li>\r\n</ul>\r\n</div>\r\n</section>\r\n</div>\r\n\r\n<div class="col-md-3">\r\n<h4 class="text-bold text-bold text-black text-med m-t-0 m-b-30">Â </h4>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n');
/*!40000 ALTER TABLE `page_tab` ENABLE KEYS */;

-- Dumping structure for table db_swissair.seo
CREATE TABLE IF NOT EXISTS `seo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `meta_title` text,
  `meta_keywords` text,
  `meta_description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `seo_url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.seo: ~0 rows (approximately)
DELETE FROM `seo`;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
INSERT INTO `seo` (`id`, `url`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
	(1, '/news/pt-filtration-specialist', 'PT Filtration Specialist', 'oil, air, filter', 'filtration special in oil filter, air filter, etc');
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;

-- Dumping structure for table db_swissair.subscriber
CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.subscriber: ~0 rows (approximately)
DELETE FROM `subscriber`;
/*!40000 ALTER TABLE `subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscriber` ENABLE KEYS */;

-- Dumping structure for table db_swissair.testimonial
CREATE TABLE IF NOT EXISTS `testimonial` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.testimonial: ~2 rows (approximately)
DELETE FROM `testimonial`;
/*!40000 ALTER TABLE `testimonial` DISABLE KEYS */;
INSERT INTO `testimonial` (`id`, `language`, `name`, `description`, `picture`, `active`) VALUES
	(1, 'en', '{"en":"San San"}', '{"en":"I just wanted to say i am very happy with your air purifier system. I just ordered an Air Purifier Filter system, and yesterday, I installed it with no complications! This compact easy to install system has impressed me!"}', 'logo-s_1.png', 1),
	(2, 'en', '{"en":"Daniel. S"}', '{"en":"I  wanted to thank you  for providing excellent customer service... Your the best!  The system arrived undamaged and all parts are functioning properly:) "}', 'logo.png', 1);
/*!40000 ALTER TABLE `testimonial` ENABLE KEYS */;

-- Dumping structure for table db_swissair.video
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL,
  `date` datetime DEFAULT NULL,
  `date_closed` datetime DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_page` (`language`,`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.video: ~0 rows (approximately)
DELETE FROM `video`;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
/*!40000 ALTER TABLE `video` ENABLE KEYS */;

-- Dumping structure for table db_swissair.video_subscriber
CREATE TABLE IF NOT EXISTS `video_subscriber` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table db_swissair.video_subscriber: ~0 rows (approximately)
DELETE FROM `video_subscriber`;
/*!40000 ALTER TABLE `video_subscriber` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_subscriber` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
