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

    '/sign-up' => 'AuthController.signupForm',
    '/do-sign-up' => 'AuthController.signup',
    '/sign-up/success' => 'AuthController.signupSuccess',

    /**
     * Backend Routes
     */
    '/dashboard' => 'AdminController.dashboard',
    '/products/{id}/edit' => 'AdminProductController.editForm',
    '/products/{id}/do-edit' => 'AdminProductController.edit',

    '/orders/{id}/edit' => 'AdminOrderController.editForm',
    '/orders/{id}/do-edit' => 'AdminOrderController.edit',

    /**
     * Product Routes (Frontend)
     */
    '/products' => 'ProductController.list',
    '/products/{id}' => 'ProductController.showProduct', // ProductController.php => ProductController::showProduct($id)
];
