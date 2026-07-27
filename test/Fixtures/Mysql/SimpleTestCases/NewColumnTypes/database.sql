CREATE TABLE `metrics` (
  `id` SERIAL,
  `score` NUMERIC(10,2) NOT NULL,
  `ratio` REAL NOT NULL,
  `amount` DEC(8,2) NOT NULL,
  `weight` FIXED(6,3) NOT NULL,
  `tiny_flag` INT1 NOT NULL,
  `big_value` INT8 NOT NULL,
  `area` GEOMETRYCOLLECTION NOT NULL,
  `embedding` VECTOR(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
