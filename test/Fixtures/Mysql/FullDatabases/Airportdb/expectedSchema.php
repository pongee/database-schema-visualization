<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SpatialIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table()
            ->setName('airline')
            ->addColumn(
                new Column(
                    'airline_id',
                    'smallint',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'iata',
                    'char',
                    ['2'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airlinename',
                    'varchar',
                    ['30'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'base_airport',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'base_airport_idx',
                    ['base_airport']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'iata_unq',
                    ['iata']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['airline_id']))
    )
    ->addTable(
        new Table()
            ->setName('airplane')
            ->addColumn(
                new Column(
                    'airplane_id',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'capacity',
                    'mediumint',
                    [],
                    'unsigned NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'type_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airline_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'type_id',
                    ['type_id']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['airplane_id']))
    )
    ->addTable(
        new Table()
            ->setName('airplane_type')
            ->addColumn(
                new Column(
                    'type_id',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'identifier',
                    'varchar',
                    ['50'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'description',
                    'text',
                    [],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
                    ''
                )
            )
            ->addFullTextIndex(
                new FulltextIndex(
                    'description_full',
                    ['identifier', 'description']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['type_id']))
    )
    ->addTable(
        new Table()
            ->setName('airport')
            ->addColumn(
                new Column(
                    'airport_id',
                    'smallint',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'iata',
                    'char',
                    ['3'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'icao',
                    'char',
                    ['4'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'name',
                    'varchar',
                    ['50'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'name_idx',
                    ['name']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'iata_idx',
                    ['iata']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'icao_unq',
                    ['icao']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['airport_id']))
    )
    ->addTable(
        new Table()
            ->setName('airport_geo')
            ->addColumn(
                new Column(
                    'airport_id',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'name',
                    'varchar',
                    ['50'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'city',
                    'varchar',
                    ['50'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'country',
                    'varchar',
                    ['50'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'latitude',
                    'decimal',
                    ['11', '8'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'longitude',
                    'decimal',
                    ['11', '8'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'geolocation',
                    'point',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addSpatialIndex(
                new SpatialIndex(
                    'geolocation_spt',
                    ['geolocation']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['airport_id']))
    )
    ->addTable(
        new Table()
            ->setName('airport_reachable')
            ->addColumn(
                new Column(
                    'airport_id',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'hops',
                    'int',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['airport_id']))
    )
    ->addTable(
        new Table()
            ->setName('booking')
            ->addColumn(
                new Column(
                    'booking_id',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'flight_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'seat',
                    'char',
                    ['4'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'passenger_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'price',
                    'decimal',
                    ['10', '2'],
                    'NOT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'flight_idx',
                    ['flight_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'passenger_idx',
                    ['passenger_id']
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'seatplan_unq',
                    ['flight_id', 'seat']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['booking_id']))
    )
    ->addTable(
        new Table()
            ->setName('employee')
            ->addColumn(
                new Column(
                    'employee_id',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'firstname',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'lastname',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'birthdate',
                    'date',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'sex',
                    'char',
                    ['1'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'street',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'city',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'zip',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'country',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'emailaddress',
                    'varchar',
                    ['120'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'telephoneno',
                    'varchar',
                    ['30'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'salary',
                    'decimal',
                    ['8', '2'],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'username',
                    'varchar',
                    ['20'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'char',
                    ['32'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'department',
                    'enum',
                    ['Marketing', 'Buchhaltung', 'Management', 'Logistik', 'Flugfeld'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'user_unq',
                    ['username']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['employee_id']))
    )
    ->addTable(
        new Table()
            ->setName('flight')
            ->addColumn(
                new Column(
                    'flight_id',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'flightno',
                    'char',
                    ['8'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'departure',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'arrival',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airline_id',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airplane_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'from_idx',
                    ['from']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'to_idx',
                    ['to']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'departure_idx',
                    ['departure']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'arrivals_idx',
                    ['arrival']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'airline_idx',
                    ['airline_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'airplane_idx',
                    ['airplane_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'flightno',
                    ['flightno']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['flight_id']))
    )
    ->addTable(
        new Table()
            ->setName('flight_log')
            ->addColumn(
                new Column(
                    'flight_log_id',
                    'int',
                    [],
                    'unsigned NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'log_date',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'user',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'flight_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'flightno_old',
                    'char',
                    ['8'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'flightno_new',
                    'char',
                    ['8'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from_old',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to_old',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from_new',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to_new',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'departure_old',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'arrival_old',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'departure_new',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'arrival_new',
                    'datetime',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airplane_id_old',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airplane_id_new',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airline_id_old',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airline_id_new',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'comment',
                    'varchar',
                    ['200'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'flight_log_ibfk_1',
                    ['flight_id']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['flight_log_id']))
    )
    ->addTable(
        new Table()
            ->setName('flightschedule')
            ->addColumn(
                new Column(
                    'flightno',
                    'char',
                    ['8'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'departure',
                    'time',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'arrival',
                    'time',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airline_id',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'monday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'tuesday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'wednesday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'thursday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'friday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'saturday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'sunday',
                    'tinyint',
                    ['1'],
                    'DEFAULT \'0\'',
                    ''
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'from_idx',
                    ['from']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'to_idx',
                    ['to']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'airline_idx',
                    ['airline_id']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['flightno']))
    )
    ->addTable(
        new Table()
            ->setName('passenger')
            ->addColumn(
                new Column(
                    'passenger_id',
                    'int',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'passportno',
                    'char',
                    ['9'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'firstname',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'lastname',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    'pass_unq',
                    ['passportno']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['passenger_id']))
    )
    ->addTable(
        new Table()
            ->setName('passengerdetails')
            ->addColumn(
                new Column(
                    'passenger_id',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'birthdate',
                    'date',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'sex',
                    'char',
                    ['1'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'street',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'city',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'zip',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'country',
                    'varchar',
                    ['100'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'emailaddress',
                    'varchar',
                    ['120'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'telephoneno',
                    'varchar',
                    ['30'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['passenger_id']))
    )
    ->addTable(
        new Table()
            ->setName('weatherdata')
            ->addColumn(
                new Column(
                    'log_date',
                    'date',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'time',
                    'time',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'station',
                    'int',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'temp',
                    'decimal',
                    ['3', '1'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'humidity',
                    'decimal',
                    ['4', '1'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'airpressure',
                    'decimal',
                    ['10', '2'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'wind',
                    'decimal',
                    ['5', '2'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'winddirection',
                    'smallint',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'weather',
                    'enum',
                    ['Nebel-Schneefall', 'Schneefall', 'Regen', 'Regen-Schneefall', 'Nebel-Regen', 'Nebel-Regen-Gewitter', 'Gewitter', 'Nebel', 'Regen-Gewitter'],
                    'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['log_date', 'time', 'station']))
    )
    ->addConnection(
        new OneToManyConnection(
            'airline',
            'airport',
            ['base_airport'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'airplane',
            'airplane_type',
            ['type_id'],
            ['type_id']
        )
    )
    ->addConnection(
        new OneToOneConnection(
            'airport_geo',
            'airport',
            ['airport_id'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToOneConnection(
            'airport_reachable',
            'airport',
            ['airport_id'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'booking',
            'flight',
            ['flight_id'],
            ['flight_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'booking',
            'passenger',
            ['passenger_id'],
            ['passenger_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flight',
            'airport',
            ['from'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flight',
            'airport',
            ['to'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flight',
            'airline',
            ['airline_id'],
            ['airline_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flight',
            'airplane',
            ['airplane_id'],
            ['airplane_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flight',
            'flightschedule',
            ['flightno'],
            ['flightno']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flight_log',
            'flight',
            ['flight_id'],
            ['flight_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flightschedule',
            'airport',
            ['from'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flightschedule',
            'airport',
            ['to'],
            ['airport_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'flightschedule',
            'airline',
            ['airline_id'],
            ['airline_id']
        )
    )
    ->addConnection(
        new OneToOneConnection(
            'passengerdetails',
            'passenger',
            ['passenger_id'],
            ['passenger_id']
        )
    );
