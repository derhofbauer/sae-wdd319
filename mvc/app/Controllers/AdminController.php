<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Core\Database;
use Core\View;

class AdminController
{

    /**
     * Das Dashboard ist bei uns die Startseite des Backends
     */
    public function dashboard ()
    {
        /**
         * Datenbankverbindung herstellen über die Core/Database.php Klasse
         */
        $db = new Database();

        /**
         * Wenn kein Account eingeloggt ist ODER ein eingeloggter Account kein Admin ist, dann leiten wir wo anders hin.
         */
        if (!User::isLoggedIn() || !User::getLoggedInUser()->is_admin) {
            header('Location: home');
            exit;
        }

        /**
         * [x] Wie viel User?
         * [x] Liste der Produkte
         * [x] Bestellungsstatisik (offen, in progress, shipped, ...)
         * [ ] @todo: Liste offener Bestellungen
         */

        /**
         * Anzahl der User
         */
        $numberOfUsers = $db->query("SELECT COUNT(*) AS numberofusers, is_admin FROM users GROUP BY is_admin");

        /**
         * Liste der Produkte
         */
        $products = Product::all();
        /**
         * Sortierung sollte eigentlich über den Datenbank Query abgerufen werden, weil es wesentlich performanter ist
         * bei großen Datenmengen.
         *
         * https://www.php.net/manual/en/function.usort.php
         * @todo: Funktion durchkommentieren
         */
        usort($products, function ($a, $b) {
            if ($a->stock === $b->stock) {
                return 0;
            }

            if ($a->stock < $b->stock) {
                return -1;
            } else {
                return 1;
            }
        });

        /**
         * Bestellungsstatistik
         */
        $productStats = $db->query('SELECT COUNT(*) AS count, status AS label FROM orders GROUP BY status');

        /**
         * Liste offener Bestellungen
         */
        $openOrders = Order::findByStatus('open');

        View::load('admin/dashboard', [
            'numberOfUsers' => $numberOfUsers,
            'products' => $products,
            'productStats' => $productStats,
            'openOrders' => $openOrders
        ]);
    }

}
