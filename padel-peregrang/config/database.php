<?php
// Database configuration
$db_host = 'mysql-asans.alwaysdata.net';
$db_user = 'asans';
$db_pass = 'soydaw2025';
$db_name = 'asans_padel_peregrang';

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4
$conn->set_charset("utf8mb4");
