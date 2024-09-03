<?php
// routes/web.php

// Define routes using the $router instance
$router->get('/signin', function() {
    include __DIR__ . '/../app/views/signin.html';
});

$router->post('/signin', 'AuthController@signin');

$router->get('/dashboard', function() {
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: /signin');
        exit();
    }

    include __DIR__ . '/../app/views/dashboard.html';
});
