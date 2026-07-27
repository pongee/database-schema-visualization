# Schema

## `airline` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| airline_id | smallint | NOT NULL AUTO_INCREMENT | - |
| iata | char ( 2 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| airlinename | varchar ( 30 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| base_airport | smallint | NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| airline_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| base_airport_idx | base_airport | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| iata_unq | iata | - |

## `airplane` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| airplane_id | int | NOT NULL AUTO_INCREMENT | - |
| capacity | mediumint | unsigned NOT NULL | - |
| type_id | int | NOT NULL | - |
| airline_id | int | NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| airplane_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| type_id | type_id | - |

## `airplane_type` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| type_id | int | NOT NULL AUTO_INCREMENT | - |
| identifier | varchar ( 50 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| description | text | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| type_id | - |

### Fulltext Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| description_full | identifier, description | - |

## `airport` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| airport_id | smallint | NOT NULL AUTO_INCREMENT | - |
| iata | char ( 3 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| icao | char ( 4 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| name | varchar ( 50 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| airport_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| name_idx | name | - |
| iata_idx | iata | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| icao_unq | icao | - |

## `airport_geo` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| airport_id | smallint | NOT NULL | - |
| name | varchar ( 50 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| city | varchar ( 50 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| country | varchar ( 50 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| latitude | decimal ( 11, 8 ) | NOT NULL | - |
| longitude | decimal ( 11, 8 ) | NOT NULL | - |
| geolocation | point | NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| airport_id | - |

### Spatial Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| geolocation_spt | geolocation | - |

## `airport_reachable` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| airport_id | smallint | NOT NULL | - |
| hops | int | DEFAULT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| airport_id | - |

## `booking` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| booking_id | int | NOT NULL AUTO_INCREMENT | - |
| flight_id | int | NOT NULL | - |
| seat | char ( 4 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| passenger_id | int | NOT NULL | - |
| price | decimal ( 10, 2 ) | NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| booking_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| flight_idx | flight_id | - |
| passenger_idx | passenger_id | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| seatplan_unq | flight_id, seat | - |

## `employee` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| employee_id | int | NOT NULL AUTO_INCREMENT | - |
| firstname | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| lastname | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| birthdate | date | NOT NULL | - |
| sex | char ( 1 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| street | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| city | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| zip | smallint | NOT NULL | - |
| country | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| emailaddress | varchar ( 120 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| telephoneno | varchar ( 30 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| salary | decimal ( 8, 2 ) | DEFAULT NULL | - |
| username | varchar ( 20 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| password | char ( 32 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| department | enum ( Marketing, Buchhaltung, Management, Logistik, Flugfeld ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| employee_id | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| user_unq | username | - |

## `flight` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| flight_id | int | NOT NULL AUTO_INCREMENT | - |
| flightno | char ( 8 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| from | smallint | NOT NULL | - |
| to | smallint | NOT NULL | - |
| departure | datetime | NOT NULL | - |
| arrival | datetime | NOT NULL | - |
| airline_id | smallint | NOT NULL | - |
| airplane_id | int | NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| flight_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| from_idx | from | - |
| to_idx | to | - |
| departure_idx | departure | - |
| arrivals_idx | arrival | - |
| airline_idx | airline_id | - |
| airplane_idx | airplane_id | - |
| flightno | flightno | - |

## `flight_log` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| flight_log_id | int | unsigned NOT NULL AUTO_INCREMENT | - |
| log_date | datetime | NOT NULL | - |
| user | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| flight_id | int | NOT NULL | - |
| flightno_old | char ( 8 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| flightno_new | char ( 8 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| from_old | smallint | NOT NULL | - |
| to_old | smallint | NOT NULL | - |
| from_new | smallint | NOT NULL | - |
| to_new | smallint | NOT NULL | - |
| departure_old | datetime | NOT NULL | - |
| arrival_old | datetime | NOT NULL | - |
| departure_new | datetime | NOT NULL | - |
| arrival_new | datetime | NOT NULL | - |
| airplane_id_old | int | NOT NULL | - |
| airplane_id_new | int | NOT NULL | - |
| airline_id_old | smallint | NOT NULL | - |
| airline_id_new | smallint | NOT NULL | - |
| comment | varchar ( 200 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| flight_log_id | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| flight_log_ibfk_1 | flight_id | - |

## `flightschedule` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| flightno | char ( 8 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| from | smallint | NOT NULL | - |
| to | smallint | NOT NULL | - |
| departure | time | NOT NULL | - |
| arrival | time | NOT NULL | - |
| airline_id | smallint | NOT NULL | - |
| monday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |
| tuesday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |
| wednesday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |
| thursday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |
| friday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |
| saturday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |
| sunday | tinyint ( 1 ) | DEFAULT &#039;0&#039; | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| flightno | - |

### Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| from_idx | from | - |
| to_idx | to | - |
| airline_idx | airline_id | - |

## `passenger` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| passenger_id | int | NOT NULL AUTO_INCREMENT | - |
| passportno | char ( 9 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| firstname | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| lastname | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| passenger_id | - |

### Unique Indexes

| Name | Columns | Parameters |
| --- | --- | --- |
| pass_unq | passportno | - |

## `passengerdetails` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| passenger_id | int | NOT NULL | - |
| birthdate | date | NOT NULL | - |
| sex | char ( 1 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| street | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| city | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| zip | smallint | NOT NULL | - |
| country | varchar ( 100 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL | - |
| emailaddress | varchar ( 120 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |
| telephoneno | varchar ( 30 ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| passenger_id | - |

## `weatherdata` table

### Columns

| Name | Type | Parameters | Comment |
| --- | --- | --- | --- |
| log_date | date | NOT NULL | - |
| time | time | NOT NULL | - |
| station | int | NOT NULL | - |
| temp | decimal ( 3, 1 ) | NOT NULL | - |
| humidity | decimal ( 4, 1 ) | NOT NULL | - |
| airpressure | decimal ( 10, 2 ) | NOT NULL | - |
| wind | decimal ( 5, 2 ) | NOT NULL | - |
| winddirection | smallint | NOT NULL | - |
| weather | enum ( Nebel-Schneefall, Schneefall, Regen, Regen-Schneefall, Nebel-Regen, Nebel-Regen-Gewitter, Gewitter, Nebel, Regen-Gewitter ) | CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL | - |

### Primary Key

| Columns | Parameters |
| --- | --- |
| log_date, time, station | - |

## Connections

| Type | Child | Parent |
| --- | --- | --- |
| OneToMany | airline ( base_airport ) | airport ( airport_id ) |
| OneToMany | airplane ( type_id ) | airplane_type ( type_id ) |
| OneToOne | airport_geo ( airport_id ) | airport ( airport_id ) |
| OneToOne | airport_reachable ( airport_id ) | airport ( airport_id ) |
| OneToMany | booking ( flight_id ) | flight ( flight_id ) |
| OneToMany | booking ( passenger_id ) | passenger ( passenger_id ) |
| OneToMany | flight ( from ) | airport ( airport_id ) |
| OneToMany | flight ( to ) | airport ( airport_id ) |
| OneToMany | flight ( airline_id ) | airline ( airline_id ) |
| OneToMany | flight ( airplane_id ) | airplane ( airplane_id ) |
| OneToMany | flight ( flightno ) | flightschedule ( flightno ) |
| OneToMany | flight_log ( flight_id ) | flight ( flight_id ) |
| OneToMany | flightschedule ( from ) | airport ( airport_id ) |
| OneToMany | flightschedule ( to ) | airport ( airport_id ) |
| OneToMany | flightschedule ( airline_id ) | airline ( airline_id ) |
| OneToOne | passengerdetails ( passenger_id ) | passenger ( passenger_id ) |
