
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of category table (Auto increment)',
  `category` varchar(128) NOT NULL COMMENT 'category name',
  `status` char(1) NOT NULL DEFAULT 't' COMMENT 't = true(Auto), f = false, status of categories',
  `created` datetime NOT NULL COMMENT 'when categories created, current timestamp',
  `modified` datetime NOT NULL COMMENT 'when categories updated, current timestamp',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'categories will be enable/disable. 1 = enable(Auto), 0 = disable.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table is used to list categories.' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` VALUES(1, 'cat_one', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(2, 'cat_two', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(3, 'cat_three', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(4, 'cat_four', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(5, 'cat_five', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(6, 'cat_six', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(7, 'cat_seven', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(8, 'cat_eight', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(9, 'cat_nine', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);
INSERT INTO `categories` VALUES(10, 'cat_ten', 't', '2016-02-14 22:47:18', '2016-02-14 22:47:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_person`
--

CREATE TABLE `contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of contact_person table (Auto increment)',
  `first_name` varchar(64) NOT NULL COMMENT 'first name of contact person',
  `last_name` varchar(64) NOT NULL COMMENT 'last name of contact person',
  `designation` varchar(255) NOT NULL COMMENT 'designation of contact_person',
  `contact_one` varchar(64) NOT NULL COMMENT 'contact one of contact_person',
  `contact_two` varchar(64) NOT NULL COMMENT 'contact two of contact_person',
  `email` varchar(255) NOT NULL COMMENT 'email id of contact person',
  `meeting_outcome` text NOT NULL,
  `next_step` text NOT NULL,
  `misc_detail` text NOT NULL COMMENT 'other details of customer',
  `customers_id` int(11) NOT NULL COMMENT 'id of customer table',
  PRIMARY KEY (`id`),
  KEY `fk_contact_person_customers1_idx` (`customers_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table is used to create muliple contact person details.' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contact_person`
--

