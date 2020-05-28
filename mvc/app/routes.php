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
    '/dashboard/products/add' => 'AdminProductController.addForm',
    '/dashboard/products/do-add' => 'AdminProductController.add',
    '/products/{id}/edit' => 'AdminProductController.editForm',
    '/products/{id}/do-edit' => 'AdminProductController.edit',

    '/orders/{id}/edit' => 'AdminOrderController.editForm',
    '/orders/{id}/do-edit' => 'AdminOrderController.edit',

    /**
     * Product Routes (Frontend)
     */
    '/products' => 'ProductController.list',
    '/products/{id}' => 'ProductController.showProduct', // ProductController.php => ProductController::showProduct($id)

    /**
     * Cart Routes
     */
    '/cart' => 'CartController.index',
    '/cart/add/{id}' => 'CartController.addProductToCart',
    '/cart/sub/{id}' => 'CartController.removeProductFromCart',
    '/cart/remove/{id}' => 'CartController.deleteProductFromCart',
    '/cart/update/{id}' => 'CartController.updateProductInCart',

    /**
     * Checkout Routes
     */
    '/checkout' => 'CheckoutController.paymentForm',
    '/checkout/handle-payment' => 'CheckoutController.handlePayment'
];
