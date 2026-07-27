CREATE DATABASE IF NOT EXISTS demo;

USE demo;

-- Create the products table
CREATE TABLE IF NOT EXISTS products (
	id INT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	category VARCHAR(100),
	price DECIMAL(10, 2) NOT NULL,
	description TEXT,
	-- This optional index allows for comparing vector search against traditional full-text search.
	FULLTEXT(description)
);

-- Load the products data from the CSV file
LOAD DATA INFILE '/products.csv'
IGNORE
INTO TABLE products
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(id, name, category, price, description);
