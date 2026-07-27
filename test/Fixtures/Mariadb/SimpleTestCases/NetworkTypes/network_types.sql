CREATE TABLE `device` (
  `id` UUID NOT NULL,
  `hostname` varchar(255) NOT NULL,
  `ipv4` INET4 DEFAULT NULL,
  `ipv6` INET6 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_hostname` (`hostname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `device_interface` (
  `id` UUID NOT NULL,
  `device_id` UUID NOT NULL,
  `address` INET6 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_device_id` (`device_id`),
  CONSTRAINT `fk_device_id` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
