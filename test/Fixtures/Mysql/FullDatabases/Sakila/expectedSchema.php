<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToOneConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\FulltextIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\SimpleIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return (new Schema())
    ->addTable(
        (new Table())
            ->setName('actor')
            ->addColumn(
                new Column(
                    'actor_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'first_name',
                    'VARCHAR',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_name',
                    'VARCHAR',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['actor_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_actor_last_name',
                    ['last_name']
                )
            )
    )
    ->addTable(
        (new Table())
            ->setName('address')
            ->addColumn(
                new Column(
                    'address_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'address',
                    'VARCHAR',
                    [50],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'address2',
                    'VARCHAR',
                    [50],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'district',
                    'VARCHAR',
                    [20],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'city_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'postal_code',
                    'VARCHAR',
                    [10],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'phone',
                    'VARCHAR',
                    [20],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['address_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_city_id',
                    ['city_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'address',
            'city',
            ['city_id'],
            ['city_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('category')
            ->addColumn(
                new Column(
                    'category_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'name',
                    'VARCHAR',
                    [25],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['category_id']))
    )
    ->addTable(
        (new Table())
            ->setName('city')
            ->addColumn(
                new Column(
                    'city_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'city',
                    'VARCHAR',
                    [50],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'country_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['city_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_country_id',
                    ['country_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'city',
            'country',
            ['country_id'],
            ['country_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('country')
            ->addColumn(
                new Column(
                    'country_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'country',
                    'VARCHAR',
                    [50],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['country_id']))
    )
    ->addTable(
        (new Table())
            ->setName('customer')
            ->addColumn(
                new Column(
                    'customer_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'store_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'first_name',
                    'VARCHAR',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_name',
                    'VARCHAR',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'VARCHAR',
                    [50],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'address_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'active',
                    'BOOLEAN',
                    [],
                    'NOT NULL DEFAULT TRUE',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'create_date',
                    'DATETIME',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['customer_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_store_id',
                    ['store_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_address_id',
                    ['address_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_last_name',
                    ['last_name']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'customer',
            'address',
            ['address_id'],
            ['address_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'customer',
            'store',
            ['store_id'],
            ['store_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('film')
            ->addColumn(
                new Column(
                    'film_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'title',
                    'VARCHAR',
                    [255],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'description',
                    'TEXT',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'release_year',
                    'YEAR',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'language_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'original_language_id',
                    'TINYINT',
                    [],
                    'UNSIGNED DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'rental_duration',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL DEFAULT 3',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'rental_rate',
                    'DECIMAL',
                    [4, 2],
                    'NOT NULL DEFAULT 4.99',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'length',
                    'SMALLINT',
                    [],
                    'UNSIGNED DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'replacement_cost',
                    'DECIMAL',
                    [5, 2],
                    'NOT NULL DEFAULT 19.99',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'rating',
                    'ENUM',
                    ['G', 'PG', 'PG-13', 'R', 'NC-17'],
                    "DEFAULT 'G'",
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'special_features',
                    'SET',
                    [
                        'Trailers',
                        'Commentaries',
                        'Deleted Scenes',
                        'Behind the Scenes',
                    ],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['film_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_title',
                    ['title']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_language_id',
                    ['language_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_original_language_id',
                    ['original_language_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'film',
            'language',
            ['language_id'],
            ['language_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'film',
            'language',
            ['original_language_id'],
            ['language_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('film_actor')
            ->addColumn(
                new Column(
                    'actor_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'film_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['actor_id', 'film_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_film_id',
                    ['film_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'film_actor',
            'actor',
            ['actor_id'],
            ['actor_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'film_actor',
            'film',
            ['film_id'],
            ['film_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('film_category')
            ->addColumn(
                new Column(
                    'film_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'category_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['film_id', 'category_id']))
    )
    ->addConnection(
        new OneToManyConnection(
            'film_category',
            'film',
            ['film_id'],
            ['film_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'film_category',
            'category',
            ['category_id'],
            ['category_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('film_text')
            ->addColumn(
                new Column(
                    'film_id',
                    'SMALLINT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'title',
                    'VARCHAR',
                    [255],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'description',
                    'TEXT',
                    [],
                    '',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['film_id']))
            ->addFullTextIndex(
                new FulltextIndex(
                    'idx_title_description',
                    ['title', 'description']
                )
            )
    )
    ->addTable(
        (new Table())
            ->setName('inventory')
            ->addColumn(
                new Column(
                    'inventory_id',
                    'MEDIUMINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'film_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'store_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['inventory_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_film_id',
                    ['film_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_store_id_film_id',
                    ['store_id', 'film_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'inventory',
            'store',
            ['store_id'],
            ['store_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'inventory',
            'film',
            ['film_id'],
            ['film_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('language')
            ->addColumn(
                new Column(
                    'language_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'name',
                    'CHAR',
                    [20],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['language_id']))
    )
    ->addTable(
        (new Table())
            ->setName('payment')
            ->addColumn(
                new Column(
                    'payment_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'customer_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'staff_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'rental_id',
                    'INT',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'amount',
                    'DECIMAL',
                    [5, 2],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'payment_date',
                    'DATETIME',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['payment_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_staff_id',
                    ['staff_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_customer_id',
                    ['customer_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'payment',
            'rental',
            ['rental_id'],
            ['rental_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'payment',
            'customer',
            ['customer_id'],
            ['customer_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'payment',
            'staff',
            ['staff_id'],
            ['staff_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('rental')
            ->addColumn(
                new Column(
                    'rental_id',
                    'INT',
                    [],
                    'NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'rental_date',
                    'DATETIME',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'inventory_id',
                    'MEDIUMINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'customer_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'return_date',
                    'DATETIME',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'staff_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['rental_id']))
            ->addUniqueIndex(
                new UniqueIndex(
                    '',
                    ['rental_date', 'inventory_id', 'customer_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_inventory_id',
                    ['inventory_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_customer_id',
                    ['customer_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_staff_id',
                    ['staff_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'rental',
            'staff',
            ['staff_id'],
            ['staff_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'rental',
            'inventory',
            ['inventory_id'],
            ['inventory_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'rental',
            'customer',
            ['customer_id'],
            ['customer_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('staff')
            ->addColumn(
                new Column(
                    'staff_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'first_name',
                    'VARCHAR',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_name',
                    'VARCHAR',
                    [45],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'address_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'picture',
                    'BLOB',
                    [],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'email',
                    'VARCHAR',
                    [50],
                    'DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'store_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'active',
                    'BOOLEAN',
                    [],
                    'NOT NULL DEFAULT TRUE',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'username',
                    'VARCHAR',
                    [16],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'password',
                    'VARCHAR',
                    [40],
                    'BINARY DEFAULT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['staff_id']))
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_store_id',
                    ['store_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_address_id',
                    ['address_id']
                )
            )
    )
    ->addConnection(
        new OneToManyConnection(
            'staff',
            'store',
            ['store_id'],
            ['store_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'staff',
            'address',
            ['address_id'],
            ['address_id']
        )
    )
    ->addTable(
        (new Table())
            ->setName('store')
            ->addColumn(
                new Column(
                    'store_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL AUTO_INCREMENT',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'manager_staff_id',
                    'TINYINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'address_id',
                    'SMALLINT',
                    [],
                    'UNSIGNED NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_update',
                    'TIMESTAMP',
                    [],
                    'NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['store_id']))
            ->addUniqueIndex(
                new UniqueIndex(
                    'idx_unique_manager',
                    ['manager_staff_id']
                )
            )
            ->addSimpleIndex(
                new SimpleIndex(
                    'idx_fk_address_id',
                    ['address_id']
                )
            )
    )
    ->addConnection(
        new OneToOneConnection(
            'store',
            'staff',
            ['manager_staff_id'],
            ['staff_id']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'store',
            'address',
            ['address_id'],
            ['address_id']
        )
    );
