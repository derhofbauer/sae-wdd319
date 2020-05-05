<?php

namespace App\Models;

use Core\Database;

class Product
{
    public $id = 0;
    public $name = '';
    public $description = null;
    public $price = 0.0;
    public $stock = 0;
    public $images = [];

    public function __construct (array $data = [])
    {
        if (count($data) > 0) {
            $this->fill($data);
        }
    }

    public function fill (array $data = [])
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->images = $data['images'];
    }

    public static function all ()
    {
        $db = new Database();

        $result = $db->query('SELECT * FROM products');

        $products = [];
        foreach ($result as $productData) {
            $product = new self($productData);
            $products[] = $product;
        }

        return $products;
    }

    public function save ()
    {

    }
}
