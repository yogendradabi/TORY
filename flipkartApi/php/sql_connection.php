<?php
//$servername = "db4free.net:3306";
//$username = "tori";
//$password = "tori123";
//$dbname="data01";
$servername = "localhost:3306";
$username = "homestead";
$password = "secret";
$dbname="test";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE test_01
(
product_id varchar(255) NOT NULL,
title varchar(255),
product_description text,
image_url_01 varchar(255),
image_url_02 varchar(255),
image_url_03 varchar(255),
image_url_04 varchar(255),
maximum_retail_price int,
selling_price int,
product_url varchar(255),
product_brand varchar(255),
size varchar(50),
category_01 varchar(50),
PRIMARY KEY (product_id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Data created successfully"."\r\n" ;
} else {
    echo "Error creating table: " . $conn->error."\r\n" ;
}

$conn->close();
?>