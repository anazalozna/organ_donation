-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `link` varchar(60) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `active` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `admin_menu_admin_menu_id_fk` (`parent`),
  CONSTRAINT `admin_menu_admin_menu_id_fk` FOREIGN KEY (`parent`) REFERENCES `admin_menu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin_menu` (`id`, `name`, `link`, `parent`, `sort`, `active`) VALUES
(1,	'Main',	'/admin',	NULL,	0,	1),
(2,	'Users',	'/admin/users',	NULL,	0,	1),
(3,	'Logout',	'/admin/logout',	NULL,	99,	1),
(4,	'Change',	'/admin/user/change',	NULL,	0,	1),
(5,	'Pages',	'/admin/pages',	NULL,	0,	1);

DROP TABLE IF EXISTS `admin_menu_roles`;
CREATE TABLE `admin_menu_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_menu_roles_admin_menu_id_fk` (`menu_id`),
  KEY `admin_menu_roles_roles_id_fk` (`role_id`),
  CONSTRAINT `admin_menu_roles_admin_menu_id_fk` FOREIGN KEY (`menu_id`) REFERENCES `admin_menu` (`id`),
  CONSTRAINT `admin_menu_roles_roles_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin_menu_roles` (`id`, `menu_id`, `role_id`) VALUES
(1,	1,	1),
(2,	2,	1),
(3,	3,	1),
(4,	4,	1),
(5,	1,	2),
(6,	3,	2),
(7,	4,	2),
(8,	5,	1);

