--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT ''1'',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_message$use$user_id_idx` (`user_id`),
  CONSTRAINT `fk_message$use$user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `apikey` varchar(100) NOT NULL,
  `active` tinyint(3) unsigned NOT NULL DEFAULT ''1'',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
INSERT  IGNORE INTO `users` VALUES (1,''User 1'',''user1@user.com.br'',''$2y$10$81JksrkLkrRSTEDoGlM.9uMrXgQT4eKmLdtytnUlJphqKfG6WZGOW'',''356a192b7913b04c54574d18c28d46e6395428ab'',1,NULL,NULL),(2,''User 2'',''user2@user.com.br'',''$2y$10$81JksrkLkrRSTEDoGlM.9uMrXgQT4eKmLdtytnUlJphqKfG6WZGOW'',''da4b9237bacccdf19c0760cab7aec4a8359010b0'',1,NULL,NULL),(3,''User 3'',''user3@user.com.br'',''$2y$10$81JksrkLkrRSTEDoGlM.9uMrXgQT4eKmLdtytnUlJphqKfG6WZGOW'',''77de68daecd823babbb58edb1c8e14d7106e83bb'',1,NULL,NULL),(4,''User 4'',''user4@user.com.br'',''$2y$10$81JksrkLkrRSTEDoGlM.9uMrXgQT4eKmLdtytnUlJphqKfG6WZGOW'',''1b6453892473a467d07372d45eb05abc2031647a'',1,NULL,NULL);
UNLOCK TABLES;
