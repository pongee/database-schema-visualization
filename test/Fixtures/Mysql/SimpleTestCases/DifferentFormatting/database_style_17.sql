CREATE TABLE
 IF NOT EXISTS
   user (
      `id`
        INT ( 10 )
        UNSIGNED
        NOT NULL,
      `email`
        VARCHAR ( 64 )
        COLLATE
        latin1_general_ci
        NOT NULL,
      `password`
        VARCHAR ( 32 )
        COLLATE
        latin1_general_ci
        NOT NULL,
      `nick`
        VARCHAR ( 16 )
        COLLATE
        latin1_general_ci
        DEFAULT NULL,
      `status`
        ENUM('enabled', 'disabled')
        COLLATE
        latin1_general_ci
        DEFAULT NULL,
      `admin`
        BIT NULL,
      `geom`
        GEOMETRY
        NOT NULL,
      `created_at`
        DATETIME
        NULL,
      `updated_at`
        DATETIME
        NULL
        DEFAULT
          CURRENT_TIMESTAMP
        ON UPDATE
          CURRENT_TIMESTAMP,
      PRIMARY KEY
        (`id`),
      INDEX
        i_password
        ( `password` ),
      INDEX
        ih_password
        ( `password` )
        USING
         HASH,
      INDEX
        ib_password
        ( `password` )
        USING
          BTREE,
      FULLTEXT KEY
        if_email_password
        ( `email`, `password` ),
      UNIQUE KEY
        iu_email_password
        ( `nick` ),
      UNIQUE KEY
        iuh_email_password
        ( `nick` )
        USING HASH,
      UNIQUE KEY
        iub_email_password
        ( `nick` )
        USING BTREE
    )
    engine = innodb
    DEFAULT charset = latin1
    COLLATE = latin1_general_ci;
