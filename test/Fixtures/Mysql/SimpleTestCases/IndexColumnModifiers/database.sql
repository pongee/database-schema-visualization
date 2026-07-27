CREATE TABLE `post` (
  `id` int(10) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `views` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_slug` (`slug`(10)),
  KEY `idx_slug_title` (`slug`(10), `title`),
  KEY `idx_views` (`views` DESC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
