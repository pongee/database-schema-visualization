<?php

declare(strict_types=1);

use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Connection\OneToManyConnection;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Column;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\PrimaryKey;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Database\Table\Index\UniqueIndex;
use Pongee\DatabaseSchemaVisualization\DataObject\Sql\Schema;

return new Schema()
    ->addTable(
        new Table('employees')
            ->addColumn(
                new Column(
                    'emp_no',
                    'INT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'birth_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'first_name',
                    'VARCHAR',
                    ['14'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'last_name',
                    'VARCHAR',
                    ['16'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'hire_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'gender',
                    'ENUM',
                    ['M', 'F'],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['emp_no']))
    )
    ->addTable(
        new Table('departments')
            ->addColumn(
                new Column(
                    'dept_no',
                    'CHAR',
                    ['4'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'dept_name',
                    'VARCHAR',
                    ['40'],
                    'NOT NULL',
                    ''
                )
            )
            ->addUniqueIndex(
                new UniqueIndex(
                    '',
                    ['dept_name']
                )
            )
            ->setPrimaryKey(new PrimaryKey(['dept_no']))
    )
    ->addTable(
        new Table('dept_manager')
            ->addColumn(
                new Column(
                    'emp_no',
                    'INT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'dept_no',
                    'CHAR',
                    ['4'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['emp_no', 'dept_no']))
    )
    ->addTable(
        new Table('dept_emp')
            ->addColumn(
                new Column(
                    'emp_no',
                    'INT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'dept_no',
                    'CHAR',
                    ['4'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['emp_no', 'dept_no']))
    )
    ->addTable(
        new Table('titles')
            ->addColumn(
                new Column(
                    'emp_no',
                    'INT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'title',
                    'VARCHAR',
                    ['50'],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to_date',
                    'DATE',
                    [],
                    '',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['emp_no', 'title', 'from_date']))
    )
    ->addTable(
        new Table('salaries')
            ->addColumn(
                new Column(
                    'emp_no',
                    'INT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'salary',
                    'INT',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'from_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->addColumn(
                new Column(
                    'to_date',
                    'DATE',
                    [],
                    'NOT NULL',
                    ''
                )
            )
            ->setPrimaryKey(new PrimaryKey(['emp_no', 'from_date']))
    )
    ->addConnection(
        new OneToManyConnection(
            'dept_manager',
            'employees',
            ['emp_no'],
            ['emp_no']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'dept_manager',
            'departments',
            ['dept_no'],
            ['dept_no']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'dept_emp',
            'employees',
            ['emp_no'],
            ['emp_no']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'dept_emp',
            'departments',
            ['dept_no'],
            ['dept_no']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'titles',
            'employees',
            ['emp_no'],
            ['emp_no']
        )
    )
    ->addConnection(
        new OneToManyConnection(
            'salaries',
            'employees',
            ['emp_no'],
            ['emp_no']
        )
    );