INSERT INTO `contact_person` VALUES(1, 'Ram', 'kumar', 'software developer', '123456789', '987654321', 'ramsingh@gmail.com', 'nothing', 'no step', 'no misc details', 1);
INSERT INTO `contact_person` VALUES(2, 'karam', 'kumar', 'software tester', '5566447789', '9988775528', 'karamkumar@gmail.com', 'no metting for karam', 'no next step for karam', 'no misg details for karam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of customers table (Auto increment)',
  `name` varchar(255) DEFAULT NULL COMMENT 'name of customer',
  `address_one` text COMMENT 'address one of customer',
  `address_two` text COMMENT 'address two of customer',
  `state` varchar(255) DEFAULT NULL COMMENT 'state of customer',
  `city` varchar(45) DEFAULT NULL COMMENT 'city of customer',
  `ticket_no` varchar(255) DEFAULT NULL,
  `entry_time` datetime DEFAULT NULL COMMENT 'entry time of meeting',
  `initiated_by` varchar(64) DEFAULT NULL COMMENT 'Manager of sale person',
  `meeting_trigger` varchar(255) DEFAULT NULL,
  `meeting_type` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'duration of meeting',
  `req_created` text,
  `status` char(1) NOT NULL DEFAULT 't' COMMENT 't = true f = false(Auto), status of customer',
  `created` datetime NOT NULL COMMENT 'when customer created current timestamp',
  `modified` datetime NOT NULL COMMENT 'when customer updated current timestamp',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'customer will be enable/disable. 1 = enable(Auto), 0 = disable.',
  `logins_id` int(11) NOT NULL COMMENT 'Sale person (id of login table)',
  `objectives_id` int(11) NOT NULL COMMENT 'id of objecrtive table',
  `opposite_size_id` int(11) NOT NULL COMMENT 'id of opposite size table',
  `categories_id` int(11) NOT NULL COMMENT 'id of categories table',
  `customer_type_id` int(11) NOT NULL COMMENT 'id of customer_type table',
  PRIMARY KEY (`id`),
  KEY `fk_customers_logins1_idx` (`logins_id`),
  KEY `fk_customers_customer_type1_idx` (`customer_type_id`),
  KEY `fk_customers_objectives1_idx` (`objectives_id`),
  KEY `fk_customers_opposite_size1_idx` (`opposite_size_id`),
  KEY `fk_customers_categories1_idx` (`categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table is used to provide details of customers.' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` VALUES(1, 'royal enfied', 'SCO 280, Opposite Nirman Cinema, 32D, Sector 32', NULL, 'chandigarh', 'chandigarh', NULL, '2016-02-14 02:09:15', 'Mohan singh', NULL, NULL, 45, NULL, 't', '2016-02-14 23:05:25', '2016-02-14 23:05:25', 1, 1, 2, 6, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of customer_type table (Auto increment)',
  `type` varchar(128) NOT NULL COMMENT 'customer type',
  `status` char(1) NOT NULL DEFAULT 't' COMMENT 't = true(Auto), f = false, status of customer_type',
  `created` datetime NOT NULL COMMENT 'when customer_type created, current timestamp',
  `modified` datetime NOT NULL COMMENT 'when customer_type updated, current timestamp',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'customer_type will be enable/disable. 1 = enable(Auto), 0 = disable.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table is used to list customer_types.' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` VALUES(1, 'private limited', 't', '2016-02-14 22:45:58', '2016-02-14 22:45:58', 1);
INSERT INTO `customer_type` VALUES(2, 'LLB', 't', '2016-02-14 22:45:58', '2016-02-14 22:45:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of logins table (Auto increment)',
  `username` varchar(64) NOT NULL COMMENT 'username of user (Display name)',
  `password` varchar(255) NOT NULL COMMENT 'password of user encrypted',
  `status` char(1) NOT NULL DEFAULT 'f' COMMENT 't = true f = false(Auto) status of user',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'user will be enable/disable. 1 = enable(Auto), 0 = disable.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Logins table is used to stroe username/password of user.' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` VALUES(1, 'testone', 'dea404003c3a80819f73187842f5d1de', 't', 1);
INSERT INTO `logins` VALUES(2, 'dummyone', 'eebd8ecbb577653d983ad32577efcbba', 't', 1);

-- --------------------------------------------------------

--
-- Table structure for table `objectives`
--

CREATE TABLE `objectives` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of objectives table (Auto increment)',
  `objective` varchar(128) NOT NULL COMMENT 'objective name',
  `status` char(1) NOT NULL DEFAULT 't' COMMENT 't = true(Auto), f = false, status of objective',
  `created` datetime NOT NULL COMMENT 'when objective created, current timestamp',
  `modified` datetime NOT NULL COMMENT 'when objective updated, current timestamp',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'objective will be enable/disable. 1 = enable(Auto), 0 = disable.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table is used to list objectives.' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `objectives`
--

INSERT INTO `objectives` VALUES(1, 'object_one', 't', '2016-02-14 22:42:31', '2016-02-14 22:42:31', 1);
INSERT INTO `objectives` VALUES(2, 'object_two', 't', '2016-02-14 22:42:31', '2016-02-14 22:42:31', 1);
INSERT INTO `objectives` VALUES(3, 'object_three', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(4, 'object_four', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(5, 'object_five', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(6, 'object_six', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(7, 'object_seven', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(8, 'object_eight', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(9, 'object_nine', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);
INSERT INTO `objectives` VALUES(10, 'object_ten', 't', '2016-02-14 22:43:32', '2016-02-14 22:43:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `opposite_size`
--

CREATE TABLE `opposite_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of opposite_size table (Auto increment)',
  `size` varchar(128) NOT NULL COMMENT 'opposite size',
  `status` char(1) NOT NULL DEFAULT 't' COMMENT 't = true(Auto), f = false, status of opposite_size',
  `created` datetime NOT NULL COMMENT 'when opposite_size created, current timestamp',
  `modified` datetime NOT NULL COMMENT 'when opposite_size updated, current timestamp',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT 'opposite_size will be enable/disable. 1 = enable(Auto), 0 = disable.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table is used to list opposite_size.' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `opposite_size`
--

INSERT INTO `opposite_size` VALUES(1, 'size_one', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(2, 'size_two', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(3, 'size_three', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(4, 'size_four', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(5, 'size_five', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(6, 'size_six', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(7, 'size_seven', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(8, 'size_eight', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(9, 'size_nine', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);
INSERT INTO `opposite_size` VALUES(10, 'size_ten', 't', '2016-02-14 22:44:58', '2016-02-14 22:44:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of users table (Auto increment)',
  `der_no` varchar(255) DEFAULT NULL COMMENT 'a unique no generated by programming',
  `email` varchar(255) DEFAULT NULL COMMENT 'email id of user',
  `first_name` varchar(64) DEFAULT NULL COMMENT 'first name of user',
  `last_name` varchar(64) DEFAULT NULL COMMENT 'last name of user',
  `profile_image` varchar(255) DEFAULT NULL COMMENT 'image of user',
  `contact` varchar(64) DEFAULT NULL COMMENT 'contact number of user',
  `state` varchar(64) DEFAULT NULL COMMENT 'state of user',
  `city` varchar(64) DEFAULT NULL COMMENT 'city of user',
  `address_one` text COMMENT 'address one of user',
  `address_two` text COMMENT 'address two of user',
  `device_id` varchar(255) DEFAULT NULL COMMENT 'imei number of mobile or application',
  `token` varchar(255) DEFAULT NULL,
  `server_name` varchar(128) DEFAULT NULL COMMENT 'server name for security purpose',
  `server_add` varchar(128) DEFAULT NULL COMMENT 'server address for security purpose',
  `browser` varchar(255) DEFAULT NULL COMMENT 'browser name',
  `created` datetime NOT NULL COMMENT 'when user created current timestamp',
  `modified` datetime NOT NULL COMMENT 'when user updated current timestamp',
  `logins_id` int(11) NOT NULL COMMENT 'id of logins table',
  PRIMARY KEY (`id`,`logins_id`),
  UNIQUE KEY `der_no_UNIQUE` (`der_no`),
  KEY `fk_users_logins_idx` (`logins_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='users table is used to store other information of user.' AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, '777_51', 'test@gmail.com', 'test', 'one', NULL, '999999999', 'haryana', 'chandigarh', 'Dummy Address one', 'Dummy Address two', NULL, NULL, 'kalco.com', '127.0.0.1', NULL, '2016-02-14 22:50:36', '2016-02-14 22:50:36', 1);
INSERT INTO `users` VALUES(2, '777_52', 'dummy@gmail.com', 'dummy', 'one', NULL, '123456789', 'haryana', 'ambala', 'dummy address one', 'dummy address two', NULL, NULL, 'kalco.com', '127.0.0.1', NULL, '2016-02-14 22:52:01', '2016-02-14 22:52:01', 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_person`
--
ALTER TABLE `contact_person`
  ADD CONSTRAINT `fk_contact_person_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customers_customer_type1` FOREIGN KEY (`customer_type_id`) REFERENCES `customer_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customers_logins1` FOREIGN KEY (`logins_id`) REFERENCES `logins` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customers_objectives1` FOREIGN KEY (`objectives_id`) REFERENCES `objectives` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_customers_opposite_size1` FOREIGN KEY (`opposite_size_id`) REFERENCES `opposite_size` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_logins` FOREIGN KEY (`logins_id`) REFERENCES `logins` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

