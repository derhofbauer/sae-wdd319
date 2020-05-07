<?php

return [
    /**
     * Home Route
     */
    '/' => 'ProductController.list',
    '/home' => 'ProductController.list',

    /**
     * Auth Routes
     */
    '/login' => 'AuthController.loginForm',
    '/do-login' => 'AuthController.login',
    '/logout' => 'AuthController.logout',

    /**
     * Backend Routes
     */
    '/dashboard' => 'AdminController.dashboard',

    /**
     * Product Routes
     */
    '/products' => 'ProductController.list',
    '/products/{id}' => 'ProductController.showProduct', // ProductController.php => ProductController::showProduct($id)
];
