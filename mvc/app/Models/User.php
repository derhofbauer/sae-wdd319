<?php

namespace App\Models;

use Core\Models\BaseUser;
use Core\Models\ModelTrait;

/**
 * Für Erklärungen s. app/Models/Product.php
 */
class User
{
    use ModelTrait;
    use BaseUser;

    public static $tableName = 'users';

    public $id = 0;
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $password = '';
    public $is_admin = false;

    public function fill (array $data = [])
    {
        $this->id = $data['id'];
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->is_admin = (bool)$data['is_admin'];
    }
}
