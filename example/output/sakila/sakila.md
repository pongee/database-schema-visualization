# Schema

## `actor` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| actor_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| first_name | VARCHAR ( 45 ) | NOT NULL | - |
| last_name | VARCHAR ( 45 ) | NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| actor_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_actor_last_name | last_name | - |

## `address` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| address_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| address | VARCHAR ( 50 ) | NOT NULL | - |
| address2 | VARCHAR ( 50 ) | DEFAULT NULL | - |
| district | VARCHAR ( 20 ) | NOT NULL | - |
| city_id | SMALLINT | UNSIGNED NOT NULL | - |
| postal_code | VARCHAR ( 10 ) | DEFAULT NULL | - |
| phone | VARCHAR ( 20 ) | NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| address_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_city_id | city_id | - |

## `category` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| category_id | TINYINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| name | VARCHAR ( 25 ) | NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| category_id | - |

## `city` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| city_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| city | VARCHAR ( 50 ) | NOT NULL | - |
| country_id | SMALLINT | UNSIGNED NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| city_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_country_id | country_id | - |

## `country` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| country_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| country | VARCHAR ( 50 ) | NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| country_id | - |

## `customer` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| customer_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| store_id | TINYINT | UNSIGNED NOT NULL | - |
| first_name | VARCHAR ( 45 ) | NOT NULL | - |
| last_name | VARCHAR ( 45 ) | NOT NULL | - |
| email | VARCHAR ( 50 ) | DEFAULT NULL | - |
| address_id | SMALLINT | UNSIGNED NOT NULL | - |
| active | BOOLEAN | NOT NULL DEFAULT TRUE | - |
| create_date | DATETIME | NOT NULL | - |
| last_update | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| customer_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_store_id | store_id | - |
| idx_fk_address_id | address_id | - |
| idx_last_name | last_name | - |

## `film` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| film_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| title | VARCHAR ( 255 ) | NOT NULL | - |
| description | TEXT | DEFAULT NULL | - |
| release_year | YEAR | DEFAULT NULL | - |
| language_id | TINYINT | UNSIGNED NOT NULL | - |
| original_language_id | TINYINT | UNSIGNED DEFAULT NULL | - |
| rental_duration | TINYINT | UNSIGNED NOT NULL DEFAULT 3 | - |
| rental_rate | DECIMAL ( 4, 2 ) | NOT NULL DEFAULT 4.99 | - |
| length | SMALLINT | UNSIGNED DEFAULT NULL | - |
| replacement_cost | DECIMAL ( 5, 2 ) | NOT NULL DEFAULT 19.99 | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |
| rating | ENUM ( G, PG, PG-13, R, NC-17 ) | DEFAULT &#039;G&#039; | - |
| special_features | SET ( Trailers, Commentaries, Deleted Scenes, Behind the Scenes ) | DEFAULT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| film_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_title | title | - |
| idx_fk_language_id | language_id | - |
| idx_fk_original_language_id | original_language_id | - |

## `film_actor` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| actor_id | SMALLINT | UNSIGNED NOT NULL | - |
| film_id | SMALLINT | UNSIGNED NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| actor_id, film_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_film_id | film_id | - |

## `film_category` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| film_id | SMALLINT | UNSIGNED NOT NULL | - |
| category_id | TINYINT | UNSIGNED NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| film_id, category_id | - |

## `film_text` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| film_id | SMALLINT | NOT NULL | - |
| title | VARCHAR ( 255 ) | NOT NULL | - |
| description | TEXT | - | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| film_id | - |

### Fulltext Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_title_description | title, description | - |

## `inventory` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| inventory_id | MEDIUMINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| film_id | SMALLINT | UNSIGNED NOT NULL | - |
| store_id | TINYINT | UNSIGNED NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| inventory_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_film_id | film_id | - |
| idx_store_id_film_id | store_id, film_id | - |

## `language` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| language_id | TINYINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| name | CHAR ( 20 ) | NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| language_id | - |

