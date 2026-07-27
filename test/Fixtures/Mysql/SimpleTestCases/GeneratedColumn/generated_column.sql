CREATE TABLE `invoice` (
  `price` decimal(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `total` decimal(12,2) AS (`price` * `qty`) STORED,
  `summary` varchar(50) AS (CONCAT(`price`, `qty`)) VIRTUAL,
  `bumped` int(11) GENERATED ALWAYS AS (`qty` + 1) STORED,
  PRIMARY KEY (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
