CREATE TABLE `note` (
  `id` int(10) unsigned NOT NULL,
  `body` varchar(255) NOT NULL COMMENT 'it''s a note',
  `label` varchar(64) DEFAULT NULL COMMENT 'a\'b',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