## `payment` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| payment_id | SMALLINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| customer_id | SMALLINT | UNSIGNED NOT NULL | - |
| staff_id | TINYINT | UNSIGNED NOT NULL | - |
| rental_id | INT | DEFAULT NULL | - |
| amount | DECIMAL ( 5, 2 ) | NOT NULL | - |
| payment_date | DATETIME | NOT NULL | - |
| last_update | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| payment_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_staff_id | staff_id | - |
| idx_fk_customer_id | customer_id | - |

## `rental` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| rental_id | INT | NOT NULL AUTO_INCREMENT | - |
| rental_date | DATETIME | NOT NULL | - |
| inventory_id | MEDIUMINT | UNSIGNED NOT NULL | - |
| customer_id | SMALLINT | UNSIGNED NOT NULL | - |
| return_date | DATETIME | DEFAULT NULL | - |
| staff_id | TINYINT | UNSIGNED NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| rental_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_inventory_id | inventory_id | - |
| idx_fk_customer_id | customer_id | - |
| idx_fk_staff_id | staff_id | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
|  | rental_date, inventory_id, customer_id | - |

## `staff` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| staff_id | TINYINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| first_name | VARCHAR ( 45 ) | NOT NULL | - |
| last_name | VARCHAR ( 45 ) | NOT NULL | - |
| address_id | SMALLINT | UNSIGNED NOT NULL | - |
| picture | BLOB | DEFAULT NULL | - |
| email | VARCHAR ( 50 ) | DEFAULT NULL | - |
| store_id | TINYINT | UNSIGNED NOT NULL | - |
| active | BOOLEAN | NOT NULL DEFAULT TRUE | - |
| username | VARCHAR ( 16 ) | NOT NULL | - |
| password | VARCHAR ( 40 ) | BINARY DEFAULT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| staff_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_store_id | store_id | - |
| idx_fk_address_id | address_id | - |

## `store` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| store_id | TINYINT | UNSIGNED NOT NULL AUTO_INCREMENT | - |
| manager_staff_id | TINYINT | UNSIGNED NOT NULL | - |
| address_id | SMALLINT | UNSIGNED NOT NULL | - |
| last_update | TIMESTAMP | NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| store_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_fk_address_id | address_id | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| idx_unique_manager | manager_staff_id | - |

## Connections

| Type | Child | Parent |
| --- | --- | --- |
| OneToMany | address ( city_id ) | city ( city_id ) |
| OneToMany | city ( country_id ) | country ( country_id ) |
| OneToMany | customer ( address_id ) | address ( address_id ) |
| OneToMany | customer ( store_id ) | store ( store_id ) |
| OneToMany | film ( language_id ) | language ( language_id ) |
| OneToMany | film ( original_language_id ) | language ( language_id ) |
| OneToMany | film_actor ( actor_id ) | actor ( actor_id ) |
| OneToMany | film_actor ( film_id ) | film ( film_id ) |
| OneToMany | film_category ( film_id ) | film ( film_id ) |
| OneToMany | film_category ( category_id ) | category ( category_id ) |
| OneToMany | inventory ( store_id ) | store ( store_id ) |
| OneToMany | inventory ( film_id ) | film ( film_id ) |
| OneToMany | payment ( rental_id ) | rental ( rental_id ) |
| OneToMany | payment ( customer_id ) | customer ( customer_id ) |
| OneToMany | payment ( staff_id ) | staff ( staff_id ) |
| OneToMany | rental ( staff_id ) | staff ( staff_id ) |
| OneToMany | rental ( inventory_id ) | inventory ( inventory_id ) |
| OneToMany | rental ( customer_id ) | customer ( customer_id ) |
| OneToMany | staff ( store_id ) | store ( store_id ) |
| OneToMany | staff ( address_id ) | address ( address_id ) |
| OneToOne | store ( manager_staff_id ) | staff ( staff_id ) |
| OneToMany | store ( address_id ) | address ( address_id ) |
