<?php

namespace App\Controllers;

use App\Models\User;

class AdminController {

    /**
     * Das Dashboard ist bei uns die Startseite des Backends
     */
    public function dashboard () {
        /**
         * Wenn kein Account eingeloggt ist ODER ein eingeloggter Account kein Admin ist, dann leiten wir wo anders hin.
         */
        if (!User::isLoggedIn() || !User::getLoggedInUser()->is_admin) {
            header('Location: home');
            exit;
        }

        echo "Dashboard";
    }

}
