<?php

return [
    // '/' => HomeController.php => HomeController::index()
    '/' => 'HomeController.index',
    '/products' => 'ProductController.list',

    // ProductController.php => ProductController::showProduct($id)
    '/products/{id}' => 'ProductController.showProduct',
    '/products/{id}/something/{else}' => 'ProductController.somethingElse',
];
