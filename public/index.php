<?php
// public/index.php

// Start session
session_start();

// Include necessary files
require __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../core/Router.php';  // Include the Router class

// Explicitly check if config.php exists and include it
if (!file_exists(__DIR__ . '/../config/config.php')) {
    die('Configuration file not found.');
}


// Load configuration
$config = require __DIR__ . '/../config/config.php';

// Set up database connection
var_dump($config);

try {
    $db = new PDO(
        'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
        $config['db']['user'],
        $config['db']['pass']
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Instantiate the router
$router = new Router();

// Include your route definitions
require_once __DIR__ . '/../routes/web.php';

// Dispatch the request
$router->dispatch();
