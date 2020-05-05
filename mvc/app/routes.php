<?php

return [
    /**
     * Home Route
     */
    '/' => 'ProductController.list',

    /**
     * Product Routes
     */
    '/products' => 'ProductController.list',
    '/products/{id}' => 'ProductController.showProduct', // ProductController.php => ProductController::showProduct($id)
];
