<?php

namespace App\Models;

use Core\Models\ModelTrait;

/**
 * Für Erklärungen s. app/Models/Product.php
 */
class User
{
    use ModelTrait;

    public static $tableName = 'users';

    public function fill (array $data = [])
    {
        /* ... */
    }
}
