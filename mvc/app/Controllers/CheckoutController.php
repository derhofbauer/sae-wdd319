<?php

namespace App\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Core\Helpers\Config;
use Core\Session;
use Core\View;

class CheckoutController
{

    const PAYMENT_KEY = 'checkout-paymentId';
    const ADDRESS_KEY = 'checkout-addressId';

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
             * Schritt wieder verwenden können.
             */
            Session::set(self::PAYMENT_KEY, (int)$payment->id);
        }

        /**
         * Weiterleiten auf den nächsten Schritt im Checkout Prozess.
         */
        $baseUrl = Config::get('app.baseUrl');
        header("Location: {$baseUrl}checkout/address");
    }

    /**
     * Adressen des Users in einem Formular anzeigen, damit eine bestehende Adresse gewählt, oder eine neue Adresse
     * eingegeben werden kann.
     *
     * @todo: [ ] invoice address
     */
    public function addressForm ()
    {
        /**
         * Ein User soll nur auschecken können, wenn er eingeloggt ist.
         */
        if (User::isLoggedIn()) {
            /**
             * Eingeloggten User aus der Datenbank abfragen.
             */
            $user = User::getLoggedInUser();

            /**
             * Alle Adressen des eingeloggten Users abfragen.
             */
            $addresses = Address::findByUser($user->id);

            /**
             * View laden und abgefragte Zahlungsmethoden übergeben.
             */
            View::load('address', [
                'addresses' => $addresses
            ]);
        } else {
            /**
             * Ist kein User eingeloggt, leiten wir auf den Login weiter.
             */
            header("Location: login");
        }
    }

    /**
     * Daten aus dem Adress-Formular entgegennehmen und verarbeiten.
     */
    public function handleAddress ()
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
        if (isset($_POST['address_id'])) {
            /**
             * Ausgefühlte AddressId in die Session speichern, damit wir sie in einem weiteren Checkout-Schritt wieder
             * verwenden können.
             */
            Session::set(self::ADDRESS_KEY, (int)$_POST['address_id']);
        }

        /**
         * Wurde das rechte Formular abgeschickt?
         */
        if (isset($_POST['address'])) {
            /**
             * Neue Addresse erstellen und in die Datenbank speichern.
             */
            $address = new Address();
            $address->address = $_POST['address'];
            $address->user_id = $user->id;
            $address->save();

            /**
             * ID der neu erstellten Adresse in die Session speichern, damit wir sie in einem weiteren Checkout-Schritt
             * wieder verwenden können.
             */
            Session::set(self::ADDRESS_KEY, (int)$address->id);
        }

        /**
         * Weiterleiten auf den nächsten Schritt im Checkout Prozess.
         */
        $baseUrl = Config::get('app.baseUrl');
        header("Location: {$baseUrl}checkout/final");
    }

    /**
     * Anzeigen einer finalen Übersicht, bevor die Zahlung vom User freigegeben wird.
     */
    public function finalOverview ()
    {
        /**
         * PaymentId und AddressID aus der Session auslesen
         */
        $paymentId = Session::get(self::PAYMENT_KEY);
        $addressId = Session::get(self::ADDRESS_KEY);

        /**
         * Payment und Address anhand der IDs aus der Datenbank holen
         */
        $payment = Payment::find($paymentId);
        $address = Address::find($addressId);

        /**
         * Cart aus der Session laden
         */
        $cart = new Cart();

        /**
         * Eingeloggten User laden
         */
        $user = User::getLoggedInUser();

        /**
         * Daten zur Anzeige an den View übergeben
         */
        View::load('checkout-final', [
            'products' => $cart->getProducts(),
            'payment' => $payment,
            'address' => $address,
            'user' => $user
        ]);
    }

    /**
     * Checkout durchführen. In dieser Methode wird aus dem Cart Inhalt eine Order. Hier müsste in einem realen System
     * die Zahlung durchgeführt werden. Meistens würde hier eine Zahlung über einen Drittanbieter gestartet werden.
     */
    public function finaliseCheckout ()
    {
        /**
         * PaymentId und AddressID aus der Session auslesen
         */
        $paymentId = Session::get(self::PAYMENT_KEY);
        $addressId = Session::get(self::ADDRESS_KEY);

        /**
         * Cart aus der Session laden
         */
        $cart = new Cart();

        /**
         * Product Daten aus der Datenbank holen
         */
        $products = $cart->getProducts();

        /**
         * Eingeloggten User laden
         */
        $user = User::getLoggedInUser();

        /**
         * Neue Order anlegen und befüllen
         */
        $order = new Order();
        $order->user_id = $user->id;
        $order->delivery_address_id = $addressId;
        $order->invoice_address_id = $addressId;
        $order->payment_id = $paymentId;
        /**
         * Die setProducts()-Methode des Order Models speichert direkt eine serialisierte Version der Produkte in das
         * Model. In der Datenbank soll dann schließlich auch ein JSON-String landen.
         */
        $order->setProducts($products);
        $order->save();

        /**
         * Cart leeren, wenn die Order erfolgreich gespeichert wurde.
         */
        $cart->flush();
        /**
         * Während des Checkout ausgewählte Adresse und Payment Methode aus der Session löschen.
         */
        Session::forget(self::PAYMENT_KEY);
        Session::forget(self::ADDRESS_KEY);

        /**
         * Erfolgsmeldung in die Session schreiben zur Verwendung auf der Zielseite des folgenden Redirects.
         */
        Session::set('flash', 'Order successfully placed! :D');

        /**
         * Redirect.
         */
        $baseUrl = Config::get('app.baseUrl');
        header("Location: {$baseUrl}account/orders");
        exit;
    }

}
