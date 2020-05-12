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
    '/products/{id}/edit' => 'AdminProductController.edit',
    '/orders/{id}/edit' => 'AdminOrderController.editForm',
    '/orders/{id}/do-edit' => 'AdminOrderController.edit',

    /**
     * Product Routes (Frontend)
     */
    '/products' => 'ProductController.list',
    '/products/{id}' => 'ProductController.showProduct', // ProductController.php => ProductController::showProduct($id)
];
