CREATE TABLE `user` (
  `id` int(10) unsigned not null,
  `email` varchar(64) collate latin1_general_ci not null,
  `password` varchar(32) collate latin1_general_ci not null,
  `nick` varchar(16) collate latin1_general_ci default null,
  `status` enum('enabled','disabled') collate latin1_general_ci default null,
  `admin` bit(1) default null,
  `geom` geometry not null,
  `created_at` datetime default null,
  `updated_at` datetime default current_timestamp on update current_timestamp,
  primary key (`id`),
  unique key `iu_email_password` (`nick`),
  unique key `iuh_email_password` (`nick`) using hash,
  unique key `iub_email_password` (`nick`) using btree,
  key `i_password` (`password`),
  key `ih_password` (`password`) using hash,
  key `ib_password` (`password`) using btree,
  fulltext key `if_email_password` (`email`,`password`)
) engine=InnoDB default charset=latin1 collate=latin1_general_ci;
