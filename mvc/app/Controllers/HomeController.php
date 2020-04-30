<?php

namespace App\Controllers;

use Core\View;

class HomeController {

    public function index () {

        /**
         * Um hier nicht den Header und den Footer und dann den View laden zu müssen, haben wir uns eine View Klasse
         * gebaut.
         */
        View::load('home', [
            'viewParam' => 'foobar'
        ]);

    }

}
