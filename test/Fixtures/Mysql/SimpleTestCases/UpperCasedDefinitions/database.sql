CREATE TABLE `user` (
  `id` INT(10) UNSIGNED NOT NULL,
  `email` VARCHAR(64) COLLATE latin1_general_ci NOT NULL,
  `password` VARCHAR(32) COLLATE latin1_general_ci NOT NULL,
  `nick` VARCHAR(16) COLLATE latin1_general_ci DEFAULT NULL,
  `status` ENUM('enabled','disabled') COLLATE latin1_general_ci DEFAULT NULL,
  `admin` BIT(1) DEFAULT NULL,
  `geom` GEOMETRY NOT NULL,
  `created_at` DATETIME DEFAULT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `iu_email_password` (`nick`),
  UNIQUE KEY `iuh_email_password` (`nick`) USING HASH,
  UNIQUE KEY `iub_email_password` (`nick`) USING BTREE,
  KEY `i_password` (`password`),
  KEY `ih_password` (`password`) USING HASH,
  KEY `ib_password` (`password`) USING BTREE,
  FULLTEXT KEY `if_email_password` (`email`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci
