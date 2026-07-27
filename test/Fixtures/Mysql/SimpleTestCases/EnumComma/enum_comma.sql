CREATE TABLE `ticket` (
  `id` int(10) unsigned NOT NULL,
  `status` enum('active','on,hold','closed') NOT NULL,
  `tags` set('a,b','c') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
