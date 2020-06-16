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
    '/dashboard/accounts' => 'AdminAccountController.list',
    '/dashboard/accounts/edit/{id}' => 'AdminAccountController.editForm',
    '/dashboard/accounts/do-edit/{id}' => 'AdminAccountController.edit',
    '/dashboard/accounts/delete/{id}' => 'AdminAccountController.deleteForm',
    '/dashboard/accounts/do-delete/{id}' => 'AdminAccountController.delete',
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
    '/checkout/handle-payment' => 'CheckoutController.handlePayment',
    '/checkout/address' => 'CheckoutController.addressForm',
    '/checkout/handle-address' => 'CheckoutController.handleAddress',
    '/checkout/final' => 'CheckoutController.finalOverview',
    '/checkout/do-checkout' => 'CheckoutController.finaliseCheckout',

    /**
     * Account Routes
     */
    '/account' => 'AccountController.editForm',
    '/account/orders' => 'AccountController.orders',
    '/account/do-edit' => 'AccountController.edit',

    /**
     * PDF Test Routes
     */
    '/pdf/{id}' => 'PdfController.example'
];