DROP TABLE IF EXISTS `login_log`;
CREATE TABLE `login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(60) DEFAULT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(30) NOT NULL,
  `success` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `login_log` (`id`, `login`, `date`, `ip`, `success`) VALUES
(1,	'ana',	'2017-02-20 13:43:01',	'127.0.0.1',	1),
(2,	'ana',	'2017-02-20 13:44:03',	'127.0.0.1',	1),
(3,	'ana',	'2017-02-20 14:56:10',	'127.0.0.1',	1),
(4,	'ana',	'2017-02-20 17:24:42',	'127.0.0.1',	1),
(5,	'ana',	'2017-02-20 21:45:59',	'127.0.0.1',	1),
(6,	'ana',	'2017-02-23 20:06:09',	'127.0.0.1',	1),
(7,	'ana',	'2017-02-23 20:06:33',	'127.0.0.1',	1),
(8,	'ana',	'2017-03-07 14:20:24',	'172.27.0.1',	0),
(9,	'ana',	'2017-03-07 14:20:39',	'172.27.0.1',	0),
(10,	'ana',	'2017-03-07 14:20:46',	'172.27.0.1',	0),
(11,	'ana',	'2017-03-07 14:21:52',	'172.27.0.1',	0),
(12,	'ana',	'2017-03-07 14:22:03',	'172.27.0.1',	0),
(13,	'ana',	'2017-03-07 14:22:11',	'172.27.0.1',	1),
(14,	'ana',	'2017-03-08 11:50:17',	'172.27.0.1',	1),
(15,	'argonavt',	'2017-03-09 13:43:18',	'172.27.0.1',	0),
(16,	'ana',	'2017-03-09 13:43:25',	'172.27.0.1',	1),
(17,	'ana',	'2017-03-10 12:29:57',	'172.27.0.1',	1),
(18,	'ana',	'2017-03-10 15:55:22',	'172.27.0.1',	1),
(19,	'ana',	'2017-03-14 12:37:09',	'172.27.0.1',	1),
(20,	'ana',	'2017-03-14 13:44:14',	'172.27.0.1',	1),
(21,	'argonavt',	'2017-03-14 20:55:02',	'172.27.0.1',	0),
(22,	'ana',	'2017-03-14 20:55:19',	'172.27.0.1',	1),
(23,	'argonavt',	'2017-03-24 15:01:39',	'172.29.0.1',	0),
(24,	'ana',	'2017-03-24 15:01:44',	'172.29.0.1',	1),
(25,	'ana',	'2017-03-24 17:04:12',	'172.29.0.1',	1),
(26,	'ana',	'2017-03-24 19:50:08',	'127.0.0.1',	1),
(27,	'ana',	'2017-03-24 19:51:13',	'127.0.0.1',	1),
(28,	'ana',	'2017-03-28 18:55:26',	'127.0.0.1',	1);

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  `alias` varchar(250) DEFAULT NULL,
  `main_title` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_alias_uindex` (`alias`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pages` (`id`, `content`, `alias`, `main_title`) VALUES
(1,	'<section class=\"content_main\">\r\n<h2 class=\"hide\">Main Container</h2>\r\n<div class=\"slider_h\">\r\n<div class=\"slider_cont\">\r\n<p><strong>1</strong> = <span>8</span></p>\r\n<h2 class=\"title_h2\">Be a Donor</h2>\r\n<a class=\"btn_more\" href=\"https://beadonor.ca/\">Register</a></div>\r\n<div class=\"all_slides\">             <div class=\"slide_1 slide\"></div>\r\n                                        <div class=\"slide_2 slide\"></div>\r\n                                        <div class=\"slide_3 slide\"></div></div>\r\n                                        \r\n                                        \r\n            <a href=\"#\" class=\"slider_arrow\" id=\"prev_slide\"><i class=\"fa fa-chevron-left\"></i></a>\r\n            <a href=\"#\" class=\"slider_arrow\" id=\"next_slide\"><i class=\"fa fa-chevron-right\"></i></a></div>\r\n            \r\n            \r\n            \r\n<section class=\"faq_block\">\r\n<h2 class=\"title_h2\">Frequently Asked Questions</h2>\r\n<div class=\"flex_faq\">\r\n<div class=\"flex_item transform_Y\">\r\n<h3 class=\"title_h3\">What organs and tissue can be donated?</h3>\r\n</div>\r\n<div class=\"flex_item transform_Y\">\r\n<h3 class=\"title_h3\">Why should I register as an organ and tissue donor?</h3>\r\n</div>\r\n<div class=\"flex_item transform_Y\">\r\n<h3 class=\"title_h3\">What does it mean to consent to donate organs and tissue for research?</h3>\r\n</div>\r\n                <a href=\"faq.php\" class=\"flex_item transform_Y\">\r\n                    <span>See Answers</span>\r\n                </a></div>\r\n</section>\r\n<section class=\"about_block\">\r\n<h2 class=\"hide\">About Donation Block</h2>\r\n<div class=\"about_text wrapper_small\">\r\n<h2 class=\"title_h2\">About Donation</h2>\r\n<p>Today, in Ontario, there are over 1,500 people waiting for a lifesaving organ transplant. This is their only treatment option, and every 3 days someone will die because they did not get their transplant in time.</p>\r\n<a class=\"btn_more\" href=\"/page/about-donation\">Read More</a></div>\r\n</section>\r\n<section id=\"videos\" class=\"videos_block\">\r\n<h2 class=\"title_h2\">Videos</h2>\r\n<div class=\"flex_videos wrapper\">\r\n<div class=\"flex_item\"><iframe src=\"https://www.youtube.com/embed/1Oh3788w-tk\" frameborder=\"0\" allowfullscreen=\"\"></iframe></div>\r\n<div class=\"flex_item\"><iframe src=\"https://www.youtube.com/embed/u8KPFGABBYo\" frameborder=\"0\" allowfullscreen=\"\"></iframe></div>\r\n<div class=\"flex_item\"><iframe src=\"https://www.youtube.com/embed/7VCEYkhzxIE\" frameborder=\"0\" allowfullscreen=\"\"></iframe></div>\r\n</div>\r\n</section>\r\n<section class=\"map\">\r\n<h2 class=\"hide\">Map</h2>\r\n<iframe style=\"border: 0;\" src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6188308.761657769!2d-88.32174491779413!3d50.44329566264599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4cce05b25f5113af%3A0x70f8425629621e09!2sOntario!5e0!3m2!1sen!2sca!4v1486990715736\" frameborder=\"0\" allowfullscreen=\"\"></iframe></section>\r\n</section>',	'home',	'Home Page'),
(9,	'<section class=\"content_main\">\n		<h2 class=\"hide\">Main Container</h2>\n        <section class=\"about_main\">\n            <div class=\"about_intro\">\n                <div class=\"wrapper_small\">\n                    <h2 class=\"title_h2\">Organ and Tissue Donation: The Facts</h2>\n                    <p>Today, in Ontario, there are over 1,500 people waiting for a lifesaving organ transplant. This is their only treatment option, and every 3 days someone will die because they did not get their transplant in time.</p>\n                    <p>But you can help. When you register your consent for organ and tissue donation, you let those waiting know that you would help them if you could.</p>\n                </div>\n            </div>\n            <div class=\"about_facts\">\n                <div class=\"wrapper flex_facts\">\n                    <div class=\"flex_item\">\n                        <p><strong>One donor can save up to 8 lives</strong> through organ donation and enhance the lives of up to 75 more through the gift of tissue.</p>\n                    </div>\n                    <div class=\"flex_item\">\n                        <p><strong>Age alone does not disqualify someone from becoming a donor.</strong> The oldest organ donor was over 90 and the oldest tissue donor was over 100. There’s always potential to be a donor; it shouldn’t stop you from registering.</p>\n                    </div>\n                    <div class=\"flex_item\">\n                        <p><strong>Your current or past medical history does not prevent you from registering to be a donor.</strong> Individuals with serious illnesses can, sometimes, be organ and/or tissue donors. Each potential donor is evaluated on a case-by-case basis.</p>\n                    </div>\n                    <div class=\"flex_item\">\n                        <p><strong>All major religions support organ and tissue donation,</strong> or respect an individual’s choice.</p>\n                        <p><strong>Organ and tissue donation does not impact funeral plans.</strong> An open casket funeral is possible.</p>\n                    </div>\n                </div>\n            </div>\n            <div class=\"organs_block\">\n                <div class=\"wrapper_small flex_organs\">\n                    <div class=\"flex_item organ_img_item transform_X_left\">\n                        <div class=\"organ_img\">\n                            <img src=\"/static/img/heart.svg\" alt=\"Heart Image\" title=\"Heart Image\">\n                        </div>\n                    </div>\n                    <div class=\"flex_item transform_X_right\">\n                        <h2 class=\"title_h2\">Heart</h2>\n                        <p>Most heart recipients return to full and active lives, and almost 75% of transplanted hearts are functioning after five years.</p>\n                        <p>Every year about 600 people die while waiting for a heart. Because the number of donated hearts is limited, many paople are never placed on the waiting list.</p>\n                    </div>\n\n                    <div class=\"flex_item transform_X_left\">\n                        <h2 class=\"title_h2\">Lung</h2>\n                        <p>The primary condition leading to lung transplantation is chronic obstructive pulmonary disease, a term describing airflow obstruction associated primarily with emphysema and chronic bronchitis.</p>\n                        <p>Other conditions that can generate a need for new lungs are idiopathic pulmonary fibrosis, cystic fibrosis, and primary pulmonary hypertension.</p>\n                    </div>\n                    <div class=\"flex_item organ_img_item transform_X_right\">\n                        <div class=\"organ_img\">\n                            <img src=\"/static/img/lungs.svg\" alt=\"Lung Image\" title=\"Lung Image\">\n                        </div>\n                    </div>\n\n                    <div class=\"flex_item organ_img_item transform_X_left\">\n                        <div class=\"organ_img\">\n                            <img src=\"/static/img/liver.svg\" alt=\"Liver Image\" title=\"Liver Image\">\n                        </div>\n                    </div>\n                    <div class=\"flex_item transform_X_right\">\n                        <h2 class=\"title_h2\">Liver</h2>\n                        <p>The principal cause of liver failure leading to transplantation are viral infections like Hepatitis C, genetic disorders, and alcoholism.</p>\n                        <p>Scar tissue blocks the flow of blood, preventing the liver from functioning properly.</p>\n                    </div>\n\n                    <div class=\"flex_item transform_X_left\">\n                        <h2 class=\"title_h2\">Kidney</h2>\n                        <p>Common causes of kidney failure include diabetes, high blood pressure, as well as diseases.</p>\n                        <p>Many of them inherited, which damage the nephrons and other fragile structures deep within the kidney.</p>\n                    </div>\n                    <div class=\"flex_item organ_img_item transform_X_right\">\n                        <div class=\"organ_img\">\n                            <img src=\"/static/img/kidneys.svg\" alt=\"Kidney Image\" title=\"Kidney Image\">\n                        </div>\n                    </div>\n\n                    <div class=\"flex_item organ_img_item transform_X_left\">\n                        <div class=\"organ_img\">\n                            <img src=\"/static/img/pancreas.svg\" alt=\"Pancreas Image\" title=\"Pancreas Image\">\n                        </div>\n                    </div>\n                    <div class=\"flex_item transform_X_right\">\n                        <h2 class=\"title_h2\">Pancreas</h2>\n                        <p>Type 1 diabetes - is the most common disease leading to pancreas transplantation, which can free the recepient from dependence on daily insulin injections.</p>\n                    </div>\n\n                    <div class=\"flex_item transform_X_left\">\n                        <h2 class=\"title_h2\">Intestine</h2>\n                        <p>The most common reason leading to transplantation is short bowel syndrome resulting from tumors, Chron\'s and other inflammatory bowel diseases, congenital defects, trauma and other causes. </p>\n                    </div>\n                    <div class=\"flex_item organ_img_item transform_X_right\">\n                        <div class=\"organ_img\">\n                            <img src=\"/static/img/intestine.svg\" alt=\"Intestine Image\" title=\"Intestine Image\">\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </section>',	'about-donation',	'About Donation Page'),
(10,	'<section class=\"content_main\">\n		<h2 class=\"hide\">Main Container</h2>\n        <section class=\"faq_main\">\n            <h2 class=\"title_h2\">Frequently Asked Questions</h2>\n            <div class=\"wrapper_small\">\n                <div class=\"faq_box\">\n                    <h3 class=\"title_h3 faq_question\">What organs and tissue can be donated?</h3>\n                    <div class=\"faq_answer opacity_anim\">\n                        <p>Organs and tissue that can be donated include the heart, kidneys, liver, lungs, pancreas, small intestines, eyes, bone, skin, and heart valves.</p>\n                    </div>\n                </div>\n                <div class=\"faq_box\">\n                    <h3 class=\"title_h3 faq_question\">Does my age, medical condition, or sexual orientation prevent me from being a donor?</h3>\n                    <div class=\"faq_answer opacity_anim\">\n                        <p>Everyone is a potential donor regardless of age, medical condition or sexual orientation. The oldest Canadian organ donor was 92 and the oldest tissue donor was 104. Even individuals with serious illnesses can sometimes be donors. Your decision to register should not be based on whether you think you would be eligible or not. All potential donors are evaluated on an individual, medical, case-by-case basis.</p>\n                    </div>\n                </div>\n                <div class=\"faq_box\">\n                    <h3 class=\"title_h3 faq_question\">Why should I register as an organ and tissue donor?</h3>\n                    <div class=\"faq_answer opacity_anim\">\n                        <p>By registering consent for organ and tissue donation, you give hope to the thousands of Ontarians waiting for a transplant. Individuals on the transplant wait list are suffering from organ failure and without the generous gift of life from an organ donor, they will die. Tissue donors can also enhance the lives of recovering burn victims, help restore sight, and allow people to walk again. Transplants not only save lives, they return recipients to productive lives.</p>\n                    </div>\n                </div>\n                <div class=\"faq_box\">\n                    <h3 class=\"title_h3 faq_question\">Does my religion support organ and tissue donation?</h3>\n                    <div class=\"faq_answer opacity_anim\">\n                        <p>Most major religions support organ and tissue donation because it can save the life of another. If your religion restricts the use of a body after death, consult your religious leader: these restrictions may not include organ and tissue donation, if the donation could save another life. More information can be found <a href=\"https://www.giftoflife.on.ca/en/community.htm\">here</a>.</p>\n                    </div>\n                </div>\n                <div class=\"faq_box\">\n                    <h3 class=\"title_h3 faq_question\">What does it mean to consent to donate organs and tissue for research?</h3>\n                    <div class=\"faq_answer opacity_anim\">\n                        <p>Organs or tissue not suitable for transplantation can be used for organ and tissue research (if indicated by donor upon registration). This research is specific to the field of organ and tissue donation, and is not the same as whole body donation.</p>\n                    </div>\n                </div>\n            </div>\n        </section>',	'faq',	'Frequently Asked Questions Page');

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_uindex` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `roles` (`id`, `name`) VALUES
(1,	'Admin'),
(2,	'User');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(30) NOT NULL,
  `mail` varchar(90) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `creation_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_uindex` (`login`),
  UNIQUE KEY `users_mail_uindex` (`mail`),
  KEY `users_roles_id_fk` (`role`),
  CONSTRAINT `users_roles_id_fk` FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `login`, `mail`, `pass`, `role`, `creation_datetime`) VALUES
(2,	'ana',	'nasia.nana@gmail.com',	'$2y$10$qHYOfD9npLusbEklOxDhFOUeIH7aFtMx3lp5DUVDK5O8HEpC/aPf2',	1,	'2017-02-20 13:09:08');

-- 2017-03-30 17:25:19
