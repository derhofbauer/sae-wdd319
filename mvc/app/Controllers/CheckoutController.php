<?php

namespace App\Controllers;

use App\Models\Payment;
use App\Models\User;
use Core\Helpers\Config;
use Core\Session;
use Core\View;

class CheckoutController
{

    const PAYMENT_KEY = 'checkout-paymentId';

    /**
     * Zeigt ein Formular an, dass alle Zahlungsmethoden des aktuell eingeloggten Users auflistet und zur Auswahl
     * anbietet und auch erlaubt eine neue Zahlungsmethode anzulegen.
     */
    public function paymentForm ()
    {
        /**
         * Ist ein User eingeloggt?
         */
        if (User::isLoggedIn()) {
            /**
             * Eingeloggten User aus der Datenbank abfragen.
             */
            $user = User::getLoggedInUser();

            /**
             * Alle Zahlungsmethoden des eingeloggten Users abfragen.
             */
            $payments = Payment::findByUser($user->id);

            /**
             * View laden und abgefragte Zahlungsmethoden übergeben.
             */
            View::load('payment', [
                'payments' => $payments
            ]);
        } else {
            /**
             * Ist kein User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

    /**
     * Zahlungsmethoden Formular entgegen nehmen und Daten verarbeiten
     */
    public function handlePayment ()
    {
        /**
         * Wir verzichten der Übersichtlichkeit halber auf eine Validierung. Eigentlich müsste hier eine Daten-
         * validierung durchgeführt werden und etwaige Fehler an den User zurückgespielt werden. Im Login machen wir das
         * beispielsweise und auch bei der Bearbeitung eines Produkts. Der nachfolgende Code dürfte gar nicht mehr
         * ausgeführt werden, wenn Validierungsfehler aufgetreten sind.
         */

        /**
         * Eingeloggten User abfragen
         */
        $user = User::getLoggedInUser();

        /**
         * Wurde das linke Formular abgeschickt?
         */
        if (isset($_POST['payment'])) {
            /**
             * Ausgefühlte PaymentId in die Session speichern, damit wir sie in einem weiteren Checkout-Schritt wieder
             * verwenden können.
             */
            Session::set(self::PAYMENT_KEY, (int)$_POST['payment']);
        }

        /**
         * Wurde das rechte Formular abgeschickt?
         */
        if (isset($_POST['name'])) {
            /**
             * Neue Payment Methode erstellen und in die Datenbank speichern.
             */
            $payment = new Payment();
            $payment->name = $_POST['name'];
            $payment->number = $_POST['number'];
            $payment->expires = $_POST['expires'];
            $payment->ccv = $_POST['ccv'];
            $payment->user_id = $user->id;
            $payment->save();

            /**
             * ID der neu erstellten Zahlungsmethode in die Session speichern, damit wir sie in einem weiteren Checkout-
             * Shritt wieder verwenden können.
             */
            Session::set(self::PAYMENT_KEY, (int)$payment->id);
        }

        /**
         * Weiterleiten auf den nächsten Schritt im Checkout Prozess.
         */
        $baseUrl = Config::get('app.baseUrl');
        header("Location: {$baseUrl}checkout/address");
    }

}
