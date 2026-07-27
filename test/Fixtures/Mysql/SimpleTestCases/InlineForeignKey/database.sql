CREATE TABLE `user` (
  `id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `post` (
  `id` int(10) NOT NULL,
  `author_id` int(10) NOT NULL,
  `editor_id` int(10) NOT NULL REFERENCES `user` (`id`),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
