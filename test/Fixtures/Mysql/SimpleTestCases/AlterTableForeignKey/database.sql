CREATE TABLE `user` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `log_user_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `log`
  ADD CONSTRAINT `FK_log_user_id` FOREIGN KEY (`log_user_id`) REFERENCES `user` (`user_id`);
